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
            <th scope="col">Contact</th>
            <th scope="col">Profile URL</th>
            <th scope="col">Experience</th>
            <th scope="col">Agency ID</th>
            <th scope="col">Is Deleted</th>
            <th scope="col">Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($guides as $guide)
        <tr>
            <td>{{ $guide->guide_id }}</td>
            <td>{{ $guide->name }}</td>
            <td>{{ $guide->contact }}</td>
            <td>{{ $guide->profile_url }}</td>
            <td>{{ $guide->experience }}</td>
            <td>{{ $guide->agency_id }}</td>
            <td>{{ $guide->isDeleted }}</td>
            <td>{{ $guide->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
