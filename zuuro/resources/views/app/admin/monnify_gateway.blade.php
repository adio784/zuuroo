@extends('app.admin.admin_layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <div class="row g-4 mb-4">
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>Balance</span>
                <div class="d-flex align-items-end mt-2">
                  <h3 class="mb-0 me-2">3</h3>
                  <small class="text-success">(100%)</small>
                </div>
                <small>Total Users</small>
              </div>
              <span class="badge bg-label-primary rounded p-2">
                <i class="bx bx-user bx-sm"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>Successful Payments</span>
                <div class="d-flex align-items-end mt-2">
                  <h3 class="mb-0 me-2">0</h3>
                  <small class="text-success">(+95%)</small>
                </div>
                <small>Recent analytics </small>
              </div>
              <span class="badge bg-label-success rounded p-2">
                <i class="bx bx-user-check bx-sm"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>Pending Transactions</span>
                <div class="d-flex align-items-end mt-2">
                  <h3 class="mb-0 me-2">0</h3>
                  <small class="text-success">(0%)</small>
                </div>
                <small>Recent analytics</small>
              </div>
              <span class="badge bg-label-danger rounded p-2">
                <i class="bx bx-group bx-sm"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div class="content-left">
                <span>Failed Transactions</span>
                <div class="d-flex align-items-end mt-2">
                  <h3 class="mb-0 me-2">3</h3>
                  <small class="text-danger">(+6%)</small>
                </div>
                <small>Recent analytics</small>
              </div>
              <span class="badge bg-label-warning rounded p-2">
                <i class="bx bx-user-voice bx-sm"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Users List Table -->
    
    <div class="card mb-4">
      <h5 class="card-header">Monnify Account Settings</h5>
      <div class="dt-buttons btn-group flex-wrap">
        <button class="btn add-new btn-primary mb-3 mb-md-0" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#addPaymentDetails"><span>Add/Update Details</span></button> 
      </div>

      <div class="modal fade" id="addPaymentDetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
          <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="text-center mb-4">
                <h3 class="role-title">Add New Role</h3>
                <p>Set role permissions</p>
              </div>
              <!-- Add role form -->
              <form class="add-new-user pt-0" id="addNewUserForm">
                <input type="hidden" name="id" id="user_id">
                <div class="mb-3">
                  <label class="form-label" for="secret_key">Secret Key</label>
                  <input type="text" class="form-control" id="secret_key" placeholder="SC_0000000000000" name="secret_key" aria-label="SC_877t78" />
                </div>
                <div class="mb-3">
                  <label class="form-label" for="public_key">Public Key</label>
                  <input type="text" id="public_key" class="form-control" placeholder="PK_000000000000000" aria-label="PK_000000000000000" name="public_key" />
                </div>
                <div class="mb-3">
                  <label class="form-label" for="callback_url">Callback URL</label>
                  <input type="text" id="callback_url" class="form-control phone-mask" placeholder="https://www.000.com/callback_url" aria-label="https://www.000.com/callback_url" name="callback_url" />
                </div>
                <div class="mb-3">
                  <label class="form-label" for="webhook_url">Webhook</label>
                  <input type="text" id="webhook_url" name="webhook_url" class="form-control" placeholder="https://www.000.com/webhook_url" aria-label="webhook_url" />
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
              </form>
              <!--/ Add role form -->
            </div>
          </div>
        </div>
      </div> 
      
      <div class="card-body">
        <ul class="timeline">
          <li class="timeline-item timeline-item-transparent">
            <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-1">
                  <h6 class="mb-0">SECRET KEY</h6>
                  <small class="text-muted"> Get monnify secrete key from monnify dashboard</small>
                </div>
              </div>
              <p class="mb-2">SC_5456456465</p>
          </li>
          <hr>
          <li class="timeline-item timeline-item-transparent">
            <span class="timeline-point timeline-point-warning"></span>
            <div class="timeline-event">
              <div class="timeline-header mb-1">
                <h6 class="mb-0">PUBLIC KEY</h6>
                <small class="text-muted">Get monnify public keyfrom monnify dashboard</small>
              </div>
              <p class="mb-2">PK_7867868767</p>
            </div>
          </li>
          
          <hr>

          <li class="timeline-item timeline-item-transparent">
            <span class="timeline-point timeline-point-warning"></span>
            <div class="timeline-event">
              <div class="timeline-header mb-1">
                <h6 class="mb-0">CALLBACK URL</h6>
                <small class="text-muted">Get monnify public keyfrom monnify dashboard</small>
              </div>
              <p class="mb-2">PK_7867868767</p>
            </div>
          </li>
          <hr>
          <li class="timeline-item timeline-item-transparent">
            <span class="timeline-point timeline-point-warning"></span>
            <div class="timeline-event">
              <div class="timeline-header mb-1">
                <h6 class="mb-0">WEBHOOK  </h6>
                <small class="text-muted">Get monnify public keyfrom monnify dashboard</small>
              </div>
              <p class="mb-2">PK_7867868767</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  
    <!-- pricingModal -->
                <!--/ pricingModal -->

  </div>
  <!-- / Content -->
  
@endsection