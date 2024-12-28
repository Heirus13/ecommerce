<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="favicon.png">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <title>Checkout - Home Essentials</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

<!-- Start Checkout Section -->
<div class="hero">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-lg-5">
        <h1>Checkout</h1>
      </div>
    </div>
  </div>
</div>

<div class="untree_co-section before-footer-section">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-12">
        <h2>Your Cart Items</h2>
        <div class="site-blocks-table">
          <table class="table">
            <thead>
              <tr>
                <th class="product-thumbnail">Image</th>
                <th class="product-name">Product</th>
                <th class="product-price">Price</th>
                <th class="product-quantity">Quantity</th>
                <th class="product-total">Total</th>
              </tr>
            </thead>
            <tbody>
              @php $totalAmount = 0; @endphp
              @if($cartItems->isNotEmpty()) 
                  @foreach($cartItems as $item)
                      @php 
                          $subtotal = $item->price * $item->quantity; 
                          $totalAmount += $subtotal; 
                      @endphp
                      <tr>
                          <td class="product-thumbnail">
                              <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid" style="width: 100px; height: auto;">
                          </td>
                          <td class="product-name">{{ $item->product && $item->product->category ? $item->product->category->name : 'Unknown Category' }}</td>
                          <td class="product-price">₱{{ number_format($item->price, 2) }}</td>
                          <td class="product-quantity">{{ $item->quantity }}</td>
                          <td class="product-total">₱{{ number_format($subtotal, 2) }}</td>
                      </tr>
                  @endforeach
              @else
                  <tr>
                      <td colspan="5" class="text-center">No products available.</td>
                  </tr>
              @endif
            </tbody>
          </table>
        </div>

        <div class="row mb-5">
          <div class="col-md-12">
            <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
            <div class="row mb-3">
              <div class="col-md-6">
                <span class="text-black h4">Total: ₱{{ number_format($totalAmount, 2) }}</span>
              </div>
            </div>
            <button class="btn btn-black btn-sm" id="confirmCheckout">Confirm Purchase</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Payment Method Modal -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentMethodModalLabel">Order Summary</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 class="text-black">Payment Method</h6>
        <div>
          <input type="radio" name="paymentMethod" value="gcash" id="gcash" checked>
          <label for="gcash">GCash</label>
        </div>
        <div>
          <input type="radio" name="paymentMethod" value="credit_card" id="credit_card">
          <label for="credit_card">Credit Card</label>
        </div>

        <h6 class="mt-4">Order Summary</h6>
        <div class="order-summary">
          <div id="orderItems"></div>
          <div class="order-details">
            <p>Subtotal: ₱<span id="orderSubtotal">{{ number_format($totalAmount, 2) }}</span></p>
            <p>Shipping Fee: ₱<span id="shippingFee">{{ number_format($totalAmount * 0.070, 2) }}</span></p>
            <p>Total: ₱<span id="orderTotal">{{ number_format($totalAmount + ($totalAmount * 0.045), 2) }}</span></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirmPayment">Continue</button>
      </div>
    </div>
  </div>
</div>

<!-- Credit Card Modal -->
<div class="modal fade" id="creditCardModal" tabindex="-1" aria-labelledby="creditCardModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creditCardModalLabel">Credit Card Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="creditCardForm">
          <div class="mb-3">
            <label for="cardNumber" class="form-label">Card Number</label>
            <input type="text" class="form-control" id="cardNumber" required>
          </div>
          <div class="mb-3">
            <label for="cardName" class="form-label">Cardholder Name</label>
            <input type="text" class="form-control" id="cardName" required>
          </div>
          <div class="mb-3">
            <label for="expiryDate" class="form-label">Expiry Date (MM/YY)</label>
            <input type="text" class="form-control" id="expiryDate" required>
          </div>
          <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="processPayment">Pay Now</button>
      </div>
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
    $('#confirmCheckout').on('click', function() {
        // Clear previous items
        $('#orderItems').empty();

        // Check if there are items in the cart
        @if($cartItems->isNotEmpty())
            @foreach($cartItems as $item)
                var productImage = '{{ asset('storage/' . $item->product->image) }}';
                var categoryName = '{{ $item->product->category ? $item->product->category->name : "Unknown Category" }}';
                var productQuantity = '{{ $item->quantity }}';
                var productPrice = '{{ number_format($item->price, 2) }}';
                var subtotal = '{{ number_format($item->price * $item->quantity, 2) }}';

                $('#orderItems').append(`
                    <div class="order-item">
                        <img src="${productImage}" alt="${categoryName}" style="width: 50px; height: auto; margin-right: 10px;">
                        <span>${categoryName} (x${productQuantity}) - ₱${subtotal}</span>
                    </div>
                `);
            @endforeach
        @else
            $('#orderItems').append('<p>No items in the cart.</p>');
        @endif
        
        // Show the payment method modal
        $('#paymentMethodModal').modal('show');
    });

    $('#confirmPayment').on('click', function() {
        // Get selected payment method
        var paymentMethod = $('input[name="paymentMethod"]:checked').val();
        
        if (paymentMethod === 'gcash') {
            // Proceed to checkout with GCash
            $.ajax({
                type: 'POST',
                url: '{{ route('checkout.process') }}',
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token
                    paymentMethod: paymentMethod // Send selected payment method
                },
                success: function() {
                    window.location.href = '{{ url('/checkedout') }}'; // Redirect to checked out page
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was a problem processing your order.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        } else if (paymentMethod === 'credit_card') {
            // Show credit card modal
            $('#paymentMethodModal').modal('hide');
            $('#creditCardModal').modal('show');
        }
    });

    $('#processPayment').on('click', function() {
        // Get credit card details
        var cardNumber = $('#cardNumber').val();
        var cardName = $('#cardName').val();
        var expiryDate = $('#expiryDate').val();
        var cvv = $('#cvv').val();

        // Perform validation or further processing here

        // Proceed to checkout with Credit Card
        $.ajax({
            type: 'POST',
            url: '{{ route('checkout.process') }}',
            data: {
                _token: '{{ csrf_token() }}',
                paymentMethod: 'credit_card', // Send selected payment method
                cardNumber: cardNumber,
                cardName: cardName,
                expiryDate: expiryDate,
                cvv: cvv
            },
            success: function() {
                window.location.href = '{{ url('/checkedout') }}'; // Redirect to checked out page
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was a problem processing your credit card.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>
</body>
</html>