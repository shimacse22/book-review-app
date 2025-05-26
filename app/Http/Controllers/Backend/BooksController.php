<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    //
    public function index(){
        $books = Book::latest()->paginate(5);
        return view ('admin.book.list',compact('books'));
    }

    public function create(){
        return view ('admin.book.add');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
       // $data = $request->all(); // Get all validated input
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $data['image'] = $imagePath;
        }
    
       // Book::create($data); // Create book with modified input

       $book=new Book();
       $book->title=$request->title;
       $book->author=$request->author;
       $book->description=$request->description;
       $book->image = $imagePath;
       $book->status=$request->status;
       $book->save();
    
        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    public function edit($id){
        $book = Book::findOrFail($id);
        return view('admin.book.edit',compact('book'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required',
        'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $book = Book::findOrFail($id);
    $book->title = $request->title;
    $book->author = $request->author;
    $book->description = $request->description;
    $book->status = $request->status;

    if ($request->hasFile('cover_image')) {
        $path = $request->file('cover_image')->store('books', 'public');
        $book->cover_image = $path;
    }

    $book->save();

    return redirect()->route('books.index')->with('success', 'Book updated successfully!');
}

public function destroy($id)
{
    $book = Book::findOrFail($id);
    $book->delete(); // only delete from DB, not storage
    return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
}
}
