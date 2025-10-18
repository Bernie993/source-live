<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Store a newly created feedback in storage.
     */
    public function store(Request $request)
    {
        try {
            // Debug log
            \Log::info('=== FEEDBACK SUBMIT ===');
            \Log::info('Request data:', $request->all());
            \Log::info('Has file:', ['image' => $request->hasFile('image')]);
            
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                \Log::info('File info:', [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ]);
            }

            $validated = $request->validate([
                'login_info' => 'required|string|max:255',
                'feedback_type' => 'nullable|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB max
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('feedbacks', 'public');
                $validated['image'] = $path;
                \Log::info('Image uploaded:', ['path' => $path]);
            } else {
                \Log::warning('No image file in request');
            }

            // Add user_id if logged in
            $validated['user_id'] = Auth::id();
            $validated['status'] = 'pending';

            $feedback = Feedback::create($validated);
            \Log::info('Feedback created:', ['id' => $feedback->id, 'image' => $feedback->image]);

            return response()->json([
                'success' => true,
                'message' => 'Phản hồi của bạn đã được gửi thành công! Chúng tôi sẽ xem xét và phản hồi sớm nhất.',
                'debug' => [
                    'feedback_id' => $feedback->id,
                    'has_image' => !empty($feedback->image),
                    'image_path' => $feedback->image,
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error storing feedback:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}

