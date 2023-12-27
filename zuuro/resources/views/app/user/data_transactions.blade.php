@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Transaction /</span> Summary</h4>

        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link " href="/transactions">
                      <i class="bx bx-user me-1"></i> All</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="javascript:void(0);"
                    ><i class="bx bx-bell me-1"></i> Data</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/airtime_transactions"
                    ><i class="bx bx-link-alt me-1"></i> Airtime</a
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
                                        <th>Transaction Type</th>
                                        <th>Mobile Recharge</th>
                                        <th>Network</th>
                                        <th>Number</th>
                                        <th>Received Value</th>
                                        <th>Processing State</th>
                                        <th>Payment Time</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach($DataRecord as $item)
                                            <tr>
                                                <td> {{ $item->transfer_ref }} </td>
                                                <td> {{ $item->purchase }} </td>
                                                <td> {{ $item->plan }} </td>
                                                <td> {{ $item->operator_name }} </td>
                                                <td> {{ $item->phone_number }} </td>
                                                <td> {{ $item->receive_value }} </td>
                                                <td> {{ $item->processing_state }} </td>
                                                <td> {{ $item->country_code }} </td>
                                                <td> {{ $item->created_at }} </td>
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