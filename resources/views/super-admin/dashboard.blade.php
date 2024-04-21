@extends('layout/layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
      <br/>
      <div style="width:400px;margin-top:40px">
        <canvas id="barGraph" width="100" height="100"></canvas>
      </div>
      <div style="width:710px;margin-top:40px">
        <canvas id="lineChart"></canvas>
      </div>
      
      <div class="container">
  <div class="row">
    <div class="col-md-6">
      <div style="width:410px; margin-top:40px">
        <canvas id="pieChart"></canvas>
      </div>
    </div>
    
    <div class="col-md-6" style="margin-top:50px">
      <div class="row">
        @if ($usersWithCounts->isNotEmpty())
          @foreach ($usersWithCounts->take(3) as $user)
            <div class="col-md-4">
              <div class="card mb-3">
                <img src="{{ $user->profile_url }}" class="card-img-top img-thumbnail" alt="Profile Image">
                <div class="card-body">
                  <h5 class="card-title">{{ $user->name }}</h5>
                  <p class="card-text">Total Count: {{ $user->total_count }}</p>
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="col">
            <p>No user found with the most places, treks, and restaurants combined.</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

</div>

</div>
<script>
  
    var barGraphData = {!! json_encode($barGraphData) !!};
    var ctx = document.getElementById('barGraph').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: barGraphData.labels,
            datasets: [{
                label: 'Number of Items',
                data: barGraphData.data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    var userCountsPerMonth = {!! json_encode($userCountsPerMonth) !!};

        var labels = userCountsPerMonth.map(function(item) {
            return item.year + '-' + item.month;
        });
        var data = userCountsPerMonth.map(function(item) {
            return item.count;
        });

        var ctx = document.getElementById('lineChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'User Count Per Month',
                    data: data,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

      var pieChartData = {!! json_encode($pieChartData) !!};

      var ctx = document.getElementById('pieChart').getContext('2d');

      var myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: pieChartData.labels,
              datasets: [{
                  data: pieChartData.data,
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              responsive: true,
              plugins: {
                  legend: {
                      position: 'top',
                  },
                  title: {
                      display: true,
                      text: 'Most Reviewed Category: ' + pieChartData.mostReviewedCategory,
                      fontSize: 16
                  }
              }
          }
      });
</script>
@endsection
