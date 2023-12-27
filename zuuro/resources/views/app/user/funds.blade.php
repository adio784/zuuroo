@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Fund Wallet/</span> Card</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">We secure our payment with Paystack ...</h5>
                    <!-- Data -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                    <form id="paymentForm" method="POST" action="funds">
                      @csrf
                        <!-- Result  -->
                        <div id="error_result">
                          @if(Session::get('success'))
                              <div class="alert alert-success alert-dismissible fade show text-dark" role="alert">
                                  <strong>Success!</strong> {{ Session::get('success') }}
                              </div>
                          @endif
                          @if(Session::get('fail'))
                          <div class="alert alert-danger text-danger alert-dismissible fade show" role="alert">
                              <strong>Oh Oops!</strong> {{ Session::get('fail') }}
                          </div>
                          @endif
                      </div>
                        <div class="row">
                          <div class="mb-3 col-md-12">
                            <label class="form-label" for="pay_amount">Enter Amount to Add</label>
                            <div class="input-group input-group-merge">
                            <span id="phoneNumberIcon" class="input-group-text"><i class="bx bx-naira"></i></span>
                            <input type="number" id="pay_amount" class="form-control phone-mask amount" 
                                  aria-describedby="basic-icon-default-phone2"
                                  name="pay_amount" required>
                            
                            
                            </div>
                            <span id='pay_amount_error' class="text-success text-sm"> </span>
                        </div>
                        
                        <input type="hidden" id="email_address" name="email" value="{{ Auth::user()->email }}" class=""/>
                        <input type="hidden" id="username" name="username" value="{{ Auth::user()->name }}" class="" />
                        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}" class="" />
                        <input type="hidden" id="DistributorRef" name="reference">
                        @php
                          // echo rand();
                        @endphp
                        <div class="mt-2">
                          <button type="submit" id="hideWindowButton" class="btn btn-primary me-2" onclick="payWithPaystack()">Make payment </button>
                        </div>
                      </form>
                       
                    </div>
                    <!-- /Account -->
                  </div>
                 <script>
                    

                    $(document).ready(function(){
                        if($('#pay_amount').length){
                        var userName = document.querySelector('#pay_amount');

                            userName.addEventListener('input', restrictNumber);
                            function restrictNumber (e) {  
                            var newValue = this.value.replace(new RegExp(/[^\d]/,'ig'), "");
                            this.value = newValue;
                            }
                        }
                    })
                </script>
                </div>
              </div>
            </div>
@endsection