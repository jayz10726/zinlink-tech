#!/bin/bash

echo "🚀 Zinlink Tech - Complete Deployment Script"
echo "=============================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Step 1: Build Frontend
print_status "Building frontend..."
cd zinlink_front/project
npm run build
if [ $? -eq 0 ]; then
    print_success "Frontend built successfully!"
else
    print_error "Frontend build failed!"
    exit 1
fi

# Step 2: Prepare Backend
print_status "Preparing backend..."
cd ../../admin_zinlink
composer install --optimize-autoloader --no-dev
if [ $? -eq 0 ]; then
    print_success "Backend dependencies installed!"
else
    print_error "Backend dependencies installation failed!"
    exit 1
fi

# Step 3: Create deployment package
print_status "Creating deployment package..."
cd ..
mkdir -p deployment_package
cp -r zinlink_front/project/dist/* deployment_package/
cp -r admin_zinlink/* deployment_package/api/
cp zinlink_front/project/dist/.htaccess deployment_package/

# Step 4: Create production .env template
print_status "Creating production .env template..."
cat > deployment_package/api/.env.example << 'EOF'
APP_NAME="Zinlink Tech"
APP_ENV=production
APP_KEY=your-generated-key-here
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
EOF

# Step 5: Create deployment instructions
print_status "Creating deployment instructions..."
cat > deployment_package/DEPLOYMENT_INSTRUCTIONS.md << 'EOF'
# 🚀 Zinlink Tech - Quick Deployment Instructions

## 📋 What's Included
- ✅ Frontend (React) - Ready to deploy
- ✅ Backend (Laravel) - Ready to deploy
- ✅ Database migrations and seeders
- ✅ Admin panel with team management
- ✅ Beautiful team section design

## 🎯 Quick Steps

### 1. Upload to cPanel
1. **Extract** this package on your computer
2. **Upload** all files to `public_html/`
3. **Create** `api` folder in `public_html/` and upload backend files there

### 2. Database Setup
1. Create MySQL database in cPanel
2. Copy `.env.example` to `.env` in the `api` folder
3. Update database credentials in `.env`
4. Run: `php artisan migrate && php artisan db:seed`

### 3. Set Permissions
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Create Storage Link
```bash
php artisan storage:link
```

## 🌐 Your URLs
- **Website**: `https://yourdomain.com`
- **Admin Panel**: `https://yourdomain.com/api/admin`
- **API**: `https://yourdomain.com/api`

## 🔑 Admin Access
- **Email**: `admin@zinlinktech.com`
- **Password**: `admin123`
- **⚠️ Change password immediately!**

## ✨ Features Ready
- ✅ Modern responsive design
- ✅ Product catalog with images
- ✅ Shopping cart functionality
- ✅ Order management system
- ✅ User management
- ✅ Team member management with photos
- ✅ Review system
- ✅ WhatsApp integration
- ✅ Admin dashboard
- ✅ Mobile optimized

## 🆘 Need Help?
1. Check the main README.md for detailed steps
2. Contact your hosting provider for technical support
3. Ensure PHP 8.1+ and MySQL are available

---

**🎉 Your zinlink tech website is ready to go live!**
EOF

# Step 6: Create a simple deployment script
print_status "Creating deployment script..."
cat > deployment_package/deploy.sh << 'EOF'
#!/bin/bash
echo "🚀 Deploying Zinlink Tech to cPanel..."

# Check if we're in the right directory
if [ ! -f "index.html" ]; then
    echo "❌ Error: index.html not found. Make sure you're in the public_html directory."
    exit 1
fi

# Set up backend
if [ -d "api" ]; then
    echo "📦 Setting up backend..."
    cd api
    
    # Create .env if it doesn't exist
    if [ ! -f ".env" ]; then
        cp .env.example .env
        echo "⚠️  Please update .env file with your database credentials!"
    fi
    
    # Set permissions
    chmod -R 755 storage/
    chmod -R 755 bootstrap/cache/
    
    # Generate app key
    php artisan key:generate
    
    # Create storage link
    php artisan storage:link
    
    echo "✅ Backend setup complete!"
    cd ..
else
    echo "❌ Error: api directory not found!"
    exit 1
fi

echo "🎉 Deployment complete!"
echo "🌐 Your website should be accessible at your domain"
echo "🔑 Admin panel: yourdomain.com/api/admin"
echo "📧 Admin login: admin@zinlinktech.com / admin123"
EOF

chmod +x deployment_package/deploy.sh

# Step 7: Create a zip file
print_status "Creating deployment zip file..."
zip -r zinlink-tech-deployment.zip deployment_package/

# Step 8: Clean up
rm -rf deployment_package

print_success "🎉 Deployment package created successfully!"
echo ""
echo "📦 Files created:"
echo "   - zinlink-tech-deployment.zip (Ready for upload)"
echo "   - DEPLOYMENT_INSTRUCTIONS.md (Deployment guide)"
echo ""
echo "📋 Next steps:"
echo "   1. Upload zinlink-tech-deployment.zip to your cPanel"
echo "   2. Extract the zip file in public_html"
echo "   3. Follow the DEPLOYMENT_INSTRUCTIONS.md"
echo ""
echo "🌐 Your website will be live at your domain!"
echo "🔑 Admin panel: yourdomain.com/api/admin"
echo "📧 Admin login: admin@zinlinktech.com / admin123"
echo ""
print_warning "⚠️  Remember to change the admin password after deployment!" 