@extends('layout')

@push('styles')
    <link rel="stylesheet" href="/css/ideas-fancy.css">
@endpush

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="card mb-4 header-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="h3 mb-0">🚀 荒唐點子大投稿</h1>
                            @auth
                                <a href="{{ route('ideas.create') }}" class="btn btn-fancy-primary">
                                    <i class="fas fa-plus"></i> 投稿
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-fancy-primary">
                                    <i class="fas fa-plus"></i> 登入後投稿
                                </a>
                            @endauth
                        </div>
                        <p class="text-muted mb-0">💡 把你最荒唐的點子丟上來 ─ 看大家怎麼吐槽、怎麼加料，或真的去做。</p>
                    </div>
                </div>

                <!-- Sort and Search -->
                <div class="card mb-4 sort-search-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('ideas.index', ['sort' => 'latest'] + request()->query()) }}"
                                        class="btn btn-fancy-outline {{ $sort === 'latest' ? 'active' : '' }}">
                                        🕒 最新
                                    </a>
                                    <a href="{{ route('ideas.index', ['sort' => 'popular'] + request()->query()) }}"
                                        class="btn btn-fancy-outline {{ $sort === 'popular' ? 'active' : '' }}">
                                        🔥 熱門
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form method="GET" action="{{ route('ideas.index') }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control search-input"
                                            placeholder="🔍 搜尋荒唐點子..." value="{{ request('search') }}">
                                        <button class="btn search-btn" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ideas Grid -->
                @if ($ideas->count() > 0)
                    <div class="row">
                        @foreach ($ideas as $idea)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 idea-card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('ideas.show', $idea) }}" class="idea-title">
                                                {{ $idea->title }}
                                            </a>
                                        </h5>
                                        @if ($idea->description)
                                            <p class="card-text text-muted">
                                                {{ Str::limit($idea->description, 100) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-3">
                                                <!-- Vote Button -->
                                                @auth
                                                    <button
                                                        class="btn btn-link p-0 vote-btn {{ $idea->hasVotedBy(auth()->user()) ? 'voted' : '' }}"
                                                        data-idea-id="{{ $idea->id }}"
                                                        data-voted="{{ $idea->hasVotedBy(auth()->user()) ? 'true' : 'false' }}">
                                                        <i class="fas fa-thumbs-up"></i>
                                                        <span class="vote-count">{{ $idea->vote_count }}</span>
                                                    </button>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fas fa-thumbs-up"></i>
                                                        <span>{{ $idea->vote_count }}</span>
                                                    </span>
                                                @endauth

                                                <!-- Comments -->
                                                <span class="text-muted">
                                                    <i class="fas fa-comment"></i>
                                                    {{ $idea->comment_count }}
                                                </span>
                                            </div>
                                            <small class="text-muted">
                                                by <strong>{{ $idea->user->name }}</strong> ·
                                                {{ $idea->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $ideas->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-5 empty-state">
                        <div class="mb-4">
                            <i class="fas fa-lightbulb fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">💭 還沒有點子</h4>
                        <p class="text-muted">成為第一個分享荒唐點子的人吧！</p>
                        @auth
                            <a href="{{ route('ideas.create') }}" class="btn btn-fancy-primary">
                                <i class="fas fa-plus"></i> 立即投稿
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-fancy-primary">
                                <i class="fas fa-plus"></i> 登入後投稿
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Vote toggle functionality
            $('.vote-btn').on('click', function(e) {
                e.preventDefault();

                const btn = $(this);
                const ideaId = btn.data('idea-id');
                const voted = btn.data('voted');

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
                                btn.addClass('voted');
                                btn.data('voted', 'true');
                            } else {
                                btn.removeClass('voted');
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
