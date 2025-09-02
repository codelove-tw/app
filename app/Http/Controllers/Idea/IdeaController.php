<?php

namespace App\Http\Controllers\Idea;

use App\Http\Controllers\Controller;
use App\Models\Idea\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        $query = Idea::with(['user', 'votes', 'comments']);

        // 搜尋功能
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 排序功能
        $sort = $request->get('sort', 'latest');
        if ($sort === 'popular') {
            $ideas = $query->orderByVotes()->paginate(10);
        } else {
            $ideas = $query->orderByLatest()->paginate(10);
        }

        return view('ideas.index', compact('ideas', 'sort'));
    }

    public function create()
    {
        return view('ideas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);

        $idea = Idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('ideas.index')
            ->with('status.success', '已發表！');
    }

    public function show(Idea $idea)
    {
        $idea->load(['user', 'votes', 'comments.user']);

        return view('ideas.show', compact('idea'));
    }

    public function edit(Idea $idea)
    {
        $this->authorize('update', $idea);

        return view('ideas.edit', compact('idea'));
    }

    public function update(Request $request, Idea $idea)
    {
        $this->authorize('update', $idea);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);

        $idea->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('ideas.show', $idea)
            ->with('status.success', '點子已更新！');
    }

    public function destroy(Idea $idea)
    {
        $this->authorize('delete', $idea);

        $idea->delete();

        return redirect()->route('ideas.index')
            ->with('status.success', '點子已刪除！');
    }
}
