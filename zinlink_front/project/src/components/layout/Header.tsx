import { useState, useEffect } from 'react';
import { Link, NavLink, useLocation } from 'react-router-dom';
import { Laptop, ShoppingCart, Menu, X, Search, Home, Package, Phone, Settings, Star, Info, Lock } from 'lucide-react';
import { useCart } from '../../context/CartContext';

const Header = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isScrolled, setIsScrolled] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const [showPasswordModal, setShowPasswordModal] = useState(false);
  const [adminPassword, setAdminPassword] = useState('');
  const [passwordError, setPasswordError] = useState('');
  const { cart, getCartItemCount, getCartTotal } = useCart();
  const location = useLocation();
  
  const totalItems = getCartItemCount();

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 10) {
        setIsScrolled(true);
      } else {
        setIsScrolled(false);
      }
    };

    window.addEventListener('scroll', handleScroll);
    return () => {
      window.removeEventListener('scroll', handleScroll);
    };
  }, []);

  // Close mobile menu when route changes
  useEffect(() => {
    setIsMenuOpen(false);
  }, [location.pathname]);

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen);
  };

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    // Implement search functionality
    console.log('Searching for:', searchQuery);
  };

  // Check if current page is admin
  const [isAdminPage, setIsAdminPage] = useState(false);

  useEffect(() => {
    const checkAdminPage = () => {
      const isAdmin = window.location.hostname === 'localhost' && 
                     window.location.port === '8000' &&
                     window.location.pathname.startsWith('/admin');
      setIsAdminPage(isAdmin);
    };

    checkAdminPage();
    // Check again when window location changes
    window.addEventListener('popstate', checkAdminPage);
    return () => window.removeEventListener('popstate', checkAdminPage);
  }, []);

  // Handle admin button click - show password modal
  const handleAdminClick = (e: React.MouseEvent) => {
    e.preventDefault();
    setShowPasswordModal(true);
    setAdminPassword('');
    setPasswordError('');
  };

  // Handle password submission
  const handlePasswordSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setPasswordError('');

    try {
      // Send password to backend for verification
      const response = await fetch('http://localhost:8000/api/verify-admin', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ password: adminPassword }),
      });

      if (response.ok) {
        // Password correct - redirect to admin panel
        setShowPasswordModal(false);
        setAdminPassword('');
        window.open('http://localhost:8000/admin', '_blank');
      } else {
        // Password incorrect
        setPasswordError('Incorrect password. Please try again.');
      }
    } catch (error) {
      setPasswordError('Connection error. Please try again.');
    }
  };

  // Close password modal
  const closePasswordModal = () => {
    setShowPasswordModal(false);
    setAdminPassword('');
    setPasswordError('');
  };

  const navLinkClasses = ({ isActive }: { isActive: boolean }) => 
    `flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 ${
      isActive 
        ? 'bg-secondary-600 text-white shadow-lg' 
        : 'text-gray-700 hover:bg-secondary-50 hover:text-secondary-600'
    }`;

  const mobileNavLinkClasses = ({ isActive }: { isActive: boolean }) => 
    `flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition-all duration-300 ${
      isActive 
        ? 'bg-secondary-600 text-white' 
        : 'text-gray-700 hover:bg-secondary-50 hover:text-secondary-600'
    }`;

  const adminLinkClasses = () => 
    `flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 ${
      isAdminPage
        ? 'bg-secondary-600 text-white shadow-lg' 
        : 'text-gray-700 hover:bg-secondary-50 hover:text-secondary-600'
    }`;

  const mobileAdminLinkClasses = () => 
    `flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition-all duration-300 ${
      isAdminPage
        ? 'bg-secondary-600 text-white' 
        : 'text-gray-700 hover:bg-secondary-50 hover:text-secondary-600'
    }`;

  const navItems = [
    { to: '/', label: 'Home', icon: Home },
    { to: '/products', label: 'Products', icon: Package },
    { to: '/about', label: 'About', icon: Info },
    { to: '/contact', label: 'Contact', icon: Phone },
    { to: '/reviews', label: 'Reviews', icon: Star },
  ];

  return (
    <>
    <header 
      className={`sticky top-0 z-50 transition-all duration-300 ${
        isScrolled 
          ? 'bg-white/95 dark:bg-gray-950/95 backdrop-blur-sm shadow-lg py-2' 
          : 'bg-white/90 dark:bg-gray-950/90 backdrop-blur-sm py-4'
      }`}
    >
      <div className="container flex items-center justify-between">
        {/* Logo */}
        <Link to="/" className="flex items-center space-x-2 group">
          <div className="p-2 rounded-lg bg-secondary-600 group-hover:bg-secondary-700 transition-colors duration-300">
              <Laptop className="w-6 w-6 text-white" />
          </div>
          <span className="text-2xl font-extrabold bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent drop-shadow-lg tracking-tight font-display">
            <span className="pr-1">zinlink</span><span className="text-white bg-black/30 px-2 py-0.5 rounded-lg ml-1 shadow-md">tech</span>
          </span>
        </Link>
        
        {/* Desktop Navigation */}
        <nav className="hidden md:flex items-center space-x-2">
            {navItems.map(({ to, label, icon: Icon }) => (
              <NavLink key={to} to={to} className={navLinkClasses}>
                <Icon className="w-4 h-4" />
                <span>{label}</span>
              </NavLink>
            ))}
            
            {/* Admin Button with Lock Icon */}
            <button 
              onClick={handleAdminClick}
              className="flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 text-gray-700 hover:bg-secondary-50 hover:text-secondary-600"
            >
              <Lock className="w-4 h-4" />
              <span>Admin</span>
              {isAdminPage && (
                <span className="ml-1 px-1.5 py-0.5 text-xs bg-green-500 text-white rounded-full animate-pulse">
                  Active
                </span>
              )}
            </button>
        </nav>
        
        {/* Search and Cart */}
        <div className="hidden md:flex items-center space-x-4">
          <form onSubmit={handleSearch} className="relative">
            <input 
              type="text" 
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              placeholder="Search products..." 
              className="py-2 pl-10 pr-4 w-64 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500 transition-all duration-300"
            />
            <Search className="absolute left-3 top-2.5 w-5 h-5 text-gray-400" />
          </form>
          
          {/* Cart Dropdown */}
          <div className="relative group">
            <Link to="/cart" className="relative p-3 rounded-lg hover:bg-secondary-50 transition-all duration-300 group">
              <ShoppingCart className="w-6 h-6 text-gray-700 group-hover:text-secondary-600 transition-colors duration-300" />
              {totalItems > 0 && (
                <span className="absolute -top-1 -right-1 flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-secondary-600 rounded-full animate-pulse">
                  {totalItems}
                </span>
              )}
            </Link>
            
            {/* Cart Preview Dropdown */}
            {cart.length > 0 && (
              <div className="absolute right-0 top-full mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                <div className="p-4">
                  <h3 className="font-semibold text-gray-900 mb-3">Cart Preview</h3>
                  <div className="space-y-3 max-h-64 overflow-y-auto">
                    {cart.slice(0, 3).map((item) => (
                      <div key={item.product.id} className="flex items-center gap-3">
                        <div className="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                          <img
                            src={item.product.image}
                            alt={item.product.name}
                            className="w-full h-full object-cover"
                          />
                        </div>
                        <div className="flex-grow min-w-0">
                          <p className="text-sm font-medium text-gray-900 truncate">
                            {item.product.name}
                          </p>
                          <p className="text-sm text-gray-600">
                            Qty: {item.quantity} × KES {item.product.price.toFixed(0)}
                          </p>
                        </div>
                      </div>
                    ))}
                    {cart.length > 3 && (
                      <p className="text-sm text-gray-600 text-center">
                        +{cart.length - 3} more items
                      </p>
                    )}
                  </div>
                  <div className="border-t border-gray-200 pt-3 mt-3">
                    <div className="flex justify-between items-center mb-3">
                      <span className="font-semibold text-gray-900">Total:</span>
                      <span className="font-semibold text-gray-900">
                        KES {getCartTotal().toFixed(0)}
                      </span>
                    </div>
                    <Link
                      to="/cart"
                      className="block w-full text-center bg-secondary-600 text-white py-2 rounded-lg hover:bg-secondary-700 transition-colors"
                    >
                      View Cart
                    </Link>
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>
        
          {/* Mobile Cart and Menu */}
        <div className="flex md:hidden items-center space-x-2">
          <Link to="/cart" className="relative p-2 rounded-lg hover:bg-secondary-50 transition-all duration-300">
            <ShoppingCart className="w-6 h-6 text-gray-700" />
            {totalItems > 0 && (
              <span className="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-secondary-600 rounded-full animate-pulse">
                {totalItems}
              </span>
            )}
          </Link>
          <button 
            onClick={toggleMenu}
            className="p-2 rounded-lg hover:bg-secondary-50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-secondary-500"
          >
            {isMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>
      </div>
      
      {/* Mobile Menu */}
      {isMenuOpen && (
        <div className="md:hidden bg-white/95 backdrop-blur-sm shadow-lg animate-slide-down border-t border-gray-200">
          <div className="container py-4">
            <form onSubmit={handleSearch} className="mb-4 relative">
              <input 
                type="text" 
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                placeholder="Search products..." 
                className="w-full py-3 pl-10 pr-4 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500"
              />
              <Search className="absolute left-3 top-3.5 w-5 h-5 text-gray-400" />
            </form>
            <nav className="flex flex-col space-y-2">
                {navItems.map(({ to, label, icon: Icon }) => (
                  <NavLink key={to} to={to} className={mobileNavLinkClasses} onClick={toggleMenu}>
                    <Icon className="w-5 h-5" />
                    <span>{label}</span>
                  </NavLink>
                ))}
                
                {/* Mobile Admin Button */}
                <button 
                  onClick={() => {
                    toggleMenu();
                    handleAdminClick({ preventDefault: () => {} } as React.MouseEvent);
                  }}
                  className="flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition-all duration-300 text-gray-700 hover:bg-secondary-50 hover:text-secondary-600"
                >
                  <Lock className="w-5 h-5" />
                  <span>Admin</span>
                  {isAdminPage && (
                    <span className="ml-1 px-1.5 py-0.5 text-xs bg-green-500 text-white rounded-full animate-pulse">
                      Active
                    </span>
                  )}
                </button>
            </nav>
          </div>
        </div>
      )}
    </header>

      {/* Password Modal */}
      {showPasswordModal && (
        <div className="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
          <div className="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full transform transition-all duration-300 scale-100">
            <div className="text-center mb-6">
              <div className="mx-auto w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mb-4">
                <Lock className="w-8 h-8 text-secondary-600" />
              </div>
              <h2 className="text-2xl font-bold text-gray-900 mb-2">Admin Access</h2>
              <p className="text-gray-600">Enter password to access admin panel</p>
            </div>
            
            <form onSubmit={handlePasswordSubmit} className="space-y-4">
              <div>
                <label htmlFor="adminPassword" className="block text-sm font-medium text-gray-700 mb-2">
                  Password
                </label>
                <input
                  type="password"
                  id="adminPassword"
                  value={adminPassword}
                  onChange={(e) => setAdminPassword(e.target.value)}
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500 transition-all duration-300"
                  placeholder="Enter admin password"
                  autoFocus
                />
                {passwordError && (
                  <p className="text-red-500 text-sm mt-1">{passwordError}</p>
                )}
              </div>
              
              <div className="flex space-x-3 pt-4">
                <button
                  type="button"
                  onClick={closePasswordModal}
                  className="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  className="flex-1 px-4 py-3 bg-secondary-600 text-white rounded-lg hover:bg-secondary-700 transition-colors duration-300 font-medium"
                >
                  Access Admin
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </>
  );
};

export default Header;