@php
    $User  = App\Models\User::whereId($Info->user_id)->first();
    $UserLoan  = App\Models\Wallet::where('user_id', $Info->user_id)->first();
@endphp
@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Transaction / </span> Receipt
    </h4>

    <div class="row">
    <div class="col-md-12">
        <div class="row">
<img src="" alt="">
        <div class="col-md-12 col-12">
            <div class="card">
            <h3 class="card-header"> Detailed Loan Report </h3>
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
                            <table class="table table-bordered">
                                <tr>
                                    <td>Reference</td> <td>{{$Info->transfer_ref}} </td>
                                </tr>
                                <tr>
                                    <td>Amount</td> <td>{{$Info->receive_currency}} {{$Info->selling_price}} </td>
                                </tr>
                                <tr>
                                    <td>Purchase</td> <td>{{$Info->purchase}} </td>
                                </tr>
                                @if($Info->purchase == 'Data')
                                <tr>
                                    <td>Plan</td> <td>{{$Info->plan}}  </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Phone Number</td> <td>{{$Info->phone_number}} </td>
                                </tr>
                                <tr>
                                    <td>Network</td> <td>{{ strtoupper($Info->operator_code) }} </td>
                                </tr>
                                <tr>
                                    <td>Country</td> <td>{{$Info->country_name}} </td>
                                </tr>
                                <tr>
                                    <td> Payment Status </td> <td><span class="badge bg-info @if($Info->payment_status == 'paid') {{ 'bg-success' }} @elseif($Info->payment_status == 'partially') {{ 'bg-warning' }} @else {{ 'bg-danger' }} @endif"> {{$Info->payment_status }}  </span> </td>
                                </tr>
                                @if($Info->payment_status == 'partially')
                                <tr>
                                    <td>Amount Paid</td> <td>{{$Info->receive_currency}} {{ $Info->amount_paid}}  </td>
                                </tr>
                                <tr>
                                    <td>Amount Left</td> <td>{{$Info->receive_currency}} {{ $Info->loan_amount}}  </td>
                                </tr>

                                @endif
                                <tr>
                                    <td>Loan Date</td> <td> {{ date('D-d F, Y', strtotime($Info->created_at ) ) }} </td>
                                </tr>
                                <tr>
                                    <td>Due Date</td>
                                    <td>{{ date('D-d F, Y', strtotime($Info->repayment ) ) }}</td>
                                    {{-- <td>Due Date</td> <td>{{ date('D g, Y', strtotime($Info->due_date) ) }} </td> --}}
                                </tr>

                                <tr>
                                        <td>Repayment Date</td>
                                        <td>
                                            @if($Info->payment_status == 'paid')
                                                {{ date('D-d F, Y', strtotime($Info->updated_at ) ) }}
                                            @else
                                                <span class="badge bg-warning"> Pending </span>
                                            @endif
                                        </td>
                                </tr>

                            </table>
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
