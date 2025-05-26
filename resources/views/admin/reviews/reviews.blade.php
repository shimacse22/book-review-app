@extends('admin.profile.layouts.app')

@section('content')
    <div class="col-md-9">
        @include('admin.message')
        <div class="card border-0 shadow">
            <div class="card-header text-white">
                Reviews
            </div>
            <div class="card-body pb-0">
                <table class="table table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Book</th>
                            <th>Review</th>
                            <th>Rating</th>
                            <th>User</th>
                            <th>Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $review->book->title }}</td>
                                <td>{{ $review->review }}</td>
                                <td><i class="fa-regular fa-star"></i> {{ $review->rating }}</td>
                                <td>{{ $review->user->name }}</td>
                                <td>{{ ucfirst($review->status) }}</td>
                                <td>
                                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {!! $reviews->withQueryString()->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
