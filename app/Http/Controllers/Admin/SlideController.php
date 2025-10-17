<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slide::orderBy('order')->get();
        return view('admin.slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $data = $request->only(['title', 'link', 'order']);
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/slides'), $filename);
            $data['image'] = 'images/slides/' . $filename;
        }

        Slide::create($data);

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slide $slide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        $data = $request->only(['title', 'link', 'order']);
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($slide->image && file_exists(public_path($slide->image))) {
                unlink(public_path($slide->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/slides'), $filename);
            $data['image'] = 'images/slides/' . $filename;
        }

        $slide->update($data);

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slide $slide)
    {
        // Delete image file
        if ($slide->image && file_exists(public_path($slide->image))) {
            unlink(public_path($slide->image));
        }

        $slide->delete();

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide đã được xóa thành công!');
    }
}
