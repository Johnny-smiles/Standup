<?php

use App\Http\Controllers\Auth\ValidateInstallationController;
use App\Http\Controllers\GitHubController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SlackBotController;
use App\Http\Controllers\SlackLoginController;
use App\Http\Controllers\SlackOauth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ToggleActivityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkdayController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'login' => false,
    'register' => false,
]);

Route::get('/', function () {
    return view('slack.landing');
})->name('slack.landing');

Route::get('/temporary-home', function () {
    return view('pages.TemporaryHome');
})->name('temporary-home');

Route::post('standups/', SlackBotController::class)->name('standups.index');

Route::group([
    'prefix' => 'oauth',
    'as' => 'slack.',
    'middleware' => 'guest',
], function () {
    Route::get('/redirect', [SlackLoginController::class, 'loginRedirect'])->name('redirect');

    Route::get('/callback', [SlackOauth::class, 'oAuthCallback'])->name('callback');

    Route::post('/validate-installation', ValidateInstallationController::class)->name('validate');
});

Route::group([
    'prefix' => 'oauth/github',
    'as' => 'github.',
    'middleware' => 'auth',
], function () {
    Route::get('/redirect', [GitHubController::class, 'githubOauthRedirect'])->name('redirect');

    Route::get('/deleted', [GitHubController::class, 'deleteGitHubLink'])->name('unlink');
});

Route::group([
    'prefix' => 'tasks',
    'as' => 'task.',
    'middleware' => 'auth',
], function () {
    Route::post('/edit/{task}', [TaskController::class, 'update'])->name('update');

    Route::post('/search', [TaskController::class, 'show'])->name('search');

    Route::post('/delete/{task}', [TaskController::class, 'delete'])->name('delete');
});

Route::group([
    'prefix' => 'workday',
    'as' => 'workday.',
    'middleware' => 'auth',
], function () {
    Route::get('/show/{workday}', [WorkdayController::class, 'show'])->name('show');

    Route::post('/search', [WorkdayController::class, 'search'])->name('search');

    Route::post('/delete/{workday}', [WorkdayController::class, 'delete'])->name('delete');
});

Route::group([
    'middleware' => 'auth',
], function () {
    Route::get('activity/{status}', ToggleActivityController::class)->name('activity');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/home/{alert}', [HomeController::class, 'alert'])->name('alert');

    Route::get('/users', UserController::class)->name('users');
});
