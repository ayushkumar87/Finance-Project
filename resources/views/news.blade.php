@extends('layouts.app')

@section('content')
<div class="mb-10 text-center max-w-3xl mx-auto">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Latest Market News</h1>
    <p class="text-lg text-gray-600">Stay up-to-date with the latest financial breaking news and market analysis.</p>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 max-w-5xl mx-auto h-[600px]">
    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container" style="height:100%;width:100%">
        <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
        {
        "feedMode": "all_symbols",
        "isTransparent": true,
        "displayMode": "regular",
        "width": "100%",
        "height": "100%",
        "colorTheme": "light",
        "locale": "en"
        }
        </script>
    </div>
    <!-- TradingView Widget END -->
</div>

<div class="text-center mt-12 mb-8">
    <a href="{{ route('dashboard') }}" class="inline-block bg-gray-800 text-white font-medium px-8 py-3 rounded-lg shadow hover:bg-gray-700 transition">
        Back to Dashboard
    </a>
</div>
@endsection
