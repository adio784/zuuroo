@extends('app.user.layout.user-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-4">
            @if(Auth::user()->country_verify_at == "")   
                <div class="card">
                    <div class="card-header"><h2>{{ __('Welcome!') }}</h2> {{ __('Kindly drop the below details, for your KYC verfication ...') }} </div>
                
                    <div class="card-body">
                        <form method="POST"  id="country_kyc_form">
                             <!--action='/api/verify_bvn'-->
                            @csrf
                            <!-- Result  -->
                            <div id="result234">
                               <div class="alert bg-success text-success alert-dismissible fade show d-none" role="alert" id='successAlert'>
                                  <a href="#" class="text-dark">
                                      <strong class="text-dark">Success !!!  </strong> <span id='successMsg'>  </span>
                                  </a>
                                </div> 
                               
                                
                                <div class="alert bg-danger text-danger alert-dismissible fade show d-none" role="alert" id='errorAlert'>
                                  <a href="#" class="text-white">
                                      <strong class="text-white">Oops !!!  </strong> <span id='errorMsg'> </span>
                                  </a>
                                </div> 
                            </div>
                            
                            <div class="row mb-3 mt-4">
                                <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                                    <span id="lastname_error" class="text-danger"></span>
                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 mt-4">
                                <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                                <div class="col-md-6">
                                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="user_country" value="{{ Auth::user()->country }}">
                                    <span id="firstname_error" class="text-danger"></span>
                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                            </div>
                            
                            <div class="row mb-3 mt-4">
                                <label for="middlename" class="col-md-4 col-form-label text-md-end">{{ __('Middle Name') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}" required autocomplete="middlename" autofocus>
                                    <span id="lastname_error" class="text-danger"></span>
                                    @error('middlename')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3 mt-4">
                                <label for="Date_of_birth" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>

                                <div class="col-md-6">
                                    
                                    <div class="input-group">
                                      <span class="input-group-prepend">
                                       
                                        <select class="form-control w-100" required name="dd">
                                            
                                            @for ($i = 1; $i <= 31; $i++)
                                                @if($i < 10)
                                                    <option> 0{{ $i }} </option>
                                                @else
                                                    <option> {{ $i }} </option>
                                                @endif
                                                <!--{{ sprintf("%02d", $i) }}-->
                                                
                                            @endfor
                                            
                                        </select>
                                      </span>
                                      <select class="form-control" required name="mm">
                                            <option> Jan </option>
                                            <option> Feb </option>
                                            <option> Mar </option>
                                            <option> Apr </option>
                                            <option> May </option>
                                            <option> Jun </option>
                                            <option> Jul </option>
                                            <option> Aug </option>
                                            <option> Sep </option>
                                            <option> Oct </option>
                                            <option> Nov </option>
                                            <option> Dec </option>
                                        </select>
                                      <!--<input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">-->
                                      <span class="input-group-append">
                                        <select class="form-control w-100" required name="yy">
                                            @for ($i = 1900; $i <= date('Y')-18; $i++)
                                                
                                                <option> {{ $i }} </option>
                                                
                                            @endfor
                                        </select>
                                      </span>
                                    </div>
                                    
                                    @error('Date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!--<div class="row mb-3 mt-4">-->
                            <!--    <label for="Date_of_birth" class="col-md-4 col-form-label text-md-end">{{ __('Date of Birth') }}</label>-->

                            <!--    <div class="col-md-6">-->
                            <!--        <input id="Date_of_birth" type="text" class="form-control @error('Date_of_birth') is-invalid @enderror" name="Date_of_birth" value="{{ date('d', strtotime(Auth::user()->dob) ).'-'.date('m', strtotime(Auth::user()->dob) ).'-'.date('Y', strtotime(Auth::user()->dob) ) }}" required readonly>-->
                            <!--        @error('Date_of_birth')-->
                            <!--            <span class="invalid-feedback" role="alert">-->
                            <!--                <strong>{{ $message }}</strong>-->
                            <!--            </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->
                            <!--</div>-->

                            <div class="row mb-3 mt-4">
                                <label for="Phone_Number" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                                <div class="col-md-6">
                                    <input id="Phone_Number" type="text" class="form-control @error('Phone_Number') is-invalid @enderror" name="Phone_Number" value="{{ str_replace('234', '0', Auth::user()->mobile) }}" required readonly>
                                    @error('Phone_Number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="bvn" id="bvn_spinner" class="col-md-4 col-form-label text-md-end">{{ __('(BVN)') }}</label>

                                <div class="col-md-6">
                                    <input id="bvn" type="number" class="form-control" name="bvn" required pattern="[0-9]{11}" placeholder="Bank Verification Number ">
                                     <!--pattern="[1-9]{1}[0-9]{11}"-->
                                </div>
                                <input type="hidden" name="transaction_ref" id="DistributorRef">
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        {{ __('Submit') }}
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                
                    <script>
                        $(document).ready( ()=> {
                            var userName = document.querySelector('#bvn');
                            userName.addEventListener('input', restrictNumber);
                            function restrictNumber (e) {  
                            var newValue = this.value.replace(new RegExp(/[^\d]/,'ig'), "");
                            // var newValue = this.value(new RegExp(., '^[0-9]{10}$') );
                            this.value = newValue;
                            }


                            let lastname = $('#lastname').val();
                            let firstname = $('#firstname').val();
                            let firstname_error = $('#firstname_error');
                            let lastname_error = $('#lastname_error');
                            let bvn = $('#bvn').val();
                            let bvnFormData = $('#country_kyc_form').serialize(); //serialize();

                            $('#firstname').on('keyup', ()=> { firstname_error.html(""); });
                            $('#lastname').on('keyup', ()=> { lastname_error.html(""); });
                            $('#bvn1').on('keyup', (e)=> {
                                // console.log(bvn);
                                firstname_error.html("");
                                if( $('#firstname').val().length == 0 )
                                { firstname_error.html("First Name Cannot be Empty ..."); }
                                if( $('#lastname').val().length == 0 )
                                { lastname_error.html("Last Name Cannot be Empty ..."); }
                                else
                                {
                                    firstname_error.html("");
                                    lastname_error.html("");

                                    // Sending Ajax request to the validation end-point
                                    if($('#bvn').val().length === 10){   
                                        $('#bvn').prop('disabled', true);

                                        $('#bvn_spinner').html("(BVN)");
                                        $("#bvn_spinner").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
                                
                                        $.ajax({
                                        method: 'POST',
                                        url: "{{ URL::to('api/verify_bvn') }}/",
                                        data: bvnFormData,
                                        success:function(result)
                                        {
                                            if(result.data != ""){
                                                $('#bvn_spinner').html("(BVN)");
                                                console.log(result);
                                                // $.each(result.data, function(key, item) {
                                                // $('#network').append(
                                                //     '<option value='+item.operator_code+'>'+ item.operator_name +'</option>'
                                                // )
                                                // }); 
                                                
                                            }else{
                                                $('#bvn_spinner').html("(BVN)");
                                            }
                                        }
                                        });
                                    }
                                    console.log(lastname);
                                }
                                
                                
                            });
                            
                        })
                    </script>
                    
                    <script>
                //   Submitting form with Ajax ==============================================================================
                    $('#country_kyc_form').submit(function(event) {
                        event.preventDefault();
                        
                        // alert('Form submitted');
                        let formData = $(this).serialize();
                        $("#submitBtn").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
                        $.ajax({
                            method: 'POST',
                            url: "{{ URL::to('api/verify_bvn')}}",
                            data:formData,
                            success:function(result)
                            {
                                if(result != ""){
                                    if(result.statusCode == 200)
                                    {
                                        $('#successAlert').removeClass('d-none');
                                        $('#successMsg').append(result.message);
                                        $("#submitBtn").html('Submit');
                                    }
                                    else
                                    {
                                        $('#errorAlert').removeClass('d-none');
                                        $('#errorMsg').append(result.message);
                                        $("#submitBtn").html('Submit');
                                    }

                                } else {
                                    $('#errorAlert').removeClass('d-none');
                                    $('#errorMsg').append("Ïnternal Server Error, Try Later");
                                    $("#submitBtn").html("Submit");
                                }
                            }
                        });
                    })
                    </script>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
