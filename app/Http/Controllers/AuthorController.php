<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    // READ all authors
    public function index()
    {
        $authors = Author::all();

        if ($authors->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get all authors",
            "data" => $authors
        ], 200);
    }

    // CREATE new author
    public function store(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:authors,name',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'bio' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 422);
        }

        // 2. Upload foto jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo->store('authors', 'public');
            $photoPath = $photo->hashName();
        }

        // 3. Simpan data author
        $author = Author::create([
            'name' => $request->name,
            'photo' => $photoPath,
            'bio' => $request->bio
        ]);

        // 4. Response sukses
        return response()->json([
            "success" => true,
            "message" => "Author added successfully!",
            "data" => $author
        ], 201);
    }

    // SHOW author detail
    public function show(string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail resource',
            'data' => $author
        ], 200);
    }

    // UPDATE author
    public function update(string $id, Request $request)
    {
        // 1. Cari data author
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        // 2. Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:authors,name,' . $id,
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'bio' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan data yang akan diupdate
        $data = [
            'name' => $request->name,
            'bio' => $request->bio,
        ];

        // 4. Jika ada file foto baru dikirim
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo->store('authors', 'public');

            // Hapus foto lama jika ada
            if ($author->photo && Storage::disk('public')->exists('authors/' . $author->photo)) {
                Storage::disk('public')->delete('authors/' . $author->photo);
            }

            // Simpan nama foto baru
            $data['photo'] = $photo->hashName();
        } else {
            // Jika tidak upload foto baru, tetap gunakan foto lama
            $data['photo'] = $author->photo;
        }

        // 5. Update data di database
        $author->update($data);

        // 6. Response sukses
        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully!',
            'data' => $author
        ], 200);
    }

    // DELETE author
    public function destroy(string $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);
        }

        if ($author->photo && Storage::disk('public')->exists('authors/' . $author->photo)) {
            // Hapus file foto dari storage
            Storage::disk('public')->delete('authors/' . $author->photo);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully'
        ]);
    }
}
