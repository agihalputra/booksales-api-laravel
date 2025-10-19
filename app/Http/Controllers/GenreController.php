<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    // READ all genres
    public function index()
    {
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get all genres",
            "data" => $genres
        ], 200);
    }

    // CREATE new genre
    public function store(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 422);
        }

        // 2. Simpan data genre
        $genre = Genre::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        // 3. Response sukses
        return response()->json([
            "success" => true,
            "message" => "Genre added successfully!",
            "data" => $genre
        ], 201);
    }

    // READ detail genre
    public function show(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success'=> false,
                'message'=> 'Resource not found'
            ], 404);
        }

        return response()->json([
            'success'=> true,
            'message'=> 'Get detail resource',
            'data'=> $genre
        ], 200);
    }

    // UPDATE genre
    public function update(string $id, Request $request)
    {
        // 1. Cari data genre
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success'=> false,
                'message'=> 'Resource not found'
            ], 404);
        }

        // 2. Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 422);
        }

        // 3. Update data genre
        $genre->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        // 4. Response sukses
        return response()->json([
            'success'=> true,
            'message'=> 'Resource updated successfully!',
            'data'=> $genre
        ], 200);
    }

    // DELETE genre
    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success'=> false,
                'message'=> 'Resource not found'
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'success'=> true,
            'message'=> 'Delete resource successfully'
        ], 200);
    }
}
