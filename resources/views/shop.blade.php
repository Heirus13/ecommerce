<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">
  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="css/tiny-slider.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <title>Shop - Home Essentials</title>

  <style>
      .product-item {
          display: flex;
          flex-direction: column;
          height: 100%; 
      }

      .product-item img {
          max-height: 200px; 
          object-fit: cover; 
      }

      .btn {
          height: 50px; 
      }

      .btn-block {
          width: 100%; 
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
          <h1>Shop</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Hero Section -->

<!-- Start Categories Dropdown Section -->
<div class="container my-4">
  <h2 class="text-center">Available Categories</h2>
  <div class="dropdown text-center">
    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      Select Category
    </button>
    <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
      <li>
        <form action="{{ route('shop.index') }}" method="GET" class="px-3">
          <div class="form-check">
            <input type="radio" id="all" name="category" value="" class="form-check-input" checked>
            <label for="all" class="form-check-label">All</label>
          </div>
          @foreach ($categories as $category)
            <div class="form-check">
              <input type="radio" id="category-{{ $category->id }}" name="category" value="{{ $category->id }}" class="form-check-input">
              <label for="category-{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
            </div>
          @endforeach
          <button type="submit" class="btn btn-primary mt-2">Filter</button>
        </form>
      </li>
    </ul>
  </div>
</div>
<!-- End Categories Dropdown Section -->

  <div class="untree_co-section product-section before-footer-section">
    <div class="container">
      <div class="row">         
        <!-- Loop through products -->
        @foreach ($products as $product)
<div class="col-12 col-md-4 col-lg-3 mb-5">
    <div class="product-item d-flex flex-column">
        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid product-thumbnail" alt="{{ $product->description }}">
        <h3 class="product-category">{{ $product->category->name }}</h3> 
        <strong class="product-price">₱{{ number_format($product->price, 2) }}</strong>
        <span class="product-title">{{ $product->description }}</span> 

        @if ($product->stock > 0)
<form id="add-to-cart-form-{{ $product->id }}" action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form mt-auto">
    @csrf
    <button type="button" class="btn btn-primary btn-block add-to-cart-button" data-product-id="{{ $product->id }}">Add to Cart</button>
</form>
@else
<button class="btn btn-secondary btn-block" disabled>Out of Stock</button>
@endif
    </div>
</div>
@endforeach

      </div>                              
    </div>
  </div>

  <!-- Start Footer Section -->
  <footer class="footer-section">
    <div class="container relative">
      <div class="sofa-img">
        <img src="images/sofa.png" alt="Image" class="img-fluid">
      </div>
      <div class="row g-5 mb-5">
        <div class="col-lg-4">
          <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Home Essentials<span>.</span></a></div>
          <p class="mb-4">We are committed to providing our customers with exceptional service and quality products. Our team is dedicated to ensuring a seamless shopping experience, from browsing to checkout. Thank you for choosing us for your needs.</p>
          <ul class="list-unstyled custom-social">
            <li><a href="https://www.facebook.com/johnlloydjustiniane13"><span class="fa fa-brands fa-facebook-f"></span></a></li>
            <li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
            <li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
            <li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
          </ul>
        </div>
        <div class="col-lg-8">
          <div class="row links-wrap">
            <div class="col-6 col-sm-6 col-md-3">
              <ul class="list-unstyled">
                <li><a href="{{ url('/about') }}">About us</a></li>
                <li><a href="{{ url('/services') }}">Services</a></li>
                <li><a href="{{ url('/shop') }}">Shop</a></li>
                <li><a href="{{ url('/contact') }}">Contact us</a></li>
              </ul>
            </div>

            <div class="col-6 col-sm-6 col-md-3">
              <ul class="list-unstyled">
                <li><a href="{{ url('/') }}">Support</a></li>
                <li><a href="{{ url('/') }}">Knowledge base</a></li>
                <li><a href="{{ url('/') }}">Live chat</a></li>
              </ul>
            </div>

            <div class="col-6 col-sm-6 col-md-3">
              <ul class="list-unstyled">
                <li><a href="{{ url('/') }}">Jobs</a></li>
                <li><a href="{{ url('/') }}">Our team</a></li>
                <li><a href="{{ url('/') }}">Leadership</a></li>
                <li><a href="{{ url('/') }}">Privacy Policy</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="border-top copyright">
        <div class="row pt-4">
          <div class="col-lg-6">
            <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a>  Distributed By <a href="https://themewagon.com">ThemeWagon</a></p>
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
  <script src="js/tiny-slider.js"></script>
  <script src="js/custom.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.add-to-cart-button').on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        var form = $('#add-to-cart-form-' + productId);

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: response.success,
                        confirmButtonText: 'Okay'
                    });
                } else if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error,
                        confirmButtonText: 'Okay'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'You need to login first!',
                    confirmButtonText: 'Okay'
                });
            }
        });
    });
});
</script>
</body>
</html>
