<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
//        $books
    }

    public function show()
    {

    }

    public function store(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'title' => 'required|min:4|max:30',
            'author' => 'required|min:3|max:20',
            'translator' => 'min:3|max:20',
            'description' => 'min:4|max:500',
            'book' => 'required|mimes:pdf|max:10000'
        ]);
        if ($validated_data->fails())
            return response()->json($validated_data->errors());

        DB::beginTransaction();
        $BookName = date('Ymdhis') . rand(100, 999) . '.pdf';
        Storage::putFileAs('books', $request->file('book'), $BookName);

        Book::query()->create([
            'title' => $request->title,
            'author' => $request->author,
            'translator' => $request->translator ?? null,
            'description' => $request->description ?? null,
            'path' => $BookName,
        ]);
        DB::commit();

        return response()->json(['data' => 'book saved']);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
