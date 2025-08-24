import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import App from './App';
import './index.css';
import ErrorBoundary from './components/ErrorBoundary';

console.log('Starting React application...');

const rootElement = document.getElementById('root');
if (!rootElement) {
  throw new Error('Root element not found');
}

console.log('Root element found, creating React root...');

const root = createRoot(rootElement);

console.log('Rendering React application...');

root.render(
  <StrictMode>
    <ErrorBoundary>
      <BrowserRouter>
        <App />
      </BrowserRouter>
    </ErrorBoundary>
  </StrictMode>
);

console.log('React application rendered successfully');