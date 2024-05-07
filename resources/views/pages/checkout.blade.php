<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('checkout.placeOrder') }}" method="POST">
            @csrf

            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 rounded bg-white px-4 py-3 shadow md:grid-cols-2">
                    <div>
                        <h3 class="text-lg font-semibold tracking-wider">Billing Details</h3>

                        <div class="mt-4">
                            <x-input-label for="billing_name" value="Name" />
                            <x-text-input type="text" name="billing_name" id="billing_name"
                                value="{{ $user->name }}" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('billing_name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="billing_email" value="E-Mail" />
                            <x-text-input type="email" name="billing_email" id="billing_email"
                                value="{{ $user->email }}" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('billing_email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="billing_phone_number" value="Phone Number:" />
                            <x-text-input type="text" name="billing_phone_number" id="billing_phone_number"
                                value="{{ old('billing_phone_number') }}" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('billing_phone_number')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="billing_address" value="Address:" />
                            <x-text-input type="text" name="billing_address" id="billing_address"
                                value="{{ old('billing_address') }}" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('billing_address')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold tracking-wider">Shipping Details</h3>

                        <div class="mt-4">
                            <x-input-label for="shipping_name" value="Name" />
                            <x-text-input type="text" name="shipping_name" id="shipping_name"
                                value="{{ $user->name }}" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('shipping_name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="shipping_email" value="E-Mail" />
                            <x-text-input type="email" name="shipping_email" id="shipping_email"
                                value="{{ $user->email }}" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('shipping_email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="shipping_phone_number" value="Phone Number:" />
                            <x-text-input type="text" name="shipping_phone_number" id="shipping_phone_number"
                                value="{{ old('shipping_phone_number') }}" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('shipping_phone_number')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="shipping_address" value="Address:" />
                            <x-text-input type="text" name="shipping_address" id="shipping_address"
                                value="{{ old('shipping_address') }}" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
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
                        @foreach ($cart as $cartProduct)
                            <tr class="border-b bg-white">
                                <td class="px-6 py-4 capitalize tracking-wider text-gray-800">
                                    <img src="{{ asset('/storage/' . $cartProduct->product_image) }}"
                                        alt="{{ $cartProduct->product_name }}"
                                        class="mr-2 inline-flex h-12 w-12 rounded" />

                                    {{ $cartProduct->product_name }}
                                </td>
                                <td class="px-6 py-4 text-right tracking-wider text-gray-800">
                                    {{ $cartProduct->quantity }}
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
            </div>

            <div class="mx-auto mt-8 max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="rounded bg-indigo-500 px-3 py-1 tracking-wider text-white shadow hover:bg-indigo-700">
                        Place Order
                    </button>
                </div>
            </div>

        </form>
    </div>
</x-app-layout>
