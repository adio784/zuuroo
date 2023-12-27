@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Loan Management / </span> Repayment
    </h4>

    <div class="row">
        <div class="col-md-6">
            {{-- Actually Data Pricing --}}
        
{{-- Atually Airtime Percentage --}}
            <div class="row">
                <div class="col-sm-12 mb-md-0 mb-4">
                    <div class="card">
                        <h5 class="card-header">Manage Repayment date %</h5>
                        <div class="card-body">
                            <!-- Connections -->
                            @foreach ($LoanInfo as $Info)

                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <h1>{{$Info->percentage}}%  &nbsp;</h1>
                                    </div>
                                    <div class="flex-grow-1 row">
                                        <div class="col-3 mb-sm-0 mb-2">
                                        <h6 class="mb-0">{{$Info->labelName}}</h6>
                                        <small class="text-muted">@if($Info->status==1){{ 'Active' }} @else {{ 'Disabled' }} @endif</small>
                                        </div>
                                        <div class="col-3 text-end">
                                            <div class="form-check form-switch">
                                                <input id="activateRepay" class="form-check-input float-end IsLoanlimit" value="{{$Info->id}}" type="checkbox" role="switch" @if($Info->status== true) {{'checked'}} @else {{ 'unchecked'}} @endif />
                                                
                                            </div>
                                        </div>
                                        <div class="col-4 col-sm-5 text-end">
                                            <a href="/delete_loanLimit/{{$Info->id}}" type="button" class="btn btn-icon btn-outline-danger pr-3" onclick="confirm('Are you sure to continue');">
                                                <i class="bx bx-trash-alt mr-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- /Connections -->
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <div class="col-md-6">
            {{-- Actually Data Pricing --}}
            <div class="row">
                <div class="col-12 mb-md-0 mb-4">
                    <div class="card">
                        <h5 class="card-header">Repayment date %</h5>
                        <div class="card-body">
                            <!-- Social Accounts -->
                            <form action="{{ route('add_loanLimit') }}" id="add_loanLimit" method="post">
                                @csrf
                            <!-- Result  -->
                                <div class="row">
                                    <div class="mb-3 col-md-12 col-lg-12">
                                        <label for="labelName" class="form-label">Day</label>
                                        <input
                                        class="form-control"
                                        type="text"
                                        id="labelName"
                                        name="labelName"
                                        value="{{ old('labelName') }}"
                                        />
                                    </div>@error('countryName') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                                    <div class="mb-3 col-md-12 col-lg-12">
                                        <label for="Percentage" class="form-label">Percentage</label>
                                        <input
                                        class="form-control"
                                        type="text"
                                        id="Percentage"
                                        name="Percentage"
                                        value="{{ old('Percentage') }}"
                                        placeholder="10"
                                        />
                                    </div>@error('Percentage') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror

                                    <div class="mb-3 col-md-12 col-lg-12">
                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    </div>

                                </div>
                            </form>
                            <!-- /Social Accounts -->
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<script>
    $(document).ready(function() {
        $('.IsLoanlimit').on('click', function() {
            confirm('Are you sure to continue');
            var loanId = $(this).val();
            if(loanId != "")
            {
                $.ajax({
                    method: 'GET',
                    url: "{{ URL::to('activateRepay') }}/"+loanId,
                    success:function(result)
                    {
                       alert(result.message);
                    }
                });
            }
        })
    })
</script>
@endsection
