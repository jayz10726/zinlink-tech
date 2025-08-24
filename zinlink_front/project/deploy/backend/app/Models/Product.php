<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'brand',
        'model',
        'processor',
        'ram',
        'storage',
        'display',
        'graphics',
        'operating_system',
        'stock_quantity',
        'image_url',
        'category',
        'condition', // new, used, refurbished
        'warranty',
        'is_active',
        // CCTV Camera fields
        'resolution',
        'night_vision',
        'weatherproof',
        'power_supply',
        'viewing_angle',
        'storage_type',
        // Charger fields
        'output_voltage',
        'output_current',
        'connector_type',
        'compatible_brands',
        // Hard Disk fields
        'capacity',
        'disk_type',
        'interface',
        'speed',
        // WiFi Router fields
        'wifi_standard',
        'wifi_speed',
        'coverage',
        'antennas',
        // Accessories fields
        'material',
        'size',
        'color',
        'compatibility',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'formatted_price',
        'is_in_stock',
        'stock_status'
    ];

    // Scope for active products
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Scope for in stock products
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock_quantity', '>', 0);
    }

    // Scope for out of stock products
    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('stock_quantity', '<=', 0);
    }

    // Scope for low stock products
    public function scopeLowStock(Builder $query, int $threshold = 5): Builder
    {
        return $query->where('stock_quantity', '>', 0)
                    ->where('stock_quantity', '<=', $threshold);
    }

    // Scope for products by category
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    // Scope for products by brand
    public function scopeByBrand(Builder $query, string $brand): Builder
    {
        return $query->where('brand', $brand);
    }

    // Scope for products by condition
    public function scopeByCondition(Builder $query, string $condition): Builder
    {
        return $query->where('condition', $condition);
    }

    // Scope for products within price range
    public function scopePriceRange(Builder $query, float $min, float $max): Builder
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    // Scope for searching products
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%")
              ->orWhere('model', 'like', "%{$search}%")
              ->orWhere('processor', 'like', "%{$search}%");
        });
    }

    // Get formatted price
    public function getFormattedPriceAttribute(): string
    {
        return 'KES ' . number_format($this->price, 0);
    }

    // Check if product is in stock
    public function getIsInStockAttribute(): bool
    {
        return $this->stock_quantity > 0;
    }

    // Get stock status
    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock_quantity <= 5) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    // Check if product is in stock (method)
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    // Check if product is low in stock
    public function isLowStock(int $threshold = 5): bool
    {
        return $this->stock_quantity > 0 && $this->stock_quantity <= $threshold;
    }

    // Get stock status text
    public function getStockStatusText(): string
    {
        if ($this->stock_quantity <= 0) {
            return 'Out of Stock';
        } elseif ($this->stock_quantity <= 5) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    // Get condition text
    public function getConditionText(): string
    {
        return ucfirst($this->condition ?? 'new');
    }

    // Get full product name
    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->name} {$this->model}";
    }

    // Get specifications as array
    public function getSpecificationsAttribute(): array
    {
        $specs = [];
        
        // Common specs
        if ($this->processor) $specs['Processor'] = $this->processor;
        if ($this->ram) $specs['RAM'] = $this->ram;
        if ($this->storage) $specs['Storage'] = $this->storage;
        if ($this->display) $specs['Display'] = $this->display;
        if ($this->graphics) $specs['Graphics'] = $this->graphics;
        if ($this->operating_system) $specs['OS'] = $this->operating_system;
        
        // Category-specific specs
        switch ($this->category) {
            case 'cctv':
                if ($this->resolution) $specs['Resolution'] = $this->resolution;
                if ($this->night_vision) $specs['Night Vision'] = ucfirst($this->night_vision);
                if ($this->weatherproof) $specs['Weatherproof'] = ucfirst($this->weatherproof);
                if ($this->power_supply) $specs['Power Supply'] = $this->power_supply;
                if ($this->viewing_angle) $specs['Viewing Angle'] = $this->viewing_angle;
                if ($this->storage_type) $specs['Storage Type'] = $this->storage_type;
                break;
                
            case 'laptop-charger':
                if ($this->output_voltage) $specs['Output Voltage'] = $this->output_voltage;
                if ($this->output_current) $specs['Output Current'] = $this->output_current;
                if ($this->connector_type) $specs['Connector Type'] = $this->connector_type;
                if ($this->compatible_brands) $specs['Compatible Brands'] = $this->compatible_brands;
                break;
                
            case 'hard-disk':
                if ($this->capacity) $specs['Capacity'] = $this->capacity;
                if ($this->disk_type) $specs['Type'] = strtoupper($this->disk_type);
                if ($this->interface) $specs['Interface'] = $this->interface;
                if ($this->speed) $specs['Speed'] = $this->speed;
                break;
                
            case 'wifi':
                if ($this->wifi_standard) $specs['WiFi Standard'] = $this->wifi_standard;
                if ($this->wifi_speed) $specs['Speed'] = $this->wifi_speed;
                if ($this->coverage) $specs['Coverage'] = $this->coverage;
                if ($this->antennas) $specs['Antennas'] = $this->antennas;
                break;
                
            case 'mousepad':
            case 'accessories':
                if ($this->material) $specs['Material'] = $this->material;
                if ($this->size) $specs['Size'] = $this->size;
                if ($this->color) $specs['Color'] = $this->color;
                if ($this->compatibility) $specs['Compatibility'] = $this->compatibility;
                break;
        }
        
        return $specs;
    }

    // Get CCTV specifications
    public function getCctvSpecsAttribute(): array
    {
        return [
            'resolution' => $this->resolution,
            'night_vision' => $this->night_vision,
            'weatherproof' => $this->weatherproof,
            'power_supply' => $this->power_supply,
            'viewing_angle' => $this->viewing_angle,
            'storage_type' => $this->storage_type,
        ];
    }

    // Get charger specifications
    public function getChargerSpecsAttribute(): array
    {
        return [
            'output_voltage' => $this->output_voltage,
            'output_current' => $this->output_current,
            'connector_type' => $this->connector_type,
            'compatible_brands' => $this->compatible_brands,
        ];
    }

    // Get hard disk specifications
    public function getHardDiskSpecsAttribute(): array
    {
        return [
            'capacity' => $this->capacity,
            'disk_type' => $this->disk_type,
            'interface' => $this->interface,
            'speed' => $this->speed,
        ];
    }

    // Get WiFi router specifications
    public function getWifiSpecsAttribute(): array
    {
        return [
            'wifi_standard' => $this->wifi_standard,
            'wifi_speed' => $this->wifi_speed,
            'coverage' => $this->coverage,
            'antennas' => $this->antennas,
        ];
    }

    // Get accessory specifications
    public function getAccessorySpecsAttribute(): array
    {
        return [
            'material' => $this->material,
            'size' => $this->size,
            'color' => $this->color,
            'compatibility' => $this->compatibility,
        ];
    }

    // Get category-specific specifications
    public function getCategorySpecsAttribute(): array
    {
        switch ($this->category) {
            case 'cctv':
                return $this->cctv_specs;
            case 'laptop-charger':
                return $this->charger_specs;
            case 'hard-disk':
                return $this->hard_disk_specs;
            case 'wifi':
                return $this->wifi_specs;
            case 'mousepad':
            case 'accessories':
                return $this->accessory_specs;
            default:
                return [];
        }
    }

    // Get image URL with fallback
    public function getImageUrlAttribute($value): string
    {
        if ($value) {
            return $value;
        }
        
        // Return a placeholder image
        return 'https://via.placeholder.com/400x300?text=No+Image';
    }

    // Boot method to set default values
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (!isset($product->is_active)) {
                $product->is_active = true;
            }
            if (!isset($product->condition)) {
                $product->condition = 'new';
            }
        });
    }
}
