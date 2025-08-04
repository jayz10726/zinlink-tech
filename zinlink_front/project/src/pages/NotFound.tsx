import { Link } from 'react-router-dom';
import { Home, Search, ArrowLeft } from 'lucide-react';

const NotFound = () => {
  return (
    <div className="min-h-screen bg-gray-50 flex items-center justify-center py-12">
      <div className="container">
        <div className="max-w-md mx-auto text-center">
          {/* 404 Illustration */}
          <div className="mb-8">
            <div className="text-9xl font-bold text-gray-200 mb-4">404</div>
            <div className="w-24 h-24 mx-auto bg-secondary-100 rounded-full flex items-center justify-center">
              <Search className="w-12 h-12 text-secondary-600" />
            </div>
          </div>

          {/* Error Message */}
          <h1 className="text-3xl font-bold text-gray-900 mb-4">Page Not Found</h1>
          <p className="text-gray-600 mb-8">
            Sorry, we couldn't find the page you're looking for. 
            It might have been moved, deleted, or you entered the wrong URL.
          </p>

          {/* Action Buttons */}
          <div className="space-y-4">
            <Link
              to="/"
              className="btn-secondary w-full"
            >
              <Home className="w-5 h-5 mr-2" />
              Go to Homepage
            </Link>
            
            <Link
              to="/products"
              className="btn-outline w-full"
            >
              <Search className="w-5 h-5 mr-2" />
              Browse Products
            </Link>

            <button
              onClick={() => window.history.back()}
              className="text-gray-600 hover:text-gray-800 font-medium flex items-center justify-center w-full py-2"
            >
              <ArrowLeft className="w-5 h-5 mr-2" />
              Go Back
            </button>
          </div>

          {/* Help Text */}
          <div className="mt-12 pt-8 border-t border-gray-200">
            <p className="text-sm text-gray-500 mb-4">
              Still having trouble? Contact our support team:
            </p>
            <Link
              to="/contact"
              className="text-secondary-600 hover:text-secondary-700 font-medium"
            >
              Get Help →
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default NotFound;