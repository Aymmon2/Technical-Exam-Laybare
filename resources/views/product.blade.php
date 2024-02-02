@extends('layout')
@section('content')
<div class="container mt-5 ProductManager">
    <h1 class="mb-4">Product Manager</h1>
    <div>
        <button type="button" class="btn btn-primary mb-3 add" data-bs-toggle="modal" data-bs-target="#createProductModal"><i class="bi bi-plus-square"></i> Create New Product</button>
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
                                    <td>{{ $product->product_category }}</td>
                                    <td>{{ $product->product_description }}</td>
                                    <td>
                                        @if($product->product_image)
                                            <div class="circle-frame">
                                                <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="rounded-circle" width="50" height="50">
                                            </div>
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $product->created_by }}</td>
                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                    <td style="white-space: nowrap;">
                                        <form id="productsDeleteForm{{$product->id}}" action="{{ route('products.destroy', $product->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-primary edit" data-bs-toggle="modal" data-bs-target="#editModal{{$product->id}}">
                                                Edit
                                            </button>

                                            <button type="button" class="btn btn-danger delete" onclick="confirmDelete({{ $product->id }})">Delete</button>
                                        </form>
                                    </td>
                                </tr>


                               <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$product->id}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{$product->id}}">Edit Product</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="product_name" class="form-label">Product Name</label>
                                                        <input type="text" class="form-control" name="product_name" value="{{ $product->product_name }}" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_sku" class="form-label">Product SKU</label>
                                                        <input type="text" class="form-control" name="product_sku" value="{{ $product->product_sku }}" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_category" class="form-label">Product Category</label>
                                                        <select class="form-control" name="product_category" required>
                                                            <option value="{{ $product->product_category }}" selected>{{ $product->product_category }}</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_description" class="form-label">Product Description</label>
                                                        <input type="text" class="form-control" name="product_description" value="{{ $product->product_description }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_image" class="form-label">Product Image</label>
                                                        <input type="file" class="form-control" name="product_image">
                                                        <p class="text-muted">Leave it empty if you don't want to change the image.</p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="created_by" class="form-label">Created By</label>
                                                        <select class="form-control" name="created_by" required>
                                                            <option value="{{ $product->created_by }}" selected>{{ $product->created_by }}</option>
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->username }}">{{ $user->username }}</option>
                                                            @endforeach
                                                        </select>
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
                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
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
                        <label for="product_category" class="form-label">Product Category </label>

                        <a data-bs-toggle="modal" data-bs-target="#createCategoryModal" style="color: blue; cursor: pointer;">
                            <i class="bi bi-plus-square"></i> Create New Category
                        </a>

                        <select class="form-control" name="product_category" required>
                            <option value="" disabled selected>Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="product_description" class="form-label">Product Description</label>
                        <input type="text" class="form-control" name="product_description">
                    </div>
                    <div class="mb-3">
                        <label for="product_image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="product_image" required>
                    </div>

                    <div class="mb-3">
                        <label for="created_by" class="form-label">Created By </label>

                        <a data-bs-toggle="modal" data-bs-target="#createUserModal" style="color: blue; cursor: pointer;">
                            <i class="bi bi-plus-square"></i> Create User
                        </a>

                        <select class="form-control" name="created_by" required>
                            <option value="" disabled selected>Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->username }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>



                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-square"></i> Create Product</button>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- category create --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_description" class="form-label">Category Description</label>
                        <input type="text" class="form-control" name="category_description" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_manager" class="form-label">Product Manager</label>
                        <input type="text" class="form-control" name="product_manager" required>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-square"></i> Create Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{--  Modal for creating a new user --}}
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
    document.addEventListener('DOMContentLoaded', function() {
        if (!localStorage.getItem('introShown')) {
            introJs().setOptions({
                steps: [
                    {
                        element: document.querySelector('.ProductManager'),
                        intro: 'Product Manager'
                    },
                    {
                        element: document.querySelector('.add'),
                        intro: 'Add Product'
                    },
                    {
                        element: document.querySelector('.edit'),
                        intro: 'Edit Product data'
                    },
                    {
                        element: document.querySelector('.delete'),
                        intro: 'Delete Product record using soft-deletion method.'
                    },
                ],
                exitOnOverlayClick: true,
            }).start();

            localStorage.setItem('introShown', true);

        }
    });
</script>

@endsection
