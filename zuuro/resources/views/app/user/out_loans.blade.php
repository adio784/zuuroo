@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Loan</span> Summary</h4>

        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                <a class="nav-link active" href="/loans"><i class="bx bx-user me-1"></i> Paid Loan
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Outstanding Loan
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/funds"
                  ><i class="bx bx-link-alt me-1"></i> Pay outstanding</a
                >
              </li>
            </ul>
            <div class="card mb-4">
            <!-- <h5 class="card-header">Data</h5> -->
            <!-- Data -->

                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table-responsive text-wrap">
                            <table class="table" id="example">
                    <thead>
                      <tr>
                        <th>TransactionRef</th>
                        <th>Mobile Recharge</th>
                        <th>Network</th>
                        <th>Number</th>
                        <th>Received Value</th>
                        <th>Processing State</th>
                        <th>Payment Time</th>
                        <th>Payment Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($LoanInfo as $item)

                      <tr>
                        <td>
                          <i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>{{ $item->transfer_ref }}</strong>
                        </td>
                        <td>{{ $item->purchase }}</td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <span class="badge bg-primary"> {{ $item->operator_code }} </span>
                          </ul>
                        </td>
                        <td><span class="badge bg-label-info me-1">{{ $item->phone_number }}</span></td>
                        <td>{{ $item->receive_value }} @if( $item->purchase !='Data') {{ $item->receive_currency }} @endif </td>
                        <td>{{ $item->processing_state }}</td>
                        <td>{{ $item->payment_status }}</td>
                        <td>{{ $item->due_date .' Days' }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="/user_loanreceipt/{{ $item->transfer_ref }}"
                                ><i class="bx bx-edit-alt me-2"></i> Recipt</a
                              >
                            </div>
                          </div>
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
