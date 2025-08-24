# 🚀 Zinlink Tech - Complete E-commerce Solution

A modern, full-stack e-commerce platform built with React frontend and Laravel backend.

## ✨ Features

- 🛍️ **Modern E-commerce Frontend** - React with Tailwind CSS
- 🔧 **Powerful Admin Panel** - Laravel backend with full CRUD operations
- 📱 **Mobile Responsive** - Works perfectly on all devices
- 🛒 **Shopping Cart** - Full cart functionality with persistence
- 👥 **Team Management** - Add and manage team members
- 📦 **Product Management** - Complete product catalog system
- ⭐ **Review System** - Customer reviews and ratings
- 📞 **WhatsApp Integration** - Direct customer communication
- 🔐 **User Authentication** - Secure login system
- 📊 **Order Management** - Complete order tracking

## 🛠️ Tech Stack

### Frontend
- **React 18** - Modern UI framework
- **TypeScript** - Type-safe development
- **Tailwind CSS** - Utility-first styling
- **Vite** - Fast build tool
- **React Router** - Client-side routing

### Backend
- **Laravel 10** - PHP framework
- **MySQL** - Database
- **Eloquent ORM** - Database management
- **RESTful API** - Clean API design

## 🚀 Quick Start

### Prerequisites
- Node.js 18+
- PHP 8.1+
- Composer
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

## 🌐 Live Demo

- **Website**: [Your Domain]
- **Admin Panel**: [Your Domain]/api/admin
- **API**: [Your Domain]/api

## 🔑 Admin Access

- **Email**: admin@zinlinktech.com
- **Password**: admin123

⚠️ **Change password immediately after deployment!**

## 📁 Project Structure

```
zinlink-tech/
├── zinlink_front/project/     # React frontend
│   ├── src/
│   │   ├── components/        # React components
│   │   ├── pages/            # Page components
│   │   ├── services/         # API services
│   │   └── types/            # TypeScript types
│   └── public/               # Static assets
├── admin_zinlink/            # Laravel backend
│   ├── app/
│   │   ├── Http/Controllers/ # API controllers
│   │   ├── Models/           # Eloquent models
│   │   └── Providers/        # Service providers
│   ├── database/
│   │   ├── migrations/       # Database migrations
│   │   └── seeders/          # Database seeders
│   └── resources/views/      # Blade templates
└── docs/                     # Documentation
```

## 🚀 Deployment

### GitHub Actions (Recommended)
This repository includes automated deployment to Truehost cPanel via GitHub Actions.

**Status**: Ready for deployment! 🚀

### Manual Deployment
See `DEPLOYMENT_GUIDE.md` for detailed manual deployment instructions.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## 📄 License

This project is licensed under the MIT License.

## 🆘 Support

For support, email support@zinlinktech.com or create an issue in this repository.

---

**Built with ❤️ by Zinlink Tech Team**
