<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Add this to your head section -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <label>Laybare Exam</label>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard Manager</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">User Manager</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">Category Manager</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Product Manager</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>


    <div class="container mx-auto mt-5">
        @if(session('success'))
            <div id="flash-message" class="alert alert-{{ session('alertColor', 'success') }}">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    $('#flash-message').fadeOut();
                }, 2000);
            </script>
        @endif



        @yield('content')
    </div>

    <!-- jQuery and Bootstrap JS CDNs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS CDN -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Use DataTable for the product table with search bar
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>
    <style> @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"); </style>

      <style>
        #datatable th {
            color: white;
            background-color: #212529ff;
            white-space: nowrap;
        }
    </style>
    <style>
        input[readonly] {
            background-color: #f2f2f2;
            color: #555;
            cursor: auto;
        }
    </style>

</body>

</html>
