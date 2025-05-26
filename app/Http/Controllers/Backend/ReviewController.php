<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
class ReviewController extends Controller
{
    //

    public function index(){

        $reviews=Review::with(['book','user'])->latest()->paginate(5);

        return view('admin.reviews.reviews',compact('reviews'));

    }

    public function edit($id){
        $review = Review::findOrFail($id);
        return view('admin.reviews.edit-review', compact('review'));
    }

    // Admin: Update a review
    public function update(Request $request, $id)
    {
        $request->validate([
            'review' => 'required|string|max:1000',
            'rating' => 'required|numeric|min:1|max:5',
            'status' => 'required|in:active,block'
        ]);

        $review = Review::findOrFail($id);
        $review->update($request->only('review', 'rating', 'status'));

        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    // Admin: Delete review
    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
