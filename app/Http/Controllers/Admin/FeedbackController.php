<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Feedback::with('user')->latest();

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by login_info or content
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('login_info', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('feedback_type', 'like', "%{$search}%");
            });
        }

        $feedbacks = $query->paginate(20);
        
        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        $feedback->load('user');
        return view('admin.feedbacks.show', compact('feedback'));
    }

    /**
     * Update the status of the feedback.
     */
    public function updateStatus(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processed,rejected',
        ]);

        $feedback->update($validated);

        return redirect()->route('admin.feedbacks.index')
            ->with('success', 'Trạng thái phản hồi đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        // Delete image if exists
        if ($feedback->image) {
            Storage::disk('public')->delete($feedback->image);
        }

        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')
            ->with('success', 'Phản hồi đã được xóa thành công!');
    }
}

