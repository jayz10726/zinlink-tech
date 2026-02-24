import { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
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

  // ✅ Get backend base URL dynamically from .env
  const BASE_URL = import.meta.env.VITE_API_BASE_URL?.replace('/api', '');

  useEffect(() => {
    if (!id) return;

    setLoading(true);
    setError(null);

    apiService.getProduct(Number(id))
      .then(response => {
        setProduct(response.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error(err);
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

  // ✅ Proper image handling for production
  const resolvedImage = product.image_url
    ? product.image_url.startsWith('http')
      ? product.image_url
      : `${BASE_URL}/${product.image_url}`
    : 'https://via.placeholder.com/300x300?text=No+Image';

  const mappedProduct = {
    id: product.id,
    name: product.name,
    price: parseFloat(product.price),
    image: resolvedImage,
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
          i < Math.floor(rating)
            ? 'text-yellow-400 fill-current'
            : 'text-gray-300'
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
          <div className="aspect-square bg-white rounded-lg overflow-hidden shadow-sm">
            <img
              src={mappedProduct.image}
              alt={mappedProduct.name}
              className="w-full h-full object-cover"
            />
          </div>

          {/* Product Info */}
          <div className="space-y-6">
            <h1 className="text-3xl font-bold text-gray-900">
              {mappedProduct.name}
            </h1>

            <div className="flex items-center gap-2">
              <div className="flex">{renderStars(mappedProduct.rating)}</div>
              <span className="text-sm text-gray-600">
                ({mappedProduct.rating})
              </span>
            </div>

            <div className="text-3xl font-bold text-primary-900">
              KES {mappedProduct.price.toFixed(0)}
            </div>

            <p className="text-gray-700 leading-relaxed">
              {mappedProduct.description}
            </p>

            {/* Quantity */}
            <div className="flex items-center gap-4">
              <button
                onClick={() => setQuantity(Math.max(1, quantity - 1))}
                className="px-3 py-2 border"
              >
                -
              </button>
              <span>{quantity}</span>
              <button
                onClick={() => setQuantity(quantity + 1)}
                className="px-3 py-2 border"
              >
                +
              </button>
            </div>

            <button
              onClick={handleAddToCart}
              className="btn-secondary w-full"
              disabled={!mappedProduct.inStock}
            >
              <ShoppingCart className="w-5 h-5 mr-2" />
              {mappedProduct.inStock ? 'Add to Cart' : 'Out of Stock'}
            </button>

            {/* Features */}
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 border-t">
              <div className="flex items-center gap-2">
                <Truck className="w-5 h-5 text-secondary-600" />
                <span className="text-sm">Free Shipping</span>
              </div>
              <div className="flex items-center gap-2">
                <Shield className="w-5 h-5 text-secondary-600" />
                <span className="text-sm">3 Year Warranty</span>
              </div>
              <div className="flex items-center gap-2">
                <RotateCcw className="w-5 h-5 text-secondary-600" />
                <span className="text-sm">30 Day Returns</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProductDetail;