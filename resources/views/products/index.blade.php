<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Your Cart</title>
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="h3 mb-4 text-gray-800">Your Cart</h1>

        @if(session('cart') && count(session('cart')) > 0)
            <form method="POST" action="{{ route('cart.update') }}">
                @csrf
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $item)
                            @php
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td><img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="width: 50px;"></td>
                                <td>{{ $item['name'] }}</td>
                                <td>${{ number_format($item['price'], 2) }}</td>
                                <td>
                                    <input type="number" name="quantity[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="form-control" style="width: 60px;">
                                </td>
                                <td>${{ number_format($subtotal, 2) }}</td>
                                <td>
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Update Cart</button>
            </form>
            <div class="mt-3">
                <h4>Total: ${{ number_format($total, 2) }}</h4>
                <a href="{{ url('/checkout') }}" class="btn btn-success">Proceed to Checkout</a>
            </div>
        @else
            <div class="alert alert-warning">Your cart is empty.</div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>