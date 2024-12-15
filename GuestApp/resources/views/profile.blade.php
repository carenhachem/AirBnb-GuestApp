@extends('layouts.app')

@push('styles')
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush

@section('content')
  <div class="container light-style flex-grow-1 container-p-y">

      <h4 class="font-weight-bold py-3 mb-4">Profile</h4>

      <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
          <div class="col-md-3 pt-0">
            <div class="list-group list-group-flush account-settings-links">
              <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
              <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
            </div>
          </div>
          <div class="col-md-9">
            <div class="tab-content">
              <!-- General Tab -->
              <div class="tab-pane fade active show" id="account-general">
                <form action="{{ route('profile.update', $user->userid) }}" method="POST" id="updateProfileForm" enctype="multipart/form-data">
                  @csrf
                  @method('PUT') 
                  @if ($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                  @endif 
                  <div class="card-body media align-items-center">
                    <img src="{{ $user->profilepic ? asset('uploads/profiles/' . $user->profilepic) :'https://bootdey.com/img/Content/avatar/avatar1.png' }}" 
                        alt="" class="d-block ui-w-80">
                    <div class="media-body ml-4">
                      <label class="btn btn-outline-primary">
                        Upload new photo
                        <input type="file" name="profilepic" class="account-settings-fileinput">
                      </label>
                      <div class="text-light small mt-1">Allowed JPG, JPEG, or PNG. Max size of 2048K</div>
                    </div>
                  </div>
                  <hr class="border-light m-0">
                  <div class="card-body">
                    <div class="form-group">
                      <label class="form-label">First Name</label>
                      <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Last Name</label>
                      <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Username</label>
                      <input type="text" class="form-control mb-1" value="{{ $user->username }}" disabled>
                    </div>
                    <div class="form-group">
                      <label class="form-label">E-mail</label>
                      <input type="text" class="form-control mb-1" value="{{ $user->email }}" disabled>
                    </div>
                  </div>
                </form>
              </div>
              <!-- Change Password Tab -->
              <div class="tab-pane fade" id="account-change-password">
                <form action="{{ route('profile.change-password', $user->userid) }}" method="POST" id="changePasswordForm">
                  @csrf
                  @method('PUT')
                  @if ($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                  @endif 
                  <div class="card-body pb-2">
                    <div class="form-group">
                      <label class="form-label">Current Password</label>
                      <input type="password" class="form-control" name="current_password">
                    </div>
                    <div class="form-group">
                      <label class="form-label">New Password</label>
                      <input type="password" class="form-control" name="new_password">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Repeat New Password</label>
                      <input type="password" class="form-control" name="new_password_confirmation">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Save Changes Button -->
      <div class="text-right mt-3">
        <button id="saveChangesBtn" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('accomodations.index') }}">
          <button type="button" class="btn btn-secondary">Cancel</button>
        </a>
      </div>
      <br>
  </div>
@endsection


@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Handle Save Changes button click
    document.getElementById('saveChangesBtn').addEventListener('click', function() {
      const activeTab = document.querySelector('.tab-pane.active');
      const form = activeTab.querySelector('form');
      if (form) form.submit();
    });
  </script>
@endpush
