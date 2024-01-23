@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mobile Recharge /</span> Airtime</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Top-up /Loan - Airtime</h5>
                    <!-- Data -->

                    <hr class="my-0" />
                    <div class="card-body">
                    <form id="formAccountSettings" method="POST">
                      {{-- action="/airtimes" --}}
                      @csrf
                      {{-- {!! csrf_field() !!} --}}

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

                        <div class="row ">
                            <div class="mb-3 col-md-12" >
                              <label class="form-label" for="top_up">Topup option</label>
                              <select id="top_up" class="select2 form-select" name="top_up">
                                <option value="">-- - --</option>
                                 @foreach ($PurchaseService as $Service)
                                    <option value="{{ $Service->svalue }}">{{ $Service->service_name }}</option>
                                @endforeach
                              </select>
                              @error('top_up') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                              <span class="text-danger d-none" id="topup_message"> </span>
                            </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="country" id="select_country">Country</label>
                            <select id="country" class="select2 form-select country_select" name="country">
                              <option value="">-- - --</option>

                            </select>
                            @error('country') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber" id="select_phoneNumber">Phone No.</label>
                            <div class="input-group input-group-merge">
                            <span id="phoneNumberIcon" class="input-group-text"><i class="bx bx-phone"></i></span>
                            <input type="number" maxlength="13" id="phone_Number" class="form-control phone-mask phoneNumber"
                                  placeholder="+ 11658 799 8941"
                                  aria-describedby="basic-icon-default-phone2"
                                  name="phoneNumber">
                            </div>
                            @error('phoneNumber') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                        </div>
                        <div class="mb-3 col-md-12  ">
                            <label class="form-label" for="network" id="select_network">Network </label>
                            <select id="network" class="select2 form-select" name="network_operator">
                              <option value="">-- - --</option>
                              <option value="234">Nigeria</option>

                            </select>
                            @error('network_operator') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>

                          {{-- <div class="mb-3 col-md-12 d-none" id="product_category_toggle">
                            <label class="form-label" for="network" id="select_data_type">Airtime type </label>
                            <select id="product_category" class="select2 form-select" name="product_category">
                              <option value="">-- - --</option>
                              <option value="VTU"> VTU </option>

                            </select>
                            @error('product_category') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div> --}}

                          <div class="mb-3 col-md-12">
                            <label class="form-label" for="amount" id="select_amount"> Amount</label>
                            <input type="number" maxlength="4" id="amount" class="form-control" name="amount">

                            @error('amount') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>

                          <div class="mb-3 col-md-12 d-none" id="loan_term_box">
                            <label class="form-label" for="loan_term">Select Loan Term (days)</label>
                            <input type="text" class="d-none" name="loan_limt" id="loan_limit" value="{{ $MaxLimit->limit_value }}">
                            <select id="loan_term" class="select2 form-select" name="loan_term">
                              <option value="1">-- --</option>
                              @foreach ($LoanInfo as $loan)
                                <option value="{{ $loan->percentage }}"> {{ $loan->labelName .' days' }}  </option>
                              @endforeach
                            </select>
                            @error('loan_term') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>

                          <div class="mb-3 col-md-12">
                            <label id="total_price_select"> Actual Price (2%) on all product </label>
                            <input type="number" maxlength="4" readonly id="total_price" class="form-control disabled total_price" name="total_price">
                            @error('total_price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>



                          @error('pin') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror

                          {{-- <div class="mb-3 col-md-12 d-none mt-2" id="repayment_box">
                            <label class="form-label" for="repayment">Loan Repayment</label>
                            <input type="text" class="form-control" id="repayment"  name="repayment" readonly>
                            @error('repayment') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div> --}}


                        </div>
                        <div class="mb-3 col-md-6 d-none" id="modileNetworkDetaile">  <!--style="display: none"-->
                          <div class="row">
                            <div class="col-md-10">
                              <p>
                                Operator Name: <span id="operator_CName"> <strong>  </strong></span>
                                <div class="form-group">
                                <input type="text" id="DistributorRef" name="DistributorRef" onload="getRandom()">
                                <input type="text" id="actualPerc" value="{{$Info->variation_amount}}" onload="getRandom()">
                                <input type="text" id="loanPerc" value="{{$Info->loan_perc}}" onload="getRandom()">
                                </div>
                              </p>
                            </div>
                          </div>
                        </div>
                        <div class="mt-2">
                          <button id="proceedBtn" type="button" class="btn btn-primary disabled" data-bs-toggle="modal" data-bs-target="#modalCenter">
                            Proceed
                          </button>
                          <button id="clearBtn" type="reset" class="btn btn-outline-secondary">Clear all</button>
                        </div>

                        {{-- Modal Input PIN --}}
                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Input PIN</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col mb-3">
                                    <label for="pinfield" class="form-label">Input PIN to proceed</label>
                                    <input
                                      type="password"
                                      id="pinfield"
                                      class="form-control"
                                      placeholder="Enter PIN"
                                      name="pin"
                                      maxlength="4"
                                    />
                                  </div>
                                  <p> By submitting, you agreed that all information provided are right </p>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary me-2" id="submitBtn" >Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>

                        {{-- Input PIN Modal --}}
                      </form>
                    </div>
                    <!-- /Account -->

                    <script>

                      // This vaidate between Top-up and Loan -------------------------------------------------------------------->
                      $('#top_up').change(function(){
                        let top_up = $(this).val();
                        $('#amount').val("");
                        $('.total_price').val("");
                        $("#select_country").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
                          if(top_up ==1)
                          {
                            // Clear already existing field if topup selected ---###
                            $('#country').html("");
                            $('#network').html("");
                            $('.phoneNumber').val("");
                            $('#product_category').html("");
                            $('#data_plan').html("");
                            // --------------------------------------------------###

                            $('#loan_term_box').addClass('d-none');
                            $('#repayment_box').addClass('d-none');
                            $.ajax({
                              url: "{{ URL::to('api/CountryByStatus') }}",
                              method: 'get',
                              success: function(result){
                                if( result.data != "")
                                {
                                  $("#select_country").html("COUNTRY");
                                  $('#country').html("<option> -- Select Country -- </option>");
                                  $.each( result.data, function(key, item){
                                    $('#country').append(
                                        "<option value="+ item.country_code + ">" + item.country_name  + "</option>"
                                      );
                                  });

                                }else{
                                  $('#country').html("<option> -- Not Available -- </option>");
                                }

                              }

                            });

                          }else if(top_up ==2){
                            // Clear already existing field if topup selected ---###
                            $('#country').html("");
                            $('#network').html("");
                            $('.phoneNumber').val("");
                            $('#product_category').html("");
                            $('#data_plan').html("");
                            // --------------------------------------------------###

                            $('#country').html("-- --");
                            $('#loan_term_box').removeClass('d-none');
                            $('#repayment_box').removeClass('d-none');
                            $.ajax({
                              url: "{{ URL::to('api/isloan') }}",
                              method: 'get',
                              success: function(result){
                                if( result == "")
                                {
                                  $('#country').html("<option> -- Not Available -- </option>");
                                }else{
                                  $("#select_country").html("COUNTRY");
                                  $('#country').html("<option> -- Select Country -- </option>");
                                  $.each( result.data, function(key, item){
                                    $('#country').append(
                                        "<option value="+ item.country_code + ">" + item.country_name  + "</option>"
                                      );
                                  });
                                }
                              }
                            });

                          }else{
                            $("#select_country").html("COUNTRY");
                            $('#loan_term_box').addClass('d-none');
                            $('#country').attr('disabled', false);
                            $('#network').attr('disabled', false);
                            $('.phoneNumber').attr('disabled', false);
                            $('#repayment_box').addClass('d-none');

                            $('#country').html("");
                            $('#network').html("");
                            $('.phoneNumber').val("");
                            $('#product_category').html("");
                            $('#data_plan').html("");
                          }

                      });

                      // Getting Phone-Code and Country Operator Code ------------------------------------------------------------->
                      $('#country').change(function(){
                        let ctr = $('#country').val();
                        $('#amount').val("");
                        $('.total_price').val("");

                        $('#data_plan').html("<option> -- Select Amount -- </option>");
                        $("#select_network").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
                        $("#select_phoneNumber").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
                        $.ajax({
                          method: 'GET',
                          url: "{{ URL::to('api/operatorByCountry') }}/"+ctr,
                          success:function(result)
                          {
                            if(result.data != ""){
                                $("#select_network").html("NETWORK");
                                $('#network').html("<option> -- Select Network -- </option>");
                                $.each(result.data, function(key, item) {
                                  $('#network').append(
                                    '<option value='+item.operator_code+'>'+ item.operator_name +'</option>'
                                  )
                                });

                            }else{
                              $("#select_network").html("NETWORK");
                              $('#network').html("<option> -- Not Available -- </option>");
                            }
                          }
                        });
                        $.ajax({
                          method: 'GET',
                          url: "{{ URL::to('api/CountryPhoneCode') }}/"+ctr,
                          success:function(result)
                          {
                            if(result.data != ""){
                                $("#select_phoneNumber").html("PHONE NO.");
                                let countryCode = result.data.phone_code;
                                $('.phoneNumber').val(countryCode);
                            }

                          }
                          });
                      });

                      // Making Submit Button Available
                      $('#amount').keyup(function(){
                        let amount = parseInt( $(this).val() );
                        var actualPerc = parseInt( $('#actualPerc').val() ) /100;
                        var loanPerc = parseInt( $('#loan_term').val() ) /100;
                        var top_up = $('#top_up').val();
                        var loan_limit = $('#loan_limit').val();
                        var loanPrice = amount + (loanPerc * amount);

                        if(top_up == "")
                        {
                            alert("Select your topup option");
                        }
                        else
                        {
                            if(top_up  ==1 ){
                                $('.total_price').val(amount - (actualPerc* amount ));
                                $('total_price').css('pointer-events','none');
                            }
                            else{
                                if(amount > loan_limit)
                                {
                                    alert('You cannot apply beyond '+ loan_limit);
                                    $('.total_price').val("");
                                    $(this).val("");
                                    $('total_price').css('pointer-events','none');
                                }
                                $('.total_price').val("");
                                $('total_price').css('pointer-events','none');
                            }
                        }

                      });
                      // Making Submit Button Available
                      $('#amount').change(function(){
                        let total_price = $('.total_price').val();
                        if(total_price == "" || total_price == 0){
                          $('#proceedBtn').addClass('disabled');
                        }else{
                          $('#proceedBtn').removeClass('disabled');
                        }
                      });

                      $('#loan_term').change(function(){

                        var actualPerc = parseInt( $(this).val() ) /100;
                        var amountPerc = parseInt( $('#amount').val() ) * actualPerc;
                        var amount = parseInt( $('#amount').val() );
                        var loanPrice = amountPerc + amount;
                        var top_up = $('#top_up').val();

                        if(top_up == "")
                        {
                            alert("Select your topup option");
                        }
                        else
                        {
                            if(amount > loan_limit)
                            {
                                alert('You cannot apply beyond '+ loan_limit + ' loan amount');
                                $('#actualPerc').val("");
                                $(this).val("");
                                $('#proceedBtn').addClass('disabled');
                            }
                            else{
                                $('.total_price').val(loanPrice);
                                $('total_price').css('pointer-events','none');
                                $('#proceedBtn').removeClass('disabled');
                            }

                        }

                      });



                      // Clicking clearAll to disable button
                      $('#clearBtn').on('click', function(){
                        $('#proceedBtn').addClass('disabled');
                      });

                      // Form submition =================================================================================>
                       $('#formAccountSettings').on('submit', function(e) {
                         e.preventDefault();
                         let formData = $(this).serialize();
                         $("#submitBtn").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));

                         // console.log(formData);
                         $.ajax({
                           method: 'POST',
                           url: "{{ URL::to('airtimes') }}",
                           data:formData,
                           dataType: "json",
                           success:function(result)
                           {
                            console.log(result);
                             if(result != ""){
                                    if(result.statusCode == 200)
                                    {
                                        $('#successAlert').removeClass('d-none');
                                        $('#successMsg').append(result.message);
                                        $("#submitBtn").html('Submit');
                                        $('.btn-close').click();
                                        $("#clearBtn").click();
                                    }
                                    else
                                    {
                                        $('#errorAlert').removeClass('d-none');
                                        $('#errorMsg').append(result.message);
                                        $('.btn-close').click();
                                        $("#submitBtn").html('Submit');
                                        $("#clearBtn").click();
                                    }

                                }
                           }
                         })
                       })

                      // Form submition
                      // $('#formAccountSettings').on('submit', function(e) {
                      //   e.preventDefault();
                      //   let formData = $(this).serialize();
                      //   alert('Form Submitted !!!');
                      //   // console.log(formData);
                      //   $.ajax({
                      //     method: 'POST',
                      //     url: "{{ URL::to('datas') }}",
                      //     data:formData,
                      //     dataType: "json",
                      //     success:function(result)
                      //     {
                      //       console.log(result);
                      //     }
                      //   })
                        // $.ajax({
                        //   method: 'GET',
                        //   url: "{{ URL::to('api/operatorByCountry') }}/"+ctr,
                        //   success:function(result)
                        //   {
                        //     if(result.data != ""){
                        //         $("#select_network").html("NETWORK");
                        //         $('#network').html("<option> -- Select Network -- </option>");
                        //         $.each(result.data, function(key, item) {
                        //           $('#network').append(
                        //             '<option value='+item.operator_code+'>'+ item.operator_name +'</option>'
                        //           )
                        //         });

                        //     }else{
                        //       $("#select_network").html("NETWORK");
                        //       $('#network').html("<option> -- Not Available -- </option>");
                        //     }
                        //   }
                        // });
                      // })
                    </script>
                  </div>

                </div>
              </div>
            </div>
@endsection
