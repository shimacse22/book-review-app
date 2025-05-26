<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendAuthController;
use App\Http\Controllers\Backend\BooksController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\UserProfileController;
use Illuminate\Support\Facades\Http; 


Route::get('/', function () {
    return view('welcome');
});

Route::get('/book-review', function () {
    return view('frontend.index');
})->name('books');


Route::get('/books/{id}', function () {
    return view('frontend.book-detail');
})->name('book-detail');

Route::get('/register', function () {
    return view('frontend.auth.register');
})->name('register');

Route::get('/login', function () {
    return view('frontend.auth.login');
})->name('login');

// Admin routes with prefix "admin"
Route::prefix('admin')->group(function () {

     // Only accessible to guests (not logged in)
     Route::middleware('guest')->group(function () {
         Route::get('/login', [BackendAuthController::class, 'showLoginForm'])->name('admin.login');
         Route::post('/login', [BackendAuthController::class, 'login']);
         Route::get('/register', [BackendAuthController::class, 'showRegisterForm'])->name('admin.register');
         Route::post('/register', [BackendAuthController::class, 'register']);
     });

    // Only accessible to authenticated users
    Route::middleware(['auth', 'admin'])->group(function () {
       
        Route::get('/dashboard', [BackendAuthController::class, 'dashboard'])->name('admin.dashboard');
         // Profile Routes
        Route::get('/profile', [UserProfileController::class, 'profile'])->name('admin.profile');
        
        Route::put('/profile/update', [UserProfileController::class, 'update'])->name('admin.profile.update');
         // Book CRUD Routes
        Route::get('/books', [BooksController::class, 'index'])->name('books.index');
        Route::get('/books/create', [BooksController::class, 'create'])->name('books.create');
        Route::post('/books/store', [BooksController::class, 'store'])->name('books.store');
        Route::get('/books/{book}/edit', [BooksController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}/update', [BooksController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}/delete', [BooksController::class, 'destroy'])->name('books.destroy');

        // Admin review management
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });

});


