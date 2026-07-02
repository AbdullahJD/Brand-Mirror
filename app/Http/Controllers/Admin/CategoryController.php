<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'asc')->get();
        return view('Dashboard.Pages.Category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('Dashboard.Pages.Category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);
        $data = $request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'parent_id',
            'status'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $categories = Category::create($data);
        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'category',
            'New category name Created',
            "category {$categories->name} was created"
        );

        return redirect()->route('categories.index')
                        ->with('success', __('messages.flash_category_created'));
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
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)->get();
        return view('Dashboard.Pages.Category.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|boolean',
            'image' => 'nullable|image',
        ]);

        // 🔥 إذا في صورة جديدة
        if ($request->hasFile('image')) {

            // حذف الصورة القديمة إذا موجودة
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            // حفظ الجديدة
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('updated', __('messages.flash_category_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //  حذف الصورة إذا موجودة
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'category',
            'Category Deleted',
            "category {$category->name} was Deleted"
        );

        return back()->with('deleted', __('messages.flash_category_deleted'));
    }
}
