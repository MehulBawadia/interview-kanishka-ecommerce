<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PagesController extends Controller
{
    /**
     * Show the home page with all the products.
     *
     * @return \Illuminate\View\View
     */
    public function allProducts()
    {
        $products = Product::query()
            ->select(['id', 'name', 'images', 'price'])
            ->active()
            ->latest('id')
            ->paginate(12);

        return view('pages.all-products', [
            'products' => $products,
        ]);
    }
}
