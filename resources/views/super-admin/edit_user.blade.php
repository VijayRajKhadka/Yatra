@extends('layout/layout')

@section('content')

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

<div class="row">
    <div class="col-md-6">
            <h2>{{ $user->name }}</h2>
        <p>Created At: {{ $user->created_at }}</p>
        <p>Last Updated: {{ $user->updated_at }}</p>
        
    </div>
            <form action="{{ route('updateUser', $user->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <strong>Name: </strong>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>User ID: </strong>
                    <input type="text" name="user_id" value="{{ $user->id }}" readonly class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Email: </strong>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Contact:</strong>
                    <input type="text" name="contact" value="{{ $user->contact }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Role: </strong>
                    <select name="role" class="form-select">
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Super Admin</option>
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Admin</option>
                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-success btn-lg">Update User</button>
                </div>

            </form>
        </div>
        
    </div>
    
</div>
@endsection
