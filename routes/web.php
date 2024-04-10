<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\UserController;

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

// Home routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/find', [HomeController::class, 'searchContent']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/policy', [HomeController::class, 'policy']);

// Blog content routes
Route::get('/news/{id}', [BlogController::class, 'index']);
Route::post('/send-notif', [BlogController::class, 'sendComment']);

// Dashboard author
Route::get('/notification/{email}', [AuthorController::class, 'notification']);
Route::prefix('author')->middleware(['auth'])->group(function () {
    Route::get('/', [AuthorController::class, 'index']);
    Route::get('/create', [AuthorController::class, 'createContent']);
    Route::get('/edit/{id}', [AuthorController::class, 'updateContent']);
    Route::get('/profile', [UserController::class, 'index']);
    Route::post('/create-content', [AuthorController::class, 'postContent']);
    Route::post('/update-content/{id}', [AuthorController::class, 'editContent']);
    Route::post('/delete-content/{id}', [AuthorController::class, 'deleteContent']);
    // Route::group(function () {
    // });
});
Route::post('/upload-image', [ImageUploadController::class, 'uploadImage'])->name('upload.image');

// Auth routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/callback/google', [AuthController::class, 'handleGoogleCallback']);
Route::get('/logout', [AuthController::class, 'logout']);

// //empty page
// Route::get('')

