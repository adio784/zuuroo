@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Transaction / </span> Receipt
    </h4>

    <div class="row">
    <div class="col-md-12">
        <div class="row">

        <div class="col-md-12 col-12">
            <div class="card">
            <h5 class="card-header"> Detailed Loan Report </h5>
            <div class="card-body">
                <!-- Social Accounts -->
                <div>
                    <table width="90%">
                        {{-- id="table_id" --}}
                        <thead style="padding: 20px">
                            <tr style="padding: 20px">
                                <th>Name</th> <th>{{ $User->name }}</th>
                            </tr>
                            <tr style="padding: 20px">
                                <th>Username</th> <th>{{ $User->username}}</th>
                            </tr>
                            <tr>
                                <th>Email Address</th> <th>{{ $User->email}}</th>
                            </tr>
                            <tr style="padding: 20px">
                                <th>Phone Number</th> <th>{{ $User->mobile}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $Info as $info)

                            <br>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Reference</td> <td>{{$info->transfer_ref}} </td>
                                </tr>
                                @if($info->purchase == 'Data')
                                <tr>
                                    <td>Plan</td> <td>{{$info->plan}}  </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Amount</td> <td>{{$info->receive_currency}} {{ number_format($info->selling_price) }} </td>
                                </tr>
                                <tr>
                                    <td>Purchase</td> <td>{{$info->purchase}} </td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td> <td>{{$info->phone_number}} </td>
                                </tr>
                                <tr>
                                    <td>Network</td> <td>{{$info->operator_code}} </td>
                                </tr>
                                <tr>
                                    <td>Country</td> <td>{{$info->country_name}} </td>
                                </tr>
                                <tr>
                                    <td>Due Date</td>
                                    <td>{{ date('Y-m-d', strtotime($info->repayment. ' +'.$info->due_date )) }}</td>
                                    {{-- <td>Due Date</td> <td>{{ date('F g, Y', strtotime($info->created_at) ) }} </td> --}}
                                </tr>
                            </table>

                            <br>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /Social Accounts -->
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection
