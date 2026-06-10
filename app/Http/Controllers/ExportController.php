<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:export articles');
    }
    // Export the articles of the authenticated user (or all articles for Admin) to a CSV file.
    public function exportCsv()
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $articles = Article::with(['author','category'])->get();
        } else {
            $articles = Article::with(['author','category'])->where('user_id', $user->id)->get();
        }
        $fileName = 'articles.csv';
        $headers = [
            'content-Type' => 'text/csv',
            'content-disposition' => "attachment; filename=$fileName",
        ];
        $callback = function () use ($articles) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
               'ID',
               'Title',
               'body',
               'Author',
               'Category',
               'Published',
            ]);
            foreach ($articles as $article) {
                fputcsv($handle, [
                    $article->id,
                    $article->title,
                    $article->body,
                    $article->author->name,
                    $article->category->name,
                    $article->is_published ? 'Yes' : 'No',
                ]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }
    // Export the articles of the authenticated user (or all articles for Admin) to a PDF file.
    public function exportPdf()
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $articles = Article::with(['author','category'])->get();
        } else {
            $articles = Article::with(['author','category'])->where('user_id', $user->id)->get();
        }
        $pdf = Pdf::loadView('exports.articles-pdf', compact('articles'));
        return $pdf->download('articles.pdf');
    }
}
