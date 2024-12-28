<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="favicon.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Cart - Home Essentials</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script>
        var isAuthenticated = @json(Auth::check());
    </script>
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

<!-- Start Cart Section -->
<div class="hero">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-lg-5">
        <div class="intro-excerpt">
          <h1>Your Cart</h1>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="untree_co-section before-footer-section">
  <div class="container">
    <div class="row mb-5">
      <form class="col-md-12" method="post" action="{{ route('cart.update') }}" id="update-cart-form">
        @csrf
        <div class="site-blocks-table">
          <table class="table">
            <thead>
              <tr>
                <th class="product-thumbnail">Image</th>
                <th class="product-name">Product</th>
                <th class="product-price">Price</th>
                <th class="product-quantity">Quantity</th>
                <th class="product-total">Total</th>
                <th class="product-remove">Action</th>
              </tr>
            </thead>
            <tbody>
              @php $total = 0; @endphp
              @if(Auth::check() && $cartItems->count() > 0)
                  @foreach($cartItems as $item)
                      @php
                          $subtotal = $item->price * $item->quantity;
                          $total += $subtotal;
                      @endphp
                      <tr>
                          <td>
                              <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 200px; height: auto;">
                          </td>
                          <td class="product-category">
                              {{ $item->product && $item->product->category ? $item->product->category->name : 'Unknown Category' }}
                          </td>
                          <td class="product-price">₱{{ number_format($item->price, 2) }}</td>
                          <td class="product-quantity">
                              <input type="number" name="quantity[{{ $item->product_id }}]" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 80px;">
                          </td>
                          <td class="product-total">₱{{ number_format($subtotal, 2) }}</td>
                          <td class="product-remove">
                              <button type="button" class="btn btn-danger btn-sm remove-item" data-id="{{ $item->product_id }}">
                                  <i class="fas fa-trash"></i> Remove
                              </button>
                          </td>
                      </tr>
                  @endforeach
              @else
                  <tr>
                      <td colspan="6" class="text-center">Your cart is empty.</td>
                  </tr>
              @endif
            </tbody>
          </table>
        </div>

        <!-- Alert for Empty Cart -->
        @if(Auth::check() && $cartItems->count() === 0)
          <div class="alert alert-warning" role="alert">
            Your cart is empty! Please add items to your cart before proceeding to checkout.
          </div>
        @endif

        <!-- Update Cart Section -->
        <div class="row mb-5">
          <div class="col-md-6">
            <button class="btn btn-black btn-sm btn-block" type="button" id="update-cart-button">Update Cart</button>
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <span class="text-black">Subtotal</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">₱{{ number_format($total, 2) }}</strong>
                  </div>
                </div>
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">₱{{ number_format($total, 2) }}</strong>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-black btn-lg py-3 btn-block" id="checkout-button" 
                    @if(Auth::check() && $cartItems->count() === 0) disabled @endif>Proceed To Checkout</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Start Footer Section -->
<footer class="footer-section">
  <div class="container relative">
    <div class="border-top copyright">
      <div class="row pt-4">
        <div class="col-lg-6">
          <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a></p>
        </div>
        <div class="col-lg-6 text-center text-lg-end">
          <ul class="list-unstyled d-inline-flex ms-auto">
            <li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
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
    // Remove item from cart
    $('.remove-item').on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('id');

        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this item!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('cart.remove', '') }}/' + productId,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Removed!',
                            text: 'Your item has been removed from the cart.',
                            icon: 'success',
                            timer: 2000
                        }).then(() => {
                            location.reload(); // Refresh to update cart
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON?.error || 'Error removing product from cart.'
                        });
                    }
                });
            }
        });
    });

    // Update cart confirmation
    $('#update-cart-button').on('click', function(e) {
        e.preventDefault();

        if (!isAuthenticated) {
            Swal.fire({
                icon: 'warning',
                title: 'Not Logged In',
                text: 'You must be logged in to update your cart.',
            });
            return;
        }

        Swal.fire({
            title: 'Update Cart',
            text: "Are you sure you want to update your cart?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#update-cart-form').submit(); // Submit the form for update
            }
        });
    });

    // Proceed to checkout confirmation
    $('#checkout-button').on('click', function(e) {
        e.preventDefault();

        if (!isAuthenticated) {
            Swal.fire({
                icon: 'warning',
                title: 'Not Logged In',
                text: 'You must be logged in to proceed to checkout.',
            });
            return;
        }

        Swal.fire({
            title: 'Proceed to Checkout',
            text: "Are you sure you want to proceed to checkout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ url('/checkout') }}';
            }
        });
    });
});
</script>

</body>
</html>