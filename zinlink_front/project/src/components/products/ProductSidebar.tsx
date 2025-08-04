import React from 'react';
import { Filter, X, SlidersHorizontal } from 'lucide-react';

interface FilterState {
  category: string;
  brand: string;
  condition: string;
  minPrice: string;
  maxPrice: string;
  inStock: boolean;
  sortBy: string;
}

interface ProductSidebarProps {
  filters: FilterState;
  onFilterChange: (filters: FilterState) => void;
  categories: string[];
  brands: string[];
  isOpen: boolean;
  onToggle: () => void;
}

const ProductSidebar: React.FC<ProductSidebarProps> = ({
  filters,
  onFilterChange,
  categories,
  brands,
  isOpen,
  onToggle
}) => {
  const handleFilterChange = (key: keyof FilterState, value: string | boolean) => {
    onFilterChange({
      ...filters,
      [key]: value
    });
  };

  const clearFilters = () => {
    onFilterChange({
      category: '',
      brand: '',
      condition: '',
      minPrice: '',
      maxPrice: '',
      inStock: false,
      sortBy: 'name'
    });
  };

  const hasActiveFilters = () => {
    return filters.category || filters.brand || filters.condition || 
           filters.minPrice || filters.maxPrice || filters.inStock;
  };

  return (
    <>
      {/* Mobile Overlay */}
      {isOpen && (
        <div 
          className="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
          onClick={onToggle}
        />
      )}

      {/* Sidebar */}
      <div className={`
        fixed lg:static inset-y-0 left-0 z-50 w-80 bg-blue-100 shadow-lg transform transition-transform duration-300 ease-in-out
        ${isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'}
      `}>
        <div className="flex flex-col h-full">
          {/* Header */}
          <div className="flex items-center justify-between p-4 border-b border-blue-200 bg-blue-50">
            <div className="flex items-center space-x-2">
              <Filter className="w-5 h-5 text-gray-600" />
              <h2 className="text-lg font-semibold text-gray-900">Filters</h2>
            </div>
            <button
              onClick={onToggle}
              className="lg:hidden p-2 text-gray-500 hover:text-gray-700"
            >
              <X className="w-5 h-5" />
            </button>
          </div>

          {/* Filter Content */}
          <div className="flex-1 overflow-y-auto p-4 space-y-6">
            
            {/* Sort By */}
            <div>
              <h3 className="text-sm font-medium text-gray-900 mb-3">Sort By</h3>
              <select
                value={filters.sortBy}
                onChange={(e) => handleFilterChange('sortBy', e.target.value)}
                className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
              >
                <option value="name">Name (A-Z)</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
              </select>
            </div>

            {/* Category Filter */}
            <div>
              <h3 className="text-sm font-medium text-gray-900 mb-3">Category</h3>
              <div className="space-y-2">
                <label className="flex items-center">
                  <input
                    type="radio"
                    name="category"
                    value=""
                    checked={filters.category === ''}
                    onChange={(e) => handleFilterChange('category', e.target.value)}
                    className="mr-2 text-primary-600 focus:ring-primary-500"
                  />
                  <span className="text-sm text-gray-700">All Categories</span>
                </label>
                {categories.map((category) => (
                  <label key={category} className="flex items-center">
                    <input
                      type="radio"
                      name="category"
                      value={category}
                      checked={filters.category === category}
                      onChange={(e) => handleFilterChange('category', e.target.value)}
                      className="mr-2 text-primary-600 focus:ring-primary-500"
                    />
                    <span className="text-sm text-gray-700 capitalize">{category}</span>
                  </label>
                ))}
              </div>
            </div>

            {/* Brand Filter */}
            <div>
              <h3 className="text-sm font-medium text-gray-900 mb-3">Brand</h3>
              <div className="space-y-2">
                <label className="flex items-center">
                  <input
                    type="radio"
                    name="brand"
                    value=""
                    checked={filters.brand === ''}
                    onChange={(e) => handleFilterChange('brand', e.target.value)}
                    className="mr-2 text-primary-600 focus:ring-primary-500"
                  />
                  <span className="text-sm text-gray-700">All Brands</span>
                </label>
                {brands.map((brand) => (
                  <label key={brand} className="flex items-center">
                    <input
                      type="radio"
                      name="brand"
                      value={brand}
                      checked={filters.brand === brand}
                      onChange={(e) => handleFilterChange('brand', e.target.value)}
                      className="mr-2 text-primary-600 focus:ring-primary-500"
                    />
                    <span className="text-sm text-gray-700">{brand}</span>
                  </label>
                ))}
              </div>
            </div>

            {/* Condition Filter */}
            <div>
              <h3 className="text-sm font-medium text-gray-900 mb-3">Condition</h3>
              <div className="space-y-2">
                <label className="flex items-center">
                  <input
                    type="radio"
                    name="condition"
                    value=""
                    checked={filters.condition === ''}
                    onChange={(e) => handleFilterChange('condition', e.target.value)}
                    className="mr-2 text-primary-600 focus:ring-primary-500"
                  />
                  <span className="text-sm text-gray-700">All Conditions</span>
                </label>
                <label className="flex items-center">
                  <input
                    type="radio"
                    name="condition"
                    value="new"
                    checked={filters.condition === 'new'}
                    onChange={(e) => handleFilterChange('condition', e.target.value)}
                    className="mr-2 text-primary-600 focus:ring-primary-500"
                  />
                  <span className="text-sm text-gray-700">New</span>
                </label>
                <label className="flex items-center">
                  <input
                    type="radio"
                    name="condition"
                    value="used"
                    checked={filters.condition === 'used'}
                    onChange={(e) => handleFilterChange('condition', e.target.value)}
                    className="mr-2 text-primary-600 focus:ring-primary-500"
                  />
                  <span className="text-sm text-gray-700">Used</span>
                </label>
                <label className="flex items-center">
                  <input
                    type="radio"
                    name="condition"
                    value="refurbished"
                    checked={filters.condition === 'refurbished'}
                    onChange={(e) => handleFilterChange('condition', e.target.value)}
                    className="mr-2 text-primary-600 focus:ring-primary-500"
                  />
                  <span className="text-sm text-gray-700">Refurbished</span>
                </label>
              </div>
            </div>

            {/* Price Range */}
            <div>
              <h3 className="text-sm font-medium text-gray-900 mb-3">Price Range</h3>
              <div className="space-y-3">
                <div>
                  <label className="block text-xs text-gray-600 mb-1">Min Price</label>
                  <input
                    type="number"
                    placeholder="0"
                    value={filters.minPrice}
                    onChange={(e) => handleFilterChange('minPrice', e.target.value)}
                    className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                  />
                </div>
                <div>
                  <label className="block text-xs text-gray-600 mb-1">Max Price</label>
                  <input
                    type="number"
                    placeholder="10000"
                    value={filters.maxPrice}
                    onChange={(e) => handleFilterChange('maxPrice', e.target.value)}
                    className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                  />
                </div>
              </div>
            </div>

            {/* Stock Filter */}
            <div>
              <h3 className="text-sm font-medium text-gray-900 mb-3">Availability</h3>
              <label className="flex items-center">
                <input
                  type="checkbox"
                  checked={filters.inStock}
                  onChange={(e) => handleFilterChange('inStock', e.target.checked)}
                  className="mr-2 text-primary-600 focus:ring-primary-500"
                />
                <span className="text-sm text-gray-700">In Stock Only</span>
              </label>
            </div>
          </div>

          {/* Footer */}
          <div className="p-4 border-t border-gray-200">
            {hasActiveFilters() && (
              <button
                onClick={clearFilters}
                className="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-md text-sm font-medium hover:bg-gray-200 transition-colors"
              >
                Clear All Filters
              </button>
            )}
          </div>
        </div>
      </div>
    </>
  );
};

export default ProductSidebar; 