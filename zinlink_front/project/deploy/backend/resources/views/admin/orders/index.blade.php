@extends('admin.layout')

@section('title', 'Orders - zinlink tech Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
    </div>
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr>
                    <td class="px-4 py-2 font-semibold text-gray-900">#{{ $order->id }}</td>
                    <td class="px-4 py-2">{{ $order->first_name }} {{ $order->last_name }}</td>
                    <td class="px-4 py-2">{{ $order->email }}</td>
                    <td class="px-4 py-2">{{ $order->phone }}</td>
                    <td class="px-4 py-2">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 font-semibold text-gray-900">KES {{ number_format($order->total, 2) }}</td>
                    <td class="px-4 py-2 text-gray-500">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="#" class="text-blue-600 hover:text-blue-900 font-semibold">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection 