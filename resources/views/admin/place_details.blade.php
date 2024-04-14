@extends('layout/layout')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div>
            <h2>{{ $place->name }}</h2>
            <form action="{{ route('updatePlaceDetails', $place->place_id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <strong>Place Name: </strong>
                    <input type="text" name="name" value="{{ $place->name }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Place ID: </strong>
                    <input type="text" name="place_id" value="{{ $place->place_id }}" readonly class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Description: </strong>
                    <textarea name="description" class="form-control">{{ $place->description }}</textarea>
                </div>
                <div class="col-md-6">
                    <strong>Location:</strong>
                    <input type="text" name="location" value="{{ $place->location }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Category: </strong>
                    <input type="text" name="category" value="{{ $place->category }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Latitude: </strong>
                    <input type="text" name="latitude" value="{{ $place->latitude }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Longitude: </strong>
                    <input type="text" name="longitude" value="{{ $place->longitude }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Open Time: </strong>
                    <input type="text" name="open_time" value="{{ $place->open_time }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <str`ong>Get There: </strong>
                    <input type="text" name="get_there" value="{{ $place->get_there }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Approval Status: </strong>
                    <select name="approve" class="form-select">
                        <option value="0" {{ $place->approve == 0 ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ $place->approve == 1 ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-lg">Approve Place</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <p>Created At: {{ $place->created_at }}</p>
        <div id="imageSlider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($placeImage->first()->place_image as $key => $image)
                <li data-target="#imageSlider" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($placeImage->first()->place_image as $key => $image)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <img class="d-block w-100" src="{{ $image->place_image_path }}" alt="Image {{ $key }}">
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#imageSlider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#imageSlider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
@endsection
