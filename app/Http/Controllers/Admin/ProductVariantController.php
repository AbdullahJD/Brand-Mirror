<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::with([
            'product',
            'attributeValues.attribute'
        ])->latest()->get();

        return view(
            'Dashboard.Pages.ProductVariant.index',compact('variants')
        );
    }

    public function create()
    {
        $products = Product::all();

        $attributeValues = AttributeValue::with('attribute')
            ->get();

        return view(
            'Dashboard.Pages.ProductVariant.create',
            compact(
                'products',
                'attributeValues'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|boolean',

            'attribute_values' => 'nullable|array',
            'attribute_values.*' => 'exists:attribute_values,id',
        ]);

        $variant = ProductVariant::create([
            'product_id' => $request->product_id,
            'sku' => $request->sku,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        $variant->attributeValues()->sync(
            $request->attribute_values ?? []
        );

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'product',
            'New Product Variant Created',
            "Product Variant {$variant->sku} was created"
        );

        return redirect()
            ->route('product-variants.index')
            ->with(
                'success',
                __('messages.flash_variant_created')
            );
    }

    public function show(string $id)
    {
        //
    }

    public function edit(ProductVariant $productVariant)
    {
        $products = Product::all();

        $attributeValues = AttributeValue::with('attribute')
            ->get();

        return view(
            'Dashboard.Pages.ProductVariant.edit',compact('productVariant','products','attributeValues'));
    }

    public function update(
        Request $request,
        ProductVariant $productVariant
    ) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|boolean',

            'attribute_values' => 'nullable|array',
            'attribute_values.*' => 'exists:attribute_values,id',
        ]);

        $productVariant->update([
            'product_id' => $request->product_id,
            'sku' => $request->sku,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        $productVariant->attributeValues()->sync(
            $request->attribute_values ?? []
        );

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'product',
            'New Product Variant Updated',
            "Product Variant {$productVariant->sku} was updated"
        );

        return redirect()
            ->route('product-variants.index')
            ->with(
                'updated',
                __('messages.flash_variant_updated')
            );
    }

    public function destroy(ProductVariant $productVariant)
    {
        $productVariant->delete();

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'product',
            'New Product Variant Deleted',
            "Product Variant {$productVariant->sku} was deleted"
        );

        return redirect()
            ->route('product-variants.index')
            ->with(
                'deleted',
                __('messages.flash_variant_deleted')
            );
    }
}
