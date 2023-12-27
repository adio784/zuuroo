@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage / </span> Admins
        <a href="/add_admin" class="btn btn-info"> Add Admin </a>
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
                            <div class="table-responsive text-wrap">
                            <table class="table" id="table_id">
                          <div id="result">
                              @if(Session::get('success'))
                                  <div class="alert alert-success alert-dismissible" role="alert">
                                  <strong>Success!</strong> {{ Session::get('success') }}
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                              @endif
                              @if(Session::get('fail'))
                              <div class="alert alert-danger alert-dismissible" role="alert">
                                  <strong>Oh Oops! </strong> {{ Session::get('fail') }}
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                              @endif
                          </div>
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Account Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach($UserInfo as $user)
                      <?php $i++ ?>
                      <tr>
                        <td>{{ $i }}</td>
                        <td>
                          <i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->gender }}</td>
                        <td>
                          <a href="tel:{{ $user->telephone }}" class="btn btn-sm btn-outline-primary p-1"> {{ $user->telephone }}</a>
                        </td>
                        <td><a href="mailto:{{ $user->email }}"><span class="badge bg-primary me-1">{{ $user->email }}</span></a></td>
                        <td><span class="badge @if($user->email_verified_at==""){{ 'bg-secondary' }} @else {{ 'bg-warning' }} @endif">
                          @if($user->email_verified_at=="") {{ 'Unverified' }} @else {{ 'Verified' }} @endif
                        </span></td>
                        <td><span class="badge @if($user->status=="" || $user->status==0){{ 'bg-danger' }} @else {{ 'bg-success' }} @endif">
                          @if($user->status=="" || $user->status==0) {{ 'Suspended' }} @else {{ 'Active' }} @endif
                        </span></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">

                              {{-- View user transaction --}}
                              <a class="dropdown-item" href="user_transaction_page/{{  $user->id }}"
                                ><i class="bx bx-accessibility me-2"></i> Transactions</a
                              >

                              <a class="dropdown-item" href="/remove_admin_page/{{ $user->id }}" onclick="return confirm('Are you sure to remove this admin totally from the system ?')"
                                ><i class="bx bx-trash me-2"></i> Remove Admin</a
                              >

                              @if($user->email_verified_at == "")
                              <a class="dropdown-item" href="/verify_users_page/{{ $user->id }}" onclick="return confirm('Are you sure to verify this admin?')"
                                ><i class="bx bx-user-pin me-2"></i> Verify User</a
                              >@endif

                              {{-- Suspend or reactivate user --}}
                              @if($user->status == 1)
                              <a class="dropdown-item" href="/disable_admin/{{ $user->id }}" onclick="return confirm('Are you sure to suspend this admin?')"
                                ><i class="bx bx-trash me-2"></i> Suspend</a
                              >@endif
                              @if($user->status == 0)
                              <a class="dropdown-item" href="/activate_admin/{{ $user->id }}" onclick="return confirm('Are you sure to reactivate this admin?')"
                                ><i class="bx bx-user-pin me-2"></i> Activate</a
                              >@endif

                              {{-- View user info. --}}
                              <a class="dropdown-item" href="/view_user_info/{{ $user->id }}"
                                ><i class="bx bx-bullseye me-2"></i> View</a
                              >

                              {{-- Change Admin Password --}}
                              <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#modalCenter{{ $user->id }}" onclick="return confirm('Are you sure to changes this admin password?')">
                                <i class="bx bx-user-pin me-2"></i>
                                Change Password
                              </a>

                              {{-- View user info. --}}
                              <a class="dropdown-item" href="/role_permission/{{ $user->id }}"
                                ><i class="bx bx-bullseye me-2"></i> Role & Permission</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                      @include('app.admin.change_admin_password')
                      @endforeach
                    </tbody>
                  </table>
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
