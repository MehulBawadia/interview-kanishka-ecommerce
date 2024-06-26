<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display the orders list.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::query()
            ->select(['id', 'user_id', 'billing_details', 'order_code', 'cart_total', 'created_at'])
            ->latest('id')
            ->when(auth()->user()->role === 'customer', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->when(auth()->user()->role === 'admin', function ($query) {
                $query->with(['user:id,name,email']);
            })
            ->paginate(10);

        return view('pages.orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display the order detials of the given order code.
     *
     * @return \Illuminate\View\View
     */
    public function show($orderCode)
    {
        $order = Order::query()
            ->select(['id', 'user_id', 'order_code', 'billing_details', 'shipping_details', 'product_details', 'cart_total', 'created_at'])
            ->where('order_code', $orderCode)
            ->when(auth()->user()->role === 'customer', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->when(auth()->user()->role === 'admin', function ($query) {
                $query->with(['user:id,name,email']);
            })
            ->firstOrFail();

        return view('pages.orders.show', [
            'order' => $order,
        ]);
    }
}
