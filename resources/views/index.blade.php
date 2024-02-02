@extends('layout')
@section('content')
    <div class="container mt-5 dashboard">
        <h1 class="mb-4">Dashboard</h1>
        <div class="col-md-12">
            <div class="card shadow-sm border-1 pipelinetable">
                <div class="card-body">
                    <h4 class="card-title" style="color:#0A1832">(Landing Page)</h4>

                    <label class="categoryFilter" for="category_filter">Filter by Category:
                    <select id="category_filter" onchange="filterProducts()">
                        <option value="all">Show All</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->product_category }}">{{ $product->product_category }}</option>
                        @endforeach
                    </select>
                </label>
                    <div class="row">
                        <table id="datatable" class="table dt-responsive wrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th class="productName">Product Name</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Product Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="text-center">
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->product_sku }}</td>
                                        <td>{{ $product->product_category }}</td>
                                        <td>
                                            @if($product->product_image)
                                                <div class="circle-frame">
                                                    <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="rounded-circle" width="50" height="50">
                                                </div>
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <form id="productsDeleteForm{{$product->id}}" action="{{ route('products.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" class="btn btn-primary viewdetails"
                                                    data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                                    View Details
                                                </button>

                                                <button type="button" class="btn btn-danger delete" onclick="confirmDelete({{ $product->id }})">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal for each product -->
                                    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        @if($product->product_image)
                                                            <div class="circle-frame">
                                                                <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="rounded-circle" width="50" height="50">
                                                            </div>
                                                        @else
                                                            No Image
                                                        @endif
                                                    </p>
                                                    <p><strong>Product Name:</strong> {{ $product->product_name }}</p>
                                                    <p><strong>SKU:</strong> {{ $product->product_sku }}</p>
                                                    <p><strong>Category:</strong> {{ $product->product_category }}</p>
                                                    <p><strong>Description:</strong> {{ $product->product_description }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Use DataTable for the product table with search bar
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
    </script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('productsDeleteForm' + id).submit();
            }
        });
    }
</script>

<script>
    function filterProducts() {
        var selectedCategory = document.getElementById('category_filter').value;
        var rows = document.getElementById('datatable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var rowCategory = rows[i].getElementsByTagName('td')[2].innerText; // Assuming category is in the third column

            if (selectedCategory === 'all' || selectedCategory === rowCategory) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!localStorage.getItem('introShown')) {
        introJs().setOptions({
            steps: [
                {
                    title: 'Welcome',
                    intro: 'Hello Lay Bare, please allow me to introduce My Practical Exam base in the EXERCISE DETAILS next if you want to continue'
                },
                {
                    element: document.querySelector('.dashboard'),
                    intro: 'This is the Dashboard (Landing Page)'
                },
                {
                    element: document.querySelector('.viewdetails'),
                    intro: 'Show the product details with full description when a product from the list is clicked'
                },
                {
                    element: document.querySelector('.categoryFilter'),
                    intro: 'Add a category filter that will list products based on the selected category. By default, the selected filter should be “Show All”, which is a pseudo-category to list all products from all categories.'
                },
                {
                    element: document.querySelector('.productName'),
                    intro: 'Show the product details with full description when a product from the list is clicked'
                },
                {
                    element: document.querySelector('.delete'),
                    intro: 'Soft-deleted products should not be visible in the list.'
                },
            ],
            exitOnOverlayClick: true,
        }).start();

            localStorage.setItem('introShown', true);
        }
    });
</script>

@endsection
