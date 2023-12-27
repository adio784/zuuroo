@extends('app.user.layout.user-layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mobile Recharge /</span> Data</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Top-up /Loan - Data</h5>
                    <!-- Data -->

                    <hr class="my-0" />
                    <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="/datas">
                      {{-- action="/sendDataTransfer" --}}
                      @csrf
                      {{-- {!! csrf_field() !!} --}}
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
                        <div class="row ">
                            <div class="mb-3 col-md-12" >
                              <label class="form-label" for="top_up">Topup option</label>
                              <select id="top_up" class="select2 form-select" name="top_up">
                                <option value="">-- - --</option>
                                <option value="1">Topup</option>
                                <option value="2"> Loan </option>
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

                            </select>
                            @error('network_operator') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>

                          <div class="mb-3 col-md-12 d-none" id="product_category_toggle">
                            <label class="form-label" for="network" id="select_data_type">Data type </label>
                            <select id="product_category" class="select2 form-select" name="product_category">
                              <option value="">-- - --</option>

                            </select>
                            @error('product_category') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>

                          <div class="mb-3 col-md-12">
                            <label class="form-label" for="data_plan" id="select_dataplan"> Data Plan</label>
                            <select id="data_plan" class="select2 form-select" name="data_plan">
                              <option value="">-- - --</option>

                            </select>
                            @error('data_plan') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>


                          <div class="mb-3 col-md-12 d-none" id="loan_term_box">
                            <label class="form-label" for="loan_term">Select Loan Term (days)</label>
                            <select id="loan_term" class="select2 form-select" name="loan_term">
                              <option value="">-- --</option>
                              @foreach ($LoanInfo as $loan)
                                <option> {{ $loan->labelName }} </option>
                              @endforeach
                            </select>
                            @error('loan_term') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>
                          @error('pin') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror

                          <div class="mb-3 col-md-12 d-none mt-2" id="repayment_box">
                            <label class="form-label" for="repayment">Loan Repayment</label>
                            <input type="text" class="form-control" id="repayment"  name="repayment" readonly>
                            @error('repayment') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                          </div>


                        </div>
                        <div class="mb-3 col-md-6 d-none" id="modileNetworkDetaile">  <!--style="display: none"-->
                          <div class="row">
                            <div class="col-md-10">
                              <p>
                                Operator Name: <span id="operator_CName"> <strong>  </strong></span>
                                <div class="form-group">
                                <input type="text" id="DistributorRef" name="DistributorRef" onload="getRandom()">
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
                        $('#data_plan').html("<option> -- Select Data Plan -- </option>");
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

                      // Getting Product through Category and Product List -------------------------------------------------------->
                      $('#network').on('change', function(){
                        let networkId = $(this).val();
                        if(networkId != "")
                        {

                          $.ajax({
                            method: 'GET',
                            url: "{{ URL::to('api/ProductCategoriesByOperator') }}/"+networkId,
                            success:function(result)
                            {
                              if(result.data != ""){
                                  $('#product_category_toggle').removeClass('d-none');
                                  $('#product_category').html("<option> -- Select Category -- </option>");
                                  $.each(result.data, function(key, item) {
                                    $('#product_category').append(
                                      '<option value='+item.category_code+'>'+ item.category_name +'</option>'
                                    )
                                  });

                              }else{
                                $('#product_category_toggle').addClass('d-none');
                                $("#select_dataplan").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
                                var top_up = $('#top_up').val();
                                $.ajax({
                                    method: 'GET',
                                    url: "{{ URL::to('api/ProductByOperator') }}/"+networkId,
                                    success:function(result)
                                    {

                                      if(result != ""){
                                          $("#select_dataplan").html("DATA PLAN");
                                          $('#data_plan').html("<option value=''> -- Select Data Plan -- </option>");
                                          if(top_up ==1 ){
                                            $.each(result.data, function(key, item) {
                                            $data_value = [item.product_code];
                                            $('#data_plan').append(
                                                '<option value='+$data_value+'>'+ item.product_name + '  --|--  '+  new Intl.NumberFormat().format(item.product_price) + ' ' + item.receive_currency + item.validity +' ' +'</option>'
                                            )
                                            });
                                        }else{
                                                $.each(result.data, function(key, item) {
                                                $data_value = [item.product_code];
                                                $('#data_plan').append(
                                                    '<option value='+$data_value+'>'+ item.product_name +'</option>'
                                                )
                                                });
                                        }
                                          // $('#DistributorRef').val(getRandom());
                                          // $('#DefaultDisplayText').val(item.product_name);
                                          // $('#SendCurrencyIso').val(item.commission_rate);
                                          // $('#SName').val('Data');
                                          // $('#BillRef').val(item.product_code);
                                          // $('#ReceiveCurrencyIso').val(item.receive_currency);
                                          // Passing values
                                          // $('#DistributorRef').val(distributorReference);




                                      }
                                    }
                                });


                              }
                            }
                          });
                        }else{
                          $('#product_category_toggle').hide();
                        }

                      });

                      // Getting Product Details Through Category ----------------------------------------------------------------->
                      $('#product_category').on('change', function() {
                        let categoryId = $(this).val();
                        // alert(categoryId);
                        $("#select_dataplan").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
                        if(categoryId =="")
                        {
                          $('#data_plan').html("");
                        }else{
                              $.ajax({
                                  method: 'GET',
                                  url: "{{ URL::to('api/ProductByCategory') }}/"+categoryId,
                                  success:function(result)
                                  {

                                    if(result.data != ""){
                                      $("#select_dataplan").html("DATA PLAN");
                                        var top_up = $('#top_up').val();
                                        $('#data_plan').html("<option value=''> -- Select Data Plan -- </option>");
                                        if(top_up ==1 ){
                                            $.each(result.data, function(key, item) {
                                            $data_value = [item.product_code];
                                            $('#data_plan').append(
                                                '<option value='+$data_value+'>'+ item.product_name + '  --|--  '+  new Intl.NumberFormat().format(item.product_price) + ' ' + item.receive_currency + item.validity +' ' +'</option>'
                                            )
                                            });
                                        }else{
                                            $.each(result.data, function(key, item) {
                                            $data_value = [item.product_code];
                                            $('#data_plan').append(
                                                '<option value='+$data_value+'>'+ item.product_name +'</option>'
                                            )
                                            });
                                        }

                                    }
                                  }
                              });
                            }
                      });

                      // Making Submit Button Available
                      $('#data_plan').change(function(){
                        var dataId = $(this).val();
                        var top_up = $('#top_up').val();
                        let data_plan_value = $(this).val();
                        if(data_plan_value == ""){
                          $('#proceedBtn').addClass('disabled');
                        }else{
                            $.ajax({
                            method: 'GET',
                            url: "{{ URL::to('api/getProductById') }}/"+dataId,
                            success:function(result)
                            {
                                if(result.data != ""){
                                    if( top_up == 1 ){
                                        $('#repayment').val(result.data.product_price);
                                    }else{
                                        $('#repayment').val(result.data.loan_price);
                                    }

                                }

                            }
                          });
                          $('#proceedBtn').removeClass('disabled');
                        }
                      });

                      // Clicking clearAll to disable button
                      $('#clearBtn').on('click', function(){
                        $('#proceedBtn').addClass('disabled');
                      });

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
