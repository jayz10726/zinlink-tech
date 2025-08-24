# 🚀 Zinlink Tech - Truehost Deployment Guide

## 📋 Truehost-Specific Setup

### Step 1: Access Truehost cPanel
1. **Go to**: `https://yourdomain.com/cpanel`
2. **Login** with your Truehost credentials
3. **Look for** database management tools

### Step 2: Find Database Management
**Look for these in your cPanel:**
- "MySQL Databases" 
- "MariaDB Databases"
- "Databases" section
- "phpMyAdmin"
- "Database Wizard"

### Step 3: Create Database (if available)
1. **Click** on database management tool
2. **Create** new database
3. **Create** database user
4. **Assign** user to database

### Step 4: Upload Files
1. **Open** File Manager
2. **Navigate** to `public_html`
3. **Upload** `zinlink-tech-complete-deployment.zip`
4. **Extract** the files

### Step 5: Configure Database
1. **Edit** `public_html/api/.env` file
2. **Update** database credentials
3. **Save** the file

### Step 6: Run Setup Commands
1. **Open** Terminal/SSH
2. **Run** deployment script
3. **Set** file permissions

## 🔧 Truehost-Specific Troubleshooting

### If no database option available:
1. **Check** your hosting plan
2. **Contact** Truehost support
3. **Upgrade** plan if needed

### If Terminal not available:
1. **Use** File Manager to edit files
2. **Contact** Truehost for SSH access
3. **Use** alternative deployment methods

## 📞 Truehost Support
- **Email**: support@truehost.co.ke
- **Phone**: Check Truehost website
- **Live Chat**: Available on Truehost website

## 🎯 Quick Setup Commands
```bash
cd public_html
chmod +x QUICK_DEPLOY.sh
./QUICK_DEPLOY.sh
```

## ✅ Success Checklist
- [ ] Files uploaded to public_html
- [ ] Database created and configured
- [ ] .env file updated
- [ ] Deployment script run
- [ ] Website accessible at yourdomain.com
- [ ] Admin panel working at yourdomain.com/api/admin 