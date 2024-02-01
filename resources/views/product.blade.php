@extends('layout')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Product Manager</h1>
    <div>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createProductModal"><i class="bi bi-plus-square"></i> Create New Product</button>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm border-1">
            <div class="card-body">
                <h4 class="card-title" style="color:#0A1832">Product List</h4>
                <div class="row">
                    <table id="datatable" class="table dt-responsive wrap" style="overflow-x: auto; max-width: 100%;">
                        <thead>
                            <tr class="text-center">
                                <th>Product Name</th>
                                <th>Product SKU</th>
                                <th>Product Category</th>
                                <th>Product Description</th>
                                <th>Product Image</th>
                                <th>Created By</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="text-center">
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_sku }}</td>
                                    <td>{{ $product->category->category_name }}</td>
                                    <td>{{ $product->product_description }}</td>
                                    <td>{{ $product->product_image }}</td>
                                    <td></td>
                                    <td>{{ $product->created_at }}</td>
                                    <td style="white-space: nowrap;">
                                        <form id="productsDeleteForm{{$product->product_id}}" action="{{ route('products.destroy', $product->product_id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$product->product_id}}">
                                                Edit
                                            </button>

                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $product->product_id }})">Delete</button>
                                        </form>
                                    </td>
                                </tr>


                               <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{$product->product_id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$product->product_id}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{$product->product_id}}">Edit Product</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{ route('products.update', $product->product_id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="product_name" class="form-label">Product Name</label>
                                                        <input type="text" class="form-control" name="product_name" value="{{ $product->product_name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_sku" class="form-label">Product SKU</label>
                                                        <input type="text" class="form-control" name="product_sku" value="{{ $product->product_sku }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_category" class="form-label">Product Category</label>
                                                        <input type="text" class="form-control" name="product_category_id" value="{{ $product->product_category }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_description" class="form-label">Product Description</label>
                                                        <input type="text" class="form-control" name="product_description" value="{{ $product->product_description }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="product_image" class="form-label">Product Image</label>
                                                        <input type="text" class="form-control" name="product_image" value="{{ $product->product_image }}" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </form>
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




{{--  Modal for creating a new Product --}}
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="post" >
                    @csrf
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_sku" class="form-label">Product SKU</label>
                        <input type="text" class="form-control" name="product_sku" required>
                    </div>

                    <div class="mb-3">
                        <label for="product_category_id" class="form-label">Product Category</label>
                        <select class="form-control" name="product_category_id" required>
                            <option value="" disabled selected>Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="product_description" class="form-label">Product Description</label>
                        <input type="text" class="form-control" name="product_description">
                    </div>
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Product Image</label>
                        <input type="text" class="form-control" name="product_image">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-square"></i> Create Product</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(product_id) {
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
                document.getElementById('productsDeleteForm' + product_id).submit();
            }
        });
    }
</script>

@endsection
