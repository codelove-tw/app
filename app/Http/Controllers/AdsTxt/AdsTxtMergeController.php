<?php

namespace App\Http\Controllers\AdsTxt;

use App\Http\Controllers\Controller;
use App\Services\AdsTxt\AdsTxtDeduplicator;
use Illuminate\Http\Request;

class AdsTxtMergeController extends Controller
{
    protected $deduplicator;

    public function __construct(AdsTxtDeduplicator $deduplicator)
    {
        $this->deduplicator = $deduplicator;
    }

    /**
     * 顯示 ads.txt 去重工具頁面
     */
    public function index()
    {
        return view('adstxt.index');
    }

    /**
     * 處理 ads.txt 去重請求
     */
    public function deduplicate(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $content = $request->input('content');
        $result = $this->deduplicator->deduplicate($content);

        return response()->json($result);
    }
}
