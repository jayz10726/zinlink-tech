@extends('admin.layout')

@section('title', 'Edit Product - LaptopHub Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Product</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.statistics') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-chart-bar mr-2"></i>Statistics
            </a>
            <a href="{{ route('admin.products') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Back to Products
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border p-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Brand *</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Model *</label>
                    <input type="text" name="model" value="{{ old('model', $product->model) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (KES) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="toggleSpecFields()">
                        <option value="">Select Category</option>
                        <option value="laptop" {{ old('category', $product->category) == 'laptop' ? 'selected' : '' }}>Laptop</option>
                        <option value="desktop" {{ old('category', $product->category) == 'desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="cctv" {{ old('category', $product->category) == 'cctv' ? 'selected' : '' }}>CCTV Camera</option>
                        <option value="laptop-charger" {{ old('category', $product->category) == 'laptop-charger' ? 'selected' : '' }}>Laptop Charger</option>
                        <option value="hard-disk" {{ old('category', $product->category) == 'hard-disk' ? 'selected' : '' }}>Hard Disk</option>
                        <option value="wifi" {{ old('category', $product->category) == 'wifi' ? 'selected' : '' }}>WiFi Router</option>
                        <option value="mousepad" {{ old('category', $product->category) == 'mousepad' ? 'selected' : '' }}>Mousepad</option>
                        <option value="accessories" {{ old('category', $product->category) == 'accessories' ? 'selected' : '' }}>Other Accessories</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="4" required
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Image Upload Section -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Product Image</h3>
                
                <!-- Current Image Preview -->
                @if($product->image_url)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                             class="w-24 h-24 object-cover rounded-lg border">
                        <div>
                            <p class="text-sm text-gray-600">{{ $product->image_url }}</p>
                            <p class="text-xs text-gray-500">Upload a new image to replace this one</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image URL (Alternative)</label>
                        <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" placeholder="https://example.com/image.jpg"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Use this if you prefer to link to an external image</p>
                    </div>
                </div>
            </div>

            <!-- Laptop/Desktop Specifications -->
            <div id="laptop-specs" class="spec-section" style="display: none;">
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Computer Specifications</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Processor</label>
                            <input type="text" name="processor" value="{{ old('processor', $product->processor) }}" placeholder="e.g., Intel Core i5-12400F"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">RAM</label>
                            <input type="text" name="ram" value="{{ old('ram', $product->ram) }}" placeholder="e.g., 8GB DDR4"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Storage</label>
                            <input type="text" name="storage" value="{{ old('storage', $product->storage) }}" placeholder="e.g., 512GB SSD"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Display</label>
                            <input type="text" name="display" value="{{ old('display', $product->display) }}" placeholder="e.g., 15.6\" FHD"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Graphics</label>
                            <input type="text" name="graphics" value="{{ old('graphics', $product->graphics) }}" placeholder="e.g., NVIDIA GTX 1650"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Operating System</label>
                            <input type="text" name="operating_system" value="{{ old('operating_system', $product->operating_system) }}" placeholder="e.g., Windows 11"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- CCTV Specifications -->
            <div id="cctv-specs" class="spec-section" style="display: none;">
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">CCTV Camera Specifications</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Resolution</label>
                            <input type="text" name="resolution" value="{{ old('resolution', $product->resolution ?? '') }}" placeholder="e.g., 1080p, 4K"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Night Vision</label>
                            <select name="night_vision" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select</option>
                                <option value="yes" {{ old('night_vision', $product->night_vision ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('night_vision', $product->night_vision ?? '') == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Weatherproof</label>
                            <select name="weatherproof" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select</option>
                                <option value="indoor" {{ old('weatherproof', $product->weatherproof ?? '') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                                <option value="outdoor" {{ old('weatherproof', $product->weatherproof ?? '') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                                <option value="both" {{ old('weatherproof', $product->weatherproof ?? '') == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Power Supply</label>
                            <input type="text" name="power_supply" value="{{ old('power_supply', $product->power_supply ?? '') }}" placeholder="e.g., 12V DC, PoE"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Viewing Angle</label>
                            <input type="text" name="viewing_angle" value="{{ old('viewing_angle', $product->viewing_angle ?? '') }}" placeholder="e.g., 90°, 120°"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Storage Type</label>
                            <input type="text" name="storage_type" value="{{ old('storage_type', $product->storage_type ?? '') }}" placeholder="e.g., SD Card, NVR"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charger Specifications -->
            <div id="charger-specs" class="spec-section" style="display: none;">
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Charger Specifications</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Output Voltage</label>
                            <input type="text" name="output_voltage" value="{{ old('output_voltage', $product->output_voltage ?? '') }}" placeholder="e.g., 19.5V"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Output Current</label>
                            <input type="text" name="output_current" value="{{ old('output_current', $product->output_current ?? '') }}" placeholder="e.g., 3.25A"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Connector Type</label>
                            <input type="text" name="connector_type" value="{{ old('connector_type', $product->connector_type ?? '') }}" placeholder="e.g., USB-C, Barrel"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Compatible Brands</label>
                            <input type="text" name="compatible_brands" value="{{ old('compatible_brands', $product->compatible_brands ?? '') }}" placeholder="e.g., HP, Dell, Lenovo"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hard Disk Specifications -->
            <div id="harddisk-specs" class="spec-section" style="display: none;">
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Hard Disk Specifications</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                            <input type="text" name="capacity" value="{{ old('capacity', $product->capacity ?? '') }}" placeholder="e.g., 1TB, 2TB"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                            <select name="disk_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select</option>
                                <option value="hdd" {{ old('disk_type', $product->disk_type ?? '') == 'hdd' ? 'selected' : '' }}>HDD</option>
                                <option value="ssd" {{ old('disk_type', $product->disk_type ?? '') == 'ssd' ? 'selected' : '' }}>SSD</option>
                                <option value="nvme" {{ old('disk_type', $product->disk_type ?? '') == 'nvme' ? 'selected' : '' }}>NVMe</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Interface</label>
                            <input type="text" name="interface" value="{{ old('interface', $product->interface ?? '') }}" placeholder="e.g., SATA, PCIe"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Speed</label>
                            <input type="text" name="speed" value="{{ old('speed', $product->speed ?? '') }}" placeholder="e.g., 7200 RPM, 3500 MB/s"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- WiFi Router Specifications -->
            <div id="wifi-specs" class="spec-section" style="display: none;">
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">WiFi Router Specifications</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WiFi Standard</label>
                            <input type="text" name="wifi_standard" value="{{ old('wifi_standard', $product->wifi_standard ?? '') }}" placeholder="e.g., WiFi 6, WiFi 5"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Speed</label>
                            <input type="text" name="wifi_speed" value="{{ old('wifi_speed', $product->wifi_speed ?? '') }}" placeholder="e.g., 300Mbps, 1Gbps"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Coverage</label>
                            <input type="text" name="coverage" value="{{ old('coverage', $product->coverage ?? '') }}" placeholder="e.g., 1500 sq ft"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Antennas</label>
                            <input type="text" name="antennas" value="{{ old('antennas', $product->antennas ?? '') }}" placeholder="e.g., 4 External"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accessories Specifications -->
            <div id="accessories-specs" class="spec-section" style="display: none;">
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Accessory Specifications</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                            <input type="text" name="material" value="{{ old('material', $product->material ?? '') }}" placeholder="e.g., Plastic, Metal, Fabric"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                            <input type="text" name="size" value="{{ old('size', $product->size ?? '') }}" placeholder="e.g., 300x250mm, Large"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                            <input type="text" name="color" value="{{ old('color', $product->color ?? '') }}" placeholder="e.g., Black, Blue, Multi"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Compatibility</label>
                            <input type="text" name="compatibility" value="{{ old('compatibility', $product->compatibility ?? '') }}" placeholder="e.g., Universal, Specific models"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                    <select name="condition" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                        <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                        <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Warranty</label>
                    <input type="text" name="warranty" value="{{ old('warranty', $product->warranty) }}" placeholder="e.g., 1 Year"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label class="ml-2 block text-sm text-gray-900">Active Product</label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.products') }}" 
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSpecFields() {
    const category = document.getElementById('category').value;
    const specSections = document.querySelectorAll('.spec-section');
    
    // Hide all spec sections first
    specSections.forEach(section => {
        section.style.display = 'none';
    });
    
    // Show relevant spec section based on category
    switch(category) {
        case 'laptop':
        case 'desktop':
            document.getElementById('laptop-specs').style.display = 'block';
            break;
        case 'cctv':
            document.getElementById('cctv-specs').style.display = 'block';
            break;
        case 'laptop-charger':
            document.getElementById('charger-specs').style.display = 'block';
            break;
        case 'hard-disk':
            document.getElementById('harddisk-specs').style.display = 'block';
            break;
        case 'wifi':
            document.getElementById('wifi-specs').style.display = 'block';
            break;
        case 'mousepad':
        case 'accessories':
            document.getElementById('accessories-specs').style.display = 'block';
            break;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleSpecFields();
});
@endsection 