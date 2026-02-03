<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resources = Resource::latest()->paginate(10);
        return view('admin.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.resources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,article,file,image',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'content_source' => 'required|in:url,upload',
        ];

        // Conditional validation based on content source
        if ($request->content_source === 'url') {
            $rules['content'] = 'required|url';
        } else {
            $rules['file'] = 'required|file|max:51200'; // 50MB max
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'category' => $request->category,
            'description' => $request->description,
            'created_by' => Auth::id(),
            'is_published' => $request->has('is_published'),
        ];

        // Handle file upload or URL
        if ($request->content_source === 'upload' && $request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('resources', $fileName, 'public');

            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
            $data['content'] = Storage::url($filePath); // Store the public URL as content
        } else {
            $data['content'] = $request->input('content');
        }

        Resource::create($data);

        return redirect()->route('admin.resources.index')->with('success', 'Resource created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        return view('admin.resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,article,file,image',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'content_source' => 'required|in:url,upload,keep',
        ];

        // Conditional validation based on content source
        if ($request->content_source === 'url') {
            $rules['content'] = 'required|url';
        } elseif ($request->content_source === 'upload') {
            $rules['file'] = 'required|file|max:51200'; // 50MB max
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'category' => $request->category,
            'description' => $request->description,
            'is_published' => $request->has('is_published'),
        ];

        // Handle file upload or URL
        if ($request->content_source === 'upload' && $request->hasFile('file')) {
            // Delete old file if exists
            if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
                Storage::disk('public')->delete($resource->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('resources', $fileName, 'public');

            $data['file_path'] = $filePath;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
            $data['content'] = Storage::url($filePath);
        } elseif ($request->content_source === 'url') {
            // Clear file data if switching to URL
            if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
                Storage::disk('public')->delete($resource->file_path);
            }
            $data['content'] = $request->input('content');
            $data['file_path'] = null;
            $data['file_name'] = null;
            $data['file_type'] = null;
            $data['file_size'] = null;
        }
        // If 'keep', don't modify file/content fields

        $resource->update($data);

        return redirect()->route('admin.resources.index')->with('success', 'Resource updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        // Delete file if exists
        if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();
        return redirect()->route('admin.resources.index')->with('success', 'Resource deleted successfully.');
    }
}
