<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Services\NotificationService;
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
            'Dashboard.Pages.Banners.index',compact('banners')
        );
    }

    public function create()
    {
        return view('Dashboard.Pages.Banners.create');
    }

    public function store(BannerRequest $request)
    {
        $image = $request->file('image')->store('banners', 'public');

        $banner = Banner::create([
            'title' => $request->title,
            'image' => $image,
            'link' => $request->link,
            'status' => $request->boolean('status'),
            'position' => $request->position,
        ]);

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'banner',
            'New banner name Created',
            "banner {$banner->title} was created"
        );

        return redirect()
            ->route('banners.index')
            ->with('success', __('messages.flash_banner_created'));
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
            'position' => $request->position,
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

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'banner',
            'New banner name Updated',
            "banner {$banner->title} was updated"
        );

        return redirect()->route('banners.index')->with('updated', __('messages.flash_banner_updated'));
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'banner',
            'New banner name Deleted',
            "banner {$banner->title} was deleted"
        );

        return redirect()->route('banners.index')->with('deleted', __('messages.flash_banner_deleted'));
    }
}
