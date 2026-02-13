<x-admin-layout title="B2B Analytics Dashboard">
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-3">
                    <i class="fas fa-chart-line text-purple-600"></i>
                    B2B Analytics Dashboard
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Business-to-Business sales insights and performance metrics</p>
            </div>

            <!-- Date Range Filter -->
            <form method="GET" action="{{ route('admin.reports.b2b-analytics') }}" class="flex gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">From</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">To</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" class="self-end bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total B2B Sales -->
            <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total B2B Sales</p>
                        <p class="text-3xl font-bold mt-2">Rs {{ number_format($stats['total_b2b_sales'], 0) }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-briefcase text-2xl"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <i class="fas fa-chart-line"></i>
                    <span>Selected period</span>
                </div>
            </div>

            <!-- Total B2B Orders -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Orders</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_b2b_orders']) }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <i class="fas fa-receipt"></i>
                    <span>Business orders</span>
                </div>
            </div>

            <!-- Business Customers -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Active Customers</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_business_customers']) }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="bg-orange-500 px-2 py-1 rounded-full text-xs font-bold">{{ $stats['pending_approvals'] }} Pending</span>
                </div>
            </div>

            <!-- Average Order Value -->
            <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Avg Order Value</p>
                        <p class="text-3xl font-bold mt-2">Rs {{ number_format($stats['avg_order_value'], 0) }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <i class="fas fa-calculator"></i>
                    <span>Per B2B order</span>
                </div>
            </div>
        </div>

        <!-- B2B vs B2C Sales Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-purple-600"></i>
                    B2B vs B2C Sales Comparison (Last 12 Months)
                </h2>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-purple-500 rounded"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">B2B Sales</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-pink-500 rounded"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">B2C Sales</span>
                    </div>
                </div>
            </div>
            <canvas id="salesComparisonChart" height="80"></canvas>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Top Business Customers -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                    <i class="fas fa-trophy text-yellow-500"></i>
                    Top 10 Business Customers
                </h2>
                <div class="space-y-3">
                    @forelse($topCustomers as $index => $customer)
                    <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $customer->name }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                @if($customer->businessProfile)
                                    {{ $customer->businessProfile->company_name }}
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-purple-600">Rs {{ number_format($customer->total_orders_value ?? 0, 0) }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $customer->total_orders_count ?? 0 }} orders</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No business customers found</p>
                    @endforelse
                </div>
            </div>

            <!-- Best Selling B2B Products -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                    <i class="fas fa-star text-yellow-500"></i>
                    Best Selling B2B Products
                </h2>
                <div class="space-y-3">
                    @forelse($bestSellingProducts as $index => $product)
                    <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-pink-50 dark:hover:bg-pink-900/20 transition-colors">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-pink-500 to-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">SKU: {{ $product->sku }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-pink-600">{{ number_format($product->total_quantity) }} units</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Rs {{ number_format($product->total_revenue, 0) }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No products sold</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Monthly Revenue Trend -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-area text-green-600"></i>
                Monthly B2B Revenue Trend
            </h2>
            <canvas id="monthlyRevenueChart" height="80"></canvas>
        </div>

        <!-- Export Button -->
        <div class="flex justify-end">
            <form method="POST" action="{{ route('admin.reports.b2b-export') }}">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-file-excel"></i>
                    Export to Excel
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Sales Comparison Chart
        const salesComparisonCtx = document.getElementById('salesComparisonChart').getContext('2d');
        new Chart(salesComparisonCtx, {
            type: 'bar',
            data: {
                labels: @json($salesComparison->pluck('month')),
                datasets: [
                    {
                        label: 'B2B Sales',
                        data: @json($salesComparison->pluck('b2b_sales')),
                        backgroundColor: 'rgba(168, 85, 247, 0.8)',
                        borderColor: 'rgba(168, 85, 247, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'B2C Sales',
                        data: @json($salesComparison->pluck('b2c_sales')),
                        backgroundColor: 'rgba(236, 72, 153, 0.8)',
                        borderColor: 'rgba(236, 72, 153, 1)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rs ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rs ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Monthly Revenue Chart
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        new Chart(monthlyRevenueCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyRevenue->pluck('month_label')),
                datasets: [{
                    label: 'B2B Revenue',
                    data: @json($monthlyRevenue->pluck('revenue')),
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: Rs ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rs ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>
