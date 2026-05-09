@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">All Transactions</h1>
        <p class="text-gray-500 mt-1 mb-4">A complete list of your incomes and expenses.</p>
        
        <!-- Filters -->
        <div class="flex space-x-2">
            <a href="{{ route('transactions.index') }}" class="px-3 py-1 rounded-full text-sm font-medium {{ request('type') ? 'bg-gray-100 text-gray-600 hover:bg-gray-200' : 'bg-indigo-100 text-indigo-800' }}">All</a>
            <a href="{{ route('transactions.index', ['type' => 'income']) }}" class="px-3 py-1 rounded-full text-sm font-medium {{ request('type') === 'income' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Income</a>
            <a href="{{ route('transactions.index', ['type' => 'expense']) }}" class="px-3 py-1 rounded-full text-sm font-medium {{ request('type') === 'expense' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Expenses</a>
        </div>
    </div>
    <div class="flex space-x-3">
        @if($transactions->count() > 0)
            <a href="{{ route('transactions.export') }}" class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-semibold py-2 px-4 rounded shadow-sm transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export CSV
            </a>
        @endif
        <a href="{{ route('transactions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow transition">
            + Add Transaction
        </a>
    </div>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    @if($transactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $transaction->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($transaction->type === 'income')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Income
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Expense
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $transactions->links() }}
        </div>
    @else
        <div class="p-12 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <p class="text-lg font-medium">No transactions found</p>
            <p class="text-sm mt-2 mb-6">You haven't added any incomes or expenses yet.</p>
            <a href="{{ route('transactions.create') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Add your first transaction &rarr;</a>
        </div>
    @endif
</div>
@endsection
