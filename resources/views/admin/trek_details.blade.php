@extends('layout/layout')

@section('content')
<div class="row">
    <div class="col-md-6">
    <div>
    
    <h2>{{ $treks->name }}</h2>
    <form action="{{ route('updateTrekDetails', $treks->trek_id) }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <strong>Trek Name: </strong>
            <input type="text" name="name" value="{{ $treks->name }}" class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Trek ID: </strong>
            <input type="text" name="trek_id" value="{{ $treks->trek_id }}" readonly class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Description: </strong>
            <textarea name="description" class="form-control">{{ $treks->description }}</textarea>
        </div>
        <div class="col-md-6">
            <strong>Location:</strong>
            <input type="text" name="location" value="{{ $treks->location }}" class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Category: </strong>
            <input type="text" name="category" value="{{ $treks->category }}" class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Altitude: </strong>
            <input type="text" name="altitude" value="{{ $treks->altitude }}" class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Difficulty: </strong>
            <input type="text" name="difficulty" value="{{ $treks->difficulty }}" class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Number of Days: </strong>
            <input type="text" name="no_of_days" value="{{ $treks->no_of_days }}" class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Emergency Contact Number: </strong>
            <input type="text" name="emergency_no" value="{{ $treks->emergency_no }}" class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Budget Range: </strong>
            <input type="text" name="budgetRange" value="{{ $treks->budgetRange }}" class="form-control">
        </div>
        <div class="col-md-6">
            <strong>Approval Status: </strong>
            <select name="approve" class="form-select">
                <option value="0" {{ $treks->approve == 0 ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ $treks->approve == 1 ? 'selected' : '' }}>Approved</option>
            </select>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-success btn-lg">Approve</button>
        </div>
    </form>
</div>


    </div>
    <div class="col-md-6">
        <p>Created At: {{ $treks->created_at }}</p>
        <div class="col-md-6">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($trekImage->trek_image as $key => $image)
        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>
    <div class="carousel-inner">
        @foreach($trekImage->trek_image as $key => $image)
        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
            <img class="d-block w-100" src="{{ $image->trek_image_path }}" alt="Trek Image">
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


        <div class="mt-3">
                <img src="{{ $treks->map_url }}" class="img-fluid" alt="Map Image">
            </div>
    </div>
</div>
@endsection
