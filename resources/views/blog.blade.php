@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold text-dark">Our Blog</h1>
        <p class="lead text-muted">Thoughts, stories and ideas</p>
    </div>

    @if ($posts->count())
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-lg-8 mx-auto mb-5">
                    <article class="card border-0 shadow-sm overflow-hidden">
                        @if($post->image_path)
                            <div class="post-image-container">
                                <img src="{{ asset('storage/' . $post->image_path) }}"
                                     alt="{{ $post->title }}"
                                     class="img-fluid w-100">
                            </div>
                        @endif
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                                <span class="mx-2 text-muted">•</span>
                                <small class="text-muted">5 min read</small>
                            </div>
                            <h2 class="h3 font-weight-bold mb-3">
                                <a href="{{ route('blog.show', $post->id) }}" class="text-dark text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="card-text text-muted mb-4">{{ Str::limit($post->content, 200) }}</p>
                            <a href="{{ route('blog.show', $post->id) }}" class="btn btn-outline-primary btn-sm">
                                Continue Reading →
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="display-4 text-muted mb-3">✏️</div>
            <h3 class="h4 text-muted">No blog posts available yet</h3>
            <p class="text-muted">Check back later for new content</p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .post-image-container {
        height: 300px;
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

    .pagination .page-item.active .page-link {
        background-color: #343a40;
        border-color: #343a40;
    }

    .pagination .page-link {
        color: #343a40;
    }
</style>
@endpush
