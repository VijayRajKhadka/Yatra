@extends('layout/layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        <div class="card-counter info" style="background-color: #8F1FFE;">
        <i class="fas fa-plane"></i>
          <span class="count-numbers">{{$totalEvents}}</span>
          <span class="count-name">Travel Partner</span>
        </div>
      </div>

      

      
      <br/>
      <div style="width:500px;margin-top:40px">
        <canvas id="barGraph" width="100" height="100"></canvas>
      </div>
      <div style="width:510px; margin-top:40px">
        <canvas id="pieChart"></canvas>
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
