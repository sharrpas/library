<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::query()->select(['id', 'title', 'author', 'description', 'image'])->simplePaginate(10);
        return response()->json($books);
    }

    public function search($search)
    {
        $books = Book::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('author', 'LIKE', "%{$search}%")
            ->orWhere('translator', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->select(['id', 'title', 'author', 'description', 'image'])
            ->simplePaginate(10);

        return response()->json($books);
    }

}
