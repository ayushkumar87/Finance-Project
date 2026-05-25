<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function dashboard()
    {
        $transactions = Auth::user()->transactions()->latest()->take(5)->get();
        $totalIncome = Auth::user()->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = Auth::user()->transactions()->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $savingsRate = $totalIncome > 0 ? round(($balance / $totalIncome) * 100, 1) : 0;

        // Last 7 days trend data
        $days = [];
        $dailyIncome = [];
        $dailyExpense = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $formattedDate = now()->subDays($i)->format('M d');
            $days[] = $formattedDate;
            
            $dailyIncome[] = (float) Auth::user()->transactions()
                ->where('type', 'income')
                ->whereDate('transaction_date', $date)
                ->sum('amount');
                
            $dailyExpense[] = (float) Auth::user()->transactions()
                ->where('type', 'expense')
                ->whereDate('transaction_date', $date)
                ->sum('amount');
        }

        // Expense Category Breakdown
        $categoryBreakdown = Auth::user()->transactions()
            ->where('type', 'expense')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        return view('dashboard', compact(
            'transactions', 
            'totalIncome', 
            'totalExpense', 
            'balance', 
            'savingsRate', 
            'days', 
            'dailyIncome', 
            'dailyExpense',
            'categoryBreakdown'
        ));
    }

    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->orderBy('transaction_date', 'desc');

        if ($request->has('type') && in_array($request->type, ['income', 'expense'])) {
            $query->where('type', $request->type);
        }

        $transactions = $query->paginate(10)->withQueryString();
        
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        Auth::user()->transactions()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Transaction added successfully!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();
        return back()->with('success', 'Transaction deleted successfully!');
    }

    public function literacy()
    {
        return view('literacy');
    }

    public function news()
    {
        return view('news');
    }

    public function calculators()
    {
        return view('calculators');
    }

    public function exportCsv()
    {
        $transactions = Auth::user()->transactions()->orderBy('transaction_date', 'desc')->get();

        $filename = "transactions_export_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Add CSV headers
        fputcsv($handle, ['Date', 'Title', 'Type', 'Amount ($)']);

        // Add rows
        foreach ($transactions as $transaction) {
            fputcsv($handle, [
                $transaction->transaction_date,
                $transaction->title,
                ucfirst($transaction->type),
                $transaction->amount
            ]);
        }

        fclose($handle);
        exit;
    }
}
