<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::query()->select(['id', 'title', 'author', 'description', 'image'])->paginate(10);
        return response()->json($books);
    }

}
