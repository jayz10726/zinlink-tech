import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { apiService, ApiProduct } from '../../services/api';
import ProductCard from '../products/ProductCard';
import { ChevronRight, Sparkles } from 'lucide-react';

interface Product {
  id: number;
  name: string;
  price: number;
  originalPrice?: number;
  image: string;
  category: string;
  brand: string;
  rating: number;
  inStock: boolean;
  isFeatured: boolean;
  isNewArrival: boolean;
  discount: number;
  specs: {
    processor: string;
    memory: string;
    storage: string;
    display: string;
    graphics: string;
    operatingSystem: string;
    weight: string;
    batteryLife: string;
  };
  description: string;
}

const FeaturedProducts = () => {
  const [products, setProducts] = useState<ApiProduct[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [activeTab, setActiveTab] = useState('all');

  useEffect(() => {
    apiService.getProducts({ per_page: 4 })
      .then(response => {
        setProducts(response.data.slice(0, 4));
        setLoading(false);
      })
      .catch(() => {
        setError('Failed to fetch featured products');
        setLoading(false);
      });
  }, []);

  const categories = ['all', ...new Set(products.map(p => p.category?.toLowerCase() || ''))];
  const filteredProducts = activeTab === 'all'
    ? products
    : products.filter(product => product.category?.toLowerCase() === activeTab.toLowerCase());
  
  const mapApiProductToProduct = (apiProduct: ApiProduct): Product => ({
    id: apiProduct.id,
    name: apiProduct.name,
    price: parseFloat(apiProduct.price),
    originalPrice: undefined, // Optionally map if available
    image: apiProduct.image_url || 'https://via.placeholder.com/300x300?text=No+Image',
    category: apiProduct.category || '',
    brand: apiProduct.brand,
    rating: 4.5, // Default or map if available
    inStock: apiProduct.stock_quantity > 0,
    isFeatured: apiProduct.is_active,
    isNewArrival: false, // Optionally map if available
    discount: 0, // Optionally map if available
    specs: {
      processor: apiProduct.processor || 'Not specified',
      memory: apiProduct.ram || 'Not specified',
      storage: apiProduct.storage || 'Not specified',
      display: apiProduct.display || 'Not specified',
      graphics: apiProduct.graphics || 'Not specified',
      operatingSystem: apiProduct.operating_system || 'Not specified',
      weight: 'Not specified',
      batteryLife: 'Not specified',
    },
    description: apiProduct.description,
  });
  
  return (
    <section className="py-20 bg-gradient-to-b from-white to-blue-50">
      <div className="container">
        {/* Header Section */}
        <div className="text-center mb-16">
          <div className="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-medium mb-6">
            <Sparkles className="w-4 h-4 mr-2" />
            Featured Collection
          </div>
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Premium Laptops & 
            <span className="block text-blue-600">Tech Solutions</span>
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
            Discover our handpicked selection of premium laptops and accessories designed to exceed your expectations.
          </p>
          <Link 
            to="/products" 
            className="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl"
          >
            Explore All Products
            <ChevronRight className="w-5 h-5 ml-2" />
          </Link>
        </div>
        
        {/* Category Tabs */}
        <div className="flex justify-center mb-12">
          <div className="flex flex-wrap justify-center gap-3">
            {categories.map((category) => (
              <button
                key={category}
                onClick={() => setActiveTab(category)}
                className={`px-6 py-3 rounded-full font-medium transition-all duration-300 ${
                  activeTab === category
                    ? 'bg-blue-600 text-white shadow-lg'
                    : 'bg-white text-gray-700 hover:bg-blue-50 border border-gray-200 hover:border-blue-200'
                }`}
              >
                {category.charAt(0).toUpperCase() + category.slice(1)}
              </button>
            ))}
          </div>
        </div>
        
        {/* Products Grid */}
        {loading ? (
          <div className="text-center py-12">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-secondary-600 mx-auto mb-4"></div>
            <p className="text-gray-500 text-lg">Loading featured products...</p>
          </div>
        ) : error ? (
          <div className="text-center py-12">
            <div className="bg-red-50 border border-red-200 rounded-lg p-6 max-w-md mx-auto">
              <p className="text-red-600 text-lg mb-4">{error}</p>
            </div>
          </div>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            {filteredProducts.map((product) => (
              <div key={product.id} className="group">
                <ProductCard product={mapApiProductToProduct(product)} />
              </div>
            ))}
            {filteredProducts.length === 0 && (
              <div className="col-span-full text-center py-16">
                <div className="max-w-md mx-auto">
                  <div className="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <Sparkles className="w-8 h-8 text-gray-400" />
                  </div>
                  <h3 className="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
                  <p className="text-gray-600 mb-6">We couldn't find any products in this category at the moment.</p>
                  <button 
                    onClick={() => setActiveTab('all')}
                    className="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors"
                  >
                    View All Products
                  </button>
                </div>
              </div>
            )}
          </div>
        )}
        
        {/* Call to Action */}
        <div className="text-center mt-16">
          <div className="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
            <h3 className="text-2xl font-bold text-gray-900 mb-4">
              Ready to Find Your Perfect Laptop?
            </h3>
            <p className="text-gray-600 mb-6 max-w-2xl mx-auto">
              Browse our complete collection of premium laptops, accessories, and tech solutions. 
              Get expert advice and find the perfect device for your needs.
            </p>
            <Link 
              to="/products" 
              className="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl"
            >
              Start Shopping Now
              <ChevronRight className="w-5 h-5 ml-2" />
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
};

export default FeaturedProducts;