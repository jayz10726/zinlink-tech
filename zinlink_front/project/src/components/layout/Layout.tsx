import { ReactNode, useEffect, useState } from 'react';
import Header from './Header';
import Footer from './Footer';
import { Link } from 'react-router-dom';
import { ShoppingCart, ArrowUp } from 'lucide-react';

interface LayoutProps {
  children: ReactNode;
}

const Layout = ({ children }: LayoutProps) => {
  const [isDark, setIsDark] = useState(() => {
    if (typeof window !== 'undefined') {
      return localStorage.getItem('theme') === 'dark';
    }
    return false;
  });

  useEffect(() => {
    if (isDark) {
      document.documentElement.classList.add('dark');
      localStorage.setItem('theme', 'dark');
    } else {
      document.documentElement.classList.remove('dark');
      localStorage.setItem('theme', 'light');
    }
  }, [isDark]);

  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <div className="min-h-screen flex flex-col bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100">
      <Header />
      <main className="flex-1">
        {children}
      </main>
      <Footer />
      
      {/* Floating Action Button */}
      <div className="fixed bottom-6 right-6 z-50 flex flex-col space-y-3">
        <Link 
          to="/cart" 
          className="floating-action group"
          title="View Cart"
        >
          <ShoppingCart className="w-6 h-6" />
        </Link>
        <button 
          onClick={scrollToTop}
          className="floating-action group"
          title="Scroll to Top"
        >
          <ArrowUp className="w-6 h-6" />
        </button>
        <button
          onClick={() => setIsDark((prev) => !prev)}
          className="floating-action group"
          title="Toggle Dark Mode"
        >
          {isDark ? (
            <svg xmlns="http://www.w3.org/2000/svg" className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 3v1m0 16v1m8.66-8.66l-.71.71M4.05 19.07l-.71.71M21 12h-1M4 12H3m16.95-7.07l-.71.71M6.34 4.93l-.71-.71" /></svg>
          ) : (
            <svg xmlns="http://www.w3.org/2000/svg" className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" /></svg>
          )}
        </button>
      </div>
    </div>
  );
};

export default Layout;