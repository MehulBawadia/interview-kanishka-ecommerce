<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display the products in a paginated format.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::query()
            ->select(['id', 'name', 'price', 'status', 'images'])
            ->latest('id')
            ->paginate(10);

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Display the form to add a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store the product details.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $imageFile = $request->file('image') ?? null;
            $imageFileName = null;
            if ($imageFile) {
                $imageFileName = $imageFile->hashName();
                $imageFile->storeAs('products', $imageFileName, 'public');
            }

            Product::create([
                'name' => $request->name,
                'status' => $request->status === 'active' ? 1 : 0,
                'description' => $request->description,
                'price' => $request->price,
                'images' => '/products/'.$imageFileName,
            ]);

            DB::commit();

            return to_route('admin.products.create')->with([
                'status' => 'product-created',
            ]);
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            DB::rollBack();

            return to_route('admin.products.create');
        }
    }

    /**
     * Display the edit form to edit the product details
     *
     *
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Update the product details.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Product $product, ProductRequest $request)
    {
        try {
            $imageFile = $request->file('image') ?? null;
            $imageFileName = null;
            if ($imageFile) {
                $imageFileName = $imageFile->hashName();
                $imageFile->storeAs('products', $imageFileName, 'public');
            }

            $product->update([
                'name' => $request->name,
                'status' => $request->status === 'active' ? 1 : 0,
                'description' => $request->description,
                'price' => $request->price,
                'images' => $imageFileName ? '/products/'.$imageFileName : $product->images,
            ]);

            DB::commit();

            return to_route('admin.products.edit', $product)->with([
                'status' => 'product-updated',
            ]);
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            DB::rollBack();

            return to_route('admin.products.edit', $product);
        }
    }

    /**
     * Destroy the product and also delete the attached image.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        try {
            $productImage = $product->images ?? null;
            if ($productImage) {
                $existingImagePath = $product->images;
                if (Storage::disk('public')->exists($existingImagePath)) {
                    Storage::disk('public')->delete($existingImagePath);
                }
            }

            $product->delete();

            DB::commit();

            return to_route('admin.products.index')->with([
                'status' => 'product-deleted',
            ]);
        } catch (\Exception $e) {
            info($e->getMessage());
            info($e->getTraceAsString());

            DB::rollBack();

            return to_route('admin.products.index');
        }
    }
}
