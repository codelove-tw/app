<?php

namespace App\Http\Controllers\Idea;

use App\Http\Controllers\Controller;
use App\Models\Idea\Comment;
use App\Models\Idea\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Idea $idea)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'idea_id' => $idea->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        if (request()->ajax()) {
            $comment->load('user');

            return response()->json([
                'success' => true,
                'message' => '留言已發表！',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => $comment->user->name,
                    'created_at' => $comment->created_at->diffForHumans(),
                ],
                'comment_count' => $idea->fresh()->comment_count,
            ]);
        }

        return back()->with('status.success', '留言已發表！');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '留言已刪除！',
            ]);
        }

        return back()->with('status.success', '留言已刪除！');
    }
}
