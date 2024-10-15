<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AllContentController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\VoteController;
use App\Models\Reply;
use App\Models\Thread;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{user}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/threads', [ThreadController::class, 'index'])->name('threads');
Route::get('/questions', [QuestionController::class, 'index'])->name('questions');
Route::get('/all', [AllContentController::class, 'index'])->name('all.content');

Route::get("/threads/create", [ThreadController::class, 'create'])->middleware('auth')->name('threads.create');
Route::get("/questions/create", [QuestionController::class, 'create'])->middleware('auth')->name('questions.create');

Route::get("/threads/{channel}", [ThreadController::class, 'index'])->name('threads.channel');
Route::get("/questions/{channel}", [QuestionController::class, 'index'])->name('questions.channel');
Route::get('/all/{channel}', [AllContentController::class, 'index'])->name('all.channel');

Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

Route::post('/threads/{channel}/{thread}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::post('/questions/{channel}/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');

Route::get("/threads/{channel}/{thread}", [ThreadController::class, 'show'])->name('threads.show');
Route::get("/questions/{channel}/{question}", [QuestionController::class, 'show'])->name('questions.show');

Route::get("/threads/{channel}/{thread}/edit", [ThreadController::class, 'edit'])->name('threads.edit');
Route::get("/questions/{channel}/{question}/edit", [QuestionController::class, 'edit'])->name('questions.edit');

Route::patch("/threads/{channel}/{thread}", [ThreadController::class, 'update'])->name('threads.update');
Route::patch("/questions/{channel}/{question}", [QuestionController::class, 'update'])->name('questions.update');

Route::delete("/threads/{channel}/{thread}", [ThreadController::class, 'destroy'])->name('threads.destroy');
Route::delete("/questions/{channel}/{question}", [QuestionController::class, 'destroy'])->name('questions.destroy');


Route::post('{type}/{id}/favorites', [FavoriteController::class, 'store'])->name('replies.favorite');
Route::post('{type}/{id}/upvotes', [VoteController::class, 'upvote'])->name('answers.upvote');
Route::post('{type}/{id}/downvotes', [VoteController::class, 'downvote'])->name('answers.downvote');

Route::delete('{type}/{id}/favorites', [FavoriteController::class, 'destroy'])->name('replies.unfavorite');
Route::delete('{type}/{id}/upvotes', [VoteController::class, 'removeUpvote'])->name('answers.removeUpvote');
Route::delete('{type}/{id}/downvotes', [VoteController::class, 'removeDownvote'])->name('answers.removeDownvote');

Route::post('/questions/{question}/answers/{answer}/best', [AnswerController::class, 'best'])->name('answers.best');
Route::delete('/questions/{question}/answers/{answer}/best', [AnswerController::class, 'removeBest'])->name('answers.removeBest');

Route::get('/replies/{reply}/isFavorited', [ReplyController::class, 'isFavorited'])->name('replies.isFavorited');
Route::get('/answers/{answer}/isVoted', [AnswerController::class, 'isVoted'])->name('answers.isVoted');

Route::patch("/replies/{reply}", [ReplyController::class, 'update'])->name('replies.update');
Route::patch("/answers/{answer}", [AnswerController::class, 'update'])->name('answers.update');

Route::delete("/replies/{reply}", [ReplyController::class, 'destroy'])->name('replies.destroy');
Route::delete("/answers/{answer}", [AnswerController::class, 'destroy'])->name('answers.destroy');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

Route::get('/profiles/{user:name}', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/upload-image', [ImageController::class, 'upload'])->name('image.upload');
Route::delete('/upload-image/{image}', [ImageController::class, 'destroy'])->name('image.destroy');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::fallback(function () {
    return Inertia::render('NotFoundPage');
});

Route::get('inertia', function () {
    return inertia('Inertia');
})->name('inertia');

require __DIR__ . '/auth.php';
