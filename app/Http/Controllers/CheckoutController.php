<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
}
