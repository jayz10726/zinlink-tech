import { Routes, Route } from 'react-router-dom';
import Layout from './components/layout/Layout';
import Home from './pages/Home';
import Products from './pages/Products';
import ProductDetail from './pages/ProductDetail';
import Cart from './pages/Cart';
import Checkout from './pages/Checkout';
import OrderConfirmation from './pages/OrderConfirmation';
import Contact from './pages/Contact';
import About from './pages/About';
import Reviews from './pages/Reviews';
import Admin from './pages/Admin';
import NotFound from './pages/NotFound';
import { CartProvider } from './context/CartContext';
import { ToastProvider } from './context/ToastContext';

function App() {
  console.log('App component rendering...');
  
  return (
    <ToastProvider>
      <CartProvider>
        <Layout>
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/products" element={<Products />} />
                      <Route path="/products/:id" element={<ProductDetail />} />
          <Route path="/cart" element={<Cart />} />
          <Route path="/checkout" element={<Checkout />} />
          <Route path="/order-confirmation" element={<OrderConfirmation />} />
          <Route path="/contact" element={<Contact />} />
            <Route path="/about" element={<About />} />
            <Route path="/reviews" element={<Reviews />} />
            <Route path="/admin" element={<Admin />} />
            <Route path="*" element={<NotFound />} />
          </Routes>
        </Layout>
      </CartProvider>
    </ToastProvider>
  );
}

export default App;