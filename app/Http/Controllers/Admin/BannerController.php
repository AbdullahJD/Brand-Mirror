<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(15);

        return view(
            'Dashboard.Pages.Banners.index',
            compact('banners')
        );
    }

    public function create()
    {
        return view('Dashboard.Pages.Banners.create');
    }

    public function store(BannerRequest $request)
    {
        $image = $request->file('image')
            ->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $image,
            'link' => $request->link,
            'status' => $request->boolean('status'),
        ]);

        return redirect()
            ->route('banners.index')
            ->with('success', 'Banner created');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Banner $banner)
    {
        return view('Dashboard.Pages.Banners.edit',compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $data = [
            'title' => $request->title,
            'link' => $request->link,
            'status' => $request->boolean('status'),
        ];

        if ($request->hasFile('image')) {

            if ($banner->image &&
                Storage::disk('public')->exists($banner->image)) {

                Storage::disk('public')->delete($banner->image);
            }

            $data['image'] = $request
                ->file('image')
                ->store('banners', 'public');
        }


        $banner->update($data);

        return redirect()->route('banners.index')->with('updated', 'Banner updated');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('banners.index')->with('deleted', 'Banner deleted successfully');
    }
}
