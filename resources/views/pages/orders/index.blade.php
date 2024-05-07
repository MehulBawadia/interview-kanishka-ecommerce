<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <table
                class="mt-6 w-full overflow-hidden rounded text-left text-sm text-gray-500 shadow shadow-gray-400 dark:text-gray-400">
                <thead class="bg-gray-200 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 tracking-wider">
                            Order Code
                        </th>
                        <th scope="col" class="px-6 py-3 text-right tracking-wider">
                            Total Amount
                        </th>
                        <th scope="col" class="px-6 py-3 text-right tracking-wider">
                            Ordered At
                        </th>
                        <th scope="col" class="px-6 py-3 text-right tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4 capitalize tracking-wider text-gray-800">
                                {{ $order->order_code }}
                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                {{ Number::currency($order->cart_total, 'INR', 'en_in') }}
                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                {{ $order->created_at->timezone('Asia/Kolkata')->format('M jS, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                <a href="#">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $orders->links('components.pagination') }}
        </div>
    </div>
</x-app-layout>
