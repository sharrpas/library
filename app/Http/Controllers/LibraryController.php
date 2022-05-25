<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    public function index()
    {
        $user =Auth::user();
        $books = $user->books()->get();
        return response()->json($books);
    }

    public function show(Book $book)
    {
        return response()->json(
            [
                'book' => $book,
                'path' => Storage::url('books/' . $book->path)
            ]);
    }

    public function store(Book $book)
    {
        $user =Auth::user();
        $user->books()->detach($book->id);
        $user->books()->attach($book->id);
        return response()->json('به کتابخانه شما افزوده شد');
    }

    public function destroy(Book $book)
    {
        $user =Auth::user();
        $user->books()->detach($book->id);
        return response()->json('از کتابخانه شما حذف شد');
    }
}
