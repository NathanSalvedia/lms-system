<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function addTransaction(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|integer',
            'book_id' => 'required|integer',
        ]);

        try {

            $book = Book::findOrFail($validated['book_id']);

            if ($book->quantity < 1) {
                return response()->json([
                    'message' => 'No available copies of this book.',
                ], 400);
            }


            $transaction = new Transaction();
            $transaction->user_id = $validated['user_id'];
            $transaction->book_id = $validated['book_id'];
            $transaction->starting_time = Carbon::now();
            $transaction->end_time = Carbon::now()->addDays(7);
            $transaction->return_time = null;
            $transaction->status = 'pending';

            $transaction->save();


            $book->decrement('quantity');

            return response()->json([
                'message' => 'Book requested successfully.',
                'transaction' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to request book.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
