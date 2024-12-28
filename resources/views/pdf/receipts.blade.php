<!DOCTYPE html>
<html>
<head>
    <title>All Receipts</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h1>All Receipts</h1>
    @foreach($orders as $order)
        <div>
            <h2>Order ID: {{ $order->id }}</h2>
            <ul>
                @php
                    $products = json_decode($order->products, true);
                @endphp
                @foreach($products as $product)
                    <li>{{ $product['name'] }} - ${{ number_format($product['price'], 2) }} (Quantity: {{ $product['quantity'] }})</li>
                @endforeach
            </ul>
            <p>Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
            <p>Date: {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <hr>
        </div>
    @endforeach
</body>
</html>