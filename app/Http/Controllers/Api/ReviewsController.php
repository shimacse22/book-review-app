<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'book'])->get();
        return ReviewResource::collection($reviews);
    }

    public function show($id)
    {
        $review = Review::with(['user', 'book'])->findOrFail($id);
        return new ReviewResource($review);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return new ReviewResource($review);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $review->update($request->only('rating', 'review'));

        return new ReviewResource($review);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully.']);
    }
}
