<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>About Product</title>
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc; /* Light background color */
        }
        .card {
            margin-top: 50px; /* Space from the top */
        }
    </style>
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
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('aboutproduct') }}">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>About Product</span>
                </a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="{{ url('/total-users') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Registered User</span>
                    </a>
            </li>
            <li class="nav-item">
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
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>

                <!-- Content Wrapper -->
                <div class="container-fluid mt-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card shadow">
                                <div class="card-header text-center">
                                    <h4 class="m-0">About Product</h4>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select class="form-control" id="category" name="category_id" required>
                                                <option value="" disabled selected>Select a category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" class="form-control" id="stock" name="stock" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="image">Product Image</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            <small class="form-text text-muted">Upload an image file (jpeg, png, jpg, gif) not exceeding 2MB.</small>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block">Add Product</button>
                                    </form>

                                    <!-- Product Table -->
                                    <h5 class="mt-4">Existing Products</h5>
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>
                                                        @if ($product->category)
                                                            {{ $product->category->name }}
                                                        @else
                                                            No Category
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->price }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>
                                                        <!-- Edit and Delete actions -->
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editProductModal" 
                                                            data-id="{{ $product->id }}"
                                                            data-description="{{ $product->description }}"
                                                            data-price="{{ $product->price }}"
                                                            data-stock="{{ $product->stock }}"
                                                            data-category-id="{{ $product->category_id }}">
                                                            Edit
                                                        </button>
                                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Content Wrapper -->
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm" action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="edit-category">Category</label>
                                <select class="form-control" id="edit-category" name="category_id" required>
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="edit-description">Description</label>
                                <textarea class="form-control" id="edit-description" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit-price">Price</label>
                                <input type="number" class="form-control" id="edit-price" name="price" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-stock">Stock</label>
                                <input type="number" class="form-control" id="edit-stock" name="stock" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-image">Product Image</label>
                                <input type="file" class="form-control" id="edit-image" name="image" accept="image/*">
                                <small class="form-text text-muted">Leave blank to keep current image.</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
        <script>
            $('#editProductModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                var description = button.data('description');
                var price = button.data('price');
                var stock = button.data('stock');
                var categoryId = button.data('category-id'); // Get category ID

                var modal = $(this);
                modal.find('#edit-description').val(description);
                modal.find('#edit-price').val(price);
                modal.find('#edit-stock').val(stock);
                modal.find('#edit-category').val(categoryId); // Set the selected category

                // Set the form action to the update route
                modal.find('#editProductForm').attr('action', '/updateproduct/' + id);
            });
        </script>
    </div>
</body>

</html>