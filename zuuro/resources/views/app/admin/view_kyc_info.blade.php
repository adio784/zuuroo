@extends('app.admin.admin_layout')

@section('content')

        <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">KYC Settings /</span> <a href="{{ route('manage_users_page') }}"> User </a> </h4>

              <div class="row">
                <div class="@if ($getUserInfo->transaction_ref==0){{ 'col-md-6' }}@else {{ 'col-md-12' }} @endif"> 
                    <div class="card">
                        <div class="card-header"><h1>KYC Application</h1></div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label for="">Refference</label>
                                <input readonly type="text" class="form-control" value="{{ $getUserInfo->transaction_ref }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Fullname</label>
                                <input readonly type="text" class="form-control" value="{{ $getUserInfo->first_name. ' ' .$getUserInfo->middle_name .' '. $getUserInfo->last_name }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Gender</label>
                                <input readonly type="text" class="form-control" value="{{ $getUserInfo->gender }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Email Address</label>
                                <input readonly type="text" class="form-control" value="{{ $getUserInfo->email }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Phone Number</label>
                                <input readonly type="text" class="form-control" value="{{ $getUserInfo->mobile }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Bank Verification Number (BVN)</label>
                                <input readonly type="text" class="form-control" value="{{ $getUserInfo->id_number }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Date of Birth</label>
                                <input readonly type="text" class="form-control" value="{{ $getUserInfo->date_of_birth }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Date of Birth</label>
                                <input readonly type="text" class="form-control" value="{{ $getUserInfo->date_of_birth }}">
                            </div>
                            <div class="form-group mb-4">
                                <a class="btn @if($getUserInfo->verificationStatus ==0) {{ 'btn-danger' }} @else {{ 'btn-success' }} @endif text-white w-100" >@if($getUserInfo->verificationStatus ==0) {{ 'Pending' }} @else {{ 'Verified & Approved' }} @endif</a>
                            </div>
                            <div class="form-group mt-3">
                               
                            </div>
                        </div>
                    </div>
                </div>

                @if ($getUserInfo->transaction_ref==0)
                <div class="col-md-6"> 
                    <div class="card">
                        <div class="card-header"><h1>User Information </h1></div>
                        <div class="card-body">
                            <div class="form-group mb-4">
                                <label for="">Name</label>
                                <input readonly type="text" class="form-control" value="{{ $UserInfo->name }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Username</label>
                                <input readonly type="text" class="form-control" value="{{ $UserInfo->username }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Email Address</label>
                                <input readonly type="text" class="form-control" value="{{ $UserInfo->email }}">
                            </div>
                            <div class="form-group mb-4">
                                <label for="">Phone Number</label>
                                <input readonly type="text" class="form-control" value="{{ $UserInfo->mobile }}">
                            </div>

                            @if ($getUserInfo->transaction_ref==0)
                            <div class="form-group mb-4">
                                <a href="/approve_kyc/{{ $getUserInfo->transaction_ref }}" class="btn btn-dark text-white w-100" onclick="return confirm('Are you sure to approve this aplication ?')">Approve ?</a>
                            </div>
                           
                            <div class="card-body bg-gray">
                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                      <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                          <strong> Query KYC Application </strong>
                                        </button>
                                      </h2>
                                      <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                          <form action="/query_kyc" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Message</label>
                                                <input name="user_id" type="text" class="form-control" value="{{ $getUserInfo->user_id }}">
                                                <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                   
                                    
                                  </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                @endif

              </div>

        </div>
       

@endsection