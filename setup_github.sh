#!/bin/bash

echo "🚀 Zinlink Tech - GitHub Setup Script"
echo "====================================="
echo ""

# Check if git is installed
if ! command -v git &> /dev/null; then
    echo "❌ Git is not installed. Please install git first."
    exit 1
fi

# Check if we're in the right directory
if [ ! -f "README.md" ]; then
    echo "❌ README.md not found. Make sure you're in the project root directory."
    exit 1
fi

echo "📋 GitHub Repository Setup Steps:"
echo ""
echo "1. 🌐 Go to https://github.com and sign in"
echo "2. 📝 Click 'New repository' (green button)"
echo "3. 📛 Repository name: zinlink-tech"
echo "4. 📄 Description: Modern e-commerce platform with React frontend and Laravel backend"
echo "5. 🔒 Visibility: Choose Public or Private"
echo "6. ❌ Don't initialize with README (we already have one)"
echo "7. ✅ Click 'Create repository'"
echo ""
echo "8. 🔗 Copy the repository URL (it will look like: https://github.com/YOUR_USERNAME/zinlink-tech.git)"
echo ""

# Get GitHub username
read -p "Enter your GitHub username: " github_username

if [ -z "$github_username" ]; then
    echo "❌ GitHub username is required."
    exit 1
fi

# Set up remote
echo "🔗 Setting up GitHub remote..."
git remote add origin https://github.com/$github_username/zinlink-tech.git

# Rename branch to main
echo "🌿 Renaming branch to main..."
git branch -M main

# Push to GitHub
echo "📤 Pushing to GitHub..."
git push -u origin main

echo ""
echo "✅ GitHub repository setup complete!"
echo ""
echo "🔧 Next Steps:"
echo "1. Go to https://github.com/$github_username/zinlink-tech"
echo "2. Click 'Settings' tab"
echo "3. Click 'Secrets and variables' → 'Actions'"
echo "4. Add these secrets:"
echo "   - TRUEHOST_HOST = your-domain.com"
echo "   - TRUEHOST_USERNAME = your-cpanel-username"
echo "   - TRUEHOST_PASSWORD = your-cpanel-password"
echo "   - TRUEHOST_PORT = 22"
echo ""
echo "5. Make a test change and push to trigger deployment:"
echo "   git add ."
echo "   git commit -m 'Test deployment'"
echo "   git push"
echo ""
echo "🎉 Your Zinlink Tech project is now on GitHub!" 