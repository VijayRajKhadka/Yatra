@extends('layout/layout')

@section('content')

    <h2 class="mb-4">Super Admin</h2>

<div class="container">
      <div class="row">
      <div class="col-md-3">
        <div class="card-counter primary">
        <i class="fas fa-map-pin"></i>
       
        <span class="count-numbers">{{$placeCount}}</span>
          <span class="count-name">Places</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter danger">
        <i class="fas fa-utensils"></i>
          <span class="count-numbers">{{$restaurantCount}}</span>
          <span class="count-name">Restaurants</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter success" style="background-color: #27D227;">
        <i class="fas fa-hiking"></i>
          <span class="count-numbers">{{$trekCount}}</span>
          <span class="count-name">Treks</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter info">
        <i class="fas fa-user-friends"></i>
          <span class="count-numbers">{{$userCount}}</span>
          <span class="count-name">Users</span>
        </div>
      </div>

      <div class="col-md-3">
      <div class="card-counter info" style="background-color: #FFA600;">
        <i class="fas fa-calendar-alt"></i>
          <span class="count-numbers">{{$totalEvents}}</span>
          <span class="count-name">Total Events</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter info" style="background-color: #8F1FFE;">
        <i class="fas fa-plane"></i>
          <span class="count-numbers">{{$totalEvents}}</span>
          <span class="count-name">Travel Partner</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter info" style="background-color: #D502FF;">
        <i class="fas fa-edit"></i>
          <span class="count-numbers">{{$totalReviews}}</span>
          <span class="count-name">Reviews Placed</span>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-counter info" style="background-color: #D29627;">
        <i class="fas fa-handshake" ></i>
          <span class="count-numbers">{{$totalGuides}}</span>
          <span class="count-name">Travel Guides</span>
        </div>
      </div>

      
  </div>
</div>
@endsection
