<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Home Essentials</title>

    <!-- Custom fonts for this template-->
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/admindashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about.product') }}">
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

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800 text-center">Admin Dashboard</h1>

                    <!-- Add Category Section -->
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Add Category</h5>

                                    <!-- Category Form -->
                                    <form action="{{ url('/admindashboard') }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Add Category..." aria-label="Add Category" name="name" id="categoryName" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mb-3">Add Category</button>
                                    </form>

                                    <!-- Categories Display -->
                                    <div class="categories-list">
                                        <h6 class="text-left">Existing Categories:</h6>
                                        <ul class="list-group">
                                            @foreach ($categories as $category)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $category->name }}
                                                    <div>
                                                        <!-- Edit Button -->
                                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Edit</button>

                                                        <!-- Delete Button -->
                                                        <form action="{{ url('/deletecategory/' . $category->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Add Category Section -->

                    <!-- Edit Category Modal -->
                    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editCategoryForm" action="{{ route('update.category') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" id="editCategoryId">
                                        <div class="form-group">
                                            <label for="editCategoryName">Category Name</label>
                                            <input type="text" class="form-control" id="editCategoryName" name="name" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Category</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="admin/vendor/jquery/jquery.min.js"></script>
        <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="admin/js/sb-admin-2.min.js"></script>

        <script>
            // Populate the edit modal with category data
            $('#editCategoryModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var categoryId = button.data('id'); // Extract info from data-* attributes
                var categoryName = button.data('name');

                // Update the modal's content
                var modal = $(this);
                modal.find('#editCategoryId').val(categoryId);
                modal.find('#editCategoryName').val(categoryName);
            });
        </script>
    </div>
</body>
</html>