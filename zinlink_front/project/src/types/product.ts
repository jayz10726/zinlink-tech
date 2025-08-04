export interface Product {
  id: number;
  name: string;
  price: number;
  originalPrice?: number;
  image: string;
  category: string;
  brand: string;
  rating: number;
  inStock: boolean;
  isFeatured?: boolean;
  isNewArrival?: boolean;
  discount?: number;
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
  
  // CCTV Camera fields
  resolution?: string;
  night_vision?: string;
  weatherproof?: string;
  power_supply?: string;
  viewing_angle?: string;
  storage_type?: string;
  
  // Charger fields
  output_voltage?: string;
  output_current?: string;
  connector_type?: string;
  compatible_brands?: string;
  
  // Hard Disk fields
  capacity?: string;
  disk_type?: string;
  interface?: string;
  speed?: string;
  
  // WiFi Router fields
  wifi_standard?: string;
  wifi_speed?: string;
  coverage?: string;
  antennas?: string;
  
  // Accessories fields
  material?: string;
  size?: string;
  color?: string;
  compatibility?: string;
}