@extends('layout')
@section('content')
<div class="container mt-5 CategoryManager">
    <h1 class="mb-4">Category Manager</h1>
    <div>
        <button type="button" class="btn btn-primary mb-3 add" data-bs-toggle="modal" data-bs-target="#createCategoryModal"><i class="bi bi-plus-square"></i> Create New Category</button>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm border-1">
            <div class="card-body">
                <h4 class="card-title" style="color:#0A1832">Category List</h4>
                <div class="row">
                    <table id="datatable" class="table dt-responsive wrap" style="overflow-x: auto; max-width: 100%;">
                        <thead>
                            <tr class="text-center">
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th>Product Manager</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="text-center">
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->category_description }}</td>
                                    <td>{{ $category->product_manager }}</td>
                                    <td style="white-space: nowrap;">
                                        <form id="categoriesDeleteForm{{$category->id}}" action="{{ route('categories.destroy', $category->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-primary edit" data-bs-toggle="modal" data-bs-target="#editModal{{$category->id}}">
                                                Edit
                                            </button>

                                            <button type="button" class="btn btn-danger delete" onclick="confirmDelete({{ $category->id }})">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$category->id}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{$category->id}}">Edit category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{ route('categories.update', $category->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="category_name" class="form-label">Category Name</label>
                                                        <input type="text" class="form-control" name="category_name" value="{{ $category->category_name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="category_description" class="form-label">Category Description</label>
                                                        <input type="text" class="form-control" name="category_description" value="{{ $category->category_description }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="product_manager" class="form-label">Product Manager</label>
                                                        <input type="text" class="form-control" name="product_manager" value="{{ $category->product_manager }}">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Edit end -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{--  Modal for creating a new Product --}}
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


<script>
    function confirmDelete(categoryId) {
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
            document.getElementById('categoriesDeleteForm' + categoryId).submit();
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
                            element: document.querySelector('.CategoryManager'),
                            intro: 'Category Manager'
                        },
                        {
                            element: document.querySelector('.add'),
                            intro: 'Add Category'
                        },
                        {
                            element: document.querySelector('.edit'),
                            intro: 'Edit Category data'
                        },
                        {
                            element: document.querySelector('.delete'),
                            intro: 'Delete category record using soft-deletion method.'
                        },
                    ],
                    exitOnOverlayClick: true,
                }).start();

                localStorage.setItem('introShown', true);
            }
        });
</script>

<style>
    #datatable th {
        color: white;
        background-color: #212529ff;
    }
</style>

@endsection
