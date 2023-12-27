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
            <h5 class="card-header"> Fund Receipt </h5>
            <div class="card-body">
                <!-- Social Accounts -->
                <div>
                    <table width="90%">
                        {{-- id="table_id" --}}
                        <thead style="padding: 20px">
                            <tr>
                                <th>Name</th> <th>{{ $Payment->name }}</th>
                            </tr>
                            <tr>
                                <th>Username</th> <th>{{ $Payment->username}}</th>
                            </tr>
                            <tr>
                                <th>Email Address</th> <th>{{ $Payment->email}}</th>
                            </tr>
                            <tr>
                                <th>Phone Number</th> <th>{{ $Payment->mobile}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Reference</td> <td>{{$Payment->reference}} </td>
                                </tr>
                                <tr>
                                    <td>Amount</td> <td>{{$Payment->currency}} {{$Payment->amount}} </td>
                                </tr>
                                <tr>
                                    <td>Mode</td> <td>{{$Payment->payment_mode}} </td>
                                </tr>
                                <tr>
                                    <td>Payment ID</td> <td>{{$Payment->payment_id}} </td>
                                </tr>
                                <tr>
                                    <td>Message</td> <td>{{$Payment->message}} </td>
                                </tr>
                                <tr>
                                    <td>Date</td> <td>{{ date('F g, Y', strtotime($Payment->created_at) ) }} </td>
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
