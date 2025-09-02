@extends('layout')

@push('styles')
    <link rel="stylesheet" href="/css/ideas-fancy.css">
@endpush

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card fancy-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">💡 發表點子</h4>
                            <a href="{{ route('ideas.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left"></i> 返回
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('ideas.store') }}">
                            @csrf

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">標題 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" placeholder="例如：幫我假裝很忙的滑鼠指標" value="{{ old('title') }}"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label">描述（選填）</label>
                                <textarea class="form-control autosize @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="5" placeholder="可以補充你的想像、使用情境…">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('ideas.index') }}" class="btn btn-fancy-secondary">取消</a>
                                <button type="submit" class="btn btn-fancy-primary">
                                    <i class="fas fa-star"></i> 發表
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
