
@extends('layout')
@section('content')
<div class="container mt-5">
    <h1 class="mb-4">User Manager</h1>
    <div>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal"><i class="bi bi-plus-square"></i> Create New User</button>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm border-1">
            <div class="card-body">
                <h4 class="card-title" style="color:#0A1832">User List</h4>
                <div class="row">
                    <table id="datatable" class="table dt-responsive wrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%; white-space: nowrap;">
                        <thead>
                            <tr class="text-center">
                                <th>User Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="text-center">
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form id="editDeleteForm{{$user->id}}" action="{{ route('users.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}">
                                                Edit
                                            </button>

                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $user->id }})">Delete</button>
                                        </form>
                                    </td>

                                </tr>

                               <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$user->id}}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{$user->id}}">Edit User</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{ route('users.update', $user->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">Username</label>
                                                        <input type="text" class="form-control" name="username" value="{{ $user->username }}" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="first_name" class="form-label">First Name</label>
                                                        <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="middle_name" class="form-label">Middle Name</label>
                                                        <input type="text" class="form-control" name="middle_name" value="{{ $user->middle_name }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="last_name" class="form-label">Last Name</label>
                                                        <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" readonly>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-square"></i> Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- modal edit end  --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
   function confirmDelete(userId) {
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
            document.getElementById('editDeleteForm' + userId).submit();
        }
    });
}
</script>

@endsection
