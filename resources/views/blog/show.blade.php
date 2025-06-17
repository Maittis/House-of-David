@extends('layouts.public')

@section('content')
<div class="container py-5">
    <article class="card border-0 shadow-sm overflow-hidden">
        @if($post->image_path)
            <div class="post-image-container mb-4">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="img-fluid w-100">
            </div>
        @endif
        <div class="card-body p-4">
            <h1 class="display-4 font-weight-bold text-dark mb-3">{{ $post->title }}</h1>
            <div class="d-flex align-items-center mb-3 text-muted">
                <small>{{ $post->created_at->format('M d, Y') }}</small>
                <span class="mx-2">•</span>
                <small>5 min read</small>
            </div>
            <div class="post-content">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>
    </article>
</div>
@endsection

@push('styles')
<style>
    .post-image-container {
        height: 400px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .post-image-container img {
        object-fit: cover;
        height: 100%;
        width: 100%;
        transition: transform 0.3s ease;
    }

    article:hover .post-image-container img {
        transform: scale(1.03);
    }
</style>
@endpush
