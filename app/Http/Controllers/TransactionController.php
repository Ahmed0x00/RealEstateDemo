<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\HandlesModelNotFound;

class TransactionController extends Controller
{
    use HandlesModelNotFound;

    // 1. Get all transactions
    public function getAllTransactions()
    {
        $transactions = Transaction::all();
        $totalTransactions = $transactions->count(); // Get the total number of transactions

        return response()->json([
            'totalTransactions' => $totalTransactions,
            'transactions' => $transactions
        ]);
    }

    // 2. Get specific transaction by ID
    public function getTransactionById($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            return response()->json($transaction);
        } catch (ModelNotFoundException $e) {
            return $this->returnNotFound('Transaction');
        }
    }

    // 3. Delete a transaction
    public function deleteTransaction($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);

            // Adjust the owner's balance before deletion
            $owner = User::where('role', 'owner')->firstOrFail();

            // Adjust the balance based on the transaction type
            if ($transaction->type === 'income') {
                $owner->balance -= $transaction->amount;
            } else {
                $owner->balance += $transaction->amount;
            }

            $owner->save();
            $transaction->delete();

            return response()->json(['message' => 'Transaction deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return $this->returnNotFound('Transaction');
        }
    }

    // 5. Create income transaction
    public function createIncome(Request $request)
    {
        return $this->createTransaction($request, 'income');
    }

    // 6. Create outcome transaction
    public function createOutcome(Request $request)
    {
        return $this->createTransaction($request, 'outcome');
    }

    // Helper function to create transactions
    private function createTransaction(Request $request, $type)
    {
        // Validate the request data
        $request->validate([
            'amount' => 'required|numeric',
            'from' => 'required|string',
            'to' => 'required|string',
            'transaction_date' => 'required|date',
        ]);

        // Get the owner
        try {
            $owner = User::where('role', 'owner')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->returnNotFound('Owner');
        }

        // If it's an outcome transaction, check if the owner has sufficient balance
        if ($type === 'outcome' && $request->amount > $owner->balance) {
            return response()->json([
                'message' => 'Insufficient balance for this transaction.',
                'owner_balance' => $owner->balance,
            ], 400);
        }

        // Create the transaction data
        $data = [
            'type' => $type, // 'income' or 'outcome'
            'amount' => $request->amount,
            'from' => $request->from,
            'to' => $request->to,
            'transaction_date' => $request->transaction_date,
        ];

        // Adjust the owner's balance based on the transaction type
        if ($type === 'income') {
            $owner->balance += $request->amount;
        } else {
            $owner->balance -= $request->amount;
        }

        $owner->save();

        // Create the transaction
        $transaction = Transaction::create($data);

        return response()->json([
            'message' => ucfirst($type) . ' transaction created successfully',
            'transaction' => $transaction,
            'owner_balance' => $owner->balance,
        ]);
    }

    // Get all incomes
    public function getAllIncomes()
    {
        $incomes = Transaction::where('type', 'income')->get(); // Update: Filter by type = 'income'
        $totalIncomes = $incomes->sum('amount');

        return response()->json([
            'totalIncomes' => number_format($totalIncomes, 0, '.', ','),
            'incomes' => $incomes
        ]);
    }

    // Get all outcomes
    public function getAllOutcomes()
    {
        $outcomes = Transaction::where('type', 'outcome')->get(); // Update: Filter by type = 'outcome'
        $totalOutcomes = $outcomes->sum('amount');

        return response()->json([
            'totalExpenses' => number_format($totalOutcomes, 0, '.', ','), // Format with commas
            'outcomes' => $outcomes
        ]);
    }

    // Get today's summary
    public function getTodaySummary()
{
    // Get today's date
    $today = Carbon::today();

    // Fetch today's transactions
    $transactions = Transaction::whereDate('created_at', $today)->get();

    // Calculate today's income and expenses
    $income = $transactions->where('type', 'income')->sum('amount');
    $expenses = $transactions->where('type', 'outcome')->sum('amount');

    // Retrieve the owner's balance
    try {
        $owner = User::where('role', 'owner')->firstOrFail();
        $balance = $owner->balance;
    } catch (ModelNotFoundException $e) {
        return $this->returnNotFound('Owner');
    }

    // Fetch the last 12 transactions
    $lastTransactions = Transaction::latest()->take(12)->get()->map(function ($transaction) {
        $transaction->amount = number_format($transaction->amount, 0, '.', ',');
        return $transaction;
    });

    // Fetch the last 10 income transactions
    $lastIncomeTransactions = Transaction::where('type', 'income')->latest()->take(10)->get()->map(function ($transaction) {
        $transaction->amount = number_format($transaction->amount, 0, '.', ',');
        return $transaction;
    });

    // Fetch the last 10 outcome transactions
    $lastOutcomeTransactions = Transaction::where('type', 'outcome')->latest()->take(10)->get()->map(function ($transaction) {
        $transaction->amount = number_format($transaction->amount, 0, '.', ',');
        return $transaction;
    });

    // Prepare response with formatted numbers
    return response()->json([
        'todayTransactions' => $transactions->count() > 0 ? $transactions->count() : 'N/A',
        'todayIncome' => $income > 0 ? number_format($income, 0, '.', ',') : 'N/A',
        'todayExpenses' => $expenses > 0 ? number_format($expenses, 0, '.', ',') : 'N/A',
        'balance' => $balance > 0 ? number_format((int) $balance, 0, '.', ',') : 'N/A',
        'lastTransactions' => $lastTransactions, // Include last 15 transactions with formatted amounts
        'lastIncomeTransactions' => $lastIncomeTransactions, // Last 15 income transactions
        'lastOutcomeTransactions' => $lastOutcomeTransactions // Last 15 outcome transactions
    ]);
}

}
