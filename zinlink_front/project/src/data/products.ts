import { Product } from '../types/product';
import { apiService, ApiImage } from '../services/api';

// Fallback product data (used when API is not available)
export const fallbackProducts: Product[] = [
  // Removed all ZINBook products
  // ... keep only non-ZINBook products here ...
];

// Function to get product images from backend
export const getProductImages = async (): Promise<ApiImage[]> => {
  try {
    const response = await apiService.getImagesByCategory('product');
    if (response.success && response.data) {
      return response.data;
    }
  } catch (error) {
    console.error('Failed to fetch product images:', error);
  }
  return [];
};

// Function to update product images with backend data
export const updateProductsWithBackendImages = async (products: Product[]): Promise<Product[]> => {
  try {
    const backendImages = await getProductImages();
    
    return products.map((product, index) => {
      const backendImage = backendImages[index];
      if (backendImage) {
        return {
          ...product,
          image: backendImage.image_url.startsWith('http') 
            ? backendImage.image_url 
            : `http://localhost:8000/storage/${backendImage.image_url}`
        };
      }
      return product;
    });
  } catch (error) {
    console.error('Failed to update products with backend images:', error);
    return products;
  }
};

// Export fallback products for backward compatibility
export const products = fallbackProducts;

export const getFeaturedProducts = (): Product[] => {
  return fallbackProducts.filter(product => product.isFeatured);
};

export const getNewArrivals = (): Product[] => {
  return fallbackProducts.filter(product => product.isNewArrival);
};

export const getProductsByCategory = (category: string): Product[] => {
  return fallbackProducts.filter(product => product.category === category);
};

export const getProductById = (id: number): Product | undefined => {
  return fallbackProducts.find(product => product.id === id);
};