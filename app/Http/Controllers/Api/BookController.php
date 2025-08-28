<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the user's books.
     */
    public function index(Request $request)
    {
        $query = $request->user()->books()->latest();

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['reading', 'completed'])) {
            $query->where('status', $request->status);
        }

        $books = $query->paginate(10);

        // Add readable status to each book
        $books->getCollection()->transform(function ($book) {
            $book->readable_status = $book->readable_status;
            return $book;
        });

        return response()->json($books);
    }

    /**
     * Store a newly created book.
     */
    public function store(StoreBookRequest $request)
    {
        $book = $request->user()->books()->create($request->validated());
        $book->readable_status = $book->readable_status;

        return response()->json([
            'message' => 'Book created successfully',
            'book' => $book
        ], 201);
    }

    /**
     * Display the specified book.
     */
    public function show(Request $request, Book $book)
    {
        $this->authorize('view', $book);

        $book->readable_status = $book->readable_status;

        return response()->json([
            'book' => $book
        ]);
    }

    /**
     * Update the specified book.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        $book->readable_status = $book->readable_status;

        return response()->json([
            'message' => 'Book updated successfully',
            'book' => $book
        ]);
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Request $request, Book $book)
    {
        $this->authorize('delete', $book);

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
}
