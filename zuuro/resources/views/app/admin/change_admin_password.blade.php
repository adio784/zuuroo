{{-- Modal Input PIN --}}
<div class="modal fade" id="modalCenter{{ $user->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="/change_admin_password" method="POST">
            @csrf
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Change Admin Password</h5>
                
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-md-12">
                    <h5 id="confirmVending"></h5>
                </div>
                <div class="col mb-3">
                    <label for="pinfield" class="form-label">Input New Password for Admin</label>
                    <input type="hidden" value="{{ $user->id }}" name="user_id">
                    <input
                    type="text"
                    id="pinfield"
                    class="form-control"
                    placeholder="Enter New Password"
                    name="password"
                    onkeydown="return verify(e)"
                    />
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary me-2" id="submitBtn" >Submit</button>
            </div>
            </div>
        </form> 
  </div>
</div>
{{-- Input PIN Modal --}}