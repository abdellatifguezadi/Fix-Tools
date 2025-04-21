<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\LoyaltyPoint;
use App\Models\Material;
use App\Models\MaterialPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'payment_method' => 'required|in:card,points',
        ]);

        $user = Auth::user();
        $cart = Cart::where('professional_id', $user->id)->where('is_active', true)->firstOrFail();
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $userPoints = $user->loyalty_points;
        if($userPoints === null) {
            $userPoints = \App\Models\LoyaltyPoint::where('professional_id', $user->id)->sum('points_earned') - 
                         \App\Models\MaterialPurchase::where('professional_id', $user->id)->sum('points_used');
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


    public function completeCheckout()
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

        foreach ($cart->items as $item) {
            $material = $item->material;
            
            if ($material->stock_quantity < $item->quantity) {
                return redirect()->route('cart.index')->with('error', 'The stock of product ' . $material->name . ' has changed. Quantity not available.');
            }
            
            $purchase = MaterialPurchase::create([
                'professional_id' => $user->id,
                'material_id' => $material->id,
                'quantity' => $item->quantity,
                'price_paid' => $checkoutData['payment_method'] == 'points' ? 0 : $item->getSubtotal(),
                'points_used' => $checkoutData['payment_method'] == 'points' ? $item->getPointsCost() : 0,
                'payment_method' => $checkoutData['payment_method'],
                'status' => 'completed'
            ]);

            $material->stock_quantity -= $item->quantity;
            $material->save();
        }

        if ($checkoutData['points_used'] > 0) {
            if ($user->loyalty_points !== null) {
                $user->loyalty_points -= $checkoutData['points_used'];
                $user->save();
            }
        }

        $cart->update(['is_active' => false]);
        $newCart = Cart::create([
            'professional_id' => $user->id,
            'is_active' => true
        ]);

        session()->forget('checkout_data');

        return redirect()->route('material-purchases.cart')->with('success', 'Purchase completed successfully!');
    }
} 