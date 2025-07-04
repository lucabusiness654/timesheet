<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="w-full md:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                    <h2 class="text-xl font-bold mb-6">Filters</h2>
                    
                    <!-- Search Box -->
                    <div class="mb-6">
                        <input type="text" id="searchQuery" placeholder="Search products..." 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <!-- Price Range -->
                    <div class="mb-6 filter-section">
                        <h3 class="font-semibold mb-3 flex justify-between items-center">
                            <span>Price Range</span>
                            <i class="fas fa-chevron-down"></i>
                        </h3>
                        <div class="filter-content">
                            <div class="flex items-center justify-between mb-2">
                                <span id="minPriceLabel">$0</span>
                                <span id="maxPriceLabel">$100+</span>
                            </div>
                            <div class="px-2">
                                <input type="range" id="priceRange" min="0" max="500" step="10" 
                                       class="w-full h-2 bg-blue-200 rounded-lg appearance-none cursor-pointer">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dynamic Filters -->
                    <div id="filtersContainer">
                        <!-- Filters will be loaded via JavaScript -->
                    </div>
                    
                    <button id="applyFilters" class="w-full bg-blue-600 text-white py-2 rounded-lg mt-4 hover:bg-blue-700">
                        Apply Filters
                    </button>
                </div>
            </div>
            
            <!-- Results Section -->
            <div class="w-full md:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold" id="resultsTitle">All Products</h1>
                    <div>
                        <select id="sortBy" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="relevance">Relevance</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="newest">Newest</option>
                            <option value="bestseller">Bestseller</option>
                        </select>
                    </div>
                </div>
                
                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="text-center py-12 hidden">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                    <p class="mt-2 text-gray-600">Loading products...</p>
                </div>
                
                <!-- Results Grid -->
                <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Products will be loaded here -->
                </div>
                
                <!-- Pagination -->
                <div id="pagination" class="mt-8 flex justify-center">
                    <!-- Pagination will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/product-search.js') }}"></script>
</body>
</html>