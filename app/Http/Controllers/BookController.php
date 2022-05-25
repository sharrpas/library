<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{

    public function index()
    {
        return Book::query()->paginate(10);

    }

    public function library()
    {
        //todo
    }

    public function show(Book $book)
    {
        return
            [
                'book' => $book,
                'path' => Storage::url('books/' . $book->path)
            ];
    }


}
