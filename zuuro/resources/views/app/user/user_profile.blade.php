@extends('app.user.layout.user-layout')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

              <div class="row">
                <div class="col-md-12">
                  <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/notifications"
                        ><i class="bx bx-bell me-1"></i> Notifications</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/supports"
                        ><i class="bx bx-link-alt me-1"></i> Connections</a
                      >
                    </li>
                  </ul>
                  <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Result  -->
                    
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                          src="@if(Auth::user()->gender =='Male'){{ asset('img/avatars/boy.png') }} @else {{ asset('img/avatars/girl-1.png') }} @endif"
                          alt="user-avatar"
                          class="d-block rounded"
                          height="100"
                          width="100"
                          id="uploadedAvatar"
                        />
                        
                        <div class="button-wrapper">
                          <button type="button" class="btn btn-primary me-2 mb-4"  data-bs-toggle="modal" data-bs-target="#modalPhoneNumber">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Update Phone Number </span>
                          </button>
                          <button type="button" class="btn btn-outline-secondary account-image-reset mb-4"  data-bs-toggle="modal" data-bs-target="#modalPassword">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset password</span>
                          </button>

                          {{-- <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p> --}}
                        </div>
                      </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return false">

                        @error('password') <span class="text-danger text-sm"> {{ $message }}  </span>@enderror

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

                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Full Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="fullName"
                              value="{{ Auth::user()->name }}"
                              @if( Auth::user()->name !='') {{ 'readonly' }} @endif
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Username</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" value="{{ Auth::user()->username }}"
                              @if( Auth::user()->username !='') {{ 'readonly' }} @endif />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="{{ Auth::user()->email }}"
                              @if( Auth::user()->email !='') {{ 'readonly' }} @endif
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Gender</label>
                            <input
                              type="text"
                              class="form-control"
                              id="organization"
                              name="organization"
                              value="{{ Auth::user()->gender }}" readonly
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="input-group input-group-merge">
                              {{-- <span class="input-group-text">US (+1)</span> --}}
                              <input
                                type="text"
                                id="phoneNumber"
                                name="phoneNumber"
                                class="form-control"
                                value="{{ Auth::user()->mobile }}"
                                @if( Auth::user()->mobile !='') {{ 'readonly' }} @endif
                              />
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ Auth::user()->address }}"
                              @if( Auth::user()->address !='') {{ 'readonly' }} @endif/>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">Country</label>
                            <input class="form-control" type="text" id="state" name="state" value="{{ Auth::user()->country }}"
                              @if( Auth::user()->country !='') {{ 'readonly' }} @endif />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Date of Birth</label>
                            <input
                              type="text"
                              class="form-control"
                              id="zipCode"
                              name="dob"
                              value="{{ date('F d, Y', strtotime(Auth::user()->dob))}}"
                              @if( Auth::user()->dob !='') {{ 'readonly' }} @endif
                              maxlength="6"
                            />
                          </div>
                        </div>
                        {{-- <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Save changes</button>
                          <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div> --}}
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  
                  {{-- Password Reset Modal --}}

                  <div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalCenterTitle">Update Password</h5>
                          <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                          ></button>
                        </div>
                        <form action="/update_password" method="POST" id="updatePasswordForm">
                          @csrf
                          <div class="modal-body">
                            <div class="row">
                              <div class="col mb-3">
                                <label for="pinfield" class="form-label">Input Password</label>
                                <input
                                  type="password"
                                  id="pinfield"
                                  class="form-control"
                                  placeholder="Enter password"
                                  name="password"
                                  required
                                />
                              </div>
                              <div class="col mb-3">
                                <label for="pinfield" class="form-label">Re-Enter Password</label>
                                <input
                                  type="password"
                                  id="pinfield"
                                  class="form-control"
                                  placeholder="Confirm password"
                                  name="password_confirmation"
                                  required
                                />
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary me-2" id="submitBtn" >Submit</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  {{-- Phone Number Update Modal --}}

                  <div class="modal fade" id="modalPhoneNumber" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalCenterTitle">Update Phone Number</h5>
                          <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                          ></button>
                        </div>
                          <form action="/update_phoneNumber" method="POST" id="updatePhoneNumberForm">
                            @csrf
                            <div class="modal-body">
                              <div class="row">
                                <div class="col mb-3">
                                  <label for="pinfield" class="form-label">Input Phone Number</label>
                                  <input
                                    type="tel"
                                    id="pinfield"
                                    class="form-control"
                                    placeholder="Enter Phone Number Starting With Your Country Code eg. 234"
                                    name="phoneNumber"
                                    required
                                  />
                                </div>
                                
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary me-2" id="submitBtn" >Submit</button>
                            </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection