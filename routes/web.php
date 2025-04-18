<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\Client\ServiceRequestController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialPurchaseController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceTrackingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientServiceController;

// Routes publiques
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'professional':
                return redirect()->route('services.my-services');
            case 'client':
                return view('welcome');
            default:
                return view('welcome');
        }
    }
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

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::post('logout', [RegisteredUserController::class, 'destroy'])->name('logout');
    
    // Dashboard principal (redirection automatique selon le rôle)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile (accessible à tous les utilisateurs authentifiés)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Messages (accessible à tous les utilisateurs authentifiés)
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    
    // Routes pour les professionnels
    Route::middleware('professional')->group(function () {
        Route::get('/professional/dashboard', [ProfessionalController::class, 'index'])->name('professionals.dashboard');
        Route::get('/my-services', [ServiceController::class, 'myServices'])->name('services.my-services');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::get('/material-purchases', [MaterialPurchaseController::class, 'index'])->name('material-purchases.index');
        Route::post('/material-purchases', [MaterialPurchaseController::class, 'store'])->name('material-purchases.store');
        Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');
        Route::get('/professionals/marketplace', [MaterialPurchaseController::class, 'index'])->name('professionals.marketplace');
        Route::get('/professionals/marketplace/filter', [MaterialPurchaseController::class, 'filter'])->name('professionals.marketplace.filter');
        Route::get('/service-tracking', [ServiceTrackingController::class, 'index'])->name('service-tracking.index');
        
        // Service Request Management for professionals
        Route::get('/service-requests', [\App\Http\Controllers\Professional\ServiceRequestController::class, 'index'])->name('professional.requests.index');
        Route::post('/service-requests/{serviceRequest}/update-price', [\App\Http\Controllers\Professional\ServiceRequestController::class, 'updatePrice'])->name('professional.requests.update-price');
        Route::post('/service-requests/{serviceRequest}/complete', [\App\Http\Controllers\Professional\ServiceRequestController::class, 'complete'])->name('professional.requests.complete');
    });
    
    // Routes pour les clients
    // Route::middleware('client')->group(function () {
    //     Route::post('/service-requests', [ServiceRequestController::class, 'store'])->name('service-requests.store');
    //     Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    // });
    
    // Routes pour l'admin
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        // User Management Routes
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::post('/admin/users/{user}/suspend', [UserController::class, 'suspend'])->name('admin.users.suspend');
        Route::post('/admin/users/{user}/activate', [UserController::class, 'activate'])->name('admin.users.activate');
        
        // Service Management Routes
        Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services.index');
        Route::get('/admin/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
        Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
        Route::get('/admin/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
        Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
        
        // Existing admin routes
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    });

  
});

// Routes publiques pour consultation
Route::get('/professionals/{professional}', [ProfessionalController::class, 'show'])->name('professionals.show');
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');

// Routes des avis (accessibles aux clients authentifiés)
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/reviews/create/{serviceRequest}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Routes des services (accès client uniquement)
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/services/search', [ClientServiceController::class, 'search'])->name('client.services.search');
    Route::get('/services/category/{category}', [ClientServiceController::class, 'byCategory'])->name('client.services.by-category');
    Route::get('/services/{service}', [ClientServiceController::class, 'show'])->name('client.services.show');
    Route::get('/services', [ClientServiceController::class, 'index'])->name('client.services.index');
    
    Route::get('/my-requests', [ServiceRequestController::class, 'index'])->name('client.my-requests');
    Route::post('/service-requests', [ServiceRequestController::class, 'store'])->name('client.service-requests.store');
    Route::post('/service-requests/{serviceRequest}/cancel', [ServiceRequestController::class, 'cancel'])->name('client.service-requests.cancel');
    Route::post('/service-requests/{serviceRequest}/accept-price', [ServiceRequestController::class, 'acceptPrice'])->name('client.service-requests.accept-price');
});
