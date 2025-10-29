<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /** 🔹 Tampilkan semua buku */
    public function index()
    {
        $books = Book::with('author', 'genre')->get();

        if ($books->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!"
            ], 200);
        }

        $books->map(function ($book) {
            if ($book->cover_photo) {
                $book->cover_photo = asset('storage/books/' . $book->cover_photo);
            }
            return $book;
        });

        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $books
        ], 200);
    }

    /** 🔹 Detail buku */
    public function show(string $id)
    {
        $book = Book::with('author', 'genre')->find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        if ($book->cover_photo) {
            $book->cover_photo = asset('storage/books/' . $book->cover_photo);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail resource',
            'data' => $book
        ], 200);
    }

    /** 🔹 Tambah buku baru */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        // Simpan cover ke folder storage/app/public/books
        $image = $request->file('cover_photo');
        $image->store('books', 'public');

        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'cover_photo' => $image->hashName(),
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully!',
            'data' => $book
        ], 201);
    }

    /** 🔹 Update buku */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // Update data utama
        $book->title = $request->title;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->stock = $request->stock;
        $book->genre_id = $request->genre_id;
        $book->author_id = $request->author_id;

        // 🔄 Jika ada upload cover baru
        if ($request->hasFile('cover_photo')) {
            // Hapus file lama jika ada
            if ($book->cover_photo && Storage::disk('public')->exists('books/' . $book->cover_photo)) {
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }

            // Simpan file baru
            $image = $request->file('cover_photo');
            $image->store('books', 'public');
            $book->cover_photo = $image->hashName();
        }

        $book->save();

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $book
        ], 200);
    }

    /** 🔹 Hapus buku */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        // Hapus cover lama
        if ($book->cover_photo && Storage::disk('public')->exists('books/' . $book->cover_photo)) {
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully'
        ], 200);
    }
}
