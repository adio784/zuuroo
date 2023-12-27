@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage/ Fund</span> Users</h4>

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
                        <th>Details</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach($UserInfo as $user)
                      <?php $i++ ?>
                      <tr>
                        <td>{{ $i }}</td>
                        <td>
                          <strong>{{ $user->fund_by }} </strong>
                          Funded User :=> <strong>{{ $user->name }} </strong>
                          With A Sum Of :=> <strong>&#8358; {{ number_format($user->amount) }} </strong>
                        </td>
                        <td>{{ $user->created_at }}</td>
                        
                      </tr>
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