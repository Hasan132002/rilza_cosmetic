<x-admin-layout>
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Sales Report</h1>
                <p class="text-gray-600 mt-1">View and analyze sales performance</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Sales</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">PKR {{ number_format($totalSales, 2) }}</h3>
                    </div>
                    <div class="bg-pink-100 rounded-full p-3">
                        <i class="fas fa-dollar-sign text-pink-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Orders</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalOrders) }}</h3>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Average Order Value</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">PKR {{ number_format($averageOrderValue, 2) }}</h3>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-chart-line text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.reports.sales') }}" class="flex flex-wrap gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Period</label>
                    <select name="period" class="border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>

                @if($period == 'daily' || $period == 'monthly')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                    <select name="year" class="border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                @endif

                @if($period == 'daily')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                    <select name="month" class="border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $month == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                @endif

                <div class="flex items-end">
                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-md">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Sales Chart</h2>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Sales (PKR)',
                    data: @json($data),
                    borderColor: 'rgb(236, 72, 153)',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'PKR ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>
