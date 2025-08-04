import React from 'react';

interface ErrorBoundaryState {
  hasError: boolean;
  error?: Error;
}

class ErrorBoundary extends React.Component<React.PropsWithChildren<{}>, ErrorBoundaryState> {
  constructor(props: React.PropsWithChildren<{}>) {
    super(props);
    this.state = { hasError: false };
  }

  static getDerivedStateFromError(error: Error) {
    return { hasError: true, error };
  }

  componentDidCatch(error: Error, errorInfo: React.ErrorInfo) {
    // You can log error to a service here
    console.error('ErrorBoundary caught an error:', error, errorInfo);
  }

  render() {
    if (this.state.hasError) {
      return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-red-50 dark:bg-red-900 text-red-800 dark:text-red-200">
          <h1 className="text-2xl font-bold mb-4">Something went wrong.</h1>
          <p className="mb-2">An unexpected error occurred. Please try refreshing the page.</p>
          {this.state.error && <pre className="bg-red-100 dark:bg-red-800 p-2 rounded text-xs overflow-x-auto max-w-xl">{this.state.error.toString()}</pre>}
        </div>
      );
    }
    return this.props.children;
  }
}

export default ErrorBoundary; 