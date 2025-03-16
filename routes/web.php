<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialPurchaseController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;

// Routes publiques
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [RegisteredUserController::class, 'login'])->name('login');
    Route::post('login', [RegisteredUserController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [RegisteredUserController::class, 'destroy'])->name('logout');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    
    // Service Requests
    Route::get('/service-requests', [ServiceRequestController::class, 'index'])->name('service-requests.index');
    Route::post('/service-requests', [ServiceRequestController::class, 'store'])->name('service-requests.store');
    Route::get('/service-requests/{serviceRequest}', [ServiceRequestController::class, 'show'])->name('service-requests.show');
    Route::put('/service-requests/{serviceRequest}', [ServiceRequestController::class, 'update'])->name('service-requests.update');
    
    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Material Purchases
    Route::get('/material-purchases', [MaterialPurchaseController::class, 'index'])->name('material-purchases.index');
    Route::post('/material-purchases', [MaterialPurchaseController::class, 'store'])->name('material-purchases.store');
});

// Routes pour les professionnels
Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');
Route::get('/professionals/{professional}', [ProfessionalController::class, 'show'])->name('professionals.show');

// Routes pour les catégories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Routes pour les matériaux
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
});
Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');

// Routes pour les services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/category/{category}', [ServiceController::class, 'byCategory'])->name('services.by-category');
Route::middleware('auth')->group(function () {
    Route::get('/my-services', [ServiceController::class, 'myServices'])->name('services.my-services');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
});
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
