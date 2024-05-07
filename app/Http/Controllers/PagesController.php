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
            ->select(['id', 'name', 'images', 'price', 'description'])
            ->active()
            ->latest('id')
            ->paginate(12);

        return view('pages.all-products', [
            'products' => $products,
        ]);
    }

    /**
     * Show the product details page.
     *
     * @return \Illuminate\View\View
     */
    public function showProduct($productId)
    {
        $product = Product::query()
            ->select(['id', 'name', 'images', 'price', 'description'])
            ->active()
            ->where('id', $productId)
            ->firstOrFail();

        return view('pages.product-details', [
            'product' => $product,
        ]);
    }
}
