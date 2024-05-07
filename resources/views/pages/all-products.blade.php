<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Products Listing') }}
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

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($products as $product)
                    <div class="overflow-hidden rounded bg-white shadow">
                        <img src="{{ asset('/storage/' . $product->images) }}" alt="{{ $product->name }}"
                            class="block h-[300px] w-[300px]" />

                        <div class="px-4 py-3">
                            <h2 class="text-xl font-bold capitalize tracking-wider">{{ $product->name }}</h2>

                            <p class="text-grqay-700 my-2 tracking-wider">
                                {{ \Illuminate\Support\Str::limit($product->description, 30) }}
                            </p>

                            <div class="my-4 font-semibold text-gray-700">&#8377; {{ $product->price }}</div>

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
                @endforeach
            </div>

            {{ $products->links('components.pagination') }}
        </div>
    </div>
</x-app-layout>
