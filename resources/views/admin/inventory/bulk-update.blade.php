<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                        <i class="fas fa-file-upload mr-3 text-pink-600"></i>Bulk Inventory Update
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Upload CSV/Excel file to update multiple products at once</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Products
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-3"></i>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                    <p class="font-bold">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if(session('bulk_errors'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-lg" role="alert">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                    <p class="font-bold">Errors during bulk update:</p>
                </div>
                <ul class="list-disc list-inside ml-8 mt-2 space-y-1">
                    @foreach(session('bulk_errors') as $error)
                    <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Upload Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-upload mr-3 text-pink-600"></i>Upload File
                        </h3>

                        <form action="{{ route('admin.inventory.bulk-upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Update Type Selection -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                                    <i class="fas fa-sliders-h mr-2 text-pink-600"></i>What do you want to update?
                                </label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-pink-500 transition-colors">
                                        <input type="radio" name="update_type" value="stock" class="w-5 h-5 text-pink-600" checked>
                                        <span class="ml-3">
                                            <span class="block font-semibold text-gray-900 dark:text-white">Stock Quantity Only</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Update only stock quantities</span>
                                        </span>
                                    </label>

                                    <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-pink-500 transition-colors">
                                        <input type="radio" name="update_type" value="price" class="w-5 h-5 text-pink-600">
                                        <span class="ml-3">
                                            <span class="block font-semibold text-gray-900 dark:text-white">Base Price Only</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Update only base prices</span>
                                        </span>
                                    </label>

                                    <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-pink-500 transition-colors">
                                        <input type="radio" name="update_type" value="both" class="w-5 h-5 text-pink-600">
                                        <span class="ml-3">
                                            <span class="block font-semibold text-gray-900 dark:text-white">Stock & Price</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Update both stock quantities and prices</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                                    <i class="fas fa-file-csv mr-2 text-pink-600"></i>Upload CSV File
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-8 text-center hover:border-pink-500 transition-colors">
                                    <i class="fas fa-cloud-upload-alt text-6xl text-gray-400 mb-4"></i>
                                    <input type="file" name="file" accept=".csv,.txt,.xlsx" required
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 cursor-pointer">
                                    <p class="text-sm text-gray-500 mt-2">CSV, TXT or XLSX (Max 2MB)</p>
                                </div>
                                @error('file')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4">
                                <button type="submit" class="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-xl transition-all transform hover:scale-105">
                                    <i class="fas fa-check mr-2"></i>Upload & Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="space-y-6">
                    <!-- Download Template -->
                    <div class="bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
                        <h3 class="text-xl font-bold mb-4 flex items-center">
                            <i class="fas fa-download mr-3"></i>Download Template
                        </h3>
                        <p class="text-pink-100 mb-4">Download our CSV template to get started quickly</p>
                        <a href="{{ route('admin.inventory.download-template') }}" class="block bg-white text-pink-600 px-6 py-3 rounded-xl font-bold text-center hover:bg-pink-50 transition-colors">
                            <i class="fas fa-file-download mr-2"></i>Download Template
                        </a>
                    </div>

                    <!-- Instructions Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-info-circle mr-3 text-blue-600"></i>Instructions
                        </h3>
                        <ol class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-start">
                                <span class="bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 w-6 h-6 rounded-full flex items-center justify-center font-bold mr-3 flex-shrink-0 mt-0.5">1</span>
                                <span>Download the CSV template file</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 w-6 h-6 rounded-full flex items-center justify-center font-bold mr-3 flex-shrink-0 mt-0.5">2</span>
                                <span>Fill in product SKU and values (Stock/Price)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 w-6 h-6 rounded-full flex items-center justify-center font-bold mr-3 flex-shrink-0 mt-0.5">3</span>
                                <span>Delete example rows and instruction lines</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 w-6 h-6 rounded-full flex items-center justify-center font-bold mr-3 flex-shrink-0 mt-0.5">4</span>
                                <span>Save the file as CSV format</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 w-6 h-6 rounded-full flex items-center justify-center font-bold mr-3 flex-shrink-0 mt-0.5">5</span>
                                <span>Upload the file using the form</span>
                            </li>
                        </ol>
                    </div>

                    <!-- Format Info -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-6 border-2 border-blue-200 dark:border-blue-800">
                        <h4 class="font-bold mb-3 text-blue-900 dark:text-blue-300 flex items-center">
                            <i class="fas fa-table mr-2"></i>CSV Format
                        </h4>
                        <pre class="text-xs bg-white dark:bg-gray-800 p-3 rounded-lg overflow-x-auto text-gray-700 dark:text-gray-300">SKU,Stock,Price
PROD001,100,1500
PROD002,50,2500</pre>
                    </div>

                    <!-- Important Notes -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-2xl p-6 border-2 border-yellow-200 dark:border-yellow-800">
                        <h4 class="font-bold mb-3 text-yellow-900 dark:text-yellow-300 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Important
                        </h4>
                        <ul class="text-xs space-y-2 text-yellow-800 dark:text-yellow-300">
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1"></i>
                                <span>SKU must match exactly with existing products</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1"></i>
                                <span>Stock must be a positive integer</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1"></i>
                                <span>Price must be a valid number</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check mr-2 mt-1"></i>
                                <span>All changes are logged in Activity Log</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
