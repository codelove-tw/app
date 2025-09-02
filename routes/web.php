<?php

use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [GeneralController::class, 'index'])->name('index');

Route::get('/react', function () {
    return view('react');
});

Route::get('/utils', function () {
    return view('utils');
});

Route::post('/utils/upload-image', [GeneralController::class, 'uploadImage']);

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ideas routes
use App\Http\Controllers\Idea\CommentController;
use App\Http\Controllers\Idea\IdeaController;
use App\Http\Controllers\Idea\VoteController;

Route::prefix('ideas')->name('ideas.')->group(function () {
    Route::get('/', [IdeaController::class, 'index'])->name('index');
    Route::get('/create', [IdeaController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/', [IdeaController::class, 'store'])->name('store')->middleware('auth');
    Route::get('/{idea}', [IdeaController::class, 'show'])->name('show');
    Route::get('/{idea}/edit', [IdeaController::class, 'edit'])->name('edit')->middleware('auth');
    Route::put('/{idea}', [IdeaController::class, 'update'])->name('update')->middleware('auth');
    Route::delete('/{idea}', [IdeaController::class, 'destroy'])->name('destroy')->middleware('auth');

    // Vote routes
    Route::post('/{idea}/vote', [VoteController::class, 'toggle'])->name('vote.toggle')->middleware('auth');

    // Comment routes
    Route::post('/{idea}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');
});

require __DIR__.'/admin.php';
