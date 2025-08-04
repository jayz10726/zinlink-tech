import { useState, useMemo, useEffect } from 'react';
import { apiService, ApiProduct } from '../services/api';
import ApiProductCard from '../components/products/ApiProductCard';
import ProductSidebar from '../components/products/ProductSidebar';
import { Search, Filter, Grid, List, Menu, SlidersHorizontal, RefreshCw, ShoppingCart } from 'lucide-react';
import { Link } from 'react-router-dom';

const Products = () => {
  const [products, setProducts] = useState<ApiProduct[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [searchTerm, setSearchTerm] = useState('');
  const [viewMode, setViewMode] = useState<'grid' | 'list'>('grid');
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [filters, setFilters] = useState({
    category: '',
    brand: '',
    condition: '',
    minPrice: '',
    maxPrice: '',
    inStock: false,
    sortBy: 'name'
  });

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        setLoading(true);
        const response = await apiService.getProducts();
        setProducts(response.data);
        setError(null);
      } catch (err) {
        setError('Failed to fetch products');
        console.error(err);
      } finally {
        setLoading(false);
      }
    };

    fetchProducts();
  }, []);

  const predefinedCategories = [
    'laptop',
    'gaming-laptop',
    'desktop',
    'cctv', 
    'laptop chargers',
    'harddisk/ssd',
    'wifi',
    'other accessories'
  ];

  // Only use predefined categories to avoid duplicates
  const categories = predefinedCategories;
  const brands = [...new Set(products.map(p => p.brand?.toLowerCase() || '').filter(Boolean))];

  const filteredAndSortedProducts = useMemo(() => {
    let filtered = products.filter(product => {
      // Search filter
      const matchesSearch = product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                           product.brand.toLowerCase().includes(searchTerm.toLowerCase());
      
      // Category filter
      const matchesCategory = !filters.category || 
                             product.category?.toLowerCase() === filters.category.toLowerCase();
      
      // Brand filter
      const matchesBrand = !filters.brand || 
                          product.brand.toLowerCase() === filters.brand.toLowerCase();
      
      // Condition filter
      const matchesCondition = !filters.condition || 
                              product.condition?.toLowerCase() === filters.condition.toLowerCase();
      
      // Price filter
      const price = parseFloat(product.price);
      const matchesMinPrice = !filters.minPrice || price >= parseFloat(filters.minPrice);
      const matchesMaxPrice = !filters.maxPrice || price <= parseFloat(filters.maxPrice);
      
      // Stock filter
      const matchesStock = !filters.inStock || product.stock_quantity > 0;
      
      return matchesSearch && matchesCategory && matchesBrand && 
             matchesCondition && matchesMinPrice && matchesMaxPrice && matchesStock;
    });

    return filtered.sort((a, b) => {
      switch (filters.sortBy) {
        case 'price-low':
          return parseFloat(a.price) - parseFloat(b.price);
        case 'price-high':
          return parseFloat(b.price) - parseFloat(a.price);
        case 'newest':
          return new Date(b.created_at).getTime() - new Date(a.created_at).getTime();
        case 'oldest':
          return new Date(a.created_at).getTime() - new Date(b.created_at).getTime();
        case 'name':
        default:
          return a.name.localeCompare(b.name);
      }
    });
  }, [products, searchTerm, filters]);

  const handleRefresh = () => {
    window.location.reload();
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
      <div className="flex">
        {/* Sidebar */}
        <ProductSidebar
          filters={filters}
          onFilterChange={setFilters}
          categories={categories}
          brands={brands}
          isOpen={sidebarOpen}
          onToggle={() => setSidebarOpen(!sidebarOpen)}
        />
        
        {/* Main Content */}
        <div className="flex-1 lg:ml-8">
          {/* Header */}
          <div className="mb-8">
            <h1 className="text-4xl font-bold text-primary-900 mb-2">Our Products</h1>
            <p className="text-gray-600 text-lg">Discover our complete collection of computers, accessories, and tech solutions</p>
          </div>

          {/* Quick Actions */}
          <div className="mb-6 flex flex-wrap gap-3">
            <Link 
              to="/cart" 
              className="btn-secondary inline-flex items-center px-4 py-2 text-sm"
            >
              <ShoppingCart className="w-4 h-4 mr-2" />
              View Cart
            </Link>
            <button
              onClick={handleRefresh}
              className="btn-ghost inline-flex items-center px-4 py-2 text-sm"
            >
              <RefreshCw className="w-4 h-4 mr-2" />
              Refresh
            </button>
          </div>

          {/* Header with Search and Controls */}
          <div className="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg p-6 mb-8 border border-white/20">
            <div className="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
              {/* Search */}
              <div className="relative flex-grow max-w-md">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                <input
                  type="text"
                  placeholder="Search products..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500 transition-all duration-300"
                />
              </div>

              <div className="flex flex-wrap gap-4 items-center">
                {/* Mobile Filter Button */}
                <button
                  onClick={() => setSidebarOpen(true)}
                  className="lg:hidden btn-outline inline-flex items-center gap-2 px-4 py-2 text-sm"
                >
                  <SlidersHorizontal className="w-4 h-4" />
                  Filters
                </button>

                {/* View Mode */}
                <div className="flex border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                  <button
                    onClick={() => setViewMode('grid')}
                    className={`p-3 transition-all duration-300 ${
                      viewMode === 'grid' 
                        ? 'bg-secondary-600 text-white shadow-md' 
                        : 'bg-white text-gray-600 hover:bg-gray-50 hover:text-secondary-600'
                    }`}
                  >
                    <Grid className="w-5 h-5" />
                  </button>
                  <button
                    onClick={() => setViewMode('list')}
                    className={`p-3 transition-all duration-300 ${
                      viewMode === 'list' 
                        ? 'bg-secondary-600 text-white shadow-md' 
                        : 'bg-white text-gray-600 hover:bg-gray-50 hover:text-secondary-600'
                    }`}
                  >
                    <List className="w-5 h-5" />
                  </button>
                </div>
              </div>
            </div>
          </div>

          {/* Loading State */}
          {loading && (
            <div className="text-center py-12">
              <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-secondary-600 mx-auto mb-4"></div>
              <p className="text-gray-500 text-lg">Loading products...</p>
            </div>
          )}

          {/* Error State */}
          {error && (
            <div className="text-center py-12">
              <div className="bg-red-50 border border-red-200 rounded-lg p-6 max-w-md mx-auto">
                <p className="text-red-600 text-lg mb-4">{error}</p>
                <button
                  onClick={handleRefresh}
                  className="btn-secondary"
                >
                  <RefreshCw className="w-4 h-4 mr-2" />
                  Try Again
                </button>
              </div>
            </div>
          )}

          {/* Results Count */}
          {!loading && !error && (
            <div className="mb-6 bg-white/80 backdrop-blur-sm rounded-lg p-4 border border-white/20">
              <p className="text-gray-600 font-medium">
                Showing <span className="text-secondary-600 font-bold">{filteredAndSortedProducts.length}</span> of{' '}
                <span className="text-secondary-600 font-bold">{products.length}</span> products
              </p>
            </div>
          )}

          {/* Products Grid */}
          {!loading && !error && (
            <div className={`grid gap-6 ${
              viewMode === 'grid' 
                ? 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4' 
                : 'grid-cols-1'
            }`}>
              {filteredAndSortedProducts.map((product) => (
                <ApiProductCard 
                  key={product.id} 
                  product={product} 
                  viewMode={viewMode}
                />
              ))}
            </div>
          )}

          {/* No Results */}
          {!loading && !error && filteredAndSortedProducts.length === 0 && (
            <div className="text-center py-12">
              <div className="bg-white/80 backdrop-blur-sm rounded-lg p-8 max-w-md mx-auto border border-white/20">
                <Search className="w-12 h-12 text-gray-400 mx-auto mb-4" />
                <h3 className="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
                <p className="text-gray-600 mb-4">Try adjusting your search criteria or filters</p>
                <button
                  onClick={() => {
                    setSearchTerm('');
                    setFilters({
                      category: '',
                      brand: '',
                      condition: '',
                      minPrice: '',
                      maxPrice: '',
                      inStock: false,
                      sortBy: 'name'
                    });
                  }}
                  className="btn-secondary"
                >
                  Clear Filters
                </button>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default Products;