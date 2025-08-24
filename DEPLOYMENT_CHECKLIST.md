# ✅ Zinlink Tech - Deployment Checklist

## 🎯 Pre-Deployment Checklist

### ✅ Local Setup
- [ ] Frontend builds successfully (`npm run build`)
- [ ] Backend runs without errors
- [ ] All team members added with photos
- [ ] Products added to catalog
- [ ] Admin panel accessible
- [ ] API endpoints working

### ✅ GitHub Repository
- [ ] Code pushed to GitHub
- [ ] Repository is public or private (your choice)
- [ ] README.md is complete
- [ ] .gitignore files are configured

## 🚀 Deployment Steps

### Step 1: Truehost cPanel Setup
- [ ] Login to Truehost cPanel
- [ ] Note down your domain name
- [ ] Create MySQL database
- [ ] Note database credentials

### Step 2: Build Project
```bash
# Frontend
cd zinlink_front/project
npm install
npm run build

# Backend
cd admin_zinlink
composer install --optimize-autoloader --no-dev
```

### Step 3: Upload Files
- [ ] Upload `zinlink_front/project/dist/` contents to `public_html/`
- [ ] Upload `admin_zinlink/` contents to `public_html/api/`
- [ ] Create `.htaccess` file in `public_html/`

### Step 4: Configure Backend
- [ ] Create `.env` file in `public_html/api/`
- [ ] Update database credentials
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Update `APP_URL` to your domain

### Step 5: Database Setup
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan db:seed`
- [ ] Set file permissions
- [ ] Create storage link

### Step 6: Test Everything
- [ ] Frontend loads at your domain
- [ ] Admin panel accessible at `/api/admin`
- [ ] API endpoints working
- [ ] Team members display with photos
- [ ] Products show correctly

## 🔧 Configuration Files

### Frontend .htaccess (public_html/.htaccess)
```apache
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /
  RewriteRule ^index\.html$ - [L]
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule . /index.html [L]
</IfModule>
```

### Backend .env (public_html/api/.env)
```env
APP_NAME="Zinlink Tech"
APP_ENV=production
APP_KEY=your-generated-key
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
```

## 🎉 Post-Deployment

### ✅ Final Checks
- [ ] Website loads correctly
- [ ] All images display properly
- [ ] Contact forms work
- [ ] WhatsApp integration works
- [ ] Admin panel accessible
- [ ] Team members show with photos
- [ ] Products display correctly

### 🔒 Security
- [ ] Change admin password
- [ ] Enable HTTPS (SSL certificate)
- [ ] Set proper file permissions
- [ ] Remove development files

### 📊 Performance
- [ ] Enable Gzip compression
- [ ] Set up browser caching
- [ ] Optimize images
- [ ] Test mobile responsiveness

## 🆘 Troubleshooting

### Common Issues
- **500 Error**: Check `.env` file and permissions
- **404 Error**: Verify `.htaccess` file and mod_rewrite
- **Database Error**: Check database credentials
- **Images Not Loading**: Verify storage link and permissions

### Support
- **Truehost Support**: For hosting issues
- **Documentation**: Check deployment guide
- **Logs**: Check Laravel logs in `storage/logs/`

## 📞 Contact Information

- **Website**: https://yourdomain.com
- **Admin Panel**: https://yourdomain.com/api/admin
- **Email**: info@zinlinktech.com
- **WhatsApp**: +254 706 850 126

---

**🎉 Congratulations! Your Zinlink Tech website is now live!** 