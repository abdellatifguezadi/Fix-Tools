<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\LoyaltyPoint;
use App\Models\Material;
use App\Models\MaterialPurchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mollie\Laravel\Facades\Mollie;

class CartController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $cart = Cart::getOrCreateCart($user->id);
        $cart->load('items.material.category');
        
        $userPoints = $user->loyalty_points;
        if($userPoints === null) {
            $userPoints = LoyaltyPoint::where('professional_id', $user->id)->sum('points_earned') - 
                         MaterialPurchase::where('professional_id', $user->id)->sum('points_used');
        }
        
        return view('professionals.cart', compact('cart', 'user', 'userPoints'));
    }

    /**
     * Add a product to the cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $material = Material::findOrFail($request->material_id);
        $cart = Cart::getOrCreateCart($user->id);

        
        if ($material->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Requested quantity not available in stock.');
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
                           ->where('material_id', $request->material_id)
                           ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($material->stock_quantity < $newQuantity) {
                return redirect()->back()->with('error', 'Total requested quantity not available in stock.');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'material_id' => $request->material_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }


    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($itemId);
        
        $user = Auth::user();
        $cart = Cart::where('professional_id', $user->id)->where('is_active', true)->firstOrFail();
        
        if ($cartItem->cart_id != $cart->id) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }

        $material = $cartItem->material;
        if ($material->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Requested quantity not available in stock.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Quantity updated successfully.');
    }


    public function removeItem($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        
        $user = Auth::user();
        $cart = Cart::where('professional_id', $user->id)->where('is_active', true)->firstOrFail();
        
        if ($cartItem->cart_id != $cart->id) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }


    public function clearCart()
    {
        $user = Auth::user();
        $cart = Cart::where('professional_id', $user->id)->where('is_active', true)->firstOrFail();
        
        CartItem::where('cart_id', $cart->id)->delete();

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }


    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cart,points',
        ]);

        $user = Auth::user();
        $cart = Cart::where('professional_id', $user->id)->where('is_active', true)->firstOrFail();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $userPoints = $user->loyalty_points;
        if($userPoints === null) {
            $userPoints = LoyaltyPoint::where('professional_id', $user->id)->sum('points_earned') - 
                         MaterialPurchase::where('professional_id', $user->id)->sum('points_used');
        }

        $totalPrice = $cart->getTotal();
        $totalPoints = 0;
        
        foreach ($cart->items as $item) {
            $totalPoints += $item->getPointsCost();
        }

        if ($request->payment_method == 'points' && $userPoints < $totalPoints) {
            return redirect()->route('cart.index')->with('error', 'You don\'t have enough points for this payment method.');
        }

        if ($request->payment_method == 'points') {
            $pointsUsed = $totalPoints;
            $priceToPay = 0;
        } else {
            $pointsUsed = 0;
            $priceToPay = $totalPrice;
        }

        session([
            'checkout_data' => [
                'cart_id' => $cart->id,
                'payment_method' => $request->payment_method,
                'points_used' => $pointsUsed,
                'price_to_pay' => $priceToPay,
            ]
        ]);

        return view('professionals.checkout', compact('cart', 'user', 'userPoints', 'pointsUsed', 'priceToPay'));
    }


    public function prepareMolliePayment($cart, $priceToPay, Request $request)
    {
        $user = Auth::user();
        
        if ($request) {
            session()->put('delivery_info', [
                'address' => $request->address,
                'phone' => $request->phone,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
            ]);
        } else {
            $deliveryInfo = session('delivery_info');
            if (!$deliveryInfo) {
                return redirect()->route('cart.index')->with('error', 'Missing delivery information. Please try again.');
            }
        }
        
        $formattedPrice = number_format($priceToPay, 2, '.', '');
        
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $formattedPrice 
            ],
            "description" => "Order #{$cart->id}",
            "redirectUrl" => route('cart.payment.success'),
            "metadata" => [
                "cart_id" => $cart->id,
                "user_id" => $user->id,
            ],
        ]);

        session(['mollie_payment_id' => $payment->id]);

        return redirect($payment->getCheckoutUrl(), 303);
    }


    public function handlePaymentSuccess(Request $request)
    {
        $paymentId = session('mollie_payment_id');
        
        if (!$paymentId) {
            return redirect()->route('cart.index')->with('error', 'Payment session expired. Please try again.');
        }
        
        $payment = Mollie::api()->payments->get($paymentId);
        
        if ($payment->isPaid()) {
            $checkoutData = session('checkout_data');
            $deliveryInfo = session('delivery_info');
            
            if (!$checkoutData || !$deliveryInfo) {
                return redirect()->route('cart.index')->with('error', 'Payment session expired. Please try again.');
            }
            
            $cart = Cart::findOrFail($checkoutData['cart_id']);
            $user = Auth::user();
            
            if ($cart->professional_id != $user->id) {
                return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
            }
            
            foreach ($cart->items as $item) {
                $material = $item->material;
                
                if ($material->stock_quantity < $item->quantity) {
                    return redirect()->route('cart.index')->with('error', 'The stock of product ' . $material->name . ' has changed. Quantity not available.');
                }
                
                $purchase = MaterialPurchase::create([
                    'professional_id' => $user->id,
                    'material_id' => $material->id,
                    'quantity' => $item->quantity,
                    'price_paid' => $item->getSubtotal(),
                    'points_used' => 0,
                    'payment_method' => 'cart',
                    'status' => 'completed',
                    'transaction_id' => $paymentId,
                    'delivery_address' => $deliveryInfo['address'],
                    'delivery_phone' => $deliveryInfo['phone'],
                    'delivery_city' => $deliveryInfo['city'],
                    'delivery_postal_code' => $deliveryInfo['postal_code'],
                ]);

                $material->stock_quantity -= $item->quantity;
                $materialToUpdate = \App\Models\Material::find($material->id);
                if ($materialToUpdate) {
                    $materialToUpdate->stock_quantity = $material->stock_quantity;
                    $materialToUpdate->save();
                }
            }
            
            $cart->update(['is_active' => false]);
            $newCart = Cart::create([
                'professional_id' => $user->id,
                'is_active' => true
            ]);
            
            session()->forget(['checkout_data', 'mollie_payment_id', 'delivery_info']);
            
            return redirect()->route('material-purchases.index')->with('success', 'Payment successful! Your purchase has been completed.');
        }
        
        return redirect()->route('cart.index')->with('error', 'Payment was not successful. Please try again.');
    }

    public function completeCheckout(Request $request)
    {
        $user = Auth::user();
        $checkoutData = session('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('cart.index')->with('error', 'Payment session expired. Please try again.');
        }
        
        $cart = Cart::findOrFail($checkoutData['cart_id']);
        
        if ($cart->professional_id != $user->id) {
            return redirect()->route('cart.index')->with('error', 'Unauthorized action.');
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'save_info' => 'nullable|boolean',
        ], [
            'address.required' => 'L\'adresse de livraison est obligatoire',
            'phone.required' => 'Le numéro de téléphone est obligatoire',
            'city.required' => 'La ville est obligatoire',
            'postal_code.required' => 'Le code postal est obligatoire',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('delivery_errors', $validator->errors()->all());
        }

        session()->put('delivery_info', [
            'address' => $request->address,
            'phone' => $request->phone,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ]);

        if ($request->has('save_info') && $request->save_info) {
            $userToUpdate = User::find(Auth::id());
            if ($userToUpdate) {
                $userToUpdate->address = $request->address;
                $userToUpdate->phone = $request->phone;
                $userToUpdate->city = $request->city;
                $userToUpdate->postal_code = $request->postal_code;
                $userToUpdate->save();
            }
        }

        if ($checkoutData['payment_method'] == 'cart') {
            return $this->prepareMolliePayment($cart, $checkoutData['price_to_pay'], $request);
        }

        foreach ($cart->items as $item) {
            $material = $item->material;
            
            if ($material->stock_quantity < $item->quantity) {
                return redirect()->route('cart.index')->with('error', 'The stock of product ' . $material->name . ' has changed. Quantity not available.');
            }
            
            $purchase = MaterialPurchase::create([
                'professional_id' => $user->id,
                'material_id' => $material->id,
                'quantity' => $item->quantity,
                'price_paid' => 0, // Paiement par points, donc prix payé = 0
                'points_used' => $item->getPointsCost(),
                'payment_method' => 'points',
                'status' => 'completed',
                'delivery_address' => $request->address,
                'delivery_phone' => $request->phone,
                'delivery_city' => $request->city,
                'delivery_postal_code' => $request->postal_code,
            ]);

            $material->stock_quantity -= $item->quantity;
            $materialToUpdate = Material::find($material->id);
            if ($materialToUpdate) {
                $materialToUpdate->stock_quantity = $material->stock_quantity;
                $materialToUpdate->save();
            }
        }

        // Mettre à jour les points de fidélité de l'utilisateur
        if ($user->loyalty_points !== null) {
            $userToUpdate = User::find($user->id);
            if ($userToUpdate) {
                $userToUpdate->loyalty_points = $userToUpdate->loyalty_points - $checkoutData['points_used'];
                $userToUpdate->save();
            }
        }

        $cart->update(['is_active' => false]);
        $newCart = Cart::create([
            'professional_id' => $user->id,
            'is_active' => true
        ]);

        session()->forget(['checkout_data', 'delivery_info']);

        return redirect()->route('material-purchases.index')->with('success', 'Purchase completed successfully!');
    }
} 