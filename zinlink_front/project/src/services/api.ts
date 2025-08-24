const API_BASE_URL = '/api';

export interface ApiProduct {
  id: number;
  name: string;
  description: string;
  price: string;
  brand: string;
  model: string;
  processor?: string;
  ram?: string;
  storage?: string;
  display?: string;
  graphics?: string;
  operating_system?: string;
  stock_quantity: number;
  image_url?: string;
  category?: string;
  condition?: string;
  warranty?: string;
  is_active: boolean;
  created_at: string;
  updated_at: string;
  // Category-specific fields
  resolution?: string;
  night_vision?: string;
  weatherproof?: string;
  power_supply?: string;
  output_voltage?: string;
  output_current?: string;
  connector_type?: string;
  compatible_brands?: string;
  capacity?: string;
  disk_type?: string;
  interface?: string;
  speed?: string;
  wifi_standard?: string;
  wifi_speed?: string;
  coverage?: string;
  antennas?: string;
  material?: string;
  size?: string;
  color?: string;
  compatibility?: string;
}

export interface ApiImage {
  id: number;
  name: string;
  description?: string;
  image_url: string;
  category: string;
  alt_text?: string;
  sort_order: number;
  is_active: boolean;
  created_at: string;
  updated_at: string;
}

export interface ApiResponse<T> {
  success: boolean;
  data: T;
  pagination?: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

export interface CreateProductData {
  name: string;
  description: string;
  price: number;
  brand: string;
  model: string;
  processor?: string;
  ram?: string;
  storage?: string;
  display?: string;
  graphics?: string;
  operating_system?: string;
  stock_quantity: number;
  image_url?: string;
  category?: string;
  condition?: 'new' | 'used' | 'refurbished';
  warranty?: string;
  is_active?: boolean;
}

export interface CreateImageData {
  name: string;
  description?: string;
  category: string;
  alt_text?: string;
  sort_order?: number;
  is_active?: boolean;
}

export interface Review {
  id: number;
  customer_name: string;
  service_used: string;
  rating: number;
  comment: string;
  status: 'pending' | 'approved' | 'rejected';
  created_at: string;
  updated_at: string;
}

export interface CreateReviewData {
  customer_name: string;
  service_used: string;
  rating: number;
  comment: string;
}

export interface ReviewStats {
  total_reviews: number;
  average_rating: number;
  rating_distribution: {
    '5_star': number;
    '4_star': number;
    '3_star': number;
    '2_star': number;
    '1_star': number;
  };
}

export interface OrderItemInput {
  product_id: number;
  product_name: string;
  price: number;
  quantity: number;
  subtotal: number;
}

export interface CreateOrderData {
  first_name: string;
  last_name: string;
  email: string;
  phone: string;
  address: string;
  city: string;
  postal_code?: string;
  payment_method: string;
  items: OrderItemInput[];
  subtotal: number;
  tax: number;
  shipping: number;
  total: number;
}

export async function createOrder(data: CreateOrderData) {
  const response = await fetch('http://localhost:8000/api/orders', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });
  return response.json();
}

export interface ApiTeamMember {
  id: number;
  name: string;
  role?: string;
  bio?: string;
  photo_url?: string;
  sort_order: number;
}

class ApiService {
  private baseUrl: string;

  constructor() {
    this.baseUrl = API_BASE_URL;
  }

  private async request<T>(
    endpoint: string,
    options: RequestInit = {}
  ): Promise<ApiResponse<T>> {
    const url = `${this.baseUrl}${endpoint}`;
    
    const config: RequestInit = {
      headers: {
        'Content-Type': 'application/json',
        ...options.headers,
      },
      ...options,
    };

    try {
      console.log('Making API request to:', url);
      
      // Add timeout to prevent hanging requests
      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout
      
      const response = await fetch(url, {
        ...config,
        signal: controller.signal
      });
      
      clearTimeout(timeoutId);
      
      console.log('Response status:', response.status);
      console.log('Response headers:', response.headers);
      
      if (!response.ok) {
        const errorText = await response.text();
        console.error('API Error Response:', errorText);
        throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
      }
      
      const data = await response.json();
      console.log('API Response:', data);
      return data;
    } catch (error) {
      console.error('API request failed:', error);
      console.error('Request URL:', url);
      console.error('Request config:', config);
      throw error;
    }
  }

