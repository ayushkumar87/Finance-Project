@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Financial Calculators</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Plan your future investments and visualize your borrowing costs in real-time.</p>
</div>

<!-- Tab Headers -->
<div class="border-b border-gray-200 dark:border-gray-700 mb-8 flex gap-6">
    <button onclick="switchTab('sip')" id="tab-btn-sip" class="pb-3 text-base font-bold transition-all duration-150 border-b-2 border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 focus:outline-none">
        SIP / Compound Interest
    </button>
    <button onclick="switchTab('emi')" id="tab-btn-emi" class="pb-3 text-base font-medium transition-all duration-150 border-b-2 border-transparent text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none">
        Loan EMI Calculator
    </button>
</div>

<!-- SIP Calculator Content -->
<div id="calculator-sip" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left inputs -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 flex flex-col gap-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-50 dark:border-gray-700 pb-2">Investment Parameters</h2>
        
        <!-- Monthly Contribution -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="sip-contrib" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Monthly Contribution ($)</label>
                <input type="number" id="sip-contrib-num" class="w-24 px-2 py-1 text-right text-sm font-bold border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-900 rounded focus:outline-none" value="500">
            </div>
            <input type="range" id="sip-contrib" min="10" max="10000" step="10" value="500" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
            <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                <span>$10</span>
                <span>$10,000</span>
            </div>
        </div>

        <!-- Expected Return Rate -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="sip-rate" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Expected Annual Return (%)</label>
                <input type="number" id="sip-rate-num" step="0.1" class="w-24 px-2 py-1 text-right text-sm font-bold border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-900 rounded focus:outline-none" value="12">
            </div>
            <input type="range" id="sip-rate" min="1" max="30" step="0.5" value="12" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
            <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                <span>1%</span>
                <span>30%</span>
            </div>
        </div>

        <!-- Time Period -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="sip-period" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Time Period (Years)</label>
                <input type="number" id="sip-period-num" class="w-24 px-2 py-1 text-right text-sm font-bold border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-900 rounded focus:outline-none" value="10">
            </div>
            <input type="range" id="sip-period" min="1" max="40" step="1" value="10" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
            <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                <span>1 Year</span>
                <span>40 Years</span>
            </div>
        </div>
    </div>

    <!-- Right results & chart -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 flex flex-col items-center justify-between min-h-[400px]">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white w-full border-b border-gray-50 dark:border-gray-700 pb-2 mb-6">Investment Summary</h2>
        
        <div class="w-full flex flex-col gap-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-400">Total Invested</span>
                <span class="text-lg font-extrabold text-gray-900 dark:text-white" id="sip-res-invested">$0.00</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-400">Estimated Returns</span>
                <span class="text-lg font-extrabold text-green-600 dark:text-green-400" id="sip-res-returns">$0.00</span>
            </div>
            <div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-700 pt-3">
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Total Wealth Value</span>
                <span class="text-xl font-black text-indigo-600 dark:text-indigo-400" id="sip-res-total">$0.00</span>
            </div>
        </div>

        <div class="w-full max-w-[200px] h-[200px] mb-2">
            <canvas id="sipChart"></canvas>
        </div>
    </div>
</div>

