@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">編輯點子</h4>
                            <a href="{{ route('ideas.show', $idea) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> 返回
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('ideas.update', $idea) }}">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">標題 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $idea->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label">描述（選填）</label>
                                <textarea class="form-control autosize @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="5">{{ old('description', $idea->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('ideas.show', $idea) }}" class="btn btn-secondary">取消</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> 儲存變更
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .form-label {
                font-weight: 600;
            }

            .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid #dee2e6;
            }
        </style>
    @endpush
@endsection
