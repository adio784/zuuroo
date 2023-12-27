@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add / </span> Admins
        <a href="/manage_admins" class="btn btn-info btn-sm"> View Admin </a>
    </h4>

        <div class="row">
          <div class="col-md-12">
            <div class="card mb-4">
            <!-- <h5 class="card-header">Data</h5> -->
            <!-- Data -->
            {{-- {//!! Toastr::message() !!} --}}
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="text-wrap">
                                <h4>Add New System Admin</h4>
                                <form action="/add_admin" class="row" method="post">
                                    @csrf
                                    <div class="col-6 mt-4">
                                        <label for="">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name')}}">
                                        @error('name') <span class="text-danger"> {{ $message }} </span>   @enderror
                                    </div>


                                    <div class="col-6 mt-4">
                                        <label for="email">Email Address</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email')}}">
                                        @error('email') <span class="text-danger"> {{ $message }} </span>   @enderror
                                    </div>


                                    <div class="col-6 mt-4">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone')}}">
                                        @error('phone') <span class="text-danger"> {{ $message }} </span>   @enderror
                                    </div>


                                    <div class="col-6 mt-4">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="" selected> -- - -- </option>
                                            <option value="Male"> Male </option>
                                            <option value="Female"> Female </option>
                                        </select>
                                        @error('gender') <span class="text-danger"> {{ $message }} </span>   @enderror
                                    </div>


                                    <div class="col-6 mt-4">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" value="{{ old('password')}}">
                                        @error('password') <span class="text-danger"> {{ $message }} </span>   @enderror
                                    </div>

                                    <div class="col-6 mt-4">
                                        <label for="country">Country</label>
                                        <select name="country" id="country" class="form-control">
                                            <option value="" selected> -- - -- </option>
                                            <option value="Nigeria"> Nigeria </option>
                                            <option value="Other"> Other </option>
                                        </select>
                                        @error('country') <span class="text-danger"> {{ $message }} </span>   @enderror
                                    </div>


                                    <div class="col-12 mt-4">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control"></textarea>
                                        @error('address') <span class="text-danger"> {{ $message }} </span>   @enderror
                                    </div>


                                    <div class="col-12 mt-4 mb-4">
                                        <button class="btn btn-info"> Submit </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /Account -->
            </div>

          </div>
        </div>
</div>
@endsection
