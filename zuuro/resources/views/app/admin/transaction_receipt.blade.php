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
                    <table width="50%" height="100px" class='table table-borderless' style="width:50%; text-transform: capitalize">
                        {{-- id="table_id" --}}
                        <thead>
                            <tr>
                                <th>Name: </th> <th>{{ $Histories->name}}</th>
                            </tr>
                            <tr>
                                <th>Username: </th> <th>{{ $Histories->username}}</th>
                            </tr>
                            <tr>
                                <th>Email Address: </th> <th>{{ $Histories->email}}</th>
                            </tr>
                            <tr>
                                <th>Phone Number: </th> <th>{{ $Histories->mobile}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Purchase</td> <td>{{$Histories->purchase}} </td>
                                </tr>
                                <tr>
                                    <td>Country</td> <td>{{$Histories->country_name}} </td>
                                </tr>
                                <tr>
                                    <td>Network</td> <td>{{$Histories->operator_name}} </td>
                                </tr>
                                <tr>
                                    <td>Product Code</td> <td>{{$Histories->product_code}} </td>
                                </tr>
                                @if($Histories->purchase == 'Data')
                                <tr>
                                    <td>Plan</td> <td>{{$Histories->plan}}  </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>To</td> <td>{{$Histories->phone_number}} </td>
                                </tr>
                                <tr>
                                    <td>Amount</td> <td>{{$Histories->selling_price}} </td>
                                </tr>
                                <tr>
                                    <td>Date</td> <td>{{ date('F d, Y', strtotime($Histories->created_at) ) }} </td>
                                </tr>
                            </table>
                            {{-- <tr>
                                <td>{{ $dt }}</td>
                                <td>{{ $Product->country_name  }}</td>
                                <td>{{ $Product->operator_name  }}</td>
                                <td>{{ $Product->product_name}}</td>
                                <td>{{ $Product->product_price }}</td>
                                <td style="width:50x">
                                    <a href="/delete_product/{{$Product->product_code}}" class="" onclick="confirm('Are you sure to continue');"> <span class="avatar-initial rounded bg-label-danger p-1"><i class="bx bx-trash"></i></span> </a>
                                </td>
                            </tr> --}}
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
