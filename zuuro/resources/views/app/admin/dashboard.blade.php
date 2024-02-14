<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <!--favicon-->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />

    <title>Zuuro ::| - We provide you best and easy services that make life easier.</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-eduwell-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lightbox.css') }}">

</head>

<!-- resources/views/dashboard/dashboard.blade.php -->

@extends('layouts.app') <!-- Assuming you have a master layout, adjust accordingly -->

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Customers</h5>
                        <p class="card-text">Total new customers for the day: </p>
                        <p class="h2">{{ $newCustomers }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Number of Sales</h5>
                        <p class="card-text">Total number of sales for the day: </p>
                        <p class="h2">{{ $numberOfSales }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Financial Overview</h5>
                        <canvas id="financialChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        <div>
            
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer</h5>
                        <p class="card-text">Total number of customers: </p>
                        <p class ="h2">{{ $customers }}</p>
                    </div>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profit</h5>
                        <p class="card-text">Total profit for the day: </p>
                        <p class ="h2">{{ $profit }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cost</h5>
                        <p class="card-text">Total cost for the day:</p>
                        <p class = "h2">{{ $cost }} </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Loan</h5>
                        <p class="card-text">Total loan taken for the day:</p>
                        <p class="h2"> {{ number_format($loan) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Paid Loan</h5>
                        <p class="card-text">Total paid loan for the day: </p>
                        <p class = "h2">{{ $paidLoan }} </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Unpaid Loan</h5>
                        <p class="card-text">Total unpaid loan for the day: </p>
                        <p class="h2">{{ $unpaidLoan }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Additional JS Files -->
    <script src="{{ asset('js/owl.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <!-- Chart.js script -->
    <script>
        var ctx = document.getElementById('financialChart').getContext('2d');

        var financialChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Revenue', 'Profit', 'Cost'],
                datasets: [{
                    label: 'Amount ($)',
                    data: [{{ $revenue }}, {{ $profit }}, {{ $cost }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                    ],
                    borderWidth: 1
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
    </script>
@endsection


<!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('js/isotope.min.js') }}"></script>
    <script src="{{ asset('js/owl-carousel.js') }}"></script>
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script src="{{ asset('js/tabs.js') }}"></script>
    <script src="{{ asset('js/video.js') }}"></script>
    <script src="{{ asset('js/slick-slider.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 
</body>

</html>