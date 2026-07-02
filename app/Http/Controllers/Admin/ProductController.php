<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\NotificationService;
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

        return view('Dashboard.Pages.Product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name_ar'        => 'required|string|max:255',
            'name_en'        => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
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

        $additionalInformationAr = $this->collectAdditionalInformation(
            $request->input('info_keys_ar', []),
            $request->input('info_values_ar', [])
        );

        $additionalInformationEn = $this->collectAdditionalInformation(
            $request->input('info_keys_en', []),
            $request->input('info_values_en', [])
        );

        $product = Product::create([
            'category_id'    => $request->category_id,
            'name_ar'        => $request->name_ar,
            'name_en'        => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'price'          => $request->price,
            'discount_price' => $request->discount_price,
            'stock'          => $request->stock,
            'main_image'     => $mainImage,
            'is_featured'    => $request->has('is_featured'),
            'status'         => $request->status,
            'additional_information_ar' => $additionalInformationAr,
            'additional_information_en' => $additionalInformationEn,
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

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'product',
            'New Product Created',
            "Product {$product->name} was created"
        );

        return redirect()
        ->route('products.index')
        ->with('success', __('messages.flash_product_created'));

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
            'name_ar'         => 'required|string|max:255',
            'name_en'         => 'required|string|max:255',
            'description_ar'  => 'nullable|string',
            'description_en'  => 'nullable|string',
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
        $data['additional_information_ar'] = $this->collectAdditionalInformation(
            $request->input('info_keys_ar', []),
            $request->input('info_values_ar', [])
        );

        $data['additional_information_en'] = $this->collectAdditionalInformation(
            $request->input('info_keys_en', []),
            $request->input('info_values_en', [])
        );
        
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

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'product',
            'New Product Updated',
            "Product {$product->name} was updated"
        );

        return redirect()
            ->route('products.index')
            ->with('updated', __('messages.flash_product_updated'));
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

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'product',
            'New Product Deleted',
            "Product {$product->name} was deleted"
        );

        return redirect()
            ->route('products.index')
            ->with('deleted', __('messages.flash_product_deleted'));
    }

    private function collectAdditionalInformation(array $keys, array $values): array
    {
        $additionalInformation = [];

        foreach ($keys as $index => $key) {
            if (! empty($key)) {
                $additionalInformation[$key] = $values[$index] ?? '';
            }
        }

        return $additionalInformation;
    }
}
