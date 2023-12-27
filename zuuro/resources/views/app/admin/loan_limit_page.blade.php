@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Loan Management /</span> Limit
    </h4>

    <div class="row">
        <div class="col-12 mb-md-0 mb-4">
            <div class="card">
                <h5 class="card-header">Set Data Limit Value <h5>
                <div class="card-body">
                    <p>Add new product limit by override the existing value </p>
                    <!-- Connections -->

                        <form action="{{ route('set_productLimit') }}" method="post">
                            @csrf

                            {{-- {!! Toastr::message() !!} --}}

                        <div class="row">

                            <div class="mb-3 col-md-8 col-lg-8 col-sm-12">
                                <input type="hidden" name="product_id" value="{{ $MaxLimit->id }}">
                                <input
                                class="form-control"
                                type="text"
                                id="product"
                                name="product_price"
                                value="{{ $MaxLimit->limit_value }}"
                                placeholder="eg: 2 or 3 %"
                                />
                                @error('product_price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                            </div>
                            <div class="mb-3 col-md-4 col-lg-4 col-sm-12">
                                <h1> <strong># {{ $MaxLimit->limit_value }} </strong></h1>
                            </div>

                            <div class="mb-1 mt-2 col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                            </div>

                        </div>
                        </form>

                    <!-- /Connections -->
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-12 mb-md-0 mb-4">
            <div class="card">
                <h5 class="card-header">Set Airtime Limit Value <h5>
                <div class="card-body">
                    <p>Add new product limit by override the existing value </p>
                    <!-- Connections -->

                        <form action="{{ route('set_productLimit') }}" method="post">
                            @csrf

                            {{-- {!! Toastr::message() !!} --}}

                        <div class="row">

                            <div class="mb-3 col-md-8 col-lg-8 col-sm-12">
                                <input type="hidden" name="product_id" value="{{ $AMaxLimit->id }}">
                                <input
                                class="form-control"
                                type="text"
                                id="product"
                                name="product_price"
                                value="{{ $AMaxLimit->limit_value }}"
                                placeholder="eg: 2 or 3 %"
                                />
                                @error('product_price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                            </div>
                            <div class="mb-3 col-md-4 col-lg-4 col-sm-12">
                                <h1> <strong># {{ $AMaxLimit->limit_value }} </strong></h1>
                            </div>

                            <div class="mb-1 mt-2 col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                            </div>

                        </div>
                        </form>

                    <!-- /Connections -->
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
                    url: "{{ URL::to('isLoanlimit') }}/"+loanId,
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
