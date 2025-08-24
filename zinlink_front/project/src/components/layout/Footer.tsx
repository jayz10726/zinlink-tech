import { Link } from 'react-router-dom';
import { Laptop, Mail, Phone, MapPin, Facebook, Twitter, Instagram, Linkedin } from 'lucide-react';

const Footer = () => {
  const currentYear = new Date().getFullYear();
  
  return (
    <footer className="bg-primary-900 text-white pt-16 pb-8 dark:bg-gray-950 dark:text-gray-100">
      <div className="container">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
          {/* Company Info */}
          <div>
            <div className="flex items-center space-x-2 mb-4">
              <Laptop className="w-6 h-6 text-secondary-500" />
              <span className="text-2xl font-extrabold bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent drop-shadow-lg tracking-tight font-display">
                <span className="pr-1">zinlink</span><span className="text-white bg-black/30 px-2 py-0.5 rounded-lg ml-1 shadow-md">tech</span>
              </span>
            </div>
            <p className="text-gray-300 mb-4 dark:text-gray-400">
              Your premium destination for cutting-edge laptops and tech accessories.
              We bring you the best technology with exceptional service.
            </p>
            <div className="flex space-x-4">
              <a href="#" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                <Facebook className="w-5 h-5" />
              </a>
              <a href="#" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                <Twitter className="w-5 h-5" />
              </a>
              <a href="#" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                <Instagram className="w-5 h-5" />
              </a>
              <a href="#" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                <Linkedin className="w-5 h-5" />
              </a>
            </div>
          </div>
          
          {/* Quick Links */}
          <div>
            <h4 className="text-lg font-semibold mb-4 text-white dark:text-gray-100">Quick Links</h4>
            <ul className="space-y-2">
              <li>
                <Link to="/" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  Home
                </Link>
              </li>
              <li>
                <Link to="/products" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  Shop
                </Link>
              </li>
              <li>
                <Link to="/products" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  New Arrivals
                </Link>
              </li>
              <li>
                <Link to="/products" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  Special Offers
                </Link>
              </li>
              <li>
                <Link to="/contact" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  Contact Us
                </Link>
              </li>
            </ul>
          </div>
          
          {/* Categories */}
          <div>
            <h4 className="text-lg font-semibold mb-4 text-white dark:text-gray-100">Categories</h4>
            <ul className="space-y-2">
              <li>
                <Link to="/products" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  Gaming Laptops
                </Link>
              </li>
              <li>
                <Link to="/products" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  Business Laptops
                </Link>
              </li>
              <li>
                <Link to="/products" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  Ultrabooks
                </Link>
              </li>
              <li>
                <Link to="/products" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  2-in-1 Laptops
                </Link>
              </li>
              <li>
                <Link to="/products" className="text-gray-300 hover:text-secondary-500 transition-colors dark:text-gray-400 dark:hover:text-secondary-400">
                  Accessories
                </Link>
              </li>
            </ul>
          </div>
          
          {/* Contact */}
          <div>
            <h4 className="text-lg font-semibold mb-4 text-white dark:text-gray-100">Contact Us</h4>
            <ul className="space-y-3">
              <li className="flex items-start">
                <MapPin className="w-5 h-5 text-secondary-500 mt-0.5 mr-2 flex-shrink-0" />
                <span className="text-gray-300 dark:text-gray-400">
                  Tivoli centre  shop 1 c
                </span>
              </li>
              <li className="flex items-center">
                <Phone className="w-5 h-5 text-secondary-500 mr-2 flex-shrink-0" />
                <span className="text-gray-300 dark:text-gray-400">0746049506</span>
              </li>
              <li className="flex items-center">
                <Mail className="w-5 h-5 text-secondary-500 mr-2 flex-shrink-0" />
                <span className="text-gray-300 dark:text-gray-400">support@zinlink techs.com</span>
              </li>
            </ul>
          </div>
        </div>
        
        {/* Newsletter */}
        <div className="border-t border-gray-800 pt-8 pb-6 dark:border-gray-700">
          <div className="max-w-2xl mx-auto text-center mb-8">
            <h4 className="text-lg font-semibold mb-2 text-white dark:text-gray-100">Subscribe to Our Newsletter</h4>
            <p className="text-gray-300 mb-4 dark:text-gray-400">
              Stay updated with our latest products and exclusive offers.
            </p>
            <form className="flex flex-col sm:flex-row gap-2 max-w-md mx-auto">
              <input
                type="email"
                placeholder="Your email address"
                className="input text-gray-900 flex-grow dark:bg-gray-800 dark:text-gray-100"
                required
              />
              <button 
                type="submit" 
                className="btn-secondary whitespace-nowrap"
              >
                Subscribe
              </button>
            </form>
          </div>
        </div>
        
        {/* Copyright */}
        <div className="border-t border-gray-800 pt-6 text-center dark:border-gray-700">
          <p className="text-gray-400 text-sm dark:text-gray-500">
            &copy; {currentYear} zinlink techs. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;