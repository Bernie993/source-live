<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keyword;
use App\Services\KeywordFilterService;

class KeywordController extends Controller
{
    protected $keywordFilterService;

    public function __construct(KeywordFilterService $keywordFilterService)
    {
        $this->middleware('auth');
        $this->middleware('permission:manage-keywords');
        $this->keywordFilterService = $keywordFilterService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keywords = Keyword::with('creator')->latest()->paginate(15);
        $stats = $this->keywordFilterService->getKeywordStats();
        
        return view('admin.keywords.index', compact('keywords', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.keywords.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'keywords' => 'required|string',
            'is_active' => 'boolean'
        ]);

        // Split keywords by comma or newline
        $keywordList = preg_split('/[,\n\r]+/', $validated['keywords']);
        $keywordList = array_map('trim', $keywordList);
        $keywordList = array_filter($keywordList); // Remove empty values

        $createdCount = 0;
        $duplicateCount = 0;

        foreach ($keywordList as $keywordText) {
            $existing = Keyword::where('keyword', $keywordText)->first();
            
            if (!$existing) {
                Keyword::create([
                    'keyword' => $keywordText,
                    'is_active' => $validated['is_active'] ?? true,
                    'created_by' => auth()->id()
                ]);
                $createdCount++;
            } else {
                $duplicateCount++;
            }
        }

        $message = "Đã tạo {$createdCount} từ khóa mới.";
        if ($duplicateCount > 0) {
            $message .= " {$duplicateCount} từ khóa đã tồn tại.";
        }

        return redirect()->route('admin.keywords.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Keyword $keyword)
    {
        return view('admin.keywords.show', compact('keyword'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keyword $keyword)
    {
        return view('admin.keywords.edit', compact('keyword'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keyword $keyword)
    {
        $validated = $request->validate([
            'keyword' => 'required|string|max:255|unique:keywords,keyword,' . $keyword->id,
            'is_active' => 'boolean'
        ]);

        $keyword->update($validated);

        return redirect()->route('admin.keywords.index')
            ->with('success', 'Từ khóa đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keyword $keyword)
    {
        $keyword->delete();

        return redirect()->route('admin.keywords.index')
            ->with('success', 'Từ khóa đã được xóa thành công!');
    }

    /**
     * Toggle keyword status
     */
    public function toggle(Keyword $keyword)
    {
        $keyword->update(['is_active' => !$keyword->is_active]);

        $status = $keyword->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        
        return redirect()->route('admin.keywords.index')
            ->with('success', "Từ khóa đã được {$status}!");
    }

    /**
     * Test keyword filtering
     */
    public function test(Request $request)
    {
        $validated = $request->validate([
            'test_message' => 'required|string'
        ]);

        $result = $this->keywordFilterService->filterMessage($validated['test_message']);
        $cleanMessage = $this->keywordFilterService->cleanMessage($validated['test_message']);

        return back()->with([
            'test_result' => $result,
            'clean_message' => $cleanMessage,
            'original_message' => $validated['test_message']
        ]);
    }
}
