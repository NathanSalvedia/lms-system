<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function requestBooks(Request $request)
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

    public function approveRequest($id)
    {
        try {
            // return $id
            $transaction = Transaction::findOrFail($id);

            if ($transaction->status === 'approved') {
                return response()->json([
                    'message' => 'Transaction is already approved.',
                ], 400);
            }

            $transaction->status = 'approved';
            $transaction->save();

            return response()->json([
                'message' => 'Transaction approved successfully.',
                'transaction' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to approve transaction.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function returnBook($id)
    {
        // return "test"
        try {
            $transaction = Transaction::findOrFail($id);

            if ($transaction->status === 'returned') {
                return response()->json([
                    'message' => 'This book has already been returned.',
                ], 400);
            }

            $transaction->status = 'returned';
            $transaction->return_time = Carbon::now();
            $transaction->save();

            $book = Book::findOrFail($transaction->book_id);
            $book->increment('quantity');

            return response()->json([
                'message' => 'Book returned successfully.',
                'transaction' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to return book.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function viewBorrowHistory($id)
    {
        // return "test"
        try {
            $transactions = Transaction::where('user_id', $id) 
                ->with('book') 
                ->orderBy('starting_time', 'desc') 
                ->get();
    
            if ($transactions->isEmpty()) {
                return response()->json([
                    'message' => 'No borrow history found for this user.',
                ], 404);
            }
            return response()->json([
                'message' => 'Borrow history retrieved successfully.',
                'borrow_history' => $transactions,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve borrow history.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    


}
