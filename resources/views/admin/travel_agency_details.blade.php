@extends('layout/layout')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div>
            <h2>{{ $agency->name }}</h2>
            <form action="{{ route('updateAgencyDetails', $agency->agency_id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <strong>Agency ID: </strong>
                    <input type="text" name="name" value="{{ $agency->agency_id }}" readonly class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Agency Name: </strong>
                    <input type="text" name="name" value="{{ $agency->name }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Email: </strong>
                    <input type="email" name="email" value="{{ $agency->email }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Contact No: </strong>
                    <input type="text" name="contact_no" value="{{ $agency->contact_no }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Location:</strong>
                    <input type="text" name="location" value="{{ $agency->location }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Registration No: </strong>
                    <input type="text" name="registration_no" value="{{ $agency->registration_no }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Approval Status: </strong>
                    <select name="approve" class="form-select">
                        <option value="0" {{ $agency->approve == 0 ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ $agency->approve == 1 ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-lg">Update Agency Details</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-md-6">
        <p>Created At: {{ $agency->created_at }}</p>
            <div class="col-md-6">
                <img src="{{ $agency->agency_image_url }}" alt="Agency Image 1" class="img-fluid mb-3">
            </div>
            <div class="col-md-6">
                <img src="{{ $agency->document_url }}" alt="Agency Image 2" class="img-fluid mb-3">
            </div>
    </div>


</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Guide ID</th>
            <th scope="col">Name</th>
            <th scope="col">Profile</th>
            <th scope="col">Contact</th>
            <th scope="col">Experience</th>
            <th scope="col">Created At</th>
            <th scope="col">Action</th>

        </tr>
    </thead>
    <tbody>
        @foreach($guides as $guide)
        <tr>
            <td>{{ $guide->guide_id }}</td>
            <td><img src="{{ $guide->profile_url }}" width="100px"/></td>
            <td>{{ $guide->name }}</td>
            <td>{{ $guide->contact }}</td>
            <td>{{ $guide->experience }}</td>
            <td>{{ $guide->created_at->format('M d Y') }}</td>
            <td>
            <form id="deleteGuide" action="{{ route('deleteGuide', $guide->guide_id ) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')
                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete('{{ $guide->name}}', '{{ $guide->guide_id  }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                        Delete
                    </button>
                    </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
<script>
    function confirmDelete(username, id) {
    if (window.confirm(username + " with id " + id + " will be deleted. ARE YOU SURE??")) {
        var form = document.getElementById('deleteGuide');
        form.submit();
    } 
}
</script>