@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Account Settings / </span> Networks
    </h4>

    <div class="row">
    <div class="col-md-12">
        <div class="row">

        <div class="col-md-7 col-12">
            <div class="card">
            <h5 class="card-header">Manage Networks</h5>
            <div class="card-body">
                <p>Network operators we provide service to</p>
                <!-- Social Accounts -->
                <div class="table-responsive">
                    <table class="table" id="table_id">
                        <thead>
                            <th>#</th>
                            <th>Country</th>
                            <th>Operators</th>
                            <th>Short Code</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($NetworkInfo as $Network)
                                <?php $dt++; ?>
                                <tr>
                                    <td>{{ $dt }}</td>
                                    <td>{{ $Network->country_name }}</td>
                                    <td>{{ $Network->operator_name }}</td>
                                    <td>{{ $Network->operator_code }}</td>
                                    <td>
                                        @if ( $Network->status ==1 )
                                        <span class="badge bg-primary"> Active</span>
                                        @else
                                            <span class="badge bg-warning"> Pending </span>
                                        @endif
                                    </td>
                                    <td style="width:50x">
                                        <a href="/toggle_NetworkStatus/{{$Network->operator_code}}" class=""> <span class="avatar-initial rounded bg-label-primary p-1"><i class="bx bx-street-view"></i></span> </a>

                                        <a href="/delete_network/{{$Network->operator_code}}" class="" onclick="confirm('Are you sure to continue');"> <span class="avatar-initial rounded bg-label-danger p-1"><i class="bx bx-trash"></i></span> </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /Social Accounts -->
            </div>
            </div>
        </div>
        <div class="col-md-5 col-12 mb-md-0 mb-4">
            <div class="card">
            <h5 class="card-header">Add Networks</h5>
            <div class="card-body">
                <p>Add network operators to the list of networks ... </p>
                <!-- Connections -->

                <div class="d-flex">
                    <form action="{{ route('manage_networks_page') }}" id="country_form" method="post">
                        @csrf

                        {{-- {!! Toastr::message() !!} --}}
                    <!-- Result  -->
                <div id="result">
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
                          <div class="mb-3 col-md-12 col-lg-12">
                            <label for="firstName" class="form-label">Country Name</label>
                            <select name="countryName" id="countryName" class="form-control">
                                <option value=""> -- -- </option>
                                @foreach($Country as $ctr)
                                <option value="{{ $ctr->id }}">{{ $ctr->country_name }}</option>
                                @endforeach
                            </select>
                          </div>@error('countryName') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror

                          <div class="mb-3 col-md-12 col-lg-12">
                            <label for="firstName" class="form-label">Operator</label>
                            <input
                              class="form-control"
                              type="text"
                              id="operator"
                              name="operator"
                              value="{{ old('operator') }}"
                              placeholder="eg: MTN Group of Company"
                            />
                          </div>@error('phonecode') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          <div class="mb-3 col-md-12 col-lg-12">
                            <label for="firstName" class="form-label">Short Code</label>
                            <input
                              class="form-control"
                              type="text"
                              id="display_text"
                              name="display_text"
                              value="{{ old('display_text') }}"
                              placeholder="eg: MTN"
                            />
                          </div>@error('capital') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror

                          <div class="mb-3 col-md-12 col-lg-12">
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                          </div>

                        </div>
                    </form>
                </div>
                <!-- /Connections -->
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection
