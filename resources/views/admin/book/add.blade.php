@extends('admin.profile.layouts.app')

@section('content')
    <div class="col-md-9">
        @include('admin.message')
        <div class="card border-0 shadow">
            <div class="card-header  text-white">
                Add Book
            </div>
            <div class="card-body">
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Title" name="title" id="title" />
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" placeholder="Author" name="author" id="author" />
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30"
                            rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="Image" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" id="image" />
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="available">Active</option>
                            <option value="unavailable">Block</option>
                        </select>
                    </div>


                    <button class="btn btn-primary mt-2" type="submit">Create</button>
                </form>
            </div>

        </div>
    </div>
@endsection
