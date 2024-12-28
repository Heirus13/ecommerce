<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>All Orders</title>
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/admindashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('aboutproduct') }}">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>About Product</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/total-users') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Registered Users</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/orders') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>All Orders</span>
                </a>
            </li>
            <hr class="sidebar-divider mt-auto">
            <li class="nav-item">
                <form action="{{ route('admin.logout') }}" method="GET" class="d-inline">
                    <button type="submit" class="btn btn-danger btn-sm btn-block">Logout</button>
                </form>
            </li>
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>

                <div class="container-fluid mt-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="card shadow">
                                <div class="card-header text-center">
                                    <h4 class="m-0">All Orders</h4>
                                </div>
                                <div class="card-body">
                                    @if ($orders->isEmpty())
                                        <p>No orders found.</p>
                                    @else
                                        <!-- Orders Table -->
                                        <table class="table table-bordered mt-3">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>User Name</th>
                                                    <th>Products</th>
                                                    <th>Total Amount</th>
                                                    <th>Order Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->user->name }}</td>
                                                        <td>
                                                            <ul>
                                                                @foreach(json_decode($order->products) as $product)
                                                                    <li>{{ $product->name }} - Quantity: {{ $product->quantity }} - Price: ${{ $product->price }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>${{ $order->total_amount }}</td>
                                                        <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
    </div>
</body>

</html>
