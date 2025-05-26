@extends('admin.profile.layouts.app')

@section('content')
    <div class="col-md-9">
        @include('admin.message')
        <div class="card border-0 shadow">
            <div class="card-header  text-white">
                Books
            </div>
            <div class="card-body pb-0">
                <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
                <table class="table  table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    <tbody>
                        @foreach ($books as $book)
                            @if ($book->status === 'available')
                                <tr>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->description }}</td>
                                    <td>
                                        @if ($book->image)
                                            <img src="{{ asset('storage/' . $book->image) }}" width="80" height="100"
                                                alt="{{ $book->title }}">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>
                                    <td>3.0 (3 Reviews)</td>
                                    <td>{{ $book->status }}</td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm"><i
                                                class="fa-regular fa-star"></i></a>
                                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm"><i
                                                class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                    </tbody>
                    </thead>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $books->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
