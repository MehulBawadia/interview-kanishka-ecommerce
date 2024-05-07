<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Add Product') }}
            </h2>

            <a href="{{ route('admin.products.index') }}" title="Go to All Products page" name="Go to All Products page">
                All Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.products.store') }}" class="mt-6 space-y-6"
                enctype="multipart/form-data">
                @csrf

                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="price" value="Price" />
                    <x-text-input type="text" id="price" name="price" value="{{ old('price') }}"
                        class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="image" value="Image" />
                    <x-text-input type="file" id="image" name="image" class="mt-1 block w-full"
                        value="{{ old('image') }}" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="status" value="Status" />
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="8"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button type="submit">Create</x-primary-button>

                    @if (session('status') === 'product-created')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                            class="text-sm font-semibold text-green-600">Product successfully created.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
