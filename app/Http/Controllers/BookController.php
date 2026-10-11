<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });

            // Increment search count for matched books if searching on client side
            if (!$request->routeIs('admin.*')) {
                (clone $query)->increment('search_count');
            }
        }

        $books = $query->latest()->paginate(10)->withQueryString();

        if ($request->routeIs('admin.*')) {
            return inertia('Admin/Books/Index', [
                'books' => $books,
                'filters' => ['search' => $search],
            ]);
        }

        return inertia('Client/Book/Index', [
            'books' => $books,
            'filters' => ['search' => $search],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Books/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('books', 'public');
            $validated['image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        // Increment view count
        $book->increment('view_count');

        return inertia('Client/Book/Show', [
            'book' => $book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return inertia('Admin/Books/Edit', [
            'book' => $book,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books,isbn,'.$book->id,
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $path = $request->file('image')->store('books', 'public');
            $validated['image'] = $path;
        } else {
            $validated['image'] = $book->image;
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }

    /**
     * Purchase a book (increment purchase count and decrease stock).
     */
    public function purchase(Request $request, Book $book)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:'.$book->stock_quantity,
        ]);

        $book->increment('purchase_count', $request->quantity);
        $book->decrement('stock_quantity', $request->quantity);

        return redirect()->back()->with('success', 'Purchase successful.');
    }

    /**
     * Admin dashboard with stats.
     */
    public function dashboard()
    {
        $totalBooks = Book::count();
        $activeBooks = Book::where('is_active', true)->count();
        $mostViewed = Book::orderByDesc('view_count')->first();
        $mostSearched = Book::orderByDesc('search_count')->first();
        $mostSold = Book::orderByDesc('purchase_count')->first();
        $topSearchedBooks = Book::where('search_count', '>', 0)->orderByDesc('search_count')->take(5)->get();
        $topSoldBooks = Book::where('purchase_count', '>', 0)->orderByDesc('purchase_count')->take(5)->get();
        $lowStock = Book::where('stock_quantity', '<', 10)->get();

        return inertia('Admin/Dashboard', [
            'totalBooks' => $totalBooks,
            'activeBooks' => $activeBooks,
            'mostViewed' => $mostViewed,
            'mostSearched' => $mostSearched,
            'mostSold' => $mostSold,
            'topSearchedBooks' => $topSearchedBooks,
            'topSoldBooks' => $topSoldBooks,
            'lowStock' => $lowStock,
        ]);
    }
}
