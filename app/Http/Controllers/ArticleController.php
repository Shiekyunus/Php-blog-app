<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\ArticlesStoreRequest;
use App\Http\Requests\ArticlesUpdateRequest;
use App\Models\Subscription;
use App\Notifications\NewArticlePublishedNotification;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {
        $this->middleware('auth')->except('search', 'show', 'relatedArticles');
        $this->middleware('permission:manage articles')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('permission:delete articles')->only(['destroy']);
        $this->middleware('permission:publish articles')->only(['updateStatus']);
    }

    // Display a listing of the published articles for the authenticated user
    public function index()
    {
        $user = Auth::user();
        $articles = Article::with(['category', 'tags'])->where('is_published', true)->where('user_id', $user->id)->latest()->paginate(6);
        return view('articles.index', compact('articles'));
    }

    // Display a listing of the draft articles for the authenticated user
    public function draft()
    {
        $user = Auth::user();
        $articles = Article::with(['category','tags'])->Where('is_published', false)->where('user_id', $user->id)->latest()->paginate(5);
        return view('articles.draft', compact('articles'));
    }
    // Show the form for creating a new article.
    public function create()
    {
        //
        $tags = Tag::all();
        $categories = Category::all();
        return view('articles.create', compact('categories', 'tags'));
    }

    // Store a newly created article in storage.
    public function store(ArticlesStoreRequest $request)
    {
        //
        $validated = $request->validated();
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('articles', 'public');
        }
        $slug = Str::slug($validated['title']);
        if (Article::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }
        $article = Article::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'body' => $validated['body'],
            'image' => $imagePath,
            'is_published' => $request->boolean('publish'),
        ]);
        $article->tags()->sync($validated['tags'] ?? []);
        if ($article->is_published) {
            $subscribers = Subscription::where('status', 'active')
                ->with('user')->get()->pluck('user')->filter();
            foreach ($subscribers as $user) {
                $user->notify(new NewArticlePublishedNotification($article));
            }
        }
        $message = $article->is_published ? 'Article published Successfully' : 'Article saved as Draft.';
        return redirect()->route('articles.index')->with('success', $message);
    }

    // Display the specified article.
    public function show(Article $article)
    {
        //
        if (!$article->is_published && Auth::id() !== $article->user_id) {
            abort(403);
        }
        $article->load(['category', 'tags', 'author'])->loadCount(['likes','savedArticles']);
        $comments = $article->comments()
            ->where('status', 'approved')->whereNull('parent_id')->with(['user', 'replies.user', 'replies.replies.user'])
            ->latest()->paginate(5);
        $relatedArticles = $this->relatedArticles($article);
        return view('articles.show', compact('article', 'comments', 'relatedArticles'));
    }

    // Show the form for editing the specified article.
    public function edit(Article $article)
    {
        //
        $user = Auth::user();
        if (!$user->hasRole('Admin') && !$user->hasRole('Editor') && $article->user_id !== $user->id) {
            abort(403);
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('articles.edit', compact('article', 'categories', 'tags'));
    }

    // Update the specified article and its revisions in storage.
    public function update(ArticlesUpdateRequest $request, Article $article)
    {
        //
        $user = Auth::user();
        if (!$user->hasRole('Admin') && !$user->hasRole('Editor')  && $article->user_id !== $user->id) {
            abort(403);
        }
        $validated = $request->validated();
        $article->revisions()->create([
            'user_id' => $user->id,
            'title' => $article->title,
            'body' => $article->body,
            'image' => $article->image,
            'category_id' => $article->category_id,
            'tags' => $article->tags->pluck('id')->toArray(),
        ]);
        $oldPublished = $article->is_published;
        $slug = Str::slug($validated['title']);
        if (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug .= '-' . time();
        }
        $imagePath = $article->image;
        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')
                ->store('articles', 'public');
        }
        $article->update([
            'title' => $validated["title"],
            'slug' => $slug,
            'body' => $validated["body"],
            'category_id' => $validated["category_id"],
            'image' => $imagePath,
            'is_published' => $request->boolean('publish', $article->is_published),
        ]);
        $article->tags()->sync($validated['tags'] ?? []);
        if (!$oldPublished && $article->is_published) {
            $subscribers = Subscription::where('status', 'active')
                ->with('user')->get()->pluck('user')->filter();
            foreach ($subscribers as $user) {
                $user->notify(new NewArticlePublishedNotification($article));
            }
        }
        return back()->with('success', 'Article updated successfully');
    }
    // Remove the specified article from storage.
    public function destroy(Article $article)
    {
        //
        $user = Auth::user();
        if (!$user->hasRole('Admin') && $article->user_id !== $user->id) {
            abort(403);
        }
        $article->delete();
        return back()->with('success', 'Article deleted Successfully.');
    }
    // Update the publication status of the specified article.
    public function updateStatus(Request $request, Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            abort(403);
        }
        $oldPublished = $article->is_published;
        $request->validate(['status' => 'required|boolean']);
        $article->update([
            'is_published' => $request->status
        ]);
        $message = $article->is_published ? 'Article published successfully.' : 'Article moved to a drafts';
        if (!$oldPublished && $article->is_published) {
            $subscribers = Subscription::where('status', 'active')
                ->with('user')->get()->pluck('user')->filter();
            foreach ($subscribers as $user) {
                $user->notify(new NewArticlePublishedNotification($article));
            }
        }
        return back()->with('success', $message);
    }
    // Get related articles based on category and tags.
    private function relatedArticles(Article $article, int $limit = 3)
    {
        $tagIds = $article->tags->pluck('id');
        return Article::with(['category', 'author'])->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where(function ($q) use ($article, $tagIds) {
                $q->where('category_id', $article->category_id);
                if ($tagIds->isNotEmpty()) {
                    $q->orWhereHas('tags', fn ($t) => $t->whereIn('tags.id', $tagIds));
                }
            })
            ->latest()
            ->limit($limit)
            ->get();
    }
    // Search for articles based on title, body, and tags.
    public function search(Request $request)
    {
        $q = $request->input('q');
        $articles = Article::with(['category', 'tags'])->where('is_published', true)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")->orWhere('body', 'like', '%$q%')
                ->orWhereHas('tags', function ($tagsQuery) use ($q) {
                    $tagsQuery->where('name', 'like', "%$q%");
                });
            })->latest()->paginate(10);
        return view('home', compact('articles', 'q'));
    }
}
