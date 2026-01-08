<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->paginate(10);
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'created_by' => Auth::id(),
        ];

        // Handle single attachment (legacy support)
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('announcements', 'public');
            }
            $data['images'] = $imagePaths;
        }

        Announcement::create($data);

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $announcement = Announcement::findOrFail($id);
        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
        ];

        // Handle single attachment (legacy support)
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($announcement->attachment && Storage::disk('public')->exists($announcement->attachment)) {
                Storage::disk('public')->delete($announcement->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        // Handle multiple images - append new images to existing ones
        if ($request->hasFile('images')) {
            // Get existing images or start with empty array
            $existingImages = $announcement->images ?? [];

            // Add new images
            $newImagePaths = [];
            foreach ($request->file('images') as $image) {
                $newImagePaths[] = $image->store('announcements', 'public');
            }

            // Merge existing and new images
            $data['images'] = array_merge($existingImages, $newImagePaths);
        }

        $announcement->update($data);

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully.');
    }

    /**
     * Delete a specific image from an announcement.
     */
    public function deleteImage($id, $index)
    {
        $announcement = Announcement::findOrFail($id);

        if (!$announcement->images || !isset($announcement->images[$index])) {
            return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
        }

        // Get the image path
        $imagePath = $announcement->images[$index];

        // Delete the image from storage
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        // Remove the image from the array
        $images = $announcement->images;
        unset($images[$index]);

        // Re-index the array to maintain sequential indices
        $images = array_values($images);

        // Update the announcement
        $announcement->images = $images;
        $announcement->save();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully.');
    }
}
