<x-admin-layout>
    <x-slot name="header">
        Super Admin Dashboard
    </x-slot>

    <!-- Welcome Card - Super Admin Exclusive -->
    <div class="bg-gradient-to-r from-gray-900 via-purple-900 to-pink-900 text-white rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden" data-aos="fade-down">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full -ml-10 -mb-10"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="bg-yellow-500 text-gray-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        <i class="fas fa-crown mr-1"></i> Super Admin
                    </span>
                </div>
                <h3 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
                <p class="text-purple-200">Full system control & monitoring dashboard</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-shield-alt text-7xl opacity-10"></i>
            </div>
        </div>
    </div>

    <!-- System Overview Cards - Super Admin Only -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift border-l-4 border-purple-500" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Users</p>
                    <p class="text-4xl font-bold text-purple-600">{{ $system_stats['total_users'] }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full">{{ $system_stats['total_super_admins'] }} SA</span>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">{{ $system_stats['total_admins'] }} Admin</span>
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">{{ $system_stats['total_staff'] }} Staff</span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-users-cog text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Roles & Permissions -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift border-l-4 border-indigo-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Roles & Permissions</p>
                    <p class="text-4xl font-bold text-indigo-600">{{ $system_stats['total_roles'] }}</p>
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-key mr-1"></i>{{ $system_stats['total_permissions'] }} Permissions</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-shield-alt text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift border-l-4 border-green-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
                    <p class="text-4xl font-bold text-green-600">Rs {{ number_format($stats['total_revenue'], 0) }}</p>
                    <p class="text-xs text-green-600 mt-2"><i class="fas fa-calendar mr-1"></i>This Month: Rs {{ number_format($stats['this_month_revenue'], 0) }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-coins text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Active Coupons -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift border-l-4 border-orange-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Coupons</p>
                    <p class="text-4xl font-bold text-orange-600">{{ $system_stats['total_coupons'] }}</p>
                    <p class="text-xs text-orange-600 mt-2"><i class="fas fa-check-circle mr-1"></i>{{ $system_stats['active_coupons'] }} Active</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-ticket-alt text-3xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Products -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Products</p>
                    <p class="text-4xl font-bold gradient-pink bg-clip-text text-transparent">{{ $stats['total_products'] }}</p>
                    <p class="text-xs text-green-600 mt-2"><i class="fas fa-check-circle mr-1"></i>{{ $stats['active_products'] }} Active</p>
                </div>
                <div class="w-16 h-16 gradient-purple rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-box-open text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                    <p class="text-4xl font-bold gradient-blue bg-clip-text text-transparent">{{ $stats['total_orders'] }}</p>
                    <p class="text-xs text-yellow-600 mt-2"><i class="fas fa-clock mr-1"></i>{{ $stats['pending_orders'] }} Pending</p>
                </div>
                <div class="w-16 h-16 gradient-blue rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-shopping-bag text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Today Revenue -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Today's Revenue</p>
                    <p class="text-4xl font-bold gradient-pink bg-clip-text text-transparent">Rs {{ number_format($stats['todays_revenue'], 0) }}</p>
                    <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up mr-1"></i>Today's earning</p>
                </div>
                <div class="w-16 h-16 gradient-orange rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-cash-register text-3xl text-white"></i>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Customers</p>
                    <p class="text-4xl font-bold gradient-purple bg-clip-text text-transparent">{{ $stats['total_customers'] }}</p>
                    <p class="text-xs text-blue-600 mt-2"><i class="fas fa-tags mr-1"></i>{{ $stats['total_categories'] }} Categories</p>
                </div>
                <div class="w-16 h-16 gradient-pink rounded-xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-users text-3xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Distribution + Monthly Revenue -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Order Status Distribution -->
        <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right">
            <h3 class="text-xl font-bold mb-6 flex items-center">
                <i class="fas fa-chart-pie text-purple-600 mr-3"></i>Order Status Distribution
            </h3>
            <div class="space-y-4">
                @php
                    $statusColors = [
                        'pending' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-700', 'light' => 'bg-yellow-100'],
                        'confirmed' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-700', 'light' => 'bg-blue-100'],
                        'processing' => ['bg' => 'bg-indigo-500', 'text' => 'text-indigo-700', 'light' => 'bg-indigo-100'],
                        'shipped' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-700', 'light' => 'bg-purple-100'],
                        'delivered' => ['bg' => 'bg-green-500', 'text' => 'text-green-700', 'light' => 'bg-green-100'],
                        'cancelled' => ['bg' => 'bg-red-500', 'text' => 'text-red-700', 'light' => 'bg-red-100'],
                    ];
                    $totalOrders = $order_status_distribution->sum();
                @endphp
                @foreach($order_status_distribution as $status => $count)
                @php
                    $colors = $statusColors[$status] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-700', 'light' => 'bg-gray-100'];
                    $percentage = $totalOrders > 0 ? round(($count / $totalOrders) * 100, 1) : 0;
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-semibold {{ $colors['text'] }}">{{ ucfirst($status) }}</span>
                        <span class="text-sm text-gray-600">{{ $count }} ({{ $percentage }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="{{ $colors['bg'] }} h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach

                @if($totalOrders == 0)
                <p class="text-center text-gray-500 py-8"><i class="fas fa-inbox text-4xl mb-2"></i><br>No orders yet</p>
                @endif
            </div>
        </div>

        <!-- Monthly Revenue Chart -->
        <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left">
            <h3 class="text-xl font-bold mb-6 flex items-center">
                <i class="fas fa-chart-bar text-green-600 mr-3"></i>Monthly Revenue (Last 6 Months)
            </h3>
            @if($monthly_revenue->count() > 0)
            <div class="space-y-4">
                @php
                    $maxRevenue = $monthly_revenue->max('revenue') ?: 1;
                    $months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                @endphp
                @foreach($monthly_revenue as $month)
                @php
                    $barWidth = ($month->revenue / $maxRevenue) * 100;
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-700">{{ $months[$month->month] }} {{ $month->year }}</span>
                        <span class="text-sm text-gray-600">Rs {{ number_format($month->revenue, 0) }} ({{ $month->order_count }} orders)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ $barWidth }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8"><i class="fas fa-chart-bar text-4xl mb-2"></i><br>No revenue data yet</p>
            @endif
        </div>
    </div>

    <!-- Admin Users + Activity Logs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Admin Users Panel - Super Admin Exclusive -->
        <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right">
            <h3 class="text-xl font-bold mb-6 flex items-center">
                <i class="fas fa-user-shield text-purple-600 mr-3"></i>Admin Team
                <a href="{{ route('admin.users.index') }}" class="ml-auto text-sm text-pink-600 hover:text-pink-700 font-medium">
                    Manage <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </h3>

            <div class="space-y-3">
                @foreach($admin_users as $admin)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 {{ $admin->hasRole('super_admin') ? 'bg-gradient-to-br from-yellow-500 to-orange-500' : ($admin->hasRole('admin') ? 'bg-gradient-to-br from-purple-500 to-pink-500' : 'bg-gradient-to-br from-blue-500 to-cyan-500') }} rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $admin->name }}</p>
                            <p class="text-xs text-gray-500">{{ $admin->email }}</p>
                        </div>
                    </div>
                    <div>
                        @foreach($admin->roles as $role)
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $role->name === 'super_admin' ? 'bg-yellow-100 text-yellow-800' : ($role->name === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Activity Logs - Super Admin Exclusive -->
        <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left">
            <h3 class="text-xl font-bold mb-6 flex items-center">
                <i class="fas fa-history text-blue-600 mr-3"></i>Recent Activity
                <a href="{{ route('admin.activity-logs.index') }}" class="ml-auto text-sm text-pink-600 hover:text-pink-700 font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </h3>

            <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
                @forelse($recent_activities as $activity)
                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                        {{ $activity->action === 'created' ? 'bg-green-100 text-green-600' : '' }}
                        {{ $activity->action === 'updated' ? 'bg-blue-100 text-blue-600' : '' }}
                        {{ $activity->action === 'deleted' ? 'bg-red-100 text-red-600' : '' }}
                        {{ $activity->action === 'login' ? 'bg-yellow-100 text-yellow-600' : '' }}
                        {{ $activity->action === 'logout' ? 'bg-gray-100 text-gray-600' : '' }}
                        {{ !in_array($activity->action, ['created', 'updated', 'deleted', 'login', 'logout']) ? 'bg-gray-100 text-gray-600' : '' }}">
                        <i class="fas {{ $activity->action === 'created' ? 'fa-plus' : '' }}{{ $activity->action === 'updated' ? 'fa-edit' : '' }}{{ $activity->action === 'deleted' ? 'fa-trash' : '' }}{{ $activity->action === 'login' ? 'fa-sign-in-alt' : '' }}{{ $activity->action === 'logout' ? 'fa-sign-out-alt' : '' }} text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900">
                            <span class="font-semibold">{{ $activity->user?->name ?? 'System' }}</span>
                            <span class="text-gray-600">{{ $activity->action_name }}</span>
                            <span class="font-medium text-purple-600">{{ $activity->model_name }}</span>
                        </p>
                        @if($activity->description)
                        <p class="text-xs text-gray-500 truncate">{{ $activity->description }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-8"><i class="fas fa-history text-4xl mb-2"></i><br>No activity yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Orders + Low Stock -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-right">
            <h3 class="text-xl font-bold mb-6 flex items-center">
                <i class="fas fa-shopping-cart text-pink-600 mr-3"></i>Recent Orders
            </h3>

            <div class="space-y-4">
                @forelse($recent_orders as $order)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 gradient-blue rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-receipt text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-600">{{ $order->customer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-pink-600">Rs {{ number_format($order->total_amount, 0) }}</p>
                        <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">{{ ucfirst($order->order_status) }}</span>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-8"><i class="fas fa-inbox text-4xl mb-2"></i><br>No orders yet</p>
                @endforelse
            </div>

            @if($recent_orders->count() > 0)
            <a href="{{ route('admin.orders.index') }}" class="block text-center mt-6 text-pink-600 font-semibold hover:text-pink-700">
                View All Orders <i class="fas fa-arrow-right ml-1"></i>
            </a>
            @endif
        </div>

        <!-- Low Stock & Bestsellers -->
        <div class="space-y-6">
            <!-- Low Stock Alert -->
            @if($low_stock_products->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-exclamation-triangle text-orange-500 mr-3"></i>Low Stock Alert
                </h3>

                <div class="space-y-3">
                    @foreach($low_stock_products as $product)
                    <div class="flex items-center justify-between p-3 {{ $product->stock_quantity <= 5 ? 'bg-red-50 border-l-4 border-red-500' : 'bg-orange-50 border-l-4 border-orange-500' }} rounded-xl">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                            <p class="text-xs text-gray-600">{{ $product->category->name }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-full {{ $product->stock_quantity <= 5 ? 'bg-red-500' : 'bg-orange-500' }} text-white text-sm font-bold">
                                {{ $product->stock_quantity }} left
                            </span>
                            @if($product->stock_quantity <= 5)
                            <p class="text-xs text-red-600 font-semibold mt-1">Critical!</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Bestsellers -->
            <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="100">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-fire text-pink-600 mr-3"></i>Bestsellers
                </h3>

                <div class="space-y-3">
                    @forelse($bestsellers as $product)
                    <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl hover:shadow-md transition-shadow">
                        @if($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-12 h-12 rounded-lg object-cover shadow-md">
                        @endif
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 text-sm">{{ $product->name }}</p>
                            <p class="text-xs text-pink-600">Rs {{ number_format($product->final_price, 0) }}</p>
                        </div>
                        <i class="fas fa-star text-yellow-500"></i>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-4">No bestsellers yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - Super Admin Gets More Options -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4" data-aos="fade-up">
        <a href="{{ route('admin.products.create') }}" class="gradient-pink text-white p-5 rounded-2xl hover-lift text-center">
            <i class="fas fa-plus-circle text-3xl mb-2"></i>
            <p class="font-bold text-sm">Add Product</p>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="gradient-blue text-white p-5 rounded-2xl hover-lift text-center">
            <i class="fas fa-shopping-bag text-3xl mb-2"></i>
            <p class="font-bold text-sm">Orders</p>
        </a>
        <a href="{{ route('admin.users.index') }}" class="bg-gradient-to-br from-purple-600 to-purple-800 text-white p-5 rounded-2xl hover-lift text-center">
            <i class="fas fa-users-cog text-3xl mb-2"></i>
            <p class="font-bold text-sm">Users</p>
        </a>
        <a href="{{ route('admin.roles.index') }}" class="bg-gradient-to-br from-indigo-600 to-indigo-800 text-white p-5 rounded-2xl hover-lift text-center">
            <i class="fas fa-shield-alt text-3xl mb-2"></i>
            <p class="font-bold text-sm">Roles</p>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="bg-gradient-to-br from-gray-700 to-gray-900 text-white p-5 rounded-2xl hover-lift text-center">
            <i class="fas fa-cog text-3xl mb-2"></i>
            <p class="font-bold text-sm">Settings</p>
        </a>
        <a href="{{ route('admin.activity-logs.index') }}" class="gradient-orange text-white p-5 rounded-2xl hover-lift text-center">
            <i class="fas fa-history text-3xl mb-2"></i>
            <p class="font-bold text-sm">Activity</p>
        </a>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 10px; }
    </style>
</x-admin-layout>
