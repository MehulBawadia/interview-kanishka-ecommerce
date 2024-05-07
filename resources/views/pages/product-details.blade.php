<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Products Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status') === 'product-added-in-cart')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="rounded bg-green-500 px-3 py-2 text-sm text-white">
                    Product successfully added in the cart.
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <img src="{{ asset('/storage/' . $product->images) }}" alt="{{ $product->name }}"
                        class="block h-full w-full" />
                </div>

                <div>
                    <h2 class="text-3xl font-bold capitalize text-gray-900">{{ $product->name }}</h2>

                    <p class="text-grqay-700 my-2 tracking-wider">
                        {!! nl2br($product->description) !!}
                    </p>

                    <div class="my-4 text-2xl font-semibold text-gray-700">
                        {{ \Illuminate\Support\Number::currency($product->price, 'INR', 'en_IN') }}
                    </div>

                    @auth
                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="quantity" value="1" />

                            <button type="submit"
                                class="rounded bg-indigo-500 px-3 py-1 tracking-wider text-white shadow hover:bg-indigo-700">Add
                                To Cart</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
