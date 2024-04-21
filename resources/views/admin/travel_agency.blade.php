@extends('layout/layout')

@section('content')

<h2 class="mb-4">Travel Agency</h2>

@if(session('success'))
<div id="successAlert" class="alert alert-success" role="alert">
  {{ session('success') }}
</div>
@endif
<script>
    setTimeout(function(){
        $('#successAlert').fadeOut('slow');
    }, 3000);
</script>

<form action="{{ route('searchAgency') }}" method="GET" class="mb-3" style="float: right; width: 500px;">
    <div class="input-group">
        <input type="text" name="query" class="form-control" placeholder="Search agency...">
        <button type="submit" class="btn btn-outline-primary">Search</button>
    </div>
</form>

<table class="table">
    
    <thead>
        <tr>
            <th scope="col">Agency ID</th>
            <th scope="col">Name</th>
            <th scope="col">Location</th>
            <th scope="col">Contact</th>
            <th scope="col">Registration No</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>

            <th scope="col">View</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($agencies as $agency)
        <tr>
            <td>{{ $agency->agency_id }}</td>
            <td>{{ $agency->name }}</td>
            <td>{{ $agency->location }}</td>
            <td>{{ $agency->contact_no }}</td>
            <td>{{ $agency->registration_no }}</td>
            <td style="{{ $agency->approve == 0 ? 'color: red;' : ($agency->approve == 1 ? 'color: green;' : '') }}">
                {{ $agency->approve == 0 ? 'Pending' : ($agency->approve == 1 ? 'Approved' : $agency->approve) }}
            </td>

            <td>{{ $agency->created_at->format('M d Y') }}</td>
            <td>{{ $agency->updated_at->format('M d Y') }}</td>

            <td>
                <a href="{{ route('agencyDetails', $agency->agency_id) }}" class="btn btn-outline-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                    </svg>
                    View
                </a>
            </td>

            <td>
                <button type="button" class="btn btn-outline-danger">
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
<div class="d-flex justify-content-end">
{{ $agencies->links('pagination::bootstrap-5') }}
</div>
@endsection
