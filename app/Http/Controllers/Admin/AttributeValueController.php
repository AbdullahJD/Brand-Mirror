<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->latest()->get();

        return view(
            'Dashboard.Pages.attribute-values.index',compact('attributeValues')
        );

    }

    public function create()
    {
         $attributes = Attribute::all();

        return view(
            'Dashboard.Pages.attribute-values.create',compact('attributes')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $attributeValue = AttributeValue::create($request->all());

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'attribute',
            'New attribute Value Created',
            "attribute Value {$attributeValue->value} was created"
        );

        return redirect()
            ->route('attribute-values.index')
            ->with('success', __('messages.flash_attribute_value_created'));

    }

    public function show(string $id)
    {
        //
    }

    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();

        return view(
            'Dashboard.Pages.attribute-values.edit',compact('attributeValue', 'attributes')
        );

    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $attributeValue->update($request->all());

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'attribute',
            'New attribute Value Updated',
            "attribute Value {$attributeValue->value} was updated"
        );

        return redirect()
            ->route('attribute-values.index')
            ->with('updated', __('messages.flash_attribute_value_updated'));
    }

    public function destroy(AttributeValue $attribute)
    {
        $attribute->delete();

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'attribute',
            'New attribute Value Deleted',
            "attribute Value {$attribute->value} was deleted"
        );

        return redirect()
            ->route('attribute-values.index')
            ->with('deleted', __('messages.flash_attribute_value_deleted'));

    }
}
