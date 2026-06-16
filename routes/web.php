<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\Admin\MatchController as AdminMatchController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\RankingController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('predictions.index');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('/predictions', [PredictionController::class, 'index'])->name('predictions.index');
    Route::post('/predictions', [PredictionController::class, 'store'])->name('predictions.store');

    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics.index');

    Route::get('/rankings/global',   [RankingController::class, 'global'])->name('rankings.global');
    Route::get('/rankings/location', [RankingController::class, 'location'])->name('rankings.location');
    Route::get('/rankings/team',     [RankingController::class, 'team'])->name('rankings.team');
});

// Route publik (tidak perlu login)
Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/matches',                  [AdminMatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/create',           [AdminMatchController::class, 'create'])->name('matches.create');
    Route::post('/matches',                 [AdminMatchController::class, 'store'])->name('matches.store');
    Route::get('/matches/{fixture}/edit',   [AdminMatchController::class, 'edit'])->name('matches.edit');
    Route::patch('/matches/{fixture}',      [AdminMatchController::class, 'update'])->name('matches.update');
    Route::delete('/matches/{fixture}',     [AdminMatchController::class, 'destroy'])->name('matches.destroy');
});

require __DIR__ . '/auth.php';
