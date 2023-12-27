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
            <h5 class="card-header"> Receipt </h5>
            <div class="card-body">
                <!-- Social Accounts -->
                <div>
                    <table width="90%">
                        {{-- id="table_id" --}}
                        <thead>
                            <tr>
                                <th>Name</th> <th>{{ $Histories->name}}</th>
                            </tr>
                            <tr>
                                <th>Username</th> <th>{{ $Histories->username}}</th>
                            </tr>
                            <tr>
                                <th>Email Address</th> <th>{{ $Histories->email}}</th>
                            </tr>
                            <tr>
                                <th>Phone Number</th> <th>{{ $Histories->mobile}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Reference</td> <td>{{$Histories->reference}} </td>
                                </tr>
                                <tr>
                                    <td>Amount</td> <td>{{$Histories->currency}} {{$Histories->amount}} </td>
                                </tr>
                                <tr>
                                    <td>Mode</td> <td>{{$Histories->payment_mode}} </td>
                                </tr>
                                <tr>
                                    <td>Payment ID</td> <td>{{$Histories->payment_id}} </td>
                                </tr>
                                <tr>
                                    <td>Message</td> <td>{{$Histories->message}} </td>
                                </tr>
                                <tr>
                                    <td>Date</td> <td>{{ date('F g, y', strtotime($Histories->created_at) ) }} </td>
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
