<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SavedArticleController;

Route::get('/', [HomeController::class,'index'])->name('home');

Auth::routes();
Route::get('/search', [ArticleController::class,'search'])->name('articles.search');
Route::view('/about', 'about')->name('about');
Route::get('/categories/{category}/articles', [CategoryController::class,'showArticles'])->name('categories.articles');
Route::get('/tags/{tag}/articles', [TagController::class,'showArticles'])->name('tags.articles');
Route::get('/feedback/create', [FeedbackController::class,'create'])->name('feedback.create');
Route::post('/feedback/store', [FeedbackController::class,'store'])->name('feedback.store');
Route::get('/locale/{locale}', [LocaleController::class,'switch'])->name('locale.switch');
Route::resource('/categories', CategoryController::class);
Route::resource('/tags', TagController::class);
Route::resource('/articles', ArticleController::class);
Route::get('/draft/articles', [ArticleController::class,'draft'])->name('articles.draft');
Route::patch('/articles/{article}/status', [ArticleController::class,'updateStatus'])->name('articles.status');
Route::get('/articles/{article}/revisions', [RevisionController::class,'index'])->name('revisions.index');
Route::post('/articles/{article}/revisions/{revision}/restore', [RevisionController::class,'restore'])->name('revisions.restore');
Route::post('/articles/{article}/comments', [CommentController::class,'store'])->name('comments.store');
Route::post('/comments/{comment}/reply', [CommentController::class,'reply'])->name('comments.reply');
Route::middleware(['permission:moderate comments'])->group(function () {
    Route::get('/comments/pending', [CommentController::class,'pending'])->name('comments.pending');
    Route::patch('/comments/{comment}/approve', [CommentController::class,'approve'])->name('comments.approve');
    Route::patch('/comments/{comment}/reject', [CommentController::class,'reject'])->name('comments.reject');
});

Route::post('/articles/{article}/save', [SavedArticleController::class,'toggle'])->name('articles.save');
Route::post('/articles/{article}/like', [ArticleLikeController::class,'toggle'])->name('articles.like');
Route::post('/subscribe', [SubscriptionController::class,'store'])->name('subscribe');
Route::delete('/unsubscribe', [SubscriptionController::class,'destroy'])->name('unsubscribe');
Route::get('/feedback/sent', [FeedbackController::class,'sentFeedbacks'])->name('feedback.sent');
Route::get('/feedback/reviewed', [FeedbackController::class,'receivedFeedbacks'])->name('feedback.reviewed');
Route::patch('/feedback/{feedback}/status', [FeedbackController::class,'updateStatus'])->name('feedback.status');
Route::delete('/feedback/{feedback}', [FeedbackController::class,'destroy'])->name('feedback.destroy');
Route::middleware(['role:Admin'])->group(function () {
    Route::resource('users', UserController::class);
});
Route::get('/backup/create', [BackupController::class,'createBackup'])->name('backup.create');
Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
Route::get('/likes', [ArticleLikeController::class,'index'])->name('likes.index');
Route::get('/saved', [SavedArticleController::class,'index'])->name('saved.index');
Route::get('/profile', [ProfileController::class,'index'])->name('profile.index');
Route::get('/profile/edit', [ProfileController::class,'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class,'update'])->name('profile.update');
Route::get('/notifications', [NotificationController::class,'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class,'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class,'markAllAsRead'])->name('notifications.readAll');
Route::get('/export/csv', [ExportController::class,'exportCsv'])->name('export.csv');
Route::get('/export/pdf', [ExportController::class,'exportPdf'])->name('export.pdf');
