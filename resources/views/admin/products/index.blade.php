<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('All Products') }}
            </h2>

            <a href="{{ route('admin.products.create') }}" title="Go to Add New Product page"
                name="Go to Add New Product page">
                Add New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status') === 'product-deleted')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="rounded bg-green-500 px-3 py-2 text-sm text-white">
                    Product successfully deleted.
                </div>
            @endif

            <table class="w-full overflow-hidden rounded text-left text-sm text-gray-500 shadow">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-center">Id</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Price</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-b bg-white">
                            <td class="whitespace-nowrap px-6 py-4 text-center text-gray-900">
                                {{ $product->id }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 capitalize text-gray-900">
                                <img src="{{ asset('/storage/' . $product->images) }}" alt="{{ $product->name }}"
                                    class="mr-2 inline-flex h-8 w-8 rounded" />
                                {{ $product->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-900">
                                {{ $product->status === 1 ? 'Active' : 'Inactive' }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-gray-900">
                                &#8377; {{ $product->price }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-gray-900">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-blue-500 transition duration-300 ease-in-out hover:text-blue-800 focus:text-blue-800 focus:outline-none focus:ring-0">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                        class="ml-4">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="text-red-500 transition duration-300 ease-in-out hover:text-red-800 focus:text-red-800 focus:outline-none focus:ring-0"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $products->links('components.pagination') !!}
        </div>
    </div>
</x-app-layout>
