@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account /</span> Today</h4>

        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="/today_account">
                      <i class="bx bx-user me-1"></i> Today</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="javascript:void(0);"
                    ><i class="bx bx-bell me-1"></i> ALL</a
                  >
                </li>
              </ul>
            <div class="card0 mb-4">
            <!-- <h5 class="card-header">Data</h5> -->
            <!-- Data -->
            
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row"> 

                      {{-- Record Starts here --}}
                      

                      {{-- Total Purchase Today --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Purchase</span>
                            <h3 class="card-title text-nowrap mb-2">&#8358;{{ number_format($TodayPurchase->sum('selling_price') ) }}</h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> All</small>
                          </div>
                        </div>
                      </div>
                      {{-- Total Purchase Today --}}

                      {{-- Total Fund Today --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Fund</span>
                            <h3 class="card-title text-nowrap mb-2">&#8358;{{ number_format($TotalFund->sum('amount') ) }}</h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> All</small>
                          </div>
                        </div>
                      </div>
                      {{-- Total Fund Today --}}

                      {{-- Total Income Today --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Income</span>
                            <h3 class="card-title text-nowrap mb-2">&#8358;{{ number_format($TotalIncome = $TotalFund->sum('amount') - $TodayPurchase->sum('selling_price') ) }}</h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> All</small>
                          </div>
                        </div>
                      </div>
                      {{-- Total Income Today--}}

                      {{-- Edu Purchase Total --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar">
                                <p></p>
                              </div>
                            </div>
                            <span class="d-block mb-1">Eductaion PINs</span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($EduToday->sum('selling_price') ) }}
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ 'Overall' }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- Edu Puchase Total --}}

                      

                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/mtn.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Sales </span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($MtnToday->sum('selling_price') ) }}  |  
                                {{ ($MtnToday->sum('plan') ) }}GB
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> All</small>
                          </div>
                        </div>
                      </div>
                      {{-- First Record  --}}

                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/glo.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Sales</span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($GloToday->sum('selling_price') ) }}  |  
                                {{ ($GloToday->sum('plan') ) }}GB
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> All</small>
                          </div>
                        </div>
                      </div>

                      {{-- Due Loan Records  --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/airtel.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Sales</span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($AirtelToday->sum('selling_price') ) }}  |  
                                {{ ($AirtelToday->sum('plan') ) }}GB
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> {{ date('M') }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- Due Loan Ends Here --}}

                      {{-- Total Paid So far --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/9mobile.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Sales</span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($nMobileToday->sum('selling_price') ) }}  |  
                                {{ ($nMobileToday->sum('plan') ) }}GB
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ 'Overall' }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- Total Paid --}}

                      {{-- SMILE RECORD --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/smileLogo.jpeg') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Total Sales</span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($SmileToday->sum('selling_price') ) }}  |  
                                {{ ($SmileToday->sum('plan') ) }}GB
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ 'Overall' }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- SMILE RECORD --}}

                      {{-- Airtime Total --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <img src="{{ asset('img/icons/rocket-white.png') }}" alt="Credit Card" class="rounded" />
                              </div>
                            </div>
                            <span class="d-block mb-1">Airtime Total Sales</span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($AirtimeToday->sum('selling_price') ) }}
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ 'Overall' }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- Airtime Todays --}}

                      {{-- Electricity Totals --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <p></p>
                              </div>
                            </div>
                            <span class="d-block mb-1">Electricity</span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($ElectToday->sum('selling_price') ) }}
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ 'Overall' }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- Electricity Totals --}}

                      {{-- Cable Sub Total --}}
                      <div class="col-3 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                              <div class="avatar flex-shrink-0">
                                <p></p>
                              </div>
                            </div>
                            <span class="d-block mb-1">Cable Subscription</span>
                            <h3 class="card-title text-nowrap mb-2">
                                &#8358;{{ number_format($CableToday->sum('selling_price') ) }}
                            </h3>
                            <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ 'Overall' }}</small>
                          </div>
                        </div>
                      </div>
                      {{-- Cable Sub Total --}}

                    </div>
                </div>
            <!-- /Account -->
            </div>
            
          </div>
        </div>
</div>
@endsection