#!/bin/bash

# Zinlink Tech Frontend Deployment Script
echo "🚀 Starting Zinlink Tech Frontend Deployment..."

# Build the project
echo "📦 Building the project..."
npm run build

# Check if build was successful
if [ $? -eq 0 ]; then
    echo "✅ Build completed successfully!"
    echo "📁 Build files are in the 'dist' directory"
    echo ""
    echo "📋 Next steps for cPanel deployment:"
    echo "1. Upload the contents of 'dist' folder to your cPanel public_html directory"
    echo "2. Make sure your domain points to the public_html folder"
    echo "3. Update your backend API URL in the production environment"
echo ""
    echo "🌐 Your website will be available at your domain"
else
    echo "❌ Build failed! Please check the error messages above."
    exit 1
fi 