<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('Dashboard.Pages.Product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('Dashboard.Pages.Product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'stock'          => 'required|integer',
            'main_image'     => 'nullable|image',
            'images.*'       => 'nullable|image',
            'status'         => 'required',
        ]);

        $mainImage = null;

        if ($request->hasFile('main_image')) {

            $mainImage = $request->file('main_image')
                ->store('products', 'public');
        }

        $product = Product::create([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'description'    => $request->description,
            'price'          => $request->price,
            'discount_price' => $request->discount_price,
            'stock'          => $request->stock,
            'main_image'     => $mainImage,
            'is_featured'    => $request->has('is_featured'),
            'status'         => $request->status,
        ]);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                ]);
            }
        }

        return redirect()
        ->route('products.index')
        ->with('success', 'Product Created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('Dashboard.Pages.Product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric',
            'discount_price'  => 'nullable|numeric',
            'stock'           => 'required|integer',
            'status'          => 'required',
            'main_image'      => 'nullable|image',
            'images.*'        => 'nullable|image',
        ]);

        // =========================
        // MAIN IMAGE (استبدال)
        // =========================
        if ($request->hasFile('main_image')) {

            // حذف القديمة
            if ($product->main_image && Storage::disk('public')->exists($product->main_image)) {
                Storage::disk('public')->delete($product->main_image);
            }

            // حفظ الجديدة
            $data['main_image'] = $request->file('main_image')
                                        ->store('products', 'public');
        }

        // =========================
        // FEATURED
        // =========================
        $data['is_featured'] = $request->has('is_featured');

        // =========================
        // UPDATE PRODUCT BASIC DATA
        // =========================
        $product->update($data);

        // =========================
        // GALLERY IMAGES (إضافة فقط)
        // =========================
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $path,
                ]);
            }
        }

        return redirect()
            ->route('products.index')
            ->with('updated', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
            // حذف الصورة الرئيسية
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        // حذف صور المعرض
        foreach ($product->images as $image) {

            Storage::disk('public')->delete($image->image);

            $image->delete();
        }

        // حذف المنتج
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('deleted', 'Product deleted successfully');;
    }
}
