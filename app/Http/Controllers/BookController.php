<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;


class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required',
            'title' => 'required',
            'author' => 'required',
            'edition' => 'required',
            'publishYear' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'quantity' => 'required',
            'status' => 'required',
        ]);
        // return $request;
        if ($request->hasFile('image')) {

            $fileName = $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs('public', $fileName);
        } else {
            $fileName = null;
        }

        $book = Book::create([
            'isbn' => $request->isbn,
            'title' => $request->title,
            'author' => $request->author,
            'edition' => $request->edition,
            'publishYear' => $request->publishYear,
            'image' => $fileName,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        return response()->json($book, 201);
    }

    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $request->validate([
            "isbn" => "required",
            "title" => "required",
            "author" => "required",
            "edition" => "required",
            "publishYear" => "required",
            "image" => "nullable|image|mimes:jpeg,png,jpg",
            "quantity" => "required",
            "status" => "required",
        ]);
        // return $request;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $book->image = $imagePath;
        }

        $book->update($request->except(['image']));
        return response()->json($book, 200);
    }

    public function destroy(string $id)
    {
        return Book::destroy($id);
    }
}
