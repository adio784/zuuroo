@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Account Settings / </span> Product Categories
    </h4>

    <div class="row">
    <div class="col-md-12">
        <div class="row">

        <div class="col-md-7 col-12">
            <div class="card">
            <h5 class="card-header">Manage Categories</h5>
            <div class="card-body">
                <!-- Social Accounts -->
                <div class="table-responsive">
                    <table class="table" id="table_id">
                        <thead>
                            <th>#</th>
                            <th>Operator</th>
                            <th>Category Code</th>
                            <th>Category</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($Categories as $CatInfo)
                                <?php $dt++; ?>
                                <tr>
                                    <td>{{ $dt }}</td>
                                    <td>{{ $CatInfo->operator_name  }}</td>
                                    <td>{{ $CatInfo->category_code  }}</td>
                                    <td>{{ $CatInfo->category_name}}</td>
                                    <td style="width:50x">
                                        <a href="/delete_productCat/{{$CatInfo->category_code}}" class="" onclick="confirm('Are you sure to continue');"> <span class="avatar-initial rounded bg-label-danger p-1"><i class="bx bx-trash"></i></span> </a>
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
        <div class="col-md-5 col-12 mb-md-0 mb-4">
            <div class="card">
            <h5 class="card-header">Add New Product <h5>
            <div class="card-body">
                <p>Add new product to the list of products ... </p>
                <!-- Connections -->

                <div class="d-flex">
                    <form action="{{ route('add_network') }}" id="country_form" method="post">
                        @csrf

                        {{-- {!! Toastr::message() !!} --}}

                        <div class="row">
                          <div class="mb-3 col-md-12 col-lg-12">
                            <label for="operatorCode" class="form-label">Operators Code</label>
                            <select name="operatorCode" id="" class="form-control">
                                <option value="" selected> -- - --</option>
                                @foreach ($Operator as $Oper)
                                    <option value="{{ $Oper->operator_code }}">{{ $Oper->operator_name }}</option>
                                @endforeach
                            </select>
                            {{-- <input name="operator" id="operator" class="form-control"> --}}
                          </div>@error('operatorCode') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror


                          <div class="mb-3 col-md-12 col-lg-12">
                            <label for="productCat" class="form-label">Product Category</label>
                            <input
                              class="form-control"
                              type="text"
                              id="productCat"
                              name="productCat"
                              value="{{ old('productCat') }}"
                              placeholder="eg: SMH"
                            />
                          </div>@error('productCat') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror

                          <div class="mb-3 col-md-12 col-lg-12">
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                          </div>

                        </div>
                    </form>
                </div>
                <!-- /Connections -->
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection
