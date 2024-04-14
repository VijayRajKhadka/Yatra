@extends('layout/layout')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div>
            <h2>{{ $restaurant->name }}</h2>
            <form action="{{ route('updateRestaurantDetails', $restaurant->restaurant_id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <strong>Restaurant Name: </strong>
                    <input type="text" name="name" value="{{ $restaurant->name }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Restaurant ID: </strong>
                    <input type="text" name="restaurant_id" value="{{ $restaurant->restaurant_id }}" readonly class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Description: </strong>
                    <textarea name="description" class="form-control">{{ $restaurant->description }}</textarea>
                </div>
                <div class="col-md-6">
                    <strong>Location:</strong>
                    <input type="text" name="location" value="{{ $restaurant->location }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Category: </strong>
                    <input type="text" name="category" value="{{ $restaurant->category }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Latitude: </strong>
                    <input type="text" name="latitude" value="{{ $restaurant->latitude }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Longitude: </strong>
                    <input type="text" name="longitude" value="{{ $restaurant->longitude }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Open Time: </strong>
                    <input type="text" name="open_time" value="{{ $restaurant->open_time }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Get There: </strong>
                    <input type="text" name="get_there" value="{{ $restaurant->get_there }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>PAN: </strong>
                    <input type="text" name="pan" value="{{ $restaurant->pan }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Affordability: </strong>
                    <input type="text" name="affordability" value="{{ $restaurant->affordability }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <strong>Approval Status: </strong>
                    <select name="approve" class="form-select">
                        <option value="0" {{ $restaurant->approve == 0 ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ $restaurant->approve == 1 ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-lg">Approve Restaurant</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
    <p>Created At: {{ $restaurant->created_at }}</p>
    <div class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($restaurantImages->first()->restaurant_image as $key => $image)
            <li data-target="#imageSlider" data-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($restaurantImages->first()->restaurant_image as $key => $image)
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <img class="d-block w-100" src="{{ $image->restaurant_image_path }}" alt="Restaurant Image" style="max-height: 400px;">
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
