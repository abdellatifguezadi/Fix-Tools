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
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Route::post('/broadcasting/auth', function (Request $request) {
    if (Auth::check()) {
        $channelName = $request->input('channel_name');
        $socketId = $request->input('socket_id');
        
        if (strpos($channelName, 'private-chat.') === 0) {
            $id = str_replace('private-chat.', '', $channelName);
            
            if ((int)$id === (int)Auth::id()) {
                $pusherKey = config('broadcasting.connections.pusher.key');
                $pusherSecret = config('broadcasting.connections.pusher.secret');
                $pusherAppId = config('broadcasting.connections.pusher.app_id');
                
                $signature = hash_hmac('sha256', $socketId . ':' . $channelName, $pusherSecret);
                
                return response()->json([
                    'auth' => $pusherKey . ':' . $signature
                ]);
            }
        }
    }
    
    return response('Unauthorized', 403);
});

// Public routes
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
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

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [RegisteredUserController::class, 'login'])->name('login');
    Route::post('login', [RegisteredUserController::class, 'authenticate']);
});

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard')->with('success', 'Your email address has been successfully verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'A new verification link has been sent to your email address.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Routes protected by authentication
Route::middleware('auth')->group(function () {
    Route::post('logout', [RegisteredUserController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware('verified')->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->middleware('verified')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware('verified')->name('profile.destroy');
    Route::get('/messages', [MessageController::class, 'index'])->middleware('verified')->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->middleware('verified')->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->middleware('verified')->name('messages.store');
    Route::post('/messages/{user}/read', [MessageController::class, 'markAsRead'])->middleware('verified')->name('messages.read');
    
    // Message API routes for real-time updates
    Route::get('/api/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('api.messages.unread-count');
    
    // Routes for professionals
    Route::middleware(['professional', 'verified'])->group(function () {
        Route::get('/professional/dashboard', [ProfessionalController::class, 'index'])->name('professionals.dashboard');
        Route::get('/my-services', [ServiceController::class, 'myServices'])->name('services.my-services');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::get('/material-purchases', [MaterialPurchaseController::class, 'index'])->name('material-purchases.index');
        Route::post('/material-purchases', [MaterialPurchaseController::class, 'store'])->name('material-purchases.store');
        Route::get('/material-purchases/checkout/{purchase}', [MaterialPurchaseController::class, 'checkout'])->name('material-purchases.checkout');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
        Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
        Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('/cart/checkout', function() {
            return redirect()->route('cart.index')->with('error', 'Please complete your cart and use the checkout button.');
        });
        Route::post('/cart/complete-checkout', [CartController::class, 'completeCheckout'])->name('cart.complete-checkout');
        Route::get('/cart/payment/success', [CartController::class, 'handlePaymentSuccess'])->name('cart.payment.success');

        Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');
        Route::get('/professionals/marketplace', [MaterialPurchaseController::class, 'index'])->name('professionals.marketplace');
        Route::get('/professionals/marketplace/filter', [MaterialPurchaseController::class, 'filter'])->name('professionals.marketplace.filter');
        Route::get('/service-tracking', [ServiceTrackingController::class, 'index'])->name('service-tracking.index');
        
        Route::get('/service-requests', [\App\Http\Controllers\Professional\ServiceRequestController::class, 'index'])->name('professional.requests.index');
        Route::post('/service-requests/{serviceRequest}/update-price', [\App\Http\Controllers\Professional\ServiceRequestController::class, 'updatePrice'])->name('professional.requests.update-price');
        Route::post('/service-requests/{serviceRequest}/complete', [\App\Http\Controllers\Professional\ServiceRequestController::class, 'complete'])->name('professional.requests.complete');
    });
    
    // Routes for clients
    // Route::middleware('client')->group(function () {
    //     Route::post('/service-requests', [ServiceRequestController::class, 'store'])->name('service-requests.store');
    //     Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    // });
    
    // Routes for admin
    Route::middleware(['admin', 'verified'])->group(function () {
        Route::get('/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::post('/admin/users/{user}/suspend', [UserController::class, 'suspend'])->name('admin.users.suspend');
        Route::post('/admin/users/{user}/activate', [UserController::class, 'activate'])->name('admin.users.activate');
        Route::delete('/admin/users/{user}/delete', [UserController::class, 'delete'])->name('admin.users.delete');
        
        Route::get('/admin/services', [AdminServiceController::class, 'index'])->name('admin.services.index');
        Route::get('/admin/services/create', [AdminServiceController::class, 'create'])->name('admin.services.create');
        Route::post('/admin/services', [AdminServiceController::class, 'store'])->name('admin.services.store');
        Route::get('/admin/services/{service}/edit', [AdminServiceController::class, 'edit'])->name('admin.services.edit');
        Route::put('/admin/services/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/admin/services/{service}', [AdminServiceController::class, 'destroy'])->name('admin.services.destroy');
        Route::patch('/admin/services/{service}/toggle-status', [AdminServiceController::class, 'toggleStatus'])->name('admin.services.toggle-status');
        
        Route::get('/admin/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::delete('/admin/reviews/{review}/delete', [\App\Http\Controllers\Admin\ReviewController::class, 'delete'])->name('admin.reviews.delete');
        
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

// // Routes publiques pour consultation
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');


// Routes des services 
Route::middleware(['auth', 'client', 'verified'])->group(function () {
    Route::get('/services/search', [ClientServiceController::class, 'search'])->name('client.services.search');
    Route::get('/services/category/{category}', [ClientServiceController::class, 'byCategory'])->name('client.services.by-category');
    Route::get('/services/{service}', [ClientServiceController::class, 'show'])->name('client.services.show');
    Route::get('/services', [ClientServiceController::class, 'index'])->name('client.services.index');
    
    Route::get('/professionals', [\App\Http\Controllers\Client\ClientProfessionalController::class, 'index'])->name('client.professionals.index');
    Route::get('/professionals/{professional}', [\App\Http\Controllers\Client\ClientProfessionalController::class, 'show'])->name('client.professionals.show');
    
    Route::get('/my-requests', [ServiceRequestController::class, 'index'])->name('client.my-requests');
    Route::post('/service-requests', [ServiceRequestController::class, 'store'])->name('client.service-requests.store');
    Route::post('/service-requests/{serviceRequest}/cancel', [ServiceRequestController::class, 'cancel'])->name('client.service-requests.cancel');
    Route::post('/service-requests/{serviceRequest}/accept-price', [ServiceRequestController::class, 'acceptPrice'])->name('client.service-requests.accept-price');

    Route::get('/reviews/create/{serviceRequest}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// // Routes pour les messages
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])
        ->name('messages.show')
        ->withTrashed();  
});


