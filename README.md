# 🚀 Zinlink Tech - Professional Computer Solutions

A modern, responsive website for Zinlink Tech, a computer solutions company in Kisumu City, Kenya. Built with React frontend and Laravel backend.

## 🌟 Features

### Frontend (React + TypeScript)
- ✅ **Modern, responsive design**
- ✅ **Product catalog** with filtering and search
- ✅ **Shopping cart** functionality
- ✅ **Team member showcase** with photos
- ✅ **Contact forms** and WhatsApp integration
- ✅ **Admin panel** for content management
- ✅ **Mobile-optimized** interface

### Backend (Laravel)
- ✅ **RESTful API** for frontend
- ✅ **Admin dashboard** for content management
- ✅ **Product management** system
- ✅ **Team member management** with photo uploads
- ✅ **Order management** system
- ✅ **User authentication** and authorization
- ✅ **Image management** system

## 🛠️ Tech Stack

### Frontend
- **React 18** with TypeScript
- **Vite** for build tooling
- **Tailwind CSS** for styling
- **React Router** for navigation
- **Lucide React** for icons

### Backend
- **Laravel 10** with PHP 8.1+
- **MySQL** database
- **File storage** for images
- **RESTful API** architecture

## 📦 Installation

### Prerequisites
- Node.js 18+ and npm
- PHP 8.1+ and Composer
- MySQL 8.0+

### Frontend Setup
```bash
cd zinlink_front/project
npm install
npm run dev
```

### Backend Setup
```bash
cd admin_zinlink
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

## 🚀 Deployment

### Quick Deployment to Truehost cPanel

1. **Build the project:**
   ```bash
   # Frontend
   cd zinlink_front/project
   npm run build
   
   # Backend
   cd admin_zinlink
   composer install --optimize-autoloader --no-dev
   ```

2. **Upload to cPanel:**
   - Upload `zinlink_front/project/dist/` contents to `public_html/`
   - Upload `admin_zinlink/` contents to `public_html/api/`

3. **Configure environment:**
   - Set up database in cPanel
   - Update `.env` file with production settings
   - Run `php artisan migrate` and `php artisan db:seed`

4. **Set permissions:**
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   php artisan storage:link
   ```

## 📁 Project Structure

```
zinlink-tech/
├── zinlink_front/project/     # React frontend
│   ├── src/
│   │   ├── components/        # React components
│   │   ├── pages/            # Page components
│   │   ├── services/         # API services
│   │   └── types/            # TypeScript types
│   ├── public/               # Static assets
│   └── dist/                 # Build output
├── admin_zinlink/            # Laravel backend
│   ├── app/
│   │   ├── Http/Controllers/ # API controllers
│   │   └── Models/           # Eloquent models
│   ├── database/
│   │   ├── migrations/       # Database migrations
│   │   └── seeders/          # Database seeders
│   ├── resources/views/      # Admin views
│   └── routes/               # API routes
└── docs/                     # Documentation
```

## 🔧 Configuration

### Environment Variables

#### Frontend (.env)
```env
VITE_API_BASE_URL=http://localhost:8000/api
```

#### Backend (.env)
```env
APP_NAME="Zinlink Tech"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 👥 Admin Access

- **URL:** `/admin` or `/api/admin`
- **Email:** `admin@zinlinktech.com`
- **Password:** `admin123`

⚠️ **Important:** Change the default password after first login!

## 📱 Features Overview

### For Customers
- Browse products by category
- Search and filter products
- Add items to cart
- Contact via WhatsApp
- View team members
- Read reviews

### For Administrators
- Manage products (add, edit, delete)
- Upload product images
- Manage team members with photos
- Handle orders
- Manage user reviews
- Update site content

## 🔒 Security Features

- CSRF protection
- SQL injection prevention
- XSS protection
- File upload validation
- Secure authentication
- HTTPS enforcement

## 📊 Performance

- Optimized images
- Lazy loading
- Code splitting
- Gzip compression
- Browser caching
- CDN ready

## 🆘 Support

For technical support:
- Check the [Deployment Guide](zinlink_front/project/DEPLOYMENT_GUIDE.md)
- Review Laravel and React documentation
- Contact your hosting provider

## 📄 License

This project is proprietary software for Zinlink Tech.

## 🎉 Credits

Built with ❤️ for Zinlink Tech - Professional Computer Solutions in Kisumu City, Kenya.

---

**🌐 Live Demo:** [Your Domain Here]
**📧 Contact:** info@zinlinktech.com
**📱 WhatsApp:** +254 706 850 126 