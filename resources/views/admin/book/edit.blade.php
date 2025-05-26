@extends('admin.profile.layouts.app')

@section('content')
    <div class="col-md-9">
        @include('admin.message')
        <div class="card border-0 shadow">
            <div class="card-header text-white">
                Edit Book
            </div>
            <div class="card-body">
                <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input value="{{ old('title', $book->title) }}" type="text" class="form-control" name="title"
                            id="title" placeholder="Title" />
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input value="{{ old('author', $book->author) }}" type="text" class="form-control" name="author"
                            id="author" placeholder="Author" />
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30"
                            rows="5">{{ old('description', $book->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" name="cover_image" id="image" />
                        @if ($book->cover_image)
                            <br>
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Book Cover" class="w-25">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $book->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $book->status == 0 ? 'selected' : '' }}>Blocked</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
