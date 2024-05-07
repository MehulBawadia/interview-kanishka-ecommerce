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
            ->select(['id', 'order_code', 'cart_total', 'created_at'])
            ->latest('id')
            ->when(auth()->user()->role === 'customer', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->paginate(10);

        return view('pages.orders.index', [
            'orders' => $orders,
        ]);
    }
}
