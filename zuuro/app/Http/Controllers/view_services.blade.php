@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account Settings / </span> Services
    </h4>

    <div class="row">
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12 col-12">
                <div class="card">
                <h5 class="card-header">Manage Data Services </h5>
                <div class="card-body">

                    <!-- Social Accounts -->
                    <div class="table-responsive">
                        <table class="table hoverable">
                            <thead>
                                <th>#</th>
                                <th>Operators</th>
                                <th>Category</th>
                                <th>Code</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @foreach($Categorynfo as $Network)
                                    <?php $dt++; ?>

                                    <tr>
                                        <td> {{  $dt }}</td>
                                        <td>
                                            <a href="/switch_operator_api/{{ $Network->operator_name }}">
                                                <img src="{{ $Network->logo_url }}" class="w-25">
                                                {{-- <span class="badge bg-info">{{ $Network->operator_name }}</span> --}}
                                            </a>
                                        </td>
                                        <td> {{ $Network->category_name }} </td>
                                        <td>{{ $Network->category_code }}</td>
                                        <td><span class="badge @if($Network->status==1) {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif"> @if($Network->status==1) {{ 'Active' }} @else {{ 'Pending' }} @endif</span></td>
                                        <td>
                                            @if($Network->status ==0)
                                            <a href="/activateService/{{ $Network->category_code }}" class="badge {{ 'bg-success text-dark' }}">
                                                Activate
                                            </a>
                                            @else
                                            <a href="/deactivateService/{{ $Network->category_code }}" class="badge {{ 'bg-secondary' }}">
                                                Disactivate
                                            </a>
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /Social Accounts -->
                </div>
                </div>
            </div>


            <h4 class="fw-bold py-3 mb-4">
                Purchase <span class="text-muted fw-light"> Subcription Service </span>
            </h4>
            {{-- Cable Services --}}
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                <h5 class="card-header">Manage Cable Services </h5>
                <div class="card-body">

                    <!-- Social Accounts -->
                    <div class="table-responsive">
                        <table class="table hoverable">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Value</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @foreach($PurchaseService as $Data)
                                    <?php $dt++; ?>

                                    <tr>
                                        <td> {{  $dt }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $Data->service_name }}</span>
                                        </td>
                                        <td> {{ $Data->service_code }} </td>
                                        <td>{{ $Data->svalue }}</td>
                                        <td><span class="badge @if($Data->service_state==1) {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif"> @if($Data->service_state==1) {{ 'Active' }} @else {{ 'Pending' }} @endif</span></td>
                                        <td>
                                            @if($Data->service_state ==0)
                                            <a href="/activateOService/{{ $Data->service_code }}" class="badge {{ 'bg-success text-dark' }}">
                                                Activate
                                            </a>
                                            @else
                                            <a href="/deactivateOService/{{ $Data->service_code }}" class="badge {{ 'bg-secondary' }}">
                                                Disactivate
                                            </a>
                                            @endif
                                        </td>
                                    </tr>

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
