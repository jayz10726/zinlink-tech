# 🚀 Zinlink Tech - cPanel Deployment Instructions

## 📦 Files Ready for Upload

Your deployment files are ready in the `deploy/` directory:

- `frontend/` - React application files
- `backend/` - Laravel API files

## 🌐 Step 1: cPanel Setup

### 1.1 Create Database
1. Login to cPanel
2. Go to "MySQL Databases"
3. Create a new database (e.g., `yourdomain_zinlink`)
4. Create a database user
5. Assign user to database with all privileges

### 1.2 Upload Files

#### Frontend (Main Website)
1. Go to File Manager in cPanel
2. Navigate to `public_html/`
3. Upload all files from `deploy/frontend/` to `public_html/`

#### Backend (API)
1. Create folder `api` in `public_html/`
2. Upload all files from `deploy/backend/` to `public_html/api/`

## ⚙️ Step 2: Laravel Configuration

### 2.1 Environment Setup
1. In `public_html/api/`, rename `.env.example` to `.env`
2. Update the `.env` file with your database credentials:

```env
APP_NAME="zinlink tech"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://yourdomain.com/api

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourdomain_zinlink
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 2.2 Laravel Commands
Run these commands via SSH or cPanel Terminal:

```bash
cd public_html/api

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Create storage link
php artisan storage:link

# Set file permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

## 🔧 Step 3: File Permissions

Set these permissions via File Manager or SSH:

```bash
# Laravel directories
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# All files
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
```

## 🌐 Step 4: Domain Configuration

### Option A: Subdomain Setup (Recommended)
1. Create subdomain `api.yourdomain.com`
2. Point it to `public_html/api/public/`
3. Update frontend API URL to `https://api.yourdomain.com`

### Option B: Subdirectory Setup
1. Keep Laravel in `public_html/api/`
2. Frontend will call `/api/` endpoints

## 🔒 Step 5: Security Setup

### 5.1 Admin Password
After deployment, change the admin password:

```bash
php artisan tinker
$admin = App\Models\User::where('email', 'admin@zinlinktech.com')->first();
$admin->password = Hash::make('your-secure-password');
$admin->save();
```

### 5.2 SSL Certificate
1. Install SSL certificate in cPanel
2. Force HTTPS redirects
3. Update all URLs to use HTTPS

## 🧪 Step 6: Testing

### 6.1 Test URLs
- **Frontend**: `https://yourdomain.com`
- **API**: `https://yourdomain.com/api/products`
- **Admin**: `https://yourdomain.com/api/admin`

### 6.2 Admin Login
- Email: `admin@zinlinktech.com`
- Password: `admin123` (change immediately!)

## 🔧 Step 7: Troubleshooting

### Common Issues

#### 500 Internal Server Error
- Check file permissions
- Verify .htaccess syntax
- Check PHP version (8.1+ required)

#### Database Connection Error
- Verify database credentials in `.env`
- Check database host settings
- Ensure database exists

#### API Not Working
- Check API URL configuration
- Verify CORS settings
- Check Laravel logs in `storage/logs/`

#### Images Not Loading
- Verify storage link exists
- Check file permissions
- Ensure correct file paths

### Log Files
- Laravel logs: `storage/logs/laravel.log`
- Apache logs: cPanel → Error Logs
- PHP logs: cPanel → Error Logs

## 📱 Step 8: Performance Optimization

### 8.1 Enable Caching
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8.2 Gzip Compression
Already configured in .htaccess files

### 8.3 Browser Caching
Already configured in .htaccess files

## 🔄 Step 9: Maintenance

### Regular Tasks
- Backup database weekly
- Update Laravel monthly
- Monitor error logs
- Check SSL certificate expiry

### Performance Monitoring
- Use cPanel's Resource Usage
- Monitor database performance
- Check page load times

## 📞 Support

For technical support:
- Check Laravel documentation
- Review cPanel documentation
- Contact hosting provider

---

## 🎉 Success Checklist

- [ ] Database created and configured
- [ ] Files uploaded to correct directories
- [ ] .env file configured with database credentials
- [ ] Laravel commands executed successfully
- [ ] File permissions set correctly
- [ ] SSL certificate installed
- [ ] Admin password changed
- [ ] Frontend accessible at domain
- [ ] API endpoints working
- [ ] Admin panel accessible

**🎉 Congratulations! Your zinlink tech application is now live!** 