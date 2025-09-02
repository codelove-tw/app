@extends('layout')

@push('styles')
    <link rel="stylesheet" href="/css/ideas-fancy.css">
@endpush

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Back Button -->
                <div class="mb-3">
                    <a href="{{ route('ideas.index') }}" class="back-btn">
                        <i class="fas fa-arrow-left"></i> 返回列表
                    </a>
                </div>

                <!-- Idea Card -->
                <div class="card mb-4 fancy-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h1 class="h3 mb-0 idea-title">{{ $idea->title }}</h1>
                            @auth
                                @if ($idea->user_id === auth()->id())
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle-split" type="button" data-bs-toggle="dropdown">
                                            操作
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('ideas.edit', $idea) }}">✏️ 編輯</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('ideas.destroy', $idea) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('確定要刪除這個點子嗎？')">🗑️ 刪除</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        @if ($idea->description)
                            <div class="mb-3">
                                <p class="text-muted mb-0">{!! nl2br(e($idea->description)) !!}</p>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Vote Button -->
                                @auth
                                    <button class="btn btn-link p-0 vote-btn" data-idea-id="{{ $idea->id }}"
                                        data-voted="{{ $idea->hasVotedBy(auth()->user()) ? 'true' : 'false' }}">
                                        <i
                                            class="fas fa-thumbs-up {{ $idea->hasVotedBy(auth()->user()) ? 'text-primary' : 'text-muted' }}"></i>
                                        <span class="vote-count">{{ $idea->vote_count }}</span>
                                    </button>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span>{{ $idea->vote_count }}</span>
                                    </span>
                                @endauth

                                <!-- Comments Count -->
                                <span class="text-muted">
                                    <i class="fas fa-comment"></i>
                                    <span class="comment-count">{{ $idea->comment_count }}</span>
                                </span>
                            </div>
                            <small class="text-muted">
                                by {{ $idea->user->name }} · {{ $idea->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="card fancy-card">
                    <div class="card-header">
                        <h5 class="mb-0">💬 留言區</h5>
                    </div>
                    <div class="card-body">
                        <!-- Comment Form -->
                        @auth
                            <div class="comment-form mb-4">
                                <form method="POST" action="{{ route('ideas.comments.store', $idea) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea class="form-control autosize @error('content') is-invalid @enderror" name="content" rows="3"
                                            placeholder="分享你的想法…" required>{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-fancy-primary">
                                        <i class="fas fa-paper-plane"></i> 發表留言
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <a href="{{ route('login') }}" class="btn btn-fancy-primary btn-sm">登入</a> 後即可留言
                            </div>
                        @endauth

                        <!-- Comments List -->
                        <div id="comments-list">
                            @forelse($idea->comments as $comment)
                                <div class="comment-item mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <strong>{{ $comment->user->name }}</strong>
                                                <small
                                                    class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0">{!! nl2br(e($comment->content)) !!}</p>
                                        </div>
                                        @auth
                                            @if ($comment->user_id === auth()->id())
                                                <form method="POST" action="{{ route('ideas.comments.destroy', $comment) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-sm text-danger"
                                                        onclick="return confirm('確定要刪除這則留言嗎？')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <div id="no-comments" class="text-center text-muted py-3">
                                    還沒有留言，來當第一個留言的人吧！
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Vote toggle functionality
                $('.vote-btn').on('click', function(e) {
                    e.preventDefault();

                    const btn = $(this);
                    const ideaId = btn.data('idea-id');

                    $.post(`/ideas/${ideaId}/vote`, {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        })
                        .done(function(response) {
                            if (response.success) {
                                // Update vote count
                                btn.find('.vote-count').text(response.vote_count);

                                // Update button state
                                const icon = btn.find('i');
                                if (response.voted) {
                                    icon.removeClass('text-muted').addClass('text-primary');
                                    btn.data('voted', 'true');
                                } else {
                                    icon.removeClass('text-primary').addClass('text-muted');
                                    btn.data('voted', 'false');
                                }

                                toastr.success(response.message);
                            }
                        })
                        .fail(function() {
                            toastr.error('操作失敗，請稍後再試');
                        });
                });
            });
        </script>
    @endpush
@endsection
