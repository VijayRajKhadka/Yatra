@extends('layout/layout')

@section('content')

    <h2 class="mb-4">User Management</h2>

    @if(session('success'))
<div id="successAlert" class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif
<script>
    setTimeout(function(){
        $('#successAlert').fadeOut('slow');
    }, 3000);


    function confirmDelete(username, id) {
    if (window.confirm(username + " with id " + id + " will be deleted. ARE YOU SURE??")) {
        var form = document.getElementById('updateForm' + id); 
        form.submit(); 
    } 

}


</script>


    <form action="{{ route('searchUsers') }}" method="GET" class="mb-3" style="float: right; width: 500px;">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Search users...">
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Role</th>
                <th>Profile URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usersWithRole1 as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->contact }}</td>
                <td style="color:red">SuperAdmin</td>
                <td>
                    <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                        <img src="{{ $user->profile_url }}" alt="Profile Image" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </td>
                <td>
                <a href="{{ route('userDetails', $user->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="7">&nbsp;</td>
            </tr>
            @foreach ($usersDescending as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->contact }}</td>
                <td style="{{ $user->role == 1 ? 'color: red;' : ($user->role == 2 ? 'color: blue;' : ($user->role == 3 ? 'color: red; text-decoration: line-through;' : '')) }}">
                    {{ $user->role == 1 ? 'SuperAdmin' : ($user->role == 2 ? 'Admin' : ($user->role == 3 ? 'Deleted' : 'User')) }}
                </td>

                <td>
                    <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                        <img src="{{ $user->profile_url }}" alt="Profile Image" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </td>
                <td>
                <a href="{{ route('userDetails', $user->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                </td>

                <td>
                <form id="updateForm{{ $user->id }}" action="{{ route('deleteUser', $user->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')
                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('{{ $user->name }}', '{{ $user->id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                        Delete
                    </button>
                </form>

                </td>
                </tr>
            
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
    {{ $usersDescending->links('pagination::bootstrap-5') }}

    </div>
@endsection
