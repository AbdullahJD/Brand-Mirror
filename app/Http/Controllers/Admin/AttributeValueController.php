<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->latest()->get();

        return view(
            'Dashboard.Pages.attribute-values.index',
            compact('attributeValues')
        );

    }

    public function create()
    {
         $attributes = Attribute::all();

        return view(
            'Dashboard.Pages.attribute-values.create',
            compact('attributes')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        AttributeValue::create($request->all());

        return redirect()
            ->route('attribute-values.index')
            ->with('success', 'Attribute Value Created Successfully');

    }

    public function show(string $id)
    {
        //
    }

    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();

        return view(
            'Dashboard.Pages.attribute-values.edit',
            compact('attributeValue', 'attributes')
        );

    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $attributeValue->update($request->all());

        return redirect()
            ->route('attribute-values.index')
            ->with('updated', 'Attribute Value Updated Successfully');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return redirect()
            ->route('attribute-values.index')
            ->with('deleted', 'Attribute Value Deleted Successfully');

    }
}
