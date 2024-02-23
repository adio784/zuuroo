@extends('app.admin.admin_layout')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Customers</h5>
                        <p class="card-text">Total new customers  </p>
                        <p class="h2">{{ $newCustomers }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Number of Sales</h5>
                        <p class="card-text">Total number of sales  </p>
                        <p class="h2">{{ $numberOfSales }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
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
                        <p class="card-text">Total number of customers </p>
                        <p class ="h2">{{ $customers }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profit</h5>
                        <p class="card-text">Total profit  </p>
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
                        <p class="card-text">Total cost </p>
                        <p class = "h2">{{ $cost }} </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Sale</h5>
                        <p class="card-text">Total sales</p>
                        <p class="h2">{{ number_format($totalSale, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Paid Loan</h5>
                        <p class="card-text">Total paid loan  </p>
                        <p class = "h2">{{ $paidLoan }} </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Unpaid Loan</h5>
                        <p class="card-text">Total unpaid loan  </p>
                        <p class="h2">{{ $unpaidLoan }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Wallet</h5>
                        <p class="card-text">Total wallet fund  </p>
                        <p class="h2">{{ number_format($totalwallet, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Loan</h5>
                        <p class="card-text">Total loan taken </p>
                        <p class="h2"> {{ number_format($loan) }}</p>
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
