@extends('layouts.app')

@section('content')
<div class="mb-10 text-center max-w-3xl mx-auto">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Financial Literacy</h1>
    <p class="text-lg text-gray-600">Master your money with these simple, fundamental rules of personal finance.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
    <!-- Tip 1 -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
        <div class="bg-indigo-600 h-2 w-full"></div>
        <div class="p-8">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-6">
                <span class="text-xl font-bold">1</span>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">The 50/30/20 Rule</h2>
            <p class="text-gray-600 leading-relaxed">
                Divide your after-tax income into three categories: <strong>50% for needs</strong> (rent, groceries, bills), <strong>30% for wants</strong> (hobbies, dining out), and <strong>20% for savings</strong> or paying off debt. It's a simple, effective way to budget without getting overwhelmed by details.
            </p>
        </div>
    </div>

    <!-- Tip 2 -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
        <div class="bg-green-500 h-2 w-full"></div>
        <div class="p-8">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-6">
                <span class="text-xl font-bold">2</span>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Build an Emergency Fund</h2>
            <p class="text-gray-600 leading-relaxed">
                Life is unpredictable. Aim to save 3 to 6 months' worth of living expenses in a separate, easily accessible savings account. This acts as your financial safety net against unexpected events like medical emergencies or sudden job loss.
            </p>
        </div>
    </div>

    <!-- Tip 3 -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
        <div class="bg-yellow-500 h-2 w-full"></div>
        <div class="p-8">
            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center mb-6">
                <span class="text-xl font-bold">3</span>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Pay Off High-Interest Debt</h2>
            <p class="text-gray-600 leading-relaxed">
                Credit card debt can quickly spiral out of control due to high compound interest. Prioritize paying off debts with the highest interest rates first (the avalanche method) while making minimum payments on others to save money in the long run.
            </p>
        </div>
    </div>

    <!-- Tip 4 -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
        <div class="bg-purple-500 h-2 w-full"></div>
        <div class="p-8">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-6">
                <span class="text-xl font-bold">4</span>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-3">Track Your Spending</h2>
            <p class="text-gray-600 leading-relaxed">
                You can't manage what you don't measure. Use this Finance Manager to record every expense and income. Knowing exactly where your money goes is the first crucial step to taking control of your financial future.
            </p>
        </div>
    </div>
</div>

<div class="text-center mt-12 mb-8">
    <a href="{{ route('dashboard') }}" class="inline-block bg-gray-800 text-white font-medium px-8 py-3 rounded-lg shadow hover:bg-gray-700 transition">
        Back to Dashboard
    </a>
</div>
@endsection
