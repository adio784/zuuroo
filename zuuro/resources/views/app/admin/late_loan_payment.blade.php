@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span> Late Payments</h4>

        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link " href="/manage_debtors">
                      <i class="bx bx-user me-1"></i> Debtors</a>
                </li>
                {{-- <li class="nav-item">
                  <a class="nav-link" href="/loan_payment_method_page"
                    ><i class="bx bx-bell me-1"></i> Payment Method</a
                  >
                </li> --}}
                <li class="nav-item">
                  <a class="nav-link active" href="javascript:void(0);"
                    ><i class="bx bx-link-alt me-1"></i> Late Payment</a
                  >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/sms_debtors_page"
                      ><i class="bx bx-link-alt me-1"></i> SMS Debtor</a
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
                        <th>#</th>
                        <th>Name</th>
                        <th>Transaction</th>
                        <th>Amount</th>
                        <th>reference</th>
                        <th>Transfer Status</th>
                        <th>Number</th>
                        <th>Send Value</th>
                        <th>Received Value</th>
                        <th>Payment Status</th>
                        <th>Purchase Date</th>
                        <th>Due Date</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($LoanInfo as $item)
                        <?php $dt++; ?>
                      <tr>
                          <td>{{ $dt }}</td>
                        <td>
                          <i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>{{ $item->name }}</strong>
                        </td>
                        <td>@if($item->TransactionType ==2)
                                {{ 'Loan' }}
                            @else
                                {{ 'Topup' }}
                            @endif
                        </td>
                        <td><span class="badge bg-primary"> {{ $item->loan_amount }}</span></td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            {{ $item->transfer_ref }}
                          </ul>
                        </td>
                        <td><span class="badge bg-primary"> {{ $item->processing_state }}</span></td>
                        <td><span class="badge bg-label-info me-1 text-dark">{{ $item->phone_number }}</span></td>
                        <td>  {{ $item->send_value .' '. $item->receive_currency }}  </td>
                        <td> @if($item->Topup == 'Data')
                                {{ $item->DataPlan }}
                            @else
                                {{ number_format($item->selling_price) . $item->ReceiveCurrencyIso }}
                            @endif
                        </td>
                        <td> <span class="badge bg-info"> {{ $item->payment_status }} </span></td>
                        <td>{{ $item->repayment }} <span class="badge bg-warning text-white"> {{  $item->due_date .' Days' }} </span> </td>
                        <td>
                            {{ date('Y-m-d', strtotime($item->repayment. ' + 10 days')) }}
                            {{-- {{ date('F g, Y', strtotime($item->created_at)) }} --}}
                        </td>
                        <?php
                        // $Date = "2010-09-17";
                        // echo date('Y-m-d', strtotime($Date. ' + 1 days'));
                        // echo date('Y-m-d', strtotime($Date. ' + 2 days'));
                        ?>

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
