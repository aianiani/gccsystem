<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = HeroImage::orderBy('order')->get();
        return view('admin.hero_images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero_images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Save to public/images/hero directory
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/hero'), $imageName);
            $imagePath = 'images/hero/' . $imageName;
        }

        HeroImage::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image uploaded successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroImage $heroImage)
    {
        return view('admin.hero_images.edit', compact('heroImage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroImage $heroImage)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if (file_exists(public_path($heroImage->image_path))) {
                @unlink(public_path($heroImage->image_path));
            }

            // Save new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/hero'), $imageName);
            $data['image_path'] = 'images/hero/' . $imageName;
        }

        $heroImage->update($data);

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroImage $heroImage)
    {
        if (file_exists(public_path($heroImage->image_path))) {
            @unlink(public_path($heroImage->image_path));
        }

        $heroImage->delete();

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image deleted successfully.');
    }
}
