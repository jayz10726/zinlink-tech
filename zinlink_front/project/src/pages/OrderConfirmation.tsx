import { Link } from 'react-router-dom';
import { CheckCircle, Package, Truck, Mail } from 'lucide-react';

const OrderConfirmation = () => {
  const orderNumber = Math.random().toString(36).substr(2, 9).toUpperCase();

  return (
    <div className="min-h-screen bg-gray-50 py-16">
      <div className="container">
        <div className="max-w-2xl mx-auto text-center">
          {/* Success Icon */}
          <div className="mb-8">
            <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <CheckCircle className="w-12 h-12 text-green-600" />
            </div>
            <h1 className="text-3xl font-bold text-gray-900 mb-4">
              Order Confirmed!
            </h1>
            <p className="text-lg text-gray-600 mb-8">
              Thank you for your purchase. Your order has been successfully placed.
            </p>
          </div>

          {/* Order Details */}
          <div className="bg-white rounded-lg shadow-sm p-8 mb-8">
            <h2 className="text-xl font-semibold text-gray-900 mb-6">Order Details</h2>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
              <div>
                <h3 className="font-medium text-gray-900 mb-2">Order Information</h3>
                <div className="space-y-2 text-sm text-gray-600">
                  <p><span className="font-medium">Order Number:</span> #{orderNumber}</p>
                  <p><span className="font-medium">Date:</span> {new Date().toLocaleDateString()}</p>
                  <p><span className="font-medium">Status:</span> <span className="text-green-600">Confirmed</span></p>
                </div>
              </div>
              
              <div>
                <h3 className="font-medium text-gray-900 mb-2">Next Steps</h3>
                <div className="space-y-2 text-sm text-gray-600">
                  <p>• You'll receive an email confirmation shortly</p>
                  <p>• We'll contact you within 24 hours</p>
                  <p>• Delivery within 2-3 business days</p>
                </div>
              </div>
            </div>
          </div>

          {/* What Happens Next */}
          <div className="bg-white rounded-lg shadow-sm p-8 mb-8">
            <h2 className="text-xl font-semibold text-gray-900 mb-6">What Happens Next?</h2>
            
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div className="text-center">
                <div className="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                  <Mail className="w-6 h-6 text-blue-600" />
                </div>
                <h3 className="font-medium text-gray-900 mb-2">Email Confirmation</h3>
                <p className="text-sm text-gray-600">
                  You'll receive a detailed confirmation email with your order details.
                </p>
              </div>
              
              <div className="text-center">
                <div className="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                  <Package className="w-6 h-6 text-yellow-600" />
                </div>
                <h3 className="font-medium text-gray-900 mb-2">Order Processing</h3>
                <p className="text-sm text-gray-600">
                  We'll prepare your order and contact you to arrange delivery.
                </p>
              </div>
              
              <div className="text-center">
                <div className="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                  <Truck className="w-6 h-6 text-green-600" />
                </div>
                <h3 className="font-medium text-gray-900 mb-2">Fast Delivery</h3>
                <p className="text-sm text-gray-600">
                  Your order will be delivered within 2-3 business days.
                </p>
              </div>
            </div>
          </div>

          {/* Contact Information */}
          <div className="bg-white rounded-lg shadow-sm p-8 mb-8">
            <h2 className="text-xl font-semibold text-gray-900 mb-6">Need Help?</h2>
            <p className="text-gray-600 mb-4">
              If you have any questions about your order, don't hesitate to contact us.
            </p>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
              <div>
                <p className="font-medium text-gray-900">Phone:</p>
                <p className="text-gray-600">0706850126</p>
              </div>
              <div>
                <p className="font-medium text-gray-900">Email:</p>
                <p className="text-gray-600">orders@zinlink techs.com</p>
              </div>
            </div>
          </div>

          {/* Action Buttons */}
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link
              to="/products"
              className="btn-secondary"
            >
              Continue Shopping
            </Link>
            <Link
              to="/contact"
              className="btn-outline"
            >
              Contact Support
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default OrderConfirmation; 