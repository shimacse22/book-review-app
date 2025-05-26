@extends('admin.profile.layouts.app')

@section('content')
    <div class="col-md-9">
        <div class="card border-0 shadow">
            <div class="card-header text-white">
                Edit Review
            </div>
            <div class="card-body">
                <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Book</label>
                        <input type="text" class="form-control" value="{{ $review->book->title }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <input type="text" class="form-control" value="{{ $review->user->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Review</label>
                        <textarea name="review" class="form-control" rows="5">{{ old('review', $review->review) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="number" name="rating" class="form-control"
                            value="{{ old('rating', $review->rating) }}" step="0.1" min="0" max="5">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $review->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="block" {{ $review->status == 'block' ? 'selected' : '' }}>Block</option>
                        </select>
                    </div>

                    <button class="btn btn-primary mt-2" type="submit">Update Review</button>
                </form>
            </div>
        </div>
    </div>
@endsection
