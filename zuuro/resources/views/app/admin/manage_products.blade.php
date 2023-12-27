@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Account Settings / </span> Products
    </h4>

    <div class="row">
        
        
        <div class="col-md-12 col-12 mb-md-0 mb-4">
        <div class="card">
            <h5 class="card-header">Add New Product <h5>
            <div class="card-body">
                <p>Add new product to the list of products ... </p>
                <!-- Connections -->
                <!--action="{{ route('add_product') }}"-->

                    <form id="add_productForm" method="post">
                        @csrf

                        {{-- {!! Toastr::message() !!} --}}
                        <!-- Result  -->
                        
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
                            
                            
                        <div id="result2">
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

                                <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>Success!</strong> {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                {{ Session::get('success') }}
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
                        
                        <div class="mb-3 col-md-12 col-lg-12 col-sm-12">
                            <label for="Operators" class="form-label">Country </label>
                            <input
                              class="form-control"
                              type="text"
                              id="country_name"
                              name="countryName"
                              value="{{ ('NG') }}"
                              readonly
                            />
                            @error('countryName') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                        </div>

                        <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                            <label for="Operators" class="form-label">Operators</label>
                            <select class="form-control" id="operators" name="operator">
                                <option value="" selected> -- -- </option>
                            @foreach ($Operator as $opr)
                                <option value="{{ $opr->operator_code }}">{{ $opr->operator_name }}</option>
                            @endforeach
                            </select>
                            @error('operator') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                        </div>


                        <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                            <label for="productCat" class="form-label" id="product_category_toggle">Product Categories</label>
                            <select class="form-control" id="product_category" name="productCat">
                                <option value="" selected> -- -- </option>
                            </select>
                            @error('productCat') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                        </div>

                        <div class="mb-3 col-md-6 col-lg-6">
                            <label for="product" class="form-label">Product</label>
                            <input
                              class="form-control"
                              type="text"
                              id="product"
                              name="product"
                              value="{{ old('product') }}"
                              placeholder="eg: MTN 4.5 GB"
                            />
                          </div>@error('product') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                       

                        <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                            <label for="price" class="form-label">Price</label>
                            <input
                            class="form-control"
                            type="number"
                            maxlength="4"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="eg: 10"
                            />
                            @error('price') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                        </div>
                        
                        <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                            <label for="productCat" class="form-label" id="product_category_toggle">Product Code</label>
                            <input type="text" class="form-control" id="product_code" name="productCode" value="{{ old('productCode') }}">
                            @error('productCode') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                        </div>


                        <div class="mb-3 col-md-6 col-lg-6 col-sm-12">
                            <label for="loanprice" class="form-label">Loan Price </label>
                            <input
                            class="form-control"
                            type="text"
                            id="loanprice"
                            name="loanprice"
                            value="{{ old('loanprice') }}"
                            placeholder="eg: 10 or 0.4"
                            />
                            @error('loanprice') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
                        </div>

                        <div class="mb-3 col-sm-12">
                            <label for="validity" class="form-label">Product Validity</label>
                            <select class="form-control" id="validity" name="validity">
                                <option value=""> -- -- </option>
                                <option>1 Day</option>
                                <option>2 Days</option>
                                <option>3 Days</option>
                                <option>7 Days</option>
                                <option>14 Days</option>
                                <option>30 Days</option>
                                <option>2 Months</option>
                                <option>3 Months</option>
                            </select>
                            @error('validity') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror
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
        
        <br> <br> <br>
        <hr />
        <div class="col-md-12 mt-4">
        <div class="row">

        <div class="col-md-12 col-12">
            <div class="card">
            <h5 class="card-header">Manage Products</h5>
            <div class="card-body">
                <!-- Social Accounts -->
                <div class="table-responsive">
                    <table class="table" id="table_id">
                        <thead>
                            <th>#</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>Operator</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($ProductInfo as $Product)
                                <?php $dt++; ?>
                                <tr>
                                    <td>{{ $dt }}</td>
                                    <td>{{ $Product->country_name  }} </td>
                                    <td><span class="badge @if($Product->status == 1 ) {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif"> 
                                    @if($Product->status == 1) {{ 'Active' }} @else {{ 'Pending' }} @endif</span></td>
                                    <td>{{ $Product->operator_code  }}</td>
                                    <td>{{ $Product->product_name}}</td>
                                    <td>{{ $Product->product_price }}</td>
                                    <td style="width:50x">
                                        
                                        @if( Session('LoggedAdminRole') == 1 )
                                        <!--<a href="/delete_product/{{$Product->product_code}}" disabled class="" onclick="confirm('Are you sure to continue');"> <span class="avatar-initial rounded bg-label-danger p-1"><i class="bx bx-trash"></i></span> </a>-->
                                        @endif
                                        
                                        @if( Session('LoggedAdminRole') == 1 )
                                            @if($Product->status ==0)
                                            <!--href="/activateProduct/{{ $Product->product_code }}"-->
                                            <button class="badge {{ 'bg-success text-dark' }}  activate_product" id="{{ $Product->product_code }}">
                                                Activate 
                                            </button>
                                            @else
                                            <!--href="/deactivateProduct/{{ $Product->product_code }}"-->
                                            <button class="badge bg-secondary  deactivate_product" id="{{ $Product->product_code }}">
                                                Disactivate
                                            </button>
                                            @endif
                                        @endif
                                      
                                      
                                        @if( Session('LoggedAdminRole') == 1 || Session('LoggedAdminRole') == 2)
                                        <a href="/edit_product/{{$Product->product_code}}" class=""> <span class="avatar-initial rounded bg-label-primary p-1"><i class="bx bx-pencil"></i></span> </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /Social Accounts -->
            </div>
            </div>
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


<script>
//   Submitting form with Ajax ==============================================================================
    $('#add_productForm').submit(function(event) {
        event.preventDefault();
        
        // alert('Form submitted');
        let formData = $(this).serialize();
        $("#submitBtn").html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
        $.ajax({
            method: 'POST',
            url: "{{ URL::to('add_product')}}",
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

<script>
//   Activate ==============================================================================
    $('.activate_product').click(function(event) {
        event.preventDefault();
        
        
        let catId = $(this).attr('id');
        $('.activate_product').html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
        alert(catId);
        $.ajax({
            method: 'GET',
            url: "{{ URL::to('activateProduct')}}/"+catId,
            success:function(result)
            {
                if(result != ""){
                    if(result.statusCode == 200)
                    {
                        $('#successAlert').removeClass('d-none');
                        $('#successMsg').append(result.message);
                        $('#activate_product').html('Activate');
                    }
                    else
                    {
                        $('#errorAlert').removeClass('d-none');
                        $('#errorMsg').append(result.message);
                        $('#activate_product').html('Activate');
                    }

                }
            }
        });
    });
    
    
//   DeActivate ==============================================================================
    $('.deactivate_product').click(function(event) {
        event.preventDefault();
        
        
        let catId = $(this).attr('id');
        $('.deactivate_product').html($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
        alert(catId);
        $.ajax({
            method: 'GET',
            url: "{{ URL::to('deactivateProduct')}}/"+catId,
            success:function(result)
            {
                if(result != ""){
                    if(result.statusCode == 200)
                    {
                        $('#successAlert').removeClass('d-none');
                        $('#successMsg').append(result.message);
                        $('.deactivate_product').html('Disactivate');
                    }
                    else
                    {
                        $('#errorAlert').removeClass('d-none');
                        $('#errorMsg').append(result.message);
                        $('.deactivate_product').html('Disactivate');
                    }

                }
            }
        });
    });
</script>


                    
                    
@endsection