  // Get all products
  async getProducts(params?: {
    category?: string;
    brand?: string;
    condition?: string;
    min_price?: number;
    max_price?: number;
    search?: string;
    per_page?: number;
  }): Promise<ApiResponse<ApiProduct[]>> {
    const queryParams = new URLSearchParams();
    
    if (params) {
      Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined) {
          queryParams.append(key, value.toString());
        }
      });
    }

    const endpoint = `/products${queryParams.toString() ? `?${queryParams.toString()}` : ''}`;
    return this.request<ApiProduct[]>(endpoint);
  }

  // Get single product
  async getProduct(id: number): Promise<ApiResponse<ApiProduct>> {
    return this.request<ApiProduct>(`/products/${id}`);
  }

  // Create new product
  async createProduct(data: CreateProductData, imageFile?: File): Promise<ApiResponse<ApiProduct>> {
    const formData = new FormData();
    
    // Add all text fields
    Object.entries(data).forEach(([key, value]) => {
      if (value !== undefined && value !== null) {
        formData.append(key, value.toString());
      }
    });
    
    // Add image file if provided
    if (imageFile) {
      formData.append('image', imageFile);
    }

    return this.request<ApiProduct>('/products', {
      method: 'POST',
      body: formData,
      headers: {}, // Remove Content-Type to let browser set it with boundary
    });
  }

  // Update product
  async updateProduct(id: number, data: Partial<CreateProductData>, imageFile?: File): Promise<ApiResponse<ApiProduct>> {
    const formData = new FormData();
    
    // Add all text fields
    Object.entries(data).forEach(([key, value]) => {
      if (value !== undefined && value !== null) {
        formData.append(key, value.toString());
      }
    });
    
    // Add image file if provided
    if (imageFile) {
      formData.append('image', imageFile);
    }

    return this.request<ApiProduct>(`/products/${id}`, {
      method: 'PUT',
      body: formData,
      headers: {}, // Remove Content-Type to let browser set it with boundary
    });
  }

  // Delete product
  async deleteProduct(id: number): Promise<ApiResponse<null>> {
    return this.request<null>(`/products/${id}`, {
      method: 'DELETE',
    });
  }

  // Get product statistics
  async getProductStats(): Promise<ApiResponse<any>> {
    return this.request<any>('/products/stats');
  }

  // Get all images
  async getImages(params?: {
    category?: string;
    active?: boolean;
    search?: string;
    sort_by?: string;
    sort_order?: string;
    per_page?: number;
  }): Promise<ApiResponse<ApiImage[]>> {
    const queryParams = new URLSearchParams();
    
    if (params) {
      Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined) {
          queryParams.append(key, value.toString());
        }
      });
    }

    const endpoint = `/images${queryParams.toString() ? `?${queryParams.toString()}` : ''}`;
    return this.request<ApiImage[]>(endpoint);
  }

  // Get images by category
  async getImagesByCategory(category: string): Promise<ApiResponse<ApiImage[]>> {
    return this.request<ApiImage[]>(`/images/category/${category}`);
  }

  // Get hero images
  async getHeroImages(): Promise<ApiResponse<ApiImage[]>> {
    return this.request<ApiImage[]>('/images/hero');
  }

  // Get single image
  async getImage(id: number): Promise<ApiResponse<ApiImage>> {
    return this.request<ApiImage>(`/images/${id}`);
  }

  // Create new image
  async createImage(data: CreateImageData, imageFile: File): Promise<ApiResponse<ApiImage>> {
    const formData = new FormData();
    
    // Add all text fields
    Object.entries(data).forEach(([key, value]) => {
      if (value !== undefined && value !== null) {
        formData.append(key, value.toString());
      }
    });
    
    // Add image file
    formData.append('image', imageFile);

    return this.request<ApiImage>('/images', {
      method: 'POST',
      body: formData,
      headers: {}, // Remove Content-Type to let browser set it with boundary
    });
  }

  // Update image
  async updateImage(id: number, data: Partial<CreateImageData>, imageFile?: File): Promise<ApiResponse<ApiImage>> {
    const formData = new FormData();
    
    // Add all text fields
    Object.entries(data).forEach(([key, value]) => {
      if (value !== undefined && value !== null) {
        formData.append(key, value.toString());
      }
    });
    
    // Add image file if provided
    if (imageFile) {
      formData.append('image', imageFile);
    }

    return this.request<ApiImage>(`/images/${id}`, {
      method: 'PUT',
      body: formData,
      headers: {}, // Remove Content-Type to let browser set it with boundary
    });
  }

  // Delete image
  async deleteImage(id: number): Promise<ApiResponse<null>> {
    return this.request<null>(`/images/${id}`, {
      method: 'DELETE',
    });
  }

  // Update image order
  async updateImageOrder(images: Array<{ id: number; sort_order: number }>): Promise<ApiResponse<null>> {
    return this.request<null>('/images/order', {
      method: 'PATCH',
      body: JSON.stringify({ images }),
    });
  }

  // Get reviews
  async getReviews(limit?: number): Promise<ApiResponse<Review[]>> {
    const endpoint = limit ? `/reviews?limit=${limit}` : '/reviews';
    return this.request<Review[]>(endpoint);
  }

  // Submit review
  async submitReview(data: CreateReviewData): Promise<ApiResponse<Review>> {
    return this.request<Review>('/reviews', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }

  // Get review statistics
  async getReviewStats(): Promise<ApiResponse<ReviewStats>> {
    return this.request<ReviewStats>('/reviews/stats');
  }

  // Get team members
  async getTeam(): Promise<ApiResponse<ApiTeamMember[]>> {
    return this.request<ApiTeamMember[]>('/team');
  }

  // Health check
  async healthCheck(): Promise<{ status: string; message: string; timestamp: string }> {
    const response = await fetch(`${this.baseUrl}/health`);
    return response.json();
  }
}

export const apiService = new ApiService(); 