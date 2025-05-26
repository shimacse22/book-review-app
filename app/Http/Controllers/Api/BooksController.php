<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use App\Http\Resources\BookResource;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        // Start the query to fetch books
        $query = Book::with('reviews.user'); // Eager load reviews and their associated users
    
        // Check if there is a search query parameter
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');  // Search books by title
        }
    
        // Fetch the books with pagination (10 books per page)
        $books = $query->paginate(10);
    
        // Return the books as a collection using BookResource
        return BookResource::collection($books);
    }
    
    public function show($id)
    {
        $book = Book::with('reviews.user')->findOrFail($id);
        
        return new BookResource($book);
    }


    public function getSimilarBooks($bookId)
{
    $book = Book::find($bookId);
    $similarBooks = Book::where('category_id', $book->category_id)
                        ->where('id', '!=', $bookId)
                        ->take(5)  // Show 5 similar books
                        ->get();

    return response()->json($similarBooks);
}

public function getReviews($bookId)
{
    $reviews = Review::where('book_id', $bookId)
                     ->with('user')  // Get user details for each review
                     ->get();

    return response()->json($reviews);
}
}
