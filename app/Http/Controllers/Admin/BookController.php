<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        return Book::all();
    }

    public function show(Book $book)
    {
        return response()->json(
            [
                'book' => $book,
                'path' => Storage::url('books/' . $book->path),
                'image' => Storage::url('books/' . $book->image),
            ]);
    }

    public function store(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'title' => 'required|min:4|max:30',
            'author' => 'required|min:3|max:20',
            'translator' => 'min:3|max:20',
            'description' => 'min:4|max:500',
            'book' => 'required|mimes:pdf|max:10000',
            'image' => 'required|image|max:10000',
        ]);
        if ($validated_data->fails())
            return response()->json(['error' => true, 'data'=>$validated_data->errors()]);

        $BookName = date('Ymdhis') . rand(100, 999) . '.pdf';
        $imageName = date('Ymdhis') . rand(100, 999) . '.' . $request->file('image')->extension();
        Storage::putFileAs('books', $request->file('book'), $BookName);
        Storage::putFileAs('books', $request->file('image'), $imageName);

        Book::query()->create([
            'title' => $request->title,
            'author' => $request->author,
            'translator' => $request->translator ?? null,
            'description' => $request->description ?? null,
            'path' => $BookName,
            'image' => $imageName
        ]);

        return response()->json(['error' => false,'data' => 'ذخیره شد']);
    }

    public function update(Book $book, Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'title' => 'required|min:4|max:30',
            'author' => 'required|min:3|max:20',
            'translator' => 'min:3|max:20',
            'description' => 'min:4|max:500',
            'image' => 'image|max:10000',
            'book' => 'mimes:pdf|max:10000'
        ]);
        if ($validated_data->fails())
            return response()->json(['error'=>true,'data'=>$validated_data->errors()]);

        if ($request->hasFile('book')) {
            Storage::delete('books/' . $book->path);
            $BookName = date('Ymdhis') . rand(100, 999) . '.pdf';
            Storage::putFileAs('books', $request->file('book'), $BookName);
        } else {
            $BookName = $book->path;
        }

        if ($request->hasFile('image')) {
            Storage::delete('books/' . $book->image);
            $imageName = date('Ymdhis') . rand(100, 999) . '.jpg';
            Storage::putFileAs('books', $request->file('image'), $imageName);
        } else {
            $imageName = $book->image;
        }

        Book::query()->create([
            'title' => $request->title,
            'author' => $request->author,
            'translator' => $request->translator ?? null,
            'description' => $request->description ?? null,
            'path' => $BookName,
            'image' => $imageName,
        ]);

        return response()->json(['error' => false,'data' => 'ویرایش شد']);

    }

    public function destroy(Book $book)
    {
        $book->delete();
        Storage::delete('books/' . $book->path);
        Storage::delete('books/' . $book->image);
        return response()->json(['error' =>false,'data' => 'حذف شد']);
    }
}
