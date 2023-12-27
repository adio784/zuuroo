@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Transaction/ All Records</span> </h4>

        <div class="row">
          <div class="col-md-12">
          {{-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0);">All</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="{{ route('data_transaction_history') }}">DATA</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('airtime_transaction_history') }}">AIRTIME</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('cable_transaction_history') }}">CABLE TV</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('utilities_transaction_history') }}">BILLER</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('echecker_transaction_history') }}">E_CHECKER</a>
              </li>
            </ul> --}}
            <div class="card mb-4">
            <!-- <h5 class="card-header">Data</h5> -->
            <!-- Data -->

                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table-responsive text-wrap">
                            <table  class="table" id="table_id">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Username</th>
                                  <th>Transfer ID</th>
                                  <th>Purchase</th>
                                  <th>Number</th>
                                  <th>Plan</th>
                                  <th>Price</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                @foreach($UserInfo as $user)
                                <?php $i++ ?>
                                <tr>
                                  <td>{{ $i }}</td>
                                  <td>
                                    <i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>{{ $user->username }}</strong>
                                  </td>
                                  <td>{{ $user->transfer_ref }}</td>
                                  <td>{{ $user->purchase }}</td>
                                  <td> <a href="tel:{{ $user->phone_number }}" class="badge bg-primary"> {{ $user->phone_number }} </a></td>

                                  <td>
                                    <a href="tel:{{ $user->plan }}" class="nav_link"> {{ $user->plan }}</a>
                                  </td>
                                  {{-- Naira sign --}}
                                  <td> <span class="badge bg-label-primary me-1">&#8358; {{ $user->selling_price }}</span> </td>
                                  <td> <span class="badge bg-label-info me-1">{{ $user->created_at }}</span> </td>
                                  <td>
                                    <span class="badge @if($user->processing_state=='failed') {{ 'bg-danger' }} @else {{ 'bg-success' }} @endif">
                                      @if($user->processing_state=='failed') {{ 'Failed' }} @else {{ $user->processing_state }} @endif
                                    </span>
                                  </td>

                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /Account -->
            </div>

          </div>
        </div>
</div>
@endsection
