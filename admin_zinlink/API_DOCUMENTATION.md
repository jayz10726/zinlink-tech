# zinlink tech - API Documentation

## Base URL
```
http://127.0.0.1:8000/api
```

## Authentication
Currently, the API is open (no authentication required). For production, consider implementing Laravel Sanctum or Passport.

## Endpoints

### 1. Health Check
**GET** `/health`
- Check if the API is running
- Returns: Status and timestamp

### 2. Products

#### Get All Products
**GET** `/products`
- Returns paginated list of products
- Supports filtering and search

**Query Parameters:**
- `search` - Search in name, description, brand, model
- `category` - Filter by category (e.g., 'laptop', 'gaming-laptop')
- `brand` - Filter by brand (e.g., 'Apple', 'Dell')
- `condition` - Filter by condition ('new', 'used', 'refurbished')
- `min_price` - Minimum price filter
- `max_price` - Maximum price filter
- `per_page` - Items per page (default: 15)
- `include_inactive` - Include inactive products

**Example:**
```
GET /api/products?brand=Apple&min_price=1000&per_page=10
```

#### Get Product Statistics
**GET** `/products/stats`
- Returns product statistics
- Includes total products, active products, in-stock products, total value, brands, categories

#### Get Single Product
**GET** `/products/{id}`
- Returns a specific product by ID

#### Create Product
**POST** `/products`
- Creates a new product

**Required Fields:**
- `name` - Product name
- `description` - Product description
- `price` - Product price (numeric)
- `brand` - Brand name
- `model` - Model name
- `stock_quantity` - Stock quantity (integer)

**Optional Fields:**
- `processor` - Processor specification
- `ram` - RAM specification
- `storage` - Storage specification
- `display` - Display specification
- `graphics` - Graphics specification
- `operating_system` - Operating system
- `image_url` - Product image URL
- `category` - Product category
- `condition` - Product condition ('new', 'used', 'refurbished')
- `warranty` - Warranty information
- `is_active` - Active status (boolean)

**Example Request Body:**
```json
{
    "name": "MacBook Air M2",
    "description": "Lightweight laptop with M2 chip",
    "price": 1199.99,
    "brand": "Apple",
    "model": "MacBook Air M2",
    "processor": "Apple M2",
    "ram": "8GB Unified Memory",
    "storage": "256GB SSD",
    "display": "13.6-inch Liquid Retina",
    "operating_system": "macOS Ventura",
    "stock_quantity": 5,
    "category": "laptop",
    "condition": "new",
    "warranty": "1 Year Apple Care"
}
```

#### Update Product
**PUT/PATCH** `/products/{id}`
- Updates an existing product
- Same fields as create, but all are optional

#### Delete Product
**DELETE** `/products/{id}`
- Deletes a product

#### Update Stock
**PATCH** `/products/{id}/stock`
- Updates only the stock quantity

**Request Body:**
```json
{
    "stock_quantity": 15
}
```

## Response Format

All API responses follow this format:

**Success Response:**
```json
{
    "success": true,
    "data": {...},
    "message": "Operation successful"
}
```

**Error Response:**
```json
{
    "success": false,
    "message": "Error description",
    "errors": {...}
}
```

**Paginated Response:**
```json
{
    "success": true,
    "data": [...],
    "pagination": {
        "current_page": 1,
        "last_page": 3,
        "per_page": 15,
        "total": 45
    }
}
```

## Testing the API

### Using cURL

1. **Get all products:**
```bash
curl http://127.0.0.1:8000/api/products
```

2. **Create a product:**
```bash
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Laptop",
    "description": "A test laptop",
    "price": 999.99,
    "brand": "Test Brand",
    "model": "Test Model",
    "stock_quantity": 10
  }'
```

3. **Get product statistics:**
```bash
curl http://127.0.0.1:8000/api/products/stats
```

### Using Postman or Similar Tools

1. Set the base URL to: `http://127.0.0.1:8000/api`
2. Use the endpoints listed above
3. For POST/PUT requests, set Content-Type header to `application/json`

## Frontend Integration

To integrate with your frontend:

1. **Fetch products:**
```javascript
fetch('http://127.0.0.1:8000/api/products')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log(data.data); // Array of products
    }
  });
```

2. **Create product:**
```javascript
fetch('http://127.0.0.1:8000/api/products', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    name: 'New Laptop',
    description: 'Description here',
    price: 1299.99,
    brand: 'Brand Name',
    model: 'Model Name',
    stock_quantity: 5
  })
})
.then(response => response.json())
.then(data => {
  if (data.success) {
    console.log('Product created:', data.data);
  }
});
```

## Sample Data

The database is seeded with 5 sample products:
1. MacBook Pro 14-inch M3
2. Dell XPS 13 Plus
3. HP Spectre x360 14
4. Lenovo ThinkPad X1 Carbon
5. ASUS ROG Zephyrus G14

## Next Steps

1. **Add Authentication** - Implement Laravel Sanctum for secure API access
2. **Add Image Upload** - Create endpoints for product image uploads
3. **Add Categories** - Create a separate categories management system
4. **Add Orders** - Implement order management system
5. **Add Users** - Customer and admin user management
6. **Add Reviews** - Product review system

## Support

For any issues or questions about the API, check the Laravel logs or contact the development team. 