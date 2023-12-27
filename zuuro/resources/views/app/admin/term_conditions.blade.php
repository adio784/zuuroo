@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Private/ </span> Policy </h4>

    <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <h5 class="card-header">Terms & Conditions of Use</h5>
            <div class="card-body">
                <!-- Social Accounts -->
                @if( !empty($Info->write_up ) )
                <div class="d-flex mb-3">
                     <div class="flex-grow-1 row">
                        <div class="termfile">

                            {{ $Info->write_up}}

                        </div>

                    </div>
                </div>
                <a href="/delete_terms/{{$Info->id}}" class="btn btn-info text-white" onclick="return confirm('Are you sure to delete ?')">
                    <i class="bx bx-trash-alt"></i> DELETE TERM-CONDITION</a>
                @endif
                <!-- /Social Accounts -->
            </div>
          </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
              <h5 class="card-header">Input writeup for use of system user ...</h5>
                    <!-- Data -->

                    <hr class="my-0" />
                    <div class="card-body">
                      <form method="post" enctype="multipart/form-data" action="{{ route('terms') }}">
                        @csrf
                         <!-- Result  -->
                <div id="result">
                    @if(Session::get('success'))
                    <div class="bs-toast toast fade show bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                          <i class="bx bx-bell me-2"></i>
                          <div class="me-auto fw-semibold">Success!</div>
                          <small>{{ date('m') }}</small>
                          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            {{ Session::get('success') }}
                        </div>
                      </div>
                    @endif
                    @if(Session::get('fail'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>Oh Oops! </strong> {{ Session::get('fail') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif
                </div>
                    <div class="row">
                    <div class="mb-3 col-md-12">
                            <label class="form-label" for="page"></label>
                            <textarea name="termOfUse" id="summernote" cols="30" rows="10" class="form-control"></textarea>
                        </div>

                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Submit</button>
                          <button type="reset" class="btn btn-outline-secondary">Clear all</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>

                </div>
              </div>
            </div>
@endsection
