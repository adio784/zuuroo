@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Account Settings / </span> Airtime Product
    </h4>

    <div class="row">
      {{-- Add Product --}}
      <div class="col-md-9 col-9 mb-md-0 mb-4">
        <div class="card">
        <h5 class="card-header">Set Airtime Percentage Value <h5>
        <div class="card-body">
            <p>Add new product value to the list of products ... </p>
            <!-- Connections -->

                <form action="{{ route('product_price_perc') }}" id="country_form" method="post">
                    @csrf

                    {{-- {!! Toastr::message() !!} --}}

                  <div class="row">

                      <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                        <input type="hidden" name="product_id" value="{{ $Info->id }}">
                        <input
                          class="form-control"
                          type="text"
                          id="product"
                          name="product_price"
                          value="{{ $Info->variation_amount }}"
                          placeholder="eg: 2 or 3 %"
                        />
                        @error('product_price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>
                      <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                        <h1> <strong> {{ $Info->variation_amount }} % </strong></h1>
                      </div>

                      <div class="mb-3 col-md-8 col-lg-8 col-sm-12 d-none">
                        <label for="loan_perc"> Set Loan Percentage </label>
                        <input type="hidden" name="loan_perc" value="0">
                        <input
                          class="form-control"
                          type="text"
                          id="loan_perc"
                          name="loan_perc"
                          value="{{ $Info->loan_perc }}"
                          placeholder="eg: 2 or 3 %"
                        />
                        @error('loan_perc') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                      </div>
                      <!--<div class="mb-3 col-md-4 col-lg-4 col-sm-12">-->
                      <!--  <h1> <strong> {{ $Info->loan_perc }} % </strong></h1>-->
                      <!--</div>-->



                      <div class="mb-1 mt-2 col-md-12 col-lg-12">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                      </div>

                  </div>
                </form>

            <!-- /Connections -->
        </div>
        </div>
      </div>
    {{-- View Product Details --}}

    </div>
    
    <br>
    {{-- Actually Data Pricing --}}
            <div class="row">
                <div class="col-9 mb-md-0 mb-4">
                    <div class="card">
                        <h5 class="card-header">Set Data Percentage Value <h5>
                        <div class="card-body">
                            <!-- Connections -->

                                <form action="{{ route('product_price_data') }}" method="post">
                                    @csrf

                                    {{-- {!! Toastr::message() !!} --}}

                                <div class="row">

                                    <div class="mb-3 col-md-8 col-lg-8 col-sm-12">
                                        <input type="hidden" name="product_id" value="{{ $DInfo->id }}">
                                        <input
                                        class="form-control"
                                        type="text"
                                        id="product"
                                        name="product_price"
                                        value="{{ $DInfo->variation_amount }}"
                                        placeholder="eg: 2 or 3 %"
                                        />
                                        @error('product_price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                                    </div>
                                    <div class="mb-3 col-md-4 col-lg-4 col-sm-12">
                                        <h1> <strong> {{ $DInfo->variation_amount }} % </strong></h1>
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
@endsection
