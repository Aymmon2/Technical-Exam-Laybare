@extends('layout')
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Dashboard</h1>
        <div class="col-md-12">
            <div class="card shadow-sm border-1 pipelinetable">
                <div class="card-body">
                    <h4 class="card-title" style="color:#0A1832">(Landing Page)</h4>

                    <label for="category_filter">Filter by Category:</label>
                    <select id="category_filter">
                        <option value="all">Show All</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_category }}</option>
                        @endforeach
                    </select>

                    <div class="row">
                        <table id="datatable" class="table dt-responsive wrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th>Product Name</th>
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

                                                <button type="button" class="btn btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                                    View Details
                                                </button>

                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $product->id }})">Delete</button>
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

@endsection