<!-- EMI Calculator Content -->
<div id="calculator-emi" class="grid grid-cols-1 lg:grid-cols-3 gap-8 hidden">
    <!-- Left inputs -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 flex flex-col gap-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-50 dark:border-gray-700 pb-2">Loan Parameters</h2>
        
        <!-- Loan Principal -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="emi-principal" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Loan Amount ($)</label>
                <input type="number" id="emi-principal-num" class="w-28 px-2 py-1 text-right text-sm font-bold border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-900 rounded focus:outline-none" value="50000">
            </div>
            <input type="range" id="emi-principal" min="1000" max="1000000" step="1000" value="50000" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
            <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                <span>$1,000</span>
                <span>$1,000,000</span>
            </div>
        </div>

        <!-- Loan Interest Rate -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="emi-rate" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Interest Rate (% p.a.)</label>
                <input type="number" id="emi-rate-num" step="0.1" class="w-24 px-2 py-1 text-right text-sm font-bold border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-900 rounded focus:outline-none" value="8.5">
            </div>
            <input type="range" id="emi-rate" min="1" max="25" step="0.1" value="8.5" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
            <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                <span>1%</span>
                <span>25%</span>
            </div>
        </div>

        <!-- Loan Tenure -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="emi-tenure" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tenure (Years)</label>
                <input type="number" id="emi-tenure-num" class="w-24 px-2 py-1 text-right text-sm font-bold border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-slate-900 rounded focus:outline-none" value="15">
            </div>
            <input type="range" id="emi-tenure" min="1" max="30" step="1" value="15" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
            <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                <span>1 Year</span>
                <span>30 Years</span>
            </div>
        </div>
    </div>

    <!-- Right results & chart -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 flex flex-col items-center justify-between min-h-[400px]">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white w-full border-b border-gray-50 dark:border-gray-700 pb-2 mb-6">Repayment Summary</h2>
        
        <div class="w-full flex flex-col gap-4 mb-6">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-400">Monthly EMI</span>
                <span class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400" id="emi-res-emi">$0.00</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-400">Principal Loan Amount</span>
                <span class="text-lg font-extrabold text-gray-900 dark:text-white" id="emi-res-principal">$0.00</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-400">Total Interest Payable</span>
                <span class="text-lg font-extrabold text-red-600 dark:text-red-400" id="emi-res-interest">$0.00</span>
            </div>
            <div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-700 pt-3">
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Total Repayment Amount</span>
                <span class="text-xl font-black text-slate-800 dark:text-white" id="emi-res-total">$0.00</span>
            </div>
        </div>

        <div class="w-full max-w-[200px] h-[200px] mb-2">
            <canvas id="emiChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // -------------------------------------------------------------
    // Tab Swapping
    // -------------------------------------------------------------
    function switchTab(type) {
        const sipSection = document.getElementById('calculator-sip');
        const emiSection = document.getElementById('calculator-emi');
        const sipBtn = document.getElementById('tab-btn-sip');
        const emiBtn = document.getElementById('tab-btn-emi');

        if(type === 'sip') {
            sipSection.classList.remove('hidden');
            emiSection.classList.add('hidden');

            sipBtn.className = "pb-3 text-base font-bold transition-all duration-150 border-b-2 border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 focus:outline-none";
            emiBtn.className = "pb-3 text-base font-medium transition-all duration-150 border-b-2 border-transparent text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none";
        } else {
            emiSection.classList.remove('hidden');
            sipSection.classList.add('hidden');

            emiBtn.className = "pb-3 text-base font-bold transition-all duration-150 border-b-2 border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 focus:outline-none";
            sipBtn.className = "pb-3 text-base font-medium transition-all duration-150 border-b-2 border-transparent text-gray-400 dark:text-gray-500 hover:text-gray-600 focus:outline-none";
            
            // Re-render EMI chart to ensure it updates when tab switches
            calculateEMI();
        }
    }

    // -------------------------------------------------------------
    // SIP Calculation & Live Chart
    // -------------------------------------------------------------
    const sipContribSlider = document.getElementById('sip-contrib');
    const sipContribNum = document.getElementById('sip-contrib-num');
    const sipRateSlider = document.getElementById('sip-rate');
    const sipRateNum = document.getElementById('sip-rate-num');
    const sipPeriodSlider = document.getElementById('sip-period');
    const sipPeriodNum = document.getElementById('sip-period-num');

    let sipChartInstance = null;

    function calculateSIP() {
        const monthly = parseFloat(sipContribSlider.value) || 0;
        const annualRate = parseFloat(sipRateSlider.value) || 0;
        const years = parseInt(sipPeriodSlider.value) || 0;

        const totalInvested = monthly * 12 * years;
        
        // SIP Formula: M = P * [ ( (1 + i)^n - 1 ) / i ] * (1 + i)
        // where i = monthly rate, n = months
        let totalValue = 0;
        if(annualRate > 0) {
            const monthlyRate = (annualRate / 100) / 12;
            const months = years * 12;
            totalValue = monthly * ((Math.pow(1 + monthlyRate, months) - 1) / monthlyRate) * (1 + monthlyRate);
        } else {
            totalValue = totalInvested;
        }

        const estReturns = Math.max(0, totalValue - totalInvested);

        // Update Text
        document.getElementById('sip-res-invested').textContent = '$' + totalInvested.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('sip-res-returns').textContent = '$' + estReturns.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('sip-res-total').textContent = '$' + totalValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        // Update Chart
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#6b7280';

        if(sipChartInstance) {
            sipChartInstance.data.datasets[0].data = [totalInvested, estReturns];
            sipChartInstance.update();
        } else {
            const ctx = document.getElementById('sipChart').getContext('2d');
            sipChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Invested Amount', 'Wealth Return'],
                    datasets: [{
                        data: [totalInvested, estReturns],
                        backgroundColor: ['#6366f1', '#10B981'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor,
                                font: { family: 'sans-serif', size: 11, weight: '600' }
                            }
                        }
                    }
                }
            });
        }
    }

    // Connect slider + numbers for SIP
    function bindSIP() {
        // Contribution
        sipContribSlider.addEventListener('input', (e) => {
            sipContribNum.value = e.target.value;
            calculateSIP();
        });
        sipContribNum.addEventListener('input', (e) => {
            sipContribSlider.value = e.target.value;
            calculateSIP();
        });

        // Return rate
        sipRateSlider.addEventListener('input', (e) => {
            sipRateNum.value = e.target.value;
            calculateSIP();
        });
        sipRateNum.addEventListener('input', (e) => {
            sipRateSlider.value = e.target.value;
            calculateSIP();
        });

        // Period
        sipPeriodSlider.addEventListener('input', (e) => {
            sipPeriodNum.value = e.target.value;
            calculateSIP();
        });
        sipPeriodNum.addEventListener('input', (e) => {
            sipPeriodSlider.value = e.target.value;
            calculateSIP();
        });
    }

    // -------------------------------------------------------------
    // EMI Calculation & Live Chart
    // -------------------------------------------------------------
    const emiPrincipalSlider = document.getElementById('emi-principal');
    const emiPrincipalNum = document.getElementById('emi-principal-num');
    const emiRateSlider = document.getElementById('emi-rate');
    const emiRateNum = document.getElementById('emi-rate-num');
    const emiTenureSlider = document.getElementById('emi-tenure');
    const emiTenureNum = document.getElementById('emi-tenure-num');

    let emiChartInstance = null;

    function calculateEMI() {
        const principal = parseFloat(emiPrincipalSlider.value) || 0;
        const annualRate = parseFloat(emiRateSlider.value) || 0;
        const years = parseInt(emiTenureSlider.value) || 0;

        const months = years * 12;
        const monthlyRate = (annualRate / 100) / 12;

        // EMI Formula: EMI = P * r * (1 + r)^n / [ (1 + r)^n - 1 ]
        let emi = 0;
        if(annualRate > 0) {
            emi = principal * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
        } else {
            emi = principal / months;
        }

        const totalPayable = emi * months;
        const totalInterest = Math.max(0, totalPayable - principal);

        // Update Text
        document.getElementById('emi-res-emi').textContent = '$' + emi.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('emi-res-principal').textContent = '$' + principal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('emi-res-interest').textContent = '$' + totalInterest.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('emi-res-total').textContent = '$' + totalPayable.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        // Update Chart
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#6b7280';

        if(emiChartInstance) {
            emiChartInstance.data.datasets[0].data = [principal, totalInterest];
            emiChartInstance.update();
        } else {
            const ctx = document.getElementById('emiChart').getContext('2d');
            emiChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Principal Amount', 'Total Interest'],
                    datasets: [{
                        data: [principal, totalInterest],
                        backgroundColor: ['#6366f1', '#EF4444'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor,
                                font: { family: 'sans-serif', size: 11, weight: '600' }
                            }
                        }
                    }
                }
            });
        }
    }

    // Connect slider + numbers for EMI
    function bindEMI() {
        // Principal
        emiPrincipalSlider.addEventListener('input', (e) => {
            emiPrincipalNum.value = e.target.value;
            calculateEMI();
        });
        emiPrincipalNum.addEventListener('input', (e) => {
            emiPrincipalSlider.value = e.target.value;
            calculateEMI();
        });

        // Rate
        emiRateSlider.addEventListener('input', (e) => {
            emiRateNum.value = e.target.value;
            calculateEMI();
        });
        emiRateNum.addEventListener('input', (e) => {
            emiRateSlider.value = e.target.value;
            calculateEMI();
        });

        // Tenure
        emiTenureSlider.addEventListener('input', (e) => {
            emiTenureNum.value = e.target.value;
            calculateEMI();
        });
        emiTenureNum.addEventListener('input', (e) => {
            emiTenureSlider.value = e.target.value;
            calculateEMI();
        });
    }

    // -------------------------------------------------------------
    // Initializers
    // -------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', () => {
        calculateSIP();
        bindSIP();
        
        calculateEMI();
        bindEMI();

        // Listen for theme toggle to update legends
        const toggleBtn = document.getElementById('theme-toggle');
        if(toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const isDarkNow = document.documentElement.classList.contains('dark');
                const nextText = isDarkNow ? '#9ca3af' : '#6b7280';
                
                if(sipChartInstance) {
                    sipChartInstance.options.plugins.legend.labels.color = nextText;
                    sipChartInstance.update();
                }
                if(emiChartInstance) {
                    emiChartInstance.options.plugins.legend.labels.color = nextText;
                    emiChartInstance.update();
                }
            });
        }
    });
</script>
@endsection
