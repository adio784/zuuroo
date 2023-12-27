@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Account Settings / </span> Customer Support
    </h4>

    <div class="row">
    <div class="col-md-12">
        <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
            <h5 class="card-header">Social Accounts</h5>
            <div class="card-body">
                <p>Connect with us on our social accounts</p>
                <!-- Social Accounts -->
                @foreach($Record as $page)
                
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0"><a href="{{ $page->page_link }}" target="_blank">
                        <img src="{{ $page->page_icon }}" alt="facebook" class="me-3" height="30"></a>
                    </div>
                    <div class="flex-grow-1 row">
                        <div class="col-8 col-sm-7 mb-sm-0 mb-2">
                        <h6 class="mb-0">{{ $page->page_type }}</h6>
                        <small class="text-muted">{{ $page->page_name }}</small>
                        </div>
                        <div class="col-4 col-sm-5 text-end">
                        <a href="{{ $page->page_link }}" onclick="return confirm('Are you sure you want to leave this page ?')" class="btn btn-icon btn-outline-secondary">
                            <i class="bx bx-link-alt"></i>
                        </a>
                        </div>
                    </div>
                </div> 
                @endforeach
                
                <!-- /Social Accounts -->
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection