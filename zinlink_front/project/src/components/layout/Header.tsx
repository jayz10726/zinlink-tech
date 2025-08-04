import { useState, useEffect } from 'react';
import { Link, NavLink, useLocation } from 'react-router-dom';
import { Laptop, ShoppingCart, Menu, X, Search, Home, Package, Phone, Settings, Star, Info } from 'lucide-react';
import { useCart } from '../../context/CartContext';

const Header = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isScrolled, setIsScrolled] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
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
    { to: 'http://localhost:8000/admin', label: 'Admin', icon: Settings, external: true },
  ];

  return (
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
            <Laptop className="w-6 h-6 text-white" />
          </div>
          <span className="text-2xl font-extrabold bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent drop-shadow-lg tracking-tight font-display">
            <span className="pr-1">zinlink</span><span className="text-white bg-black/30 px-2 py-0.5 rounded-lg ml-1 shadow-md">tech</span>
          </span>
        </Link>
        
        {/* Desktop Navigation */}
        <nav className="hidden md:flex items-center space-x-2">
          {navItems.map(({ to, label, icon: Icon, external }) => (
            external ? (
              <a 
                key={to} 
                href={to} 
                target="_blank" 
                rel="noopener noreferrer"
                className={label === 'Admin' ? adminLinkClasses() : "flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 text-gray-700 hover:bg-secondary-50 hover:text-secondary-600"}
              >
                <Icon className="w-4 h-4" />
                <span>{label}</span>
                {label === 'Admin' && isAdminPage && (
                  <span className="ml-1 px-1.5 py-0.5 text-xs bg-green-500 text-white rounded-full animate-pulse">
                    Active
                  </span>
                )}
              </a>
            ) : (
              <NavLink key={to} to={to} className={navLinkClasses}>
                <Icon className="w-4 h-4" />
                <span>{label}</span>
              </NavLink>
            )
          ))}
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
        
        {/* Mobile Cart */}
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
              {navItems.map(({ to, label, icon: Icon, external }) => (
                external ? (
                  <a 
                    key={to} 
                    href={to} 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className={label === 'Admin' ? mobileAdminLinkClasses() : "flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition-all duration-300 text-gray-700 hover:bg-secondary-50 hover:text-secondary-600"}
                    onClick={toggleMenu}
                  >
                    <Icon className="w-5 h-5" />
                    <span>{label}</span>
                    {label === 'Admin' && isAdminPage && (
                      <span className="ml-1 px-1.5 py-0.5 text-xs bg-green-500 text-white rounded-full animate-pulse">
                        Active
                      </span>
                    )}
                  </a>
                ) : (
                  <NavLink key={to} to={to} className={mobileNavLinkClasses} onClick={toggleMenu}>
                    <Icon className="w-5 h-5" />
                    <span>{label}</span>
                  </NavLink>
                )
              ))}
            </nav>
          </div>
        </div>
      )}
    </header>
  );
};

export default Header;