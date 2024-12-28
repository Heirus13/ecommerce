<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="favicon.png">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <title>Checkedout - Home Essentials</title>
  <style>
    .order-summary {
      margin-bottom: 20px;
      padding: 20px;
      border-radius: 10px;
      background-color: #f8f9fa;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .order-card {
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s;
    }
    .order-card:hover {
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }
    .btn-delete {
      background-color: white;
      color: red;
      border: 2px solid red;
      border-radius: 25px;
      padding: 10px 20px;
    }
    .product-list img {
      width: 50px; /* Adjust size as needed */
      height: auto;
      margin-right: 10px;
    }
  </style>
</head>

<body>

<!-- Start Header/Navigation -->
<nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark fixed-top" aria-label="Furni navigation bar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Home Essentials<span>.</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/shop') }}">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/cart') }}">My Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/checkedout') }}">Checkedout Details</a></li>
            </ul>	
            <div class="d-flex ms-auto">
                @if (Auth::check())
                    <form action="{{ route('logout') }}" method="POST" class="auth-button" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endif
            </div>
        </div>
    </div>
</nav>
<!-- End Header/Navigation -->

<!-- Start Hero Section -->
<div class="hero">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-lg-5">
        <div class="intro-excerpt">
          <h1>Your Checked Out Products</h1>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="untree_co-section before-footer-section">
  <div class="container">
    <div class="order-summary">
      <h4>Total Orders: {{ $orders->count() }}</h4>
      <h4>Total Spent: ${{ number_format($orders->sum('total_amount'), 2) }}</h4>
    </div>
    
    <div class="row">
      @if($orders->isEmpty())
        <div class="col text-center">
          <p>You have not checked out any products yet.</p>
        </div>
      @else
        @foreach($orders as $order)
          <div class="col-md-4">
            <div class="order-card">
              <h5>Order ID: {{ $order->id }}</h5>
              <ul class="product-list">
                @php
                  $products = json_decode($order->products, true); // Decode the JSON
                @endphp
                @foreach($products as $product)
                  <li>
                    <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}">
                     ${{ number_format($product['price'], 2) }} (Quantity: {{ $product['quantity'] }})
                  </li>
                @endforeach
              </ul>
              <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
              <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
              <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
              <form action="{{ route('order.remove', $order->id) }}" method="POST" class="d-inline" id="remove-order-{{ $order->id }}">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-delete" data-id="{{ $order->id }}">
                  <i class="fas fa-trash"></i> Delete
                </button>
              </form>
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>

<!-- Start Footer Section -->
<footer class="footer-section">
  <div class="container relative">
    <div class="border-top copyright">
      <div class="row pt-4">
        <div class="col-lg-6">
          <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- End Footer Section -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Remove order confirmation
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var orderId = $(this).data('id');
        var form = $('#remove-order-' + orderId);

        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "This order will be permanently removed!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form to remove the order
            }
        });
    });
});
</script>

</body>
</html>