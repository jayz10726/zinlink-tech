# 🚀 Zinlink Tech - Deployment Guide for Truehost cPanel

## 📋 Prerequisites

- Truehost cPanel hosting account
- Domain name (optional but recommended)
- GitHub account
- Node.js installed locally (for building)

## 🎯 Step-by-Step Deployment

### Step 1: Prepare Your Local Project

1. **Build the Frontend:**
   ```bash
   cd zinlink_front/project
   npm install
   npm run build
   ```

2. **Build the Backend:**
   ```bash
   cd admin_zinlink
   composer install --optimize-autoloader --no-dev
   ```

### Step 2: Upload to GitHub

1. **Create a new GitHub repository**
2. **Push your code:**
   ```bash
   git init
   git add .
   git commit -m "Initial commit - Zinlink Tech website"
   git branch -M main
   git remote add origin https://github.com/yourusername/zinlink-tech.git
   git push -u origin main
```

### Step 3: Deploy Backend to cPanel

1. **Access your cPanel**
2. **Go to File Manager**
3. **Navigate to public_html**
4. **Create a folder called `api`**
5. **Upload all backend files to the `api` folder:**
   - All Laravel files from `admin_zinlink/`
   - Exclude `node_modules/` and `vendor/` (will be installed on server)

### Step 4: Configure Backend

1. **Create `.env` file in the api folder:**
   ```env
   APP_NAME="Zinlink Tech"
   APP_ENV=production
   APP_KEY=your-app-key
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

2. **Set up database:**
   - Create MySQL database in cPanel
   - Run migrations: `php artisan migrate`
   - Seed data: `php artisan db:seed`

3. **Set permissions:**
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

4. **Generate app key:**
   ```bash
   php artisan key:generate
   ```

5. **Create storage link:**
   ```bash
   php artisan storage:link
   ```

### Step 5: Deploy Frontend

1. **Upload frontend build files:**
   - Upload contents of `zinlink_front/project/dist/` to `public_html/`
   - This includes `index.html`, `assets/` folder, etc.

2. **Create `.htaccess` file in public_html:**
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

### Step 6: Update API Configuration

1. **Update the API base URL in your frontend:**
   - Edit `src/config/production.ts`
   - Change `API_BASE_URL` to your actual domain

2. **Rebuild frontend:**
   ```bash
   npm run build
   ```

3. **Re-upload the new build files**

### Step 7: Final Configuration

1. **Set up domain (if using custom domain):**
   - Point domain to your hosting
   - Configure DNS settings

2. **Test your website:**
   - Frontend: `https://yourdomain.com`
   - Admin panel: `https://yourdomain.com/api/admin`
   - API: `https://yourdomain.com/api`

## 🔧 Troubleshooting

### Common Issues:

1. **500 Server Error:**
   - Check `.env` file configuration
   - Verify database credentials
   - Check file permissions

2. **404 Not Found:**
   - Ensure `.htaccess` file is uploaded
   - Check if mod_rewrite is enabled
   - Verify file paths

3. **API Not Working:**
   - Check API base URL in frontend
   - Verify backend is accessible
   - Check CORS settings

### Support:

- **Truehost Support:** Contact Truehost support for hosting issues
- **Technical Issues:** Check Laravel and React documentation

## 🎉 Success!

Your Zinlink Tech website should now be live at:
- **Website:** https://yourdomain.com
- **Admin Panel:** https://yourdomain.com/api/admin
- **API:** https://yourdomain.com/api

## 📞 Admin Access

- **Email:** admin@zinlinktech.com
- **Password:** admin123
- **⚠️ Remember to change the password!** 