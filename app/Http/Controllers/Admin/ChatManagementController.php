<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ChatMessagesExport;

class ChatManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage-chat');
    }

    /**
     * Hiển thị danh sách tin nhắn chat với thống kê
     */
    public function index(Request $request)
    {
        $query = ChatMessage::query();

        // Lọc theo ngày
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            if ($request->status === 'blocked') {
                $query->where('is_blocked', true);
            } elseif ($request->status === 'active') {
                $query->where('is_blocked', false);
            }
        }

        // Lọc theo username
        if ($request->filled('username')) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Phân trang
        $messages = $query->paginate(50)->withQueryString();

        // Thống kê tổng quan
        $stats = $this->getChatStats($request);

        return view('admin.chat.index', compact('messages', 'stats'));
    }

    /**
     * Lấy thống kê chi tiết
     */
    public function stats(Request $request)
    {
        $stats = $this->getChatStats($request);
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Xuất file Excel
     */
    public function export(Request $request)
    {
        $query = ChatMessage::query();

        // Áp dụng các bộ lọc giống như index
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            if ($request->status === 'blocked') {
                $query->where('is_blocked', true);
            } elseif ($request->status === 'active') {
                $query->where('is_blocked', false);
            }
        }
        if ($request->filled('username')) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        $query->orderBy('created_at', 'desc');

        $messages = $query->get();

        $filename = 'chat_messages_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new ChatMessagesExport($messages), $filename);
    }

    /**
     * Lấy thống kê chat
     */
    private function getChatStats(Request $request)
    {
        $baseQuery = ChatMessage::query();

        // Áp dụng bộ lọc ngày nếu có
        if ($request->filled('date_from')) {
            $baseQuery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $baseQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $stats = [
            'total_messages' => $baseQuery->count(),
            'blocked_messages' => (clone $baseQuery)->where('is_blocked', true)->count(),
            'active_messages' => (clone $baseQuery)->where('is_blocked', false)->count(),
            'unique_users' => (clone $baseQuery)->distinct('username')->count('username'),
            'messages_today' => (clone $baseQuery)->whereDate('created_at', today())->count(),
            'messages_yesterday' => (clone $baseQuery)->whereDate('created_at', today()->subDay())->count(),
        ];

        // Thống kê theo giờ trong ngày
        $hourlyStats = (clone $baseQuery)
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->whereDate('created_at', today())
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour')
            ->toArray();

        $stats['hourly_stats'] = $hourlyStats;

        // Top users
        $topUsers = (clone $baseQuery)
            ->select('username', DB::raw('COUNT(*) as message_count'))
            ->groupBy('username')
            ->orderBy('message_count', 'desc')
            ->limit(10)
            ->get();

        $stats['top_users'] = $topUsers;

        // Thống kê theo ngày (7 ngày gần nhất)
        $dailyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $count = (clone $baseQuery)->whereDate('created_at', $date)->count();
            $dailyStats[$date->format('Y-m-d')] = $count;
        }
        $stats['daily_stats'] = $dailyStats;

        return $stats;
    }

    /**
     * Xem chi tiết tin nhắn
     */
    public function show($id)
    {
        $message = ChatMessage::find($id);
        
        if (!$message) {
            abort(404, 'Tin nhắn không tồn tại');
        }
        
        return view('admin.chat.show', compact('message'));
    }

    /**
     * Xóa tin nhắn
     */
    public function destroy($id)
    {
        $message = ChatMessage::find($id);
        
        if (!$message) {
            return redirect()->route('admin.chat.index')
                ->with('error', 'Tin nhắn không tồn tại.');
        }
        
        $message->delete();

        return redirect()->route('admin.chat.index')
            ->with('success', 'Tin nhắn đã được xóa thành công.');
    }

    /**
     * Toggle trạng thái block của tin nhắn
     */
    public function toggleBlock($id)
    {
        $message = ChatMessage::find($id);
        
        if (!$message) {
            return redirect()->back()
                ->with('error', 'Tin nhắn không tồn tại.');
        }
        
        $message->update([
            'is_blocked' => !$message->is_blocked
        ]);

        $status = $message->is_blocked ? 'chặn' : 'bỏ chặn';
        
        return redirect()->back()
            ->with('success', "Tin nhắn đã được {$status} thành công.");
    }
}
