<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartProductRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $cart = $user->cartProducts;

        return view('pages.checkout', [
            'user' => $user,
            'cart' => $cart,
        ]);
    }

    public function placeOrder(Request $request)
    {
        $user = auth()->user();

        $cart = [];
        foreach ($user->cartProducts as $cartProduct) {
            $cart[] = [
                'product_id' => $cartProduct->product_id,
                'product_name' => $cartProduct->product_name,
                'product_image' => $cartProduct->product_image,
                'product_price' => $cartProduct->price,
                'product_quantity' => $cartProduct->quantity,
                'product_amount' => $cartProduct->amount,
            ];
        }

        Order::create([
            'user_id' => $user->id,
            'order_code' => Str::random(8) . '-' . mt_rand(1, 9999),
            'billing_details' => json_encode([
                'name' => $request->billing_name,
                'email' => $request->billing_email,
                'phone_number' => $request->billing_phone_number,
                'address' => $request->billing_address,
            ]),
            'shipping_details' => json_encode([
                'name' => $request->shipping_name,
                'email' => $request->shipping_email,
                'phone_number' => $request->shipping_phone_number,
                'address' => $request->shipping_address,
            ]),
            'product_details' => json_encode($cart),
            'cart_total' => $user->cartProducts->sum('amount'),
        ]);

        $user->cartProducts->each->delete();

        return to_route('dashboard');
    }
}
