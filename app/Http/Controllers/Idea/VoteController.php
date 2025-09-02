<?php

namespace App\Http\Controllers\Idea;

use App\Http\Controllers\Controller;
use App\Models\Idea\Idea;
use App\Models\Idea\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function toggle(Idea $idea)
    {
        $user = Auth::user();

        $existingVote = Vote::where('idea_id', $idea->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingVote) {
            // 取消投票
            $existingVote->delete();
            $message = '已取消投票';
            $voted = false;
        } else {
            // 投票
            Vote::create([
                'idea_id' => $idea->id,
                'user_id' => $user->id,
            ]);
            $message = '已投票！';
            $voted = true;
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'voted' => $voted,
                'vote_count' => $idea->fresh()->vote_count,
            ]);
        }

        return back()->with('status.success', $message);
    }
}
