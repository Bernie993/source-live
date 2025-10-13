<?php

namespace App\Http\Controllers\Api;

use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\Keyword;
use App\Services\KeywordFilterService;

class ChatController extends Controller
{
    protected $keywordFilterService;

    public function __construct(KeywordFilterService $keywordFilterService)
    {
        $this->keywordFilterService = $keywordFilterService;
    }

    /**
     * Send a chat message
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        // Filter message for blocked keywords
        $filterResult = $this->keywordFilterService->filterMessage($validated['message']);

        $chatMessage = ChatMessage::create([
            'username' => $validated['username'],
            'message' => $validated['message'],
            'is_blocked' => $filterResult['is_blocked'],
            'blocked_keywords' => $filterResult['blocked_keywords'],
            'sent_at' => now()
        ]);

         broadcast(new NewChatMessage($chatMessage))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $chatMessage,
            'is_blocked' => $filterResult['is_blocked'],
            'blocked_keywords' => $filterResult['blocked_keywords']
        ]);
    }

    /**
     * Get chat messages
     */
    public function getMessages(Request $request)
    {
        $limit = $request->get('limit', 50);
        $showBlocked = $request->get('show_blocked', false);

        $query = ChatMessage::latest('sent_at');

        if (!$showBlocked) {
            $query->notBlocked();
        }

        $messages = $query->limit($limit)->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    /**
     * Filter a message against blocked keywords
     */
    public function filterMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string'
        ]);

        $result = $this->keywordFilterService->filterMessage($validated['message']);

        return response()->json([
            'success' => true,
            'is_blocked' => $result['is_blocked'],
            'blocked_keywords' => $result['blocked_keywords'],
            'original_message' => $validated['message']
        ]);
    }

    /**
     * Get chat statistics
     */
    public function getStats()
    {
        $stats = [
            'total_messages' => ChatMessage::count(),
            'blocked_messages' => ChatMessage::where('is_blocked', true)->count(),
            'allowed_messages' => ChatMessage::where('is_blocked', false)->count(),
            'recent_messages' => ChatMessage::where('sent_at', '>=', now()->subHour())->count(),
            'active_keywords' => Keyword::where('is_active', true)->count()
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
