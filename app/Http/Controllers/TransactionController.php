<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'book')->get();

        if ($transactions->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!"
                ], 200);
        };


        return response()->json([
            "success" => true,
            "message" => "Get all resources",
            "data" => $transactions
        ], 200);
    }

    public function store(Request $request)
    {
        //1. validator & cek validator
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity'=> 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'=> false,
                'message' => 'Validation error',
                'data' => $validator->errors()
            ], 422);
        }
    
        //2. generate orderNumber -> unique | ORD-003
        $uniqueCode = "ORD-" . strtoupper(uniqid());

        //3. ambil user yang sedang login & cek login (apakah ada data user?)
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success'=> false,
                'message'=> 'Unauthorized!'
            ],401);
        }

        //4. mencari data buku dari request 
        $book = Book::find($request->book_id);

        //5. cek stok buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success'=> false,
                'message'=> 'Stok barang tidak cukup!'
            ], 400);
        }

        //6. hitung total harga = price * qunatity
        $totalAmount = $book->price * $request->quantity;

        //7. kurangi stok buku (update)
        $book->stock -= $request->quantity;
        $book->save();

        //8. simpan data transaksi
        $transactions = Transaction::create([
            'order_number'=> $uniqueCode,
            'customer_id' => $user->id,
            'book_id' => $request->book_id,
            'total_amount' => $totalAmount
        ]);

        return response()->json([
            'success'=> true,
            'message'=> 'Transaction created succesfully!',
            'data' => $transactions
        ],201);
    }
}
