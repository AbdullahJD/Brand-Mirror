<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{

    public function index()
    {
        $attributes = Attribute::with('values')->latest()->get();
        return view('Dashboard.Pages.attributes.index', compact('attributes'));
    }

 
    public function create()
    {
        $attributes = Attribute::latest()->get();

        return view('Dashboard.Pages.attributes.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name'
        ]);

        Attribute::create($data);

        return redirect()
            ->route('attributes.index')
            ->with('success', 'Attribute Created Successfully');
        }

   
    public function show(string $id)
    {
        //
    }

   
    public function edit(Attribute $attribute)
    {
        return view(
            'Dashboard.Pages.attributes.edit',
            compact('attribute')
        );
    }

    
    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name,' . $attribute->id
        ]);

        $attribute->update($data);

        return redirect()
            ->route('attributes.index')
            ->with('updated', 'Attribute Updated Successfully');
        }

    
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()
            ->route('attributes.index')
            ->with('deleted', 'Attribute Deleted Successfully');
        }
}
