import { Link } from 'react-router-dom';
import { Star, ShoppingCart, Heart } from 'lucide-react';
import { Product } from '../../types/product';
import { useCart } from '../../context/CartContext';
import { useToast } from '../../context/ToastContext';

interface ProductCardProps {
  product: Product;
  viewMode?: 'grid' | 'list';
}

const ProductCard = ({ product, viewMode = 'grid' }: ProductCardProps) => {
  const { addToCart, isInCart } = useCart();
  const { showToast } = useToast();

  const handleAddToCart = (e: React.MouseEvent) => {
    e.preventDefault();
    e.stopPropagation();
    
    if (!product.inStock) {
      showToast('This item is out of stock', 'error');
      return;
    }

    addToCart(product, 1);
    showToast(`${product.name} added to cart!`, 'success');
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

  if (viewMode === 'list') {
    return (
      <Link to={`/products/${product.id}`} className="block">
        <div className="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 p-6">
          <div className="flex flex-col md:flex-row gap-6">
            {/* Product Image */}
            <div className="w-full md:w-48 h-48 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
              <img
                src={product.image}
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
                      {product.isNewArrival && (
                        <span className="px-2 py-1 bg-secondary-100 text-secondary-800 text-xs font-medium rounded-full">
                          New
                        </span>
                      )}
                      {product.discount && (
                        <span className="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                          -{product.discount}%
                        </span>
                      )}
                    </div>
                  </div>

                  <div className="flex items-center gap-2 mb-3">
                    <div className="flex">{renderStars(product.rating)}</div>
                    <span className="text-sm text-gray-600">({product.rating})</span>
                  </div>

                  <p className="text-gray-600 text-sm mb-4 line-clamp-2">{product.description}</p>

                  {/* Key Specs */}
                  <div className="grid grid-cols-2 gap-2 mb-4 text-sm">
                    <div>
                      <span className="text-gray-500">Processor:</span>
                      <span className="ml-1 text-gray-900">{product.specs.processor.split(' ').slice(0, 3).join(' ')}</span>
                    </div>
                    <div>
                      <span className="text-gray-500">Memory:</span>
                      <span className="ml-1 text-gray-900">{product.specs.memory}</span>
                    </div>
                    <div>
                      <span className="text-gray-500">Storage:</span>
                      <span className="ml-1 text-gray-900">{product.specs.storage}</span>
                    </div>
                    <div>
                      <span className="text-gray-500">Display:</span>
                      <span className="ml-1 text-gray-900">{product.specs.display.split(' ').slice(0, 2).join(' ')}</span>
                    </div>
                  </div>
                </div>

                {/* Price and Actions */}
                <div className="flex items-center justify-between">
                  <div className="flex items-center gap-2">
                    <span className="text-2xl font-bold text-primary-900">
                      KES {product.price.toFixed(0)}
                    </span>
                    {product.originalPrice && (
                      <span className="text-lg text-gray-500 line-through">
                        KES {product.originalPrice.toFixed(0)}
                      </span>
                    )}
                  </div>

                  <div className="flex items-center gap-2">
                    <button
                      onClick={handleAddToCart}
                      className="btn-secondary"
                      disabled={!product.inStock}
                    >
                      <ShoppingCart className="w-4 h-4 mr-2" />
                      {product.inStock ? 'Add to Cart' : 'Out of Stock'}
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
      <div className="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
        {/* Product Image */}
        <div className="relative aspect-square bg-gray-100 overflow-hidden">
          <img
            src={product.image}
            alt={product.name}
            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
          />
          
          {/* Badges */}
          <div className="absolute top-3 left-3 flex flex-col gap-2">
            {product.isNewArrival && (
              <span className="px-2 py-1 bg-secondary-600 text-white text-xs font-medium rounded-full">
                New
              </span>
            )}
            {product.discount && (
              <span className="px-2 py-1 bg-red-600 text-white text-xs font-medium rounded-full">
                -{product.discount}%
              </span>
            )}
          </div>

          {/* Quick Actions */}
          <div className="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <button
              onClick={(e) => {
                e.preventDefault();
                e.stopPropagation();
              }}
              className="p-2 bg-white rounded-full shadow-md hover:bg-gray-50 transition-colors"
            >
              <Heart className="w-4 h-4 text-gray-600" />
            </button>
          </div>

          {/* Add to Cart Button */}
          <div className="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <button
              onClick={handleAddToCart}
              className="w-full btn-secondary text-sm py-2"
              disabled={!product.inStock}
            >
              <ShoppingCart className="w-4 h-4 mr-2" />
              {product.inStock ? 'Add to Cart' : 'Out of Stock'}
            </button>
          </div>
        </div>

        {/* Product Details */}
        <div className="p-4">
          <div className="mb-2">
            <p className="text-sm text-gray-600">{product.brand}</p>
            <h3 className="font-semibold text-gray-900 line-clamp-2 group-hover:text-primary-600 transition-colors">
              {product.name}
            </h3>
          </div>

          <div className="flex items-center gap-1 mb-3">
            <div className="flex">{renderStars(product.rating)}</div>
            <span className="text-sm text-gray-600 ml-1">({product.rating})</span>
          </div>

          <div className="flex items-center justify-between">
            <div className="flex items-center gap-2">
              <span className="text-lg font-bold text-primary-900">
                KES {product.price.toFixed(0)}
              </span>
              {product.originalPrice && (
                <span className="text-sm text-gray-500 line-through">
                  KES {product.originalPrice.toFixed(0)}
                </span>
              )}
            </div>
            
            {!product.inStock && (
              <span className="text-sm text-red-600 font-medium">Out of Stock</span>
            )}
          </div>
        </div>
      </div>
    </Link>
  );
};

export default ProductCard;