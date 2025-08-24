# 🚀 GitHub Setup & Deployment Guide

## 📋 Step-by-Step GitHub Setup

### Step 1: Create GitHub Repository

1. **Go to GitHub.com** and sign in
2. **Click** "New repository" (green button)
3. **Repository name**: `zinlink-tech`
4. **Description**: `Modern e-commerce platform with React frontend and Laravel backend`
5. **Visibility**: Choose Public or Private
6. **Don't initialize** with README (we already have one)
7. **Click** "Create repository"

### Step 2: Initialize Local Git Repository

```bash
# Navigate to your project directory
cd "/home/onyangozeddy/Desktop/zinlink poject"

# Initialize git repository
git init

# Add all files
git add .

# Create initial commit
git commit -m "Initial commit: Zinlink Tech e-commerce platform"

# Add GitHub remote (replace YOUR_USERNAME with your GitHub username)
git remote add origin https://github.com/YOUR_USERNAME/zinlink-tech.git

# Push to GitHub
git branch -M main
git push -u origin main
```

### Step 3: Set Up GitHub Secrets

1. **Go to your repository** on GitHub
2. **Click** "Settings" tab
3. **Click** "Secrets and variables" → "Actions"
4. **Click** "New repository secret"
5. **Add these secrets**:

#### Required Secrets:
```
TRUEHOST_HOST = your-domain.com
TRUEHOST_USERNAME = your-cpanel-username
TRUEHOST_PASSWORD = your-cpanel-password
TRUEHOST_PORT = 22
```

### Step 4: Configure Database

1. **Log into Truehost cPanel**
2. **Find database management** (MySQL/MariaDB)
3. **Create database** and user
4. **Update** `admin_zinlink/.env.example` with your database details

### Step 5: Test Deployment

1. **Make a small change** to any file
2. **Commit and push**:
```bash
git add .
git commit -m "Test deployment"
git push
```
3. **Check GitHub Actions** tab for deployment status

## 🔧 GitHub Actions Workflow

The workflow will automatically:
- ✅ Build the React frontend
- ✅ Install Laravel dependencies
- ✅ Deploy to Truehost
- ✅ Run database migrations
- ✅ Set proper permissions

## 📁 Repository Structure

```
zinlink-tech/
├── .github/workflows/     # GitHub Actions
├── zinlink_front/         # React frontend
├── admin_zinlink/         # Laravel backend
├── README.md             # Project documentation
├── .gitignore           # Git ignore rules
└── GITHUB_SETUP_GUIDE.md # This guide
```

## 🚀 Deployment Process

### Automatic Deployment
- **Trigger**: Push to main branch
- **Build**: Frontend and backend
- **Deploy**: To Truehost cPanel
- **Setup**: Database and permissions

### Manual Deployment
- **Go to** GitHub repository
- **Click** "Actions" tab
- **Click** "Deploy to Truehost"
- **Click** "Run workflow"

## 🔑 Admin Access After Deployment

- **URL**: `https://yourdomain.com/api/admin`
- **Email**: `admin@zinlinktech.com`
- **Password**: `admin123`

⚠️ **Change password immediately!**

## 🆘 Troubleshooting

### If deployment fails:
1. **Check** GitHub Actions logs
2. **Verify** Truehost credentials
3. **Ensure** database is accessible
4. **Check** file permissions

### If website doesn't load:
1. **Verify** domain DNS settings
2. **Check** cPanel file manager
3. **Review** error logs
4. **Test** API endpoints

## 📞 Support

- **GitHub Issues**: Create issue in repository
- **Truehost Support**: Contact hosting provider
- **Documentation**: Check README.md

---

**🎉 Your Zinlink Tech website will be live after following these steps!** 