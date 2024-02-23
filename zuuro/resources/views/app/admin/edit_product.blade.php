
<?php

// var_dump($ProductInfo);

?>
@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Account Settings / </span> Products
    </h4>

    <div class="row">

      {{-- View Product --}}
      <div class="col-md-12 col-12 mb-md-0 mb-4">
        <div class="card">
        <h5 class="card-header">Manage Product <a href="/manage_products_page" class="btn btn-secondary btn-sm text-white"> Back to product </a> <h5>
        <div class="card-body">
            <!-- Connections -->

                <form id="updateProductForm" method="post">
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

                    {{-- {!! Toastr::message() !!} --}}

                  <div class="row">

                    <div class="mb-3 col-md-12 col-lg-12 col-sm-12">
                        <label for="product_code" class="form-label">Product CODE</label>
                        <input
                          class="form-control"
                          type="text"
                          id="product_code"
                          name="product_code"
                          value="{{ $ProductInfo->product_code }}"
                        />
                        @error('product_code') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>

                      <div class="mb-3 col-md-12 col-lg-12 col-sm-12">
                        <label for="operator_code" class="form-label">Operator CODE</label>
                        <input
                          class="form-control"
                          type="text"
                          id="operator_code"
                          name="operator_code"
                          value="{{ $ProductInfo->operator_code }}"
                        />
                        @error('operator_code') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>




                      <div class="mb-3 col-sm-6">
                        <label for="productCat" class="form-label" id="product_category_toggle">Product Categories</label>
                        <select class="form-control text-dark" id="product_category" name="productCat">
                            @foreach($ProductCat as $prdCat)
                                <option value="{{ $prdCat->category_code }}" @if($prdCat->category_code == $ProductInfo->id) {{ 'selected' }} @endif> {{ $prdCat->category_name }} </option>
                            @endforeach
                        </select>
                        @error('productCat') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>

                      <div class="mb-3 col-md-6 col-sm-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" selected>Enable</option>
                            <option value="2">Disable</option>
                        </select>
                        @error('status') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>


                      <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                        <label for="product" class="form-label">Product Name</label>
                        <input
                          class="form-control"
                          type="text"
                          id="product"
                          name="product_name"
                          value="{{ $ProductInfo->product_name }}"
                          placeholder="eg: MTN SME - 10 GB"
                        />
                        @error('product_name') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>

                     <div class="mb-3 col-md-6 col-sm-6">
                        <label for="validity" class="form-label">Product Validity</label>
                        <select class="form-control" id="validity" name="validity">
                            <option selected>{{ $ProductInfo->validity }}</option>
                            <option>1 Day</option>
                            <option>2 Days</option>
                            <option>3 Days</option>
                            <option>7 Days</option>
                            <option>14 Days</option>
                            <option>30 Days</option>
                        </select>
                        @error('validity') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>

                      <div class="mb-3 col-md-12 col-lg-12 col-sm-12">
                        <label for="cost_price" class="form-label">Cost Price</label>
                        <input
                          class="form-control"
                          type="text"
                          id="cost_price"
                          name="cost_price"
                          value="{{ $ProductInfo->cost_price }}"
                        />
                        @error('cost_price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>

                      <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                        <label for="price" class="form-label">Price</label>
                        <input
                          class="form-control"
                          type="text"
                          id="price"
                          name="product_price"
                          value="{{ $ProductInfo->product_price }}"
                          placeholder="eg: 10"
                        />
                        @error('product_price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>

                      <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                        <label for="loan_price" class="form-label">Loan Price</label>
                        <input
                          class="form-control"
                          type="text"
                          id="loan_price"
                          name="loan_price"
                          value="{{ $ProductInfo->loan_price }}"
                        />
                        @error('loan_price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>





                      <div class="mb-3 mt-4 col-md-12 col-lg-12">
                        <button type="submit" class="btn btn-info w-100 me-2" id="submitBtn">UPDATE RECORD</button>
                      </div>

                  </div>
                </form>

            <!-- /Connections -->
        </div>
        </div>
      </div>
      {{-- View Product --}}

    </div>
</div>

<script>
  $('#operators').on('change', function(){

    $('#product_category').html('');
    let operatorId = $(this).val();
    $('#product_category_toggle').html('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>');
    if(operatorId != "")
    {

      // Getting Product Details Through Network ----------------------------------------------------------------->
      $.ajax({
        method: 'GET',
        url: "{{ URL::to('api/ProductCategoriesByOperator') }}/"+operatorId,
        success:function(result)
        {
          if(result.data != ""){
              $('#product_category_toggle').html('SELECT PRODUCT CATEGORY');
              $('#product_category').html("<option> -- Select Category -- </option>");
              $.each(result.data, function(key, item) {
                $('#product_category').append(
                  '<option value='+item.category_code+'>'+ item.category_name +'</option>'
                )
              });
          }
          else{
            $('#product_category').html('<option value="" selected> No record found </option>');
            $('#product_category_toggle').html('SELECT PRODUCT CATEGORY');
          }
        }
      });
    }
})
</script>

 <script>
    //   Submitting form with Ajax ==============================================================================
        $('#updateProductForm').submit(function(event) {
            event.preventDefault();

            // alert('Form submitted');
            let formData = $(this).serialize();
            $("#submitBtn").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
            $.ajax({
                method: 'POST',
                url: "{{ URL::to('update_product')}}",
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

                    }
                }
            });
        })
</script>
@endsection
