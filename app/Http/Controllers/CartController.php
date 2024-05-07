<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display the cart index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = auth()->user()->cartProducts;

        return view('pages.cart', [
            'cart' => $cart,
        ]);
    }

    /**
     * Add products in the cart.
     *
     * @param  mixed  $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($productId, CartProductRequest $request)
    {
        $product = Product::find($productId);
        if (! $product) {
            abort(404);
        }

        DB::beginTransaction();

        try {
            $quantity = $request->quantity ?? 1;
            auth()->user()->addProductInCart($product, $quantity);

            DB::commit();

            return back()->with([
                'status' => 'product-added-in-cart',
            ]);
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            DB::rollBack();

            return back()->with([
                'status' => 'could-not-add-product-in-cart',
            ]);
        }
    }

    /**
     * Update the product quantity of the given cart id.
     *
     * @param  mixed  $cartId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($cartId, CartProductRequest $request)
    {
        $user = auth()->user();
        $cart = $user->cartProducts;

        $cartProduct = $cart->find($cartId);
        if (! $cartProduct) {
            abort(404);
        }

        DB::beginTransaction();

        try {
            $cartProduct->update([
                'quantity' => $request->quantity,
                'amount' => (float) ($cartProduct->price * $request->quantity),
            ]);

            DB::commit();

            return to_route('cart.index')->with([
                'status' => 'product-quantity-updated',
            ]);
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            DB::rollBack();

            return to_route('cart.index')->with([
                'status' => 'could-not-update-product-quantity',
            ]);
        }
    }

    /**
     * Destroy the cart product of the given id.
     *
     * @param  mixed  $cartId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($cartId)
    {
        $user = auth()->user();
        $cart = $user->cartProducts;

        $cartProduct = $cart->find($cartId);
        if (! $cartProduct) {
            abort(404);
        }

        DB::beginTransaction();

        try {
            $cartProduct->delete();

            DB::commit();

            return to_route('cart.index')->with([
                'status' => 'product-quantity-deleted',
            ]);
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            DB::rollBack();

            return to_route('cart.index')->with([
                'status' => 'could-not-delete-product-quantity',
            ]);
        }
    }
}
