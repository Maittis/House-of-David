{{-- @extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="card shadow-sm rounded-lg">
            <div class="card-header bg-primary text-white text-center py-3">
                <h1 class="mb-0 font-weight-bold">Create Post</h1>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title Field -->
                    <div class="form-group mb-4">
                        <label for="title" class="form-label font-weight-bold">Title</label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" required placeholder="Enter post title">
                    </div>

                    <!-- Content Field -->
                    <div class="form-group mb-4">
                        <label for="content" class="form-label font-weight-bold">Content</label>
                        <textarea class="form-control form-control-lg" id="content" name="content" rows="5" required placeholder="Write your post content here..."></textarea>
                    </div>

                    <!-- Image Upload Field -->
                    <div class="form-group mb-4">
                        <label for="image" class="form-label font-weight-bold">Upload Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .card {
        transition: box-shadow 0.3s;
    }
    .card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .card-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .form-control-lg, .btn-lg {
        border-radius: 8px;
    }
    .form-control:focus, .btn:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style> --}}
