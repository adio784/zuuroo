@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Automated Bank Transfer </span></h4>

    <div class="row">
        <div class="col-md-12">
            @foreach ($Record as $item)
                <div class="card mb-4">
                    <!--<h5 class="card-header">{{ $item->account_name }}</h5>-->
                    <!-- Data -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="input-group input-group-merge">
                                    <input type="text"  class="form-control phone-mask amount"
                                    value="Zuuro Telecom-{{ $item->account_name }}" readonly>            
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="input-group input-group-merge">
                                    <input type="number"  class="form-control phone-mask amount"
                                    value="{{ $item->account_number }}" readonly>            
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="input-group input-group-merge">
                                    <input type="text"  class="form-control phone-mask amount"
                                    value="{{ $item->bank_name }}" readonly>            
                                </div>
                            </div>
                        
                        </div>
                    <!-- /Account -->
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection