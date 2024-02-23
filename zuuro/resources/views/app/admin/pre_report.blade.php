@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Report / </span> Select Date
    </h4>

    <div class="row">


        <div class="col-md-12 col-12 mb-md-0 mb-4">
        <div class="card">
            <h5 class="card-header">Please Select Date Range  <h5>
            <div class="card-body">
                <p>Select date range to generate report ... </p>
                <!-- Connections -->
                <!--action="{{ route('add_product') }}"-->

                    <form id="reportForm" method="post" action="/report">
                        @csrf

                        {{-- {!! Toastr::message() !!} --}}
                        <!-- Result  -->

                        <!-- Result  -->
                        <div id="result234">
                           <div class="alert bg-success text-success alert-dismissible fade show d-none" role="alert" id='successAlert'>
                              <a href="#" class="text-dark">
                                  <strong class="text-dark">Success !!!  </strong> <span id='successMsg'>  </span>
                              </a>
                            </div>


                            <div class="alert bg-danger text-danger alert-dismissible fade show d-none" role="alert" id='errorAlert'>
                              <a href="#" class="text-white">
                                  <strong class="text-white">Oops !!!  </strong> <span id='errorMsg'> </span>
                              </a>
                            </div>
                        </div>


                        <div id="result2">
                            @if(Session::get('success'))
                            <div class="bs-toast toast fade show bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                <i class="bx bx-bell me-2"></i>
                                <div class="me-auto fw-semibold">Success!</div>
                                <small>{{ date('m') }}</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    {{ Session::get('success') }}
                                </div>
                            </div>

                                <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>Success!</strong> {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                {{ Session::get('success') }}
                                </div>
                            @endif
                            @if(Session::get('fail'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>Oh Oops! </strong> {{ Session::get('fail') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                        </div>


                        <div class="row">

                            <div class="mb-3 col-md-12 col-lg-12 col-sm-12">
                                <label for="Operators" class="form-label">From </label>
                                <input
                                class="form-control"
                                type="date"
                                id="from_date"
                                name="from_date"
                                required
                                />
                                @error('from_date') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                            </div>

                            <div class="mb-3 col-md-12 col-lg-12 col-sm-12">
                                <label for="Operators" class="form-label">To </label>
                                <input
                                class="form-control"
                                type="date"
                                id="to_date"
                                name="to_date"
                                required
                                />
                                @error('from_date') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                            </div>


                            <div class="mb-1 mt-2 col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                            </div>

                        </div>
                    </form>

                <!-- /Connections -->
            </div>
        </div>
      </div>


    </div>
</div>

@endsection
