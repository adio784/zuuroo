@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Loan Transaction /</span> Summary</h4>

        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);">
                      <i class="bx bx-user me-1"></i> All</a>
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
                              <table class="table" id="table_id">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>TransactionRef</th>
                                    <th>Mobile Recharge</th>
                                    <th>Network</th>
                                    <th>Number</th>
                                    <th>Received Value</th>
                                    <th>Price</th>
                                    <th>Processing State</th>
                                    <th>Repayment</th>
                                    <th>Due Date</th>
                                    <th>Date</th>
                                    {{-- <th>Actions</th> --}}
                                  </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                  @foreach ($LoanHistory as $item)
                                    @php $dt ++ @endphp
                                  <tr>
                                    <td>{{ $dt }}</td>
                                    <td>
                                      <i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>{{ $item->transfer_ref }}</strong>
                                    </td>
                                    <td><span class="badge bg-primary"> {{ $item->purchase }}</span></td>
                                    <td>
                                      <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                        {{ $item->operator_name }}
                                      </ul>
                                    </td>
                                    <td><span class="badge bg-label-info me-1 text-dark">{{ $item->phone_number }}</span></td>
                                    <td> @if($item->purchase == 'Data')
                                            {{ $item->plan }}
                                        @else
                                            {{ number_format($item->product_price) . $item->receive_currency }}
                                        @endif
                                      </td>
                                      <td><span class="badge bg-success"> @if($item->selling_price=='') {{ '0'.' '. $item->receive_currency }} @else {{ number_format($item->selling_price) .' '. $item->receive_currency }} @endif</span></td>
                                    <td>{{ $item->processing_state }}</td>
                                    <td>{{ $item->due_date . ' Days' }}</td>
                                    <td>{{ $item->repayment }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    {{-- <td>
                                      <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                          <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item" href="/loan_receipt/{{ $item->transfer_ref }}"
                                            ><i class="bx bx-edit-alt me-2"></i> Recipt</a
                                          >
                                        </div>
                                      </div>
                                    </td> --}}
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
