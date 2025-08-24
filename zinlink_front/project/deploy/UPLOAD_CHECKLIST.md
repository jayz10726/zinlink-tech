# 📋 cPanel Upload Checklist

## 🗂️ File Upload Order

### 1. Frontend Files (public_html/)
Upload these files to your `public_html/` directory:
- [ ] index.html
- [ ] favicon.svg
- [ ] assets/ (entire folder)
- [ ] images/ (entire folder)
- [ ] .htaccess

### 2. Backend Files (public_html/api/)
Upload these files to your `public_html/api/` directory:
- [ ] app/ (entire folder)
- [ ] bootstrap/ (entire folder)
- [ ] config/ (entire folder)
- [ ] database/ (entire folder)
- [ ] resources/ (entire folder)
- [ ] routes/ (entire folder)
- [ ] storage/ (entire folder)
- [ ] vendor/ (entire folder)
- [ ] public/ (entire folder)
- [ ] artisan
- [ ] composer.json
- [ ] composer.lock

## ⚙️ Configuration Steps

### 1. Database Setup
- [ ] Create MySQL database in cPanel
- [ ] Create database user
- [ ] Assign user to database

### 2. Environment Configuration
- [ ] Rename `.env.example` to `.env`
- [ ] Update database credentials
- [ ] Set APP_URL to your domain

### 3. Laravel Setup
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan migrate`
- [ ] Run `php artisan db:seed`
- [ ] Run `php artisan storage:link`

### 4. File Permissions
- [ ] Set storage/ permissions to 755
- [ ] Set bootstrap/cache/ permissions to 755

### 5. Security
- [ ] Change admin password
- [ ] Enable SSL certificate
- [ ] Test all URLs

## 🌐 Test URLs

- [ ] Frontend: `https://yourdomain.com`
- [ ] API: `https://yourdomain.com/api/products`
- [ ] Admin: `https://yourdomain.com/api/admin`

## 🔑 Admin Login

- Email: `admin@zinlinktech.com`
- Password: `admin123` (change immediately!)

---

**✅ All items checked? Your site should be live!** 