<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        if ($books->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!"
                ], 200);
        };


        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $books
        ], 200);
    }

    public function store(Request $request) {
        //1. Validator
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description'=> 'required|string',
            'price'=> 'required|numeric',
            'stock'=> 'required|integer',
            'cover_photo'=> 'required|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id'=> 'required|exists:genres,id',
            'author_id'=> 'required|exists:authors,id'
        ]);


        //2. Check validator eror
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'=> $validator->errors(),
            ], 422);
        };

        //3. Upload image
        $image = $request->file('cover_photo');
        $image->store('books','public');

        //4. Insert Data
        $book = Book::create([
            'title'=> $request->title,
            'description'=> $request->description,
            'price'=> $request->price,
            'stock'=> $request->stock,
            'cover_photo' => $image->hashName(),
            'genre_id' => $request->genre_id,
            'author_id'=> $request->author_id,
        ]);

        //5. Response
        return response()->json([
            'success'=> true,
            'message'=> 'Resource added succesfully!',
            'data'=> $book
            ], 201);
    }

    public function show(string $id) {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success'=> false,
                'message'=> 'Resource not found'
            ],404);
        }

        return response()->json([
            'success'=> true,
            'message'=> 'Get detail resource',
            'data'=> $book
        ], 200);
    }

    public function update(string $id, Request $request)
    {
        // 1. Cari data
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        // 2. Validasi input
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

        // 3. Siapkan data untuk update
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id,
        ];

        // 4. Jika ada file cover baru dikirim
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');

            // Simpan file baru
            $image->store('books', 'public');

            // Hapus file lama kalau ada
            if ($book->cover_photo && Storage::disk('public')->exists('books/' . $book->cover_photo)) {
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }

            // Update nama file di database
            $data['cover_photo'] = $image->hashName();
        } else {
            // Jika tidak upload foto baru, gunakan foto lama
            $data['cover_photo'] = $book->cover_photo;
        }

        // 5. Update data di database
        $book->update($data);

        // 6. Response sukses
        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $book
        ], 200);
    }


    public function destroy(string $id) {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'success'=> false,
                'message'=> 'Resource not found'
            ],404);
        }

        if ($book->cover_photo) {
            //delete from storage
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        }

        $book->delete();

        return response()->json([
            'success'=> true,
            'message'=> 'Delete resource successfully'
            ]);
    }

}
