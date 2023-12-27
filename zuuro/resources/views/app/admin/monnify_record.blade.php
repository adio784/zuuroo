@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Zuuroo Account /</span> Monnify</h4>

        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="/paystack_record">
                      <i class="bx bx-user me-1"></i> Paystack</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-bell me-1"></i> Monnify</a
                  >
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/dingconnect_record"
                      ><i class="bx bx-bell me-1"></i> DingConnect</a
                    >
                  </li>
              </ul>
            <div class="card0 mb-4">
            <!-- <h5 class="card-header">Data</h5> -->
            <!-- Data -->

                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        
                    {{-- Total Paid So far --}}
                      <div class="col-4 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                              <div class="dropdown">
                                <button
                                  class="btn p-0"
                                  type="button"
                                  id="cardOpt4"
                                  data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >
                                  <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                  <a class="dropdown-item" href="/fund_transaction_history">View More</a>
                                  {{-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> --}}
                                </div>
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Payment (Today)</span>
                            <h3 class="card-title text-nowrap mb-2">&#8358;{{ number_format($TodayIncome->sum('amount') ) }}</h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ 'Today' }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- Total Paid --}}


                      {{-- Due Loan Records  --}}
                      <div class="col-4 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                              <div class="dropdown">
                                <button
                                  class="btn p-0"
                                  type="button"
                                  id="cardOpt4"
                                  data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >
                                  <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                  <a class="dropdown-item" href="/fund_transaction_history">View More</a>
                                  {{-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> --}}
                                </div>
                              </div>
                            </div>
                            <span class="d-block mb-1">Payment Received (This Month)</span>
                            <h3 class="card-title text-nowrap mb-2">&#8358;{{ number_format($MonthlyIncome->sum('amount') ) }}</h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> {{ date('M') }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- Due Loan Ends Here --}}

 {{-- Record Starts here --}}

                      <div class="col-4 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                              <div class="dropdown">
                                <button
                                  class="btn p-0"
                                  type="button"
                                  id="cardOpt4"
                                  data-bs-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false"
                                >
                                  <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                  <a class="dropdown-item" href="/fund_transaction_history">View More</a>
                                  {{-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> --}}
                                </div>
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Payment Recieved</span>
                            <h3 class="card-title text-nowrap mb-2">&#8358;{{ number_format($TotalIncome->sum('amount') ) }}</h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> Overrall</small>
                          </div>
                        </div>
                      </div>
                      {{-- First Record  --}}
                      

                    </div>
                </div>
            <!-- /Account -->
            </div>

          </div>
        </div>
</div>
@endsection
