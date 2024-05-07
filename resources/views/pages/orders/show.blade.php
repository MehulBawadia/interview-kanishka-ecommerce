<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 rounded bg-white px-4 py-3 shadow md:grid-cols-2">
                <div>
                    <h3 class="font-semibold tracking-wider text-gray-600">Order Code</h3>
                    <div class="text-lg font-bold text-gray-800">{{ $order->order_code }}</div>
                </div>
                <div class="text-right">
                    <h3 class="font-semibold tracking-wider text-gray-600">Ordered At</h3>
                    <div class="text-lg font-bold text-gray-800">
                        {{ $order->created_at->timezone('Asia/Kolkata')->format('M jS, Y h:i A') }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 rounded bg-white px-4 py-3 shadow md:grid-cols-2">
                <div>
                    <h3 class="text-lg font-semibold tracking-wider">Billing Details</h3>

                    <div class="mt-4">
                        <span class="text-gray-600">Name:</span> {{ $order->billing_details['name'] }}<br />
                        <span class="text-gray-600">E-Mail:</span> {{ $order->billing_details['email'] }}<br />
                        <span class="text-gray-600">Phone Number:</span>
                        {{ $order->billing_details['phone_number'] }}<br />
                        <span class="text-gray-600">Address:</span> {{ $order->billing_details['address'] }}<br />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold tracking-wider">Shipping Details</h3>

                    <div class="mt-4">
                        <span class="text-gray-600">Name:</span> {{ $order->shipping_details['name'] }}<br />
                        <span class="text-gray-600">E-Mail:</span> {{ $order->shipping_details['email'] }}<br />
                        <span class="text-gray-600">Phone Number:</span>
                        {{ $order->shipping_details['phone_number'] }}<br />
                        <span class="text-gray-600">Address:</span> {{ $order->shipping_details['address'] }}<br />
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <table
                class="mt-6 w-full overflow-hidden rounded text-left text-sm text-gray-500 shadow shadow-gray-400 dark:text-gray-400">
                <thead class="bg-gray-200 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 tracking-wider">
                            Name and Image
                        </th>
                        <th scope="col" class="px-6 py-3 text-right tracking-wider">
                            Quantity
                        </th>
                        <th scope="col" class="px-6 py-3 text-right tracking-wider">
                            Rate
                        </th>
                        <th scope="col" class="px-6 py-3 text-right tracking-wider">
                            Amount
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->product_details as $product)
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4 capitalize tracking-wider text-gray-800">
                                <img src="{{ asset('/storage/' . $product['product_image']) }}"
                                    alt="{{ $product['product_name'] }}" class="mr-2 inline-flex h-12 w-12 rounded" />

                                {{ $product['product_name'] }}
                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                {{ $product['product_quantity'] }}
                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                {{ Number::currency($product['product_price'], 'INR', 'en_in') }}
                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                {{ Number::currency($product['product_amount'], 'INR', 'en_in') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="border-b bg-white">
                        <td colspan="3"
                            class="px-6 py-4 text-right text-xl font-semibold tracking-wider text-gray-800">
                            Total Amount Paid:
                        </td>
                        <td class="px-6 py-4 text-right text-xl font-semibold tracking-wider text-gray-800">
                            {{ Number::currency($order->cart_total, 'INR', 'en_in') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
