<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status') === 'product-quantity-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="rounded bg-green-500 px-3 py-2 text-sm text-white">
                    Product quantity successfully updated in the cart.
                </div>
            @endif

            @if (session('status') === 'product-quantity-deleted')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="rounded bg-green-500 px-3 py-2 text-sm text-white">
                    Product successfully deleted from the cart.
                </div>
            @endif

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
                    @foreach ($cart as $cartProduct)
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4 capitalize tracking-wider text-gray-800">
                                <div class="flex">
                                    <img src="{{ asset('/storage/' . $cartProduct->product_image) }}"
                                        alt="{{ $cartProduct->product_name }}"
                                        class="mr-2 inline-flex h-12 w-12 rounded" />

                                    <div>
                                        {{ $cartProduct->product_name }}

                                        <form method="POST" action="{{ route('cart.destroy', $cartProduct->id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="mt-2 rounded tracking-wider text-red-500 hover:text-red-700">Remove
                                                from Cart</button>
                                        </form>
                                    </div>
                                </div>

                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                <form method="POST" action="{{ route('cart.update', $cartProduct->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="number" name="quantity" value="{{ $cartProduct->quantity }}"
                                        class="w-24" min="1" max="99" step="1" />

                                    <button type="submit"
                                        class="rounded bg-indigo-500 px-3 py-1 tracking-wider text-white shadow hover:bg-indigo-700">Change</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                {{ Number::currency($cartProduct->price, 'INR', 'en_in') }}
                            </td>
                            <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                {{ Number::currency($cartProduct->amount, 'INR', 'en_in') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="border-b bg-white">
                        <td colspan="3"
                            class="px-6 py-4 text-right text-xl font-semibold tracking-wider text-gray-800">
                            Cart Total:
                        </td>
                        <td class="px-6 py-4 text-right text-xl font-semibold tracking-wider text-gray-800">
                            {{ Number::currency($cart->sum('amount'), 'INR', 'en_in') }}
                        </td>
                    </tr>
                </tbody>
            </table>

            @if ($cart->isNotEmpty())
                <div class="flex items-center justify-end">
                    <a href="{{ route('checkout.index') }}"
                        class="rounded bg-indigo-500 px-3 py-1 tracking-wider text-white shadow hover:bg-indigo-700">Process
                        To Checkout</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
