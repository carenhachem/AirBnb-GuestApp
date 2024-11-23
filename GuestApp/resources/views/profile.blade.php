<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Profile </title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS -->
  <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
</head>
<body>
<div class="container light-style flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      Profile   
    </h4>

    <div class="card overflow-hidden">
      <div class="row no-gutters row-bordered row-border-light">
        <div class="col-md-3 pt-0">
          <div class="list-group list-group-flush account-settings-links">
            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
            {{-- <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a> --}}
            {{-- <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social-links">Social links</a> --}}
            {{-- <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-connections">Connections</a> --}}
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane fade active show" id="account-general">
              <form action="{{ route('profile.update', $user->userid) }}" method="POST" id="updateProfileForm">
                @csrf         
                @method('PUT') 
              <div class="card-body media align-items-center">
                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="d-block ui-w-80">
                <div class="media-body ml-4">
                  <label class="btn btn-outline-primary">
                    Upload new photo
                    <input type="file" class="account-settings-fileinput">
                  </label> &nbsp;
                  {{-- <button type="button" class="btn btn-default md-btn-flat">Reset</button> --}}

                  <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                </div>
              </div>
              <hr class="border-light m-0">

              <div class="card-body">
                <div class="form-group">
                  <label class="form-label">First Name</label> 
                  <input type="text" class="form-control" name= "first_name" value="{{ $user->first_name }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name= "last_name" value="{{ $user->last_name }}">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control mb-1" name= "username" value="{{ $user->username }}">
                  </div>
                <div class="form-group">
                  <label class="form-label">E-mail</label>
                  <input type="text" class="form-control mb-1" value="{{ $user->email }}" disabled>
                  {{-- <div class="alert alert-warning mt-3">
                    Your email is not confirmed. Please check your inbox.<br>
                    <a href="javascript:void(0)">Resend confirmation</a>
                  </div> --}}
                </div>
                {{-- <div class="form-group">
                  <label class="form-label">Company</label>
                  <input type="text" class="form-control" value="Company Ltd.">
                </div> --}}
              </div>
              <button type="submit" class="btn btn-primary" onclick="submitUpdateProfile()">Save changes</button>&nbsp;
            </form>
            </div>
            <div class="tab-pane fade" id="account-change-password">
              <form action="{{ route('profile.change-password', $user->userid) }}" method="POST" id="changePasswordForm">
                @csrf         
                @method('PUT')         
                <div class="card-body pb-2">
                      <div class="form-group">
                          <label class="form-label">Current password</label>
                          <input type="password" class="form-control" name="current_password">
                      </div>
          
                      <div class="form-group">
                          <label class="form-label">New password</label>
                          <input type="password" class="form-control" name="new_password">
                      </div>
          
                      <div class="form-group">
                          <label class="form-label">Repeat new password</label>
                          <input type="password" class="form-control" name="new_password_confirmation">
                      </div>
                  </div>
                  <div class="text-right">
                      {{-- <button type="button" class="btn btn-primary" onclick="submitChangePassword()">Save changes</button> --}}
                      <button type="submit" class="btn btn-primary" onclick="submitChangePassword()">Save changes</button>

                    </div>
              </form>
          </div>
          
            {{-- <div class="tab-pane fade" id="account-info">
              <div class="card-body pb-2">

                <div class="form-group">
                  <label class="form-label">Bio</label>
                  <textarea class="form-control" rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
                </div>
                <div class="form-group">
                  <label class="form-label">Birthday</label>
                  <input type="text" class="form-control" value="May 3, 1995">
                </div>
                <div class="form-group">
                  <label class="form-label">Country</label>
                  <select class="custom-select">
                    <option>USA</option>
                    <option selected="">Canada</option>
                    <option>UK</option>
                    <option>Germany</option>
                    <option>France</option>
                  </select>
                </div>


              </div>
              <hr class="border-light m-0">
              <div class="card-body pb-2">

                <h6 class="mb-4">Contacts</h6>
                <div class="form-group">
                  <label class="form-label">Phone</label>
                  <input type="text" class="form-control" value="+0 (123) 456 7891">
                </div>
                <div class="form-group">
                  <label class="form-label">Website</label>
                  <input type="text" class="form-control" value="">
                </div>

              </div>
      
            </div> --}}
            {{-- <div class="tab-pane fade" id="account-social-links">
              <div class="card-body pb-2">

                <div class="form-group">
                  <label class="form-label">Twitter</label>
                  <input type="text" class="form-control" value="https://twitter.com/user">
                </div>
                <div class="form-group">
                  <label class="form-label">Facebook</label>
                  <input type="text" class="form-control" value="https://www.facebook.com/user">
                </div>
                <div class="form-group">
                  <label class="form-label">Google+</label>
                  <input type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                  <label class="form-label">LinkedIn</label>
                  <input type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                  <label class="form-label">Instagram</label>
                  <input type="text" class="form-control" value="https://www.instagram.com/user">
                </div>

              </div>
            </div> --}}
            {{-- <div class="tab-pane fade" id="account-connections">
              <div class="card-body">
                <button type="button" class="btn btn-twitter">Connect to <strong>Twitter</strong></button>
              </div>
              <hr class="border-light m-0">
              <div class="card-body">
                <h5 class="mb-2">
                  <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i class="ion ion-md-close"></i> Remove</a>
                  <i class="ion ion-logo-google text-google"></i>
                  You are connected to Google:
                </h5>
                nmaxwell@mail.com
              </div>
              <hr class="border-light m-0">
              <div class="card-body">
                <button type="button" class="btn btn-facebook">Connect to <strong>Facebook</strong></button>
              </div>
              <hr class="border-light m-0">
              <div class="card-body">
                <button type="button" class="btn btn-instagram">Connect to <strong>Instagram</strong></button>
              </div>
            </div> --}}
            {{-- <div class="tab-pane fade" id="account-notifications">
              <div class="card-body pb-2">

                <h6 class="mb-4">Activity</h6>

                <div class="form-group">
                  <label class="switcher">
                    <input type="checkbox" class="switcher-input" checked="">
                    <span class="switcher-indicator">
                      <span class="switcher-yes"></span>
                      <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Email me when someone comments on my article</span>
                  </label>
                </div>
                <div class="form-group">
                  <label class="switcher">
                    <input type="checkbox" class="switcher-input" checked="">
                    <span class="switcher-indicator">
                      <span class="switcher-yes"></span>
                      <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Email me when someone answers on my forum thread</span>
                  </label>
                </div>
                <div class="form-group">
                  <label class="switcher">
                    <input type="checkbox" class="switcher-input">
                    <span class="switcher-indicator">
                      <span class="switcher-yes"></span>
                      <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Email me when someone follows me</span>
                  </label>
                </div>
              </div>
              <hr class="border-light m-0">
              <div class="card-body pb-2">

                <h6 class="mb-4">Application</h6>

                <div class="form-group">
                  <label class="switcher">
                    <input type="checkbox" class="switcher-input" checked="">
                    <span class="switcher-indicator">
                      <span class="switcher-yes"></span>
                      <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">News and announcements</span>
                  </label>
                </div>
                <div class="form-group">
                  <label class="switcher">
                    <input type="checkbox" class="switcher-input">
                    <span class="switcher-indicator">
                      <span class="switcher-yes"></span>
                      <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Weekly product updates</span>
                  </label>
                </div>
                <div class="form-group">
                  <label class="switcher">
                    <input type="checkbox" class="switcher-input" checked="">
                    <span class="switcher-indicator">
                      <span class="switcher-yes"></span>
                      <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Weekly blog digest</span>
                  </label>
                </div>

              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </div>

    <div class="text-right mt-3">
      <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
      <button type="button" class="btn btn-default">Cancel</button>
    </div>

  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script>
    function submitChangePassword() {
        const form = $('#changePasswordForm'); // Cache the form element
        const newPassword = form.find('input[name="new_password"]').val();
        const confirmPassword = form.find('input[name="new_password_confirmation"]').val();

        // Check if passwords match
        if (newPassword !== confirmPassword) {
            alert("Passwords do not match!");
            return;
        }

        const formData = form.serialize(); // Serialize the form data

        $.ajax({
            url: form.attr('action'), // Get the form's action attribute
            method: form.attr('method'), // Get the form's method attribute
            data: formData,
            success: function(response) {
                alert("Password changed successfully!");
            },
            error: function(xhr) {
                alert("An error occurred. Please try again.");
            }
        });
    }

    function submitUpdateProfile() {
        const form = $('#updateProfileForm'); // Cache the form element
        const newFname = form.find('input[name="first_name"]').val();
        const newLname = form.find('input[name="last_name"]').val();
        const newUsername = form.find('input[name="username"]').val();

        const formData = form.serialize(); // Serialize the form data

        $.ajax({
            url: form.attr('action'), // Get the form's action attribute
            method: form.attr('method'), // Get the form's method attribute
            data: formData,
            success: function(response) {
                alert("Profile changed successfully!");
            },
            error: function(xhr) {
                alert("An error occurred. Please try again.");
            }
        });
    }
</script>

    
</body>
</html>

