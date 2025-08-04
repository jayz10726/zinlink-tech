import { Link } from 'react-router-dom';
import { Star, ShoppingCart, Heart } from 'lucide-react';
import { ApiProduct } from '../../services/api';
import { useCart } from '../../context/CartContext';

interface ApiProductCardProps {
  product: ApiProduct;
  viewMode?: 'grid' | 'list';
}

const ApiProductCard = ({ product, viewMode = 'grid' }: ApiProductCardProps) => {
  const { addToCart } = useCart();

  const handleAddToCart = (e: React.MouseEvent) => {
    e.preventDefault();
    e.stopPropagation();
    // Convert ApiProduct to Product format for cart
    const cartProduct = {
      id: product.id,
      name: product.name,
      price: parseFloat(product.price),
      originalPrice: parseFloat(product.price) * 1.1, // Add 10% markup for display
      image: product.image_url || 'https://via.placeholder.com/300x300?text=No+Image',
      category: product.category || 'Laptop',
      brand: product.brand,
      rating: 4.5, // Default rating
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
    addToCart(cartProduct, 1);
  };

  const renderStars = (rating: number) => {
    return Array.from({ length: 5 }, (_, i) => (
      <Star
        key={i}
        className={`w-4 h-4 ${
          i < Math.floor(rating) ? 'text-yellow-400 fill-current' : 'text-gray-300'
        }`}
      />
    ));
  };

  const getImageUrl = () => {
    if (!product.image_url) return 'https://via.placeholder.com/300x300?text=No+Image';
    if (product.image_url.startsWith('http')) return product.image_url;
    // Handle both relative and absolute paths
    if (product.image_url.startsWith('/storage/')) {
      return `http://localhost:8000${product.image_url}`;
    }
    return `http://localhost:8000/storage/${product.image_url}`;
  };

  if (viewMode === 'list') {
    return (
      <Link to={`/products/${product.id}`} className="block">
        <div className="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 p-6">
          <div className="flex flex-col md:flex-row gap-6">
            {/* Product Image */}
            <div className="w-full md:w-48 h-48 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
              <img
                src={getImageUrl()}
                alt={product.name}
                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              />
            </div>

            {/* Product Details */}
            <div className="flex-grow">
              <div className="flex flex-col h-full">
                <div className="flex-grow">
                  <div className="flex items-start justify-between mb-2">
                    <div>
                      <p className="text-sm text-gray-600">{product.brand}</p>
                      <h3 className="text-xl font-semibold text-gray-900 mb-2">{product.name}</h3>
                    </div>
                    <div className="flex items-center gap-2">
                      {product.condition === 'new' && (
                        <span className="px-2 py-1 bg-secondary-100 text-secondary-800 text-xs font-medium rounded-full">
                          New
                        </span>
                      )}
                      {product.condition === 'refurbished' && (
                        <span className="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                          Refurbished
                        </span>
                      )}
                    </div>
                  </div>

                  <div className="flex items-center gap-2 mb-3">
                    <div className="flex">{renderStars(4.5)}</div>
                    <span className="text-sm text-gray-600">(4.5)</span>
                  </div>

                  <p className="text-gray-600 text-sm mb-4 line-clamp-2">{product.description}</p>

                  {/* Key Specs */}
                  <div className="grid grid-cols-2 gap-2 mb-4 text-sm">
                    {product.category === 'cctv' ? (
                      <>
                        <div>
                          <span className="text-gray-500">Resolution:</span>
                          <span className="ml-1 text-gray-900">{product.resolution || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Night Vision:</span>
                          <span className="ml-1 text-gray-900">{product.night_vision ? 'Yes' : 'No'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Weatherproof:</span>
                          <span className="ml-1 text-gray-900">{product.weatherproof ? product.weatherproof.charAt(0).toUpperCase() + product.weatherproof.slice(1) : 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Power Supply:</span>
                          <span className="ml-1 text-gray-900">{product.power_supply || 'Not specified'}</span>
                        </div>
                      </>
                    ) : product.category === 'laptop-charger' ? (
                      <>
                        <div>
                          <span className="text-gray-500">Output Voltage:</span>
                          <span className="ml-1 text-gray-900">{product.output_voltage || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Output Current:</span>
                          <span className="ml-1 text-gray-900">{product.output_current || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Connector Type:</span>
                          <span className="ml-1 text-gray-900">{product.connector_type || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Compatible Brands:</span>
                          <span className="ml-1 text-gray-900">{product.compatible_brands || 'Not specified'}</span>
                        </div>
                      </>
                    ) : product.category === 'hard-disk' ? (
                      <>
                        <div>
                          <span className="text-gray-500">Capacity:</span>
                          <span className="ml-1 text-gray-900">{product.capacity || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Type:</span>
                          <span className="ml-1 text-gray-900">{product.disk_type ? product.disk_type.toUpperCase() : 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Interface:</span>
                          <span className="ml-1 text-gray-900">{product.interface || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Speed:</span>
                          <span className="ml-1 text-gray-900">{product.speed || 'Not specified'}</span>
                        </div>
                      </>
                    ) : product.category === 'wifi' ? (
                      <>
                        <div>
                          <span className="text-gray-500">WiFi Standard:</span>
                          <span className="ml-1 text-gray-900">{product.wifi_standard || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Speed:</span>
                          <span className="ml-1 text-gray-900">{product.wifi_speed || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Coverage:</span>
                          <span className="ml-1 text-gray-900">{product.coverage || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Antennas:</span>
                          <span className="ml-1 text-gray-900">{product.antennas || 'Not specified'}</span>
                        </div>
                      </>
                    ) : product.category === 'mousepad' || product.category === 'accessories' ? (
                      <>
                        <div>
                          <span className="text-gray-500">Material:</span>
                          <span className="ml-1 text-gray-900">{product.material || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Size:</span>
                          <span className="ml-1 text-gray-900">{product.size || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Color:</span>
                          <span className="ml-1 text-gray-900">{product.color || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Compatibility:</span>
                          <span className="ml-1 text-gray-900">{product.compatibility || 'Not specified'}</span>
                        </div>
                      </>
                    ) : (
                      <>
                        <div>
                          <span className="text-gray-500">Processor:</span>
                          <span className="ml-1 text-gray-900">{product.processor || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Memory:</span>
                          <span className="ml-1 text-gray-900">{product.ram || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Storage:</span>
                          <span className="ml-1 text-gray-900">{product.storage || 'Not specified'}</span>
                        </div>
                        <div>
                          <span className="text-gray-500">Display:</span>
                          <span className="ml-1 text-gray-900">{product.display || 'Not specified'}</span>
                        </div>
                      </>
                    )}
                  </div>
                </div>

                {/* Price and Actions */}
                <div className="flex items-center justify-between">
                  <div className="flex items-center gap-2">
                    <span className="text-2xl font-bold text-primary-900">
                      KES {parseFloat(product.price).toFixed(0)}
                    </span>
                  </div>

                  <div className="flex items-center gap-2">
                    <button
                      onClick={handleAddToCart}
                      className="btn-secondary"
                      disabled={product.stock_quantity <= 0}
                    >
                      <ShoppingCart className="w-4 h-4 mr-2" />
                      {product.stock_quantity > 0 ? 'Add to Cart' : 'Out of Stock'}
                    </button>
                    <button className="p-2 text-gray-400 hover:text-red-500 transition-colors">
                      <Heart className="w-5 h-5" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Link>
    );
  }

  return (
    <Link to={`/products/${product.id}`} className="group block">
      <div className="relative bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl border-2 border-transparent group-hover:border-gradient-to-r group-hover:from-blue-400 group-hover:via-purple-400 group-hover:to-pink-400 transition-all duration-300 overflow-hidden hover:scale-105 hover:-translate-y-1">
        {/* Product Image */}
        <div className="relative aspect-square bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
          <img
            src={getImageUrl()}
            alt={product.name}
            className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
          />
          {/* Badges */}
          <div className="absolute top-3 left-3 flex flex-col gap-2 z-10">
            {product.condition === 'new' && (
              <span className="px-2 py-1 bg-gradient-to-r from-green-400 to-blue-500 text-white text-xs font-bold rounded-full shadow-lg animate-pulse">New</span>
            )}
            {product.condition === 'refurbished' && (
              <span className="px-2 py-1 bg-gradient-to-r from-blue-400 to-purple-500 text-white text-xs font-bold rounded-full shadow-lg">Refurbished</span>
            )}
            {product.stock_quantity <= 5 && product.stock_quantity > 0 && (
              <span className="px-2 py-1 bg-gradient-to-r from-orange-400 to-pink-500 text-white text-xs font-bold rounded-full shadow-lg">Low Stock</span>
            )}
            {product.is_active && (
              <span className="px-2 py-1 bg-gradient-to-r from-yellow-400 to-red-500 text-white text-xs font-bold rounded-full shadow-lg">Featured</span>
            )}
          </div>
          {/* Wishlist Button */}
          <div className="absolute top-3 right-3 z-10">
            <button
              onClick={e => { e.preventDefault(); e.stopPropagation(); }}
              className="p-2 bg-white/80 rounded-full shadow-md hover:bg-pink-100 transition-colors duration-300 animate-bounce"
            >
              <Heart className="w-5 h-5 text-pink-500 group-hover:scale-125 transition-transform duration-300" />
            </button>
          </div>
          {/* Add to Cart Button */}
          <div className="absolute bottom-3 left-3 right-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <button
              onClick={handleAddToCart}
              className="w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white font-bold py-2 rounded-xl shadow-lg hover:from-pink-500 hover:to-yellow-500 transition-all duration-300 active:scale-95 animate-bounce"
              disabled={product.stock_quantity <= 0}
            >
              <ShoppingCart className="w-4 h-4 mr-2 inline-block animate-spin group-hover:animate-none" />
              {product.stock_quantity > 0 ? 'Add to Cart' : 'Out of Stock'}
            </button>
          </div>
        </div>
        {/* Product Details */}
        <div className="p-5">
          <div className="mb-2 flex items-center justify-between">
            <p className="text-sm text-gray-600 font-semibold">{product.brand}</p>
            <div className="flex items-center gap-1">
              {renderStars(4.5)}
              <span className="text-xs text-gray-500 ml-1">(4.5)</span>
            </div>
          </div>
          <h3 className="font-extrabold text-lg text-gray-900 line-clamp-2 group-hover:text-primary-600 transition-colors">
            {product.name}
          </h3>
          <div className="flex items-center justify-between mt-4">
            <span className="text-xl font-bold text-primary-900 drop-shadow-lg">
              KES {parseFloat(product.price).toLocaleString()}
            </span>
            <span className="text-xs text-gray-500">
              {product.stock_quantity > 0 ? `${product.stock_quantity} in stock` : 'Out of stock'}
            </span>
          </div>
        </div>
      </div>
    </Link>
  );
};

export default ApiProductCard; 