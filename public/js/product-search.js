class ProductSearch {
    constructor() {
        this.currentPage = 1;
        this.searchQuery = '';
        this.filters = {};
        this.priceRange = [0, 500];
        this.sortBy = 'relevance';
        
        this.initElements();
        this.initEvents();
        this.loadProducts();
    }
    
    initElements() {
        this.elements = {
            searchInput: document.getElementById('searchQuery'),
            filtersContainer: document.getElementById('filtersContainer'),
            productsGrid: document.getElementById('productsGrid'),
            pagination: document.getElementById('pagination'),
            loadingIndicator: document.getElementById('loadingIndicator'),
            sortSelect: document.getElementById('sortBy'),
            priceRangeSlider: document.getElementById('priceRange'),
            minPriceLabel: document.getElementById('minPriceLabel'),
            maxPriceLabel: document.getElementById('maxPriceLabel'),
            applyFiltersBtn: document.getElementById('applyFilters')
        };
    }
    
    initEvents() {
        // Search input debounce
        this.elements.searchInput.addEventListener('input', this.debounce(() => {
            this.searchQuery = this.elements.searchInput.value.trim();
            this.currentPage = 1;
            this.loadProducts();
        }, 500));
        
        // Sort change
        this.elements.sortSelect.addEventListener('change', () => {
            this.sortBy = this.elements.sortSelect.value;
            this.loadProducts();
        });
        
        // Price range
        this.elements.priceRangeSlider.addEventListener('input', () => {
            this.priceRange[1] = parseInt(this.elements.priceRangeSlider.value);
            this.elements.maxPriceLabel.textContent = `$${this.priceRange[1]}+`;
        });
        
        // Apply filters button
        this.elements.applyFiltersBtn.addEventListener('click', () => {
            this.filters.price = [`${this.priceRange[0]}-${this.priceRange[1]}`];
            this.currentPage = 1;
            this.loadProducts();
        });
    }
    
    async loadProducts() {
        this.showLoading();
        
        try {
            const params = new URLSearchParams({
                q: this.searchQuery,
                page: this.currentPage,
                sort: this.sortBy,
                price_min: this.priceRange[0],
                price_max: this.priceRange[1],
                ...Object.fromEntries(
                    Object.entries(this.filters).map(([key, values]) => 
                        [`filters[${key}]`, values.join(',')])
                )
            });
            
            const response = await fetch(`/api/products/search?${params.toString()}`);
            const data = await response.json();


            console.log(data.products,'PDS');
            
            
            this.renderProducts(data.products);
            this.renderFacets(data.facets);
            this.renderPagination(data.products);
        } catch (error) {
            console.error('Error loading products:', error);
        } finally {
            this.hideLoading();
        }
    }
    
    renderProducts(products) {
        this.elements.productsGrid.innerHTML = '';
        
        if (products.data.length === 0) {
            this.elements.productsGrid.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-search fa-3x text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-700">No products found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your search or filters</p>
                </div>
            `;
            return;
        }
        
        products.data.forEach(product => {
            const productCard = this.createProductCard(product);
            this.elements.productsGrid.appendChild(productCard);
        });
    }
    
    createProductCard(product) {
        const card = document.createElement('div');
        card.className = 'product-card bg-white rounded-lg overflow-hidden shadow-md';
        
        // Calculate discount badge if applicable
        let discountBadge = '';
        if (product.effective_discount_percent > 0) {
            discountBadge = `
                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                    ${Math.round(product.effective_discount_percent)}% OFF
                </div>
            `;
        }


        console.log(product,'product');
        
        
        card.innerHTML = `
            <div class="relative">
                <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover">
                ${discountBadge}
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg mb-1 truncate">${product.name}</h3>
                <div class="flex items-center mb-2">
                    ${this.renderRating(product)}
                </div>
               <div class="flex items-center">
                    <span class="text-lg font-bold text-gray-900">
                        $${Number(product.effective_price).toFixed(2)}
                    </span>
                    ${product.price > product.effective_price ? `
                        <span class="ml-2 text-sm text-gray-500 line-through">
                            $${Number(product.price).toFixed(2)}
                        </span>
                    ` : ''}
                </div>
                <div class="mt-3 flex justify-between">
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        <i class="far fa-heart mr-1"></i> Wishlist
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-medium">
                        <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                    </button>
                </div>
            </div>
        `;
        
        return card;
    }
    
    renderRating(product) {
        // Implement your rating logic here
        return `
            <div class="flex text-yellow-400">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <span class="text-gray-600 text-sm ml-1">(24)</span>
        `;
    }
    
    renderFacets(facets) {
        if (!facets || !facets.filters) return;
        
        let filtersHTML = '';
        
        // Render each filter type
        for (const [filterType, options] of Object.entries(facets.filters)) {
            const title = this.formatFilterTitle(filterType);
            const isActive = this.filters[filterType] && this.filters[filterType].length > 0;
            
            filtersHTML += `
                <div class="mb-6 filter-section">
                    <h3 class="font-semibold mb-3 flex justify-between items-center cursor-pointer">
                        <span>${title}</span>
                        <i class="fas fa-chevron-${isActive ? 'up' : 'down'}"></i>
                    </h3>
                    <div class="filter-content" style="${isActive ? '' : 'display: none;'}">
                        ${options.map(option => this.renderFilterOption(filterType, option)).join('')}
                    </div>
                </div>
            `;
        }
        
        this.elements.filtersContainer.innerHTML = filtersHTML;
        
        // Add event listeners to filter sections
        document.querySelectorAll('.filter-section h3').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                const icon = header.querySelector('i');
                
                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                } else {
                    content.style.display = 'none';
                    icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                }
            });
        });
        
        // Add event listeners to filter options
        document.querySelectorAll('.filter-option input').forEach(input => {
            input.addEventListener('change', (e) => {
                const filterType = e.target.dataset.filterType;
                const filterValue = e.target.value;
                
                if (e.target.checked) {
                    if (!this.filters[filterType]) {
                        this.filters[filterType] = [];
                    }
                    this.filters[filterType].push(filterValue);
                } else {
                    this.filters[filterType] = this.filters[filterType].filter(v => v !== filterValue);
                    if (this.filters[filterType].length === 0) {
                        delete this.filters[filterType];
                    }
                }
            });
        });
    }
    
    renderFilterOption(filterType, option) {
        const isChecked = this.filters[filterType] && 
                         this.filters[filterType].includes(option.filter_value);
        
        return `
            <div class="filter-option">
                <input type="checkbox" id="filter_${filterType}_${option.filter_value}" 
                       value="${option.filter_value}" 
                       data-filter-type="${filterType}"
                       ${isChecked ? 'checked' : ''}
                       class="mr-2">
                <label for="filter_${filterType}_${option.filter_value}" class="flex-1 cursor-pointer">
                    ${this.formatFilterValue(filterType, option.filter_value)}
                    <span class="text-gray-500 text-sm ml-1">(${option.count})</span>
                </label>
            </div>
        `;
    }
    
    renderPagination(pagination) {
        if (!pagination || !pagination.links) return;
        
        let paginationHTML = '';
        
        // Previous button
        if (pagination.current_page > 1) {
            paginationHTML += `
                <button onclick="productSearch.goToPage(${pagination.current_page - 1})" 
                        class="px-3 py-1 border rounded-l-lg hover:bg-gray-100">
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;
        }
        
        // Page numbers
        for (let i = 1; i <= pagination.last_page; i++) {
            if (i === pagination.current_page) {
                paginationHTML += `
                    <button class="px-3 py-1 border-t border-b border-blue-500 bg-blue-500 text-white">
                        ${i}
                    </button>
                `;
            } else {
                paginationHTML += `
                    <button onclick="productSearch.goToPage(${i})" 
                            class="px-3 py-1 border-t border-b border-gray-300 hover:bg-gray-100">
                        ${i}
                    </button>
                `;
            }
        }
        
        // Next button
        if (pagination.current_page < pagination.last_page) {
            paginationHTML += `
                <button onclick="productSearch.goToPage(${pagination.current_page + 1})" 
                        class="px-3 py-1 border rounded-r-lg hover:bg-gray-100">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;
        }
        
        this.elements.pagination.innerHTML = paginationHTML;
    }
    
    goToPage(page) {
        this.currentPage = page;
        this.loadProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    formatFilterTitle(filterType) {
        return filterType
            .replace(/_/g, ' ')
            .replace(/\b\w/g, l => l.toUpperCase());
    }
    
    formatFilterValue(filterType, value) {
        // Custom formatting for specific filter types
        if (filterType.startsWith('size_')) {
            return value.toUpperCase();
        }
        return value
            .replace(/-/g, ' ')
            .replace(/\b\w/g, l => l.toUpperCase());
    }
    
    showLoading() {
        this.elements.loadingIndicator.classList.remove('hidden');
        this.elements.productsGrid.classList.add('opacity-50');
    }
    
    hideLoading() {
        this.elements.loadingIndicator.classList.add('hidden');
        this.elements.productsGrid.classList.remove('opacity-50');
    }
    
    debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    }
}

// Initialize the product search
const productSearch = new ProductSearch();