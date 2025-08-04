import { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { getProductById } from '../data/products';
import { useCart } from '../context/CartContext';
import { Star, ShoppingCart, Heart, Share2, Truck, Shield, RotateCcw, ChevronLeft } from 'lucide-react';
import { apiService, ApiProduct } from '../services/api';

const ProductDetail = () => {
  const { id } = useParams<{ id: string }>();
  const { addToCart } = useCart();
  const [quantity, setQuantity] = useState(1);
  const [activeTab, setActiveTab] = useState('specs');
  const [product, setProduct] = useState<ApiProduct | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    if (!id) return;
    setLoading(true);
    apiService.getProduct(Number(id))
      .then(response => {
        setProduct(response.data);
        setLoading(false);
      })
      .catch(() => {
        setError('Product not found');
        setLoading(false);
      });
  }, [id]);

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-secondary-600 mx-auto mb-4"></div>
          <p className="text-gray-500 text-lg">Loading product...</p>
        </div>
      </div>
    );
  }

  if (error || !product) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-bold text-gray-900 mb-4">Product Not Found</h2>
          <p className="text-gray-600 mb-6">The product you're looking for doesn't exist.</p>
          <Link to="/products" className="btn-secondary">
            <ChevronLeft className="w-5 h-5 mr-2" />
            Back to Products
          </Link>
        </div>
      </div>
    );
  }

  // Map ApiProduct to Product for UI rendering
  const mappedProduct = {
    id: product.id,
    name: product.name,
    price: parseFloat(product.price),
    originalPrice: undefined,
    image: product.image_url || 'https://via.placeholder.com/300x300?text=No+Image',
    category: product.category || '',
    brand: product.brand,
    rating: 4.5,
    inStock: product.stock_quantity > 0,
    isFeatured: product.is_active,
    isNewArrival: false,
    discount: 0,
    specs: {
      processor: product.processor || 'Not specified',
      memory: product.ram || 'Not specified',
      storage: product.storage || 'Not specified',
      display: product.display || 'Not specified',
      graphics: product.graphics || 'Not specified',
      operatingSystem: product.operating_system || 'Not specified',
      weight: 'Not specified',
      batteryLife: 'Not specified',
    },
    description: product.description,
  };

  const handleAddToCart = () => {
    addToCart(mappedProduct, quantity);
  };

  const renderStars = (rating: number) => {
    return Array.from({ length: 5 }, (_, i) => (
      <Star
        key={i}
        className={`w-5 h-5 ${
          i < Math.floor(rating) ? 'text-yellow-400 fill-current' : 'text-gray-300'
        }`}
      />
    ));
  };

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="container">
        {/* Breadcrumb */}
        <nav className="mb-8">
          <div className="flex items-center space-x-2 text-sm text-gray-600">
            <Link to="/" className="hover:text-primary-600">Home</Link>
            <span>/</span>
            <Link to="/products" className="hover:text-primary-600">Products</Link>
            <span>/</span>
            <span className="text-gray-900">{mappedProduct.name}</span>
          </div>
        </nav>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
          {/* Product Image */}
          <div className="space-y-4">
            <div className="aspect-square bg-white rounded-lg overflow-hidden shadow-sm">
              <img
                src={mappedProduct.image}
                alt={mappedProduct.name}
                className="w-full h-full object-cover"
              />
            </div>
          </div>

          {/* Product Info */}
          <div className="space-y-6">
            <div>
              <div className="flex items-center gap-2 mb-2">
                <span className="text-sm text-gray-600">{mappedProduct.brand}</span>
                {mappedProduct.isNewArrival && (
                  <span className="px-2 py-1 bg-secondary-100 text-secondary-800 text-xs font-medium rounded-full">
                    New Arrival
                  </span>
                )}
              </div>
              <h1 className="text-3xl font-bold text-gray-900 mb-4">{mappedProduct.name}</h1>
              
              {/* Rating */}
              <div className="flex items-center gap-2 mb-4">
                <div className="flex">{renderStars(mappedProduct.rating)}</div>
                <span className="text-sm text-gray-600">({mappedProduct.rating})</span>
              </div>

              {/* Price */}
              <div className="flex items-center gap-3 mb-6">
                <span className="text-3xl font-bold text-primary-900">
                  KES {mappedProduct.price.toFixed(0)}
                </span>
                {mappedProduct.originalPrice && (
                  <>
                    <span className="text-xl text-gray-500 line-through">
                      KES {mappedProduct.originalPrice.toFixed(0)}
                    </span>
                    <span className="px-2 py-1 bg-red-100 text-red-800 text-sm font-medium rounded">
                      {mappedProduct.discount}% OFF
                    </span>
                  </>
                )}
              </div>
            </div>

            {/* Description */}
            <div>
              <p className="text-gray-700 leading-relaxed">{mappedProduct.description}</p>
            </div>

            {/* Quantity and Add to Cart */}
            <div className="space-y-4">
              <div className="flex items-center gap-4">
                <label className="text-sm font-medium text-gray-700">Quantity:</label>
                <div className="flex items-center border border-gray-300 rounded-md">
                  <button
                    onClick={() => setQuantity(Math.max(1, quantity - 1))}
                    className="px-3 py-2 hover:bg-gray-50"
                  >
                    -
                  </button>
                  <span className="px-4 py-2 border-x border-gray-300">{quantity}</span>
                  <button
                    onClick={() => setQuantity(quantity + 1)}
                    className="px-3 py-2 hover:bg-gray-50"
                  >
                    +
                  </button>
                </div>
              </div>

              <div className="flex gap-4">
                <button
                  onClick={handleAddToCart}
                  className="btn-secondary flex-1"
                  disabled={!mappedProduct.inStock}
                >
                  <ShoppingCart className="w-5 h-5 mr-2" />
                  {mappedProduct.inStock ? 'Add to Cart' : 'Out of Stock'}
                </button>
                <button className="p-3 border border-gray-300 rounded-md hover:bg-gray-50">
                  <Heart className="w-5 h-5" />
                </button>
                <button className="p-3 border border-gray-300 rounded-md hover:bg-gray-50">
                  <Share2 className="w-5 h-5" />
                </button>
              </div>
            </div>

            {/* Features */}
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 border-t border-gray-200">
              <div className="flex items-center gap-2">
                <Truck className="w-5 h-5 text-secondary-600" />
                <span className="text-sm text-gray-700">Free Shipping</span>
              </div>
              <div className="flex items-center gap-2">
                <Shield className="w-5 h-5 text-secondary-600" />
                <span className="text-sm text-gray-700">3 Year Warranty</span>
              </div>
              <div className="flex items-center gap-2">
                <RotateCcw className="w-5 h-5 text-secondary-600" />
                <span className="text-sm text-gray-700">30 Day Returns</span>
              </div>
            </div>
          </div>
        </div>

        {/* Product Details Tabs */}
        <div className="bg-white rounded-lg shadow-sm">
          <div className="border-b border-gray-200">
            <nav className="flex space-x-8 px-6">
              <button
                onClick={() => setActiveTab('specs')}
                className={`py-4 px-1 border-b-2 font-medium text-sm ${
                  activeTab === 'specs'
                    ? 'border-secondary-600 text-secondary-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700'
                }`}
              >
                Specifications
              </button>
              <button
                onClick={() => setActiveTab('description')}
                className={`py-4 px-1 border-b-2 font-medium text-sm ${
                  activeTab === 'description'
                    ? 'border-secondary-600 text-secondary-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700'
                }`}
              >
                Description
              </button>
            </nav>
          </div>

          <div className="p-6">
            {activeTab === 'specs' && (
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="space-y-3">
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="font-medium text-gray-700">Processor</span>
                    <span className="text-gray-900">{mappedProduct.specs.processor}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="font-medium text-gray-700">Memory</span>
                    <span className="text-gray-900">{mappedProduct.specs.memory}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="font-medium text-gray-700">Storage</span>
                    <span className="text-gray-900">{mappedProduct.specs.storage}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="font-medium text-gray-700">Display</span>
                    <span className="text-gray-900">{mappedProduct.specs.display}</span>
                  </div>
                </div>
                <div className="space-y-3">
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="font-medium text-gray-700">Graphics</span>
                    <span className="text-gray-900">{mappedProduct.specs.graphics}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="font-medium text-gray-700">Operating System</span>
                    <span className="text-gray-900">{mappedProduct.specs.operatingSystem}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="font-medium text-gray-700">Weight</span>
                    <span className="text-gray-900">{mappedProduct.specs.weight}</span>
                  </div>
                  <div className="flex justify-between py-2 border-b border-gray-100">
                    <span className="font-medium text-gray-700">Battery Life</span>
                    <span className="text-gray-900">{mappedProduct.specs.batteryLife}</span>
                  </div>
                </div>
              </div>
            )}

            {activeTab === 'description' && (
              <div className="prose max-w-none">
                <p className="text-gray-700 leading-relaxed">{mappedProduct.description}</p>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProductDetail;