@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Notifications --}}
   
        <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
            <a href="/account_verify">
                <strong class="text-danger">Attention !!! </strong> Kindly Verify Your Mobile Number to Continue Using this Service ...
            </a>
        </div>
   
        <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
            <a href="/transaction_pin">
                <strong class="text-danger">Transaction PIN !!! </strong> Get your account more secure with a 4 digit PIN ...
            </a>
        </div>


    <div class="row">
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary">Welcome Ridwan Adio ! 🎉</h5>
                <p class="mb-4">
                You are welcome to <span class="fw-bold">Zuuroo</span> where we provide you 
                best and easy services that makes life easier.
                </p>

                {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">{{ session('LoggedUserReferralLink') }}</a> --}}
            </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
                <img
                src="/img/illustrations/man-with-laptop-light.png"
                height="140"
                alt="View Badge User"
                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png"
                />
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 order-1">
        <div class="row">
        <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                    <img
                    src="/img/icons/unicons/chart-success.png"
                    alt="chart success"
                    class="rounded"
                    />
                </div>
                </div>
                <span class="fw-semibold d-block mb-1">Wallet Bal</span>
                <h4 class="card-title mb-2">2,000 USD</h4>
            </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                    <img
                    src="/img/icons/unicons/wallet-info.png"
                    alt="Credit Card"
                    class="rounded"
                    />
                </div>
                </div>
                <span>Referral Comm.</span>
                <h4 class="card-title text-nowrap mb-1">$4,679</h4>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Total Revenue -->
    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
        <div class="row row-bordered g-0">
            <div class="col-md-8">
            <h5 class="card-header m-0 me-2 pb-3">Card</h5>
            <div  class="px-2">
                <table class="p-3 table"> 
                    
                </table>
            </div>
            </div>
            <div class="col-md-4">
            <div class="card-body">
                <div class="text-center">
                <div class="dropdown">
                    <button
                    class="btn btn-sm btn-outline-primary dropdown-toggle"
                    type="button"
                    id="growthReportId"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >
                    Add Credit Card
                    </button>
                </div>
                </div>
            </div>
            <div id="growthChart"></div>
            <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

            <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
               
                <div class="d-flex">
                <div class="me-2">
                    <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                </div>
                <div class="d-flex flex-column">
                    <small>Total Card</small>
                    <h6 class="mb-0">4 </h6>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!--/ Total Revenue -->
    <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
        <div class="col-6 mb-4">
            <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                    <img src="/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                </div>
                </div>
                <span class="d-block mb-1">Bonus to Wallet</span>
                <h4 class="card-title text-nowrap mb-2">$2,456</h4>
            </div>
            </div>
        </div>
        <div class="col-6 mb-4">
            <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                    <img src="/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                </div>
                </div>
                <span class="fw-semibold d-block mb-1">My Refferals</span>
                <h4 class="card-title mb-2">$14,857</h4>
                
            </div>
            </div>
        </div>
        <!-- </div>
<div class="row"> -->
        <div class="col-12 mb-4">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                    <h5 class="text-nowrap mb-2">Profile Report</h5>
                    <span class="badge bg-label-warning rounded-pill">Year 2022</span>
                    </div>
                    <div class="mt-sm-auto">
                    <small class="text-success text-nowrap fw-semibold"
                        ><i class="bx bx-chevron-up"></i> Total Spent</small
                    >
                    <h3 class="mb-0">$84,686k</h3>
                    </div>
                </div>
                <div id="profileReportChart"></div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="row">

    <!-- Transactions -->
    <div class="col-md-12 col-lg-12 order-2 mb-4">
        <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2"> Transactions Summary</h5>
            <div class="dropdown">
            
            </div>
        </div>
        <div class="card-body">
            <ul class="p-0 m-0">
            <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                <img src="/img/icons/unicons/wallet.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                    <small class="text-muted d-block mb-1">Wallet Balance</small>
                    <h6 class="mb-0">Current State of Account</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">22,000</h6>
                    <span class="text-muted">USD</span>
                </div>
                </div>
            </li>
            <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                <img src="/img/icons/unicons/chart.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                    <small class="text-muted d-block mb-1">Total Spending</small>
                    <h6 class="mb-0">Outbox</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">60,000</h6>
                    <span class="text-muted">USD</span>
                </div>
                </div>
            </li>
            <li class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                <img src="/img/icons/unicons/cc-warning.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                    <small class="text-muted d-block mb-1">Total Funding</small>
                    <h6 class="mb-0">Income</h6>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">23,000</h6>
                    <span class="text-muted">USD</span>
                </div>
                </div>
            </li>
            </ul>
        </div>
        </div>
    </div>
    <!--/ Transactions -->
    </div>
</div>
@endsection