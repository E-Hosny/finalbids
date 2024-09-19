@include('frontend.layouts.header')

<style>
  ul, .error-messages {
    margin-top: 0;
    margin-bottom: 1rem;
    color: red;
}
</style>
<section class="dtl-user-box">
    <div class="container">
        <div class="account-outer-box">
            <div class="row">
                @include('frontend.dashboard.sidebar')

                <div class="col-md-9 ">
                    <div class="heading-act">
                    @if(session('locale') === 'en')   
                        <h2>Change Password</h2>
                   @elseif(session('locale') === 'ar')
                       <h2>تغيير كلمة المرور</h2>
                    @else
                       <h2>Change Password</h2>
                    @endif  
                       
                    </div>
                   
                    <div class="profile-detail-section">
                    <div class="error-container">
                            <ul class="error-messages"></ul>
                        </div>
                        <form action="{{ route('change-password') }}" class="cmn-frm px-4" method="POST">
                          @csrf
           
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group">
                                @if(session('locale') === 'en')   
                                    <label for="current_password">Old Password</label>
                                @elseif(session('locale') === 'ar')
                                    <label for="current_password">كلمة المرور القديمة</label>
                                @else  
                                    <label for="current_password">Old Password</label>
                                @endif 
                                    <input type="password" name="current_password" id="password"class="form-control" >
                                    <i class="fa fa-eye-slash input-icon" id="password-toggle"></i>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group">
                                    @if(session('locale') === 'en')   
                                    <label for="password">New Password</label>

                                  @elseif(session('locale') === 'ar')
                                  <label for="password">كلمة مرور جديدة</label>

                                @else  
                                    <label for="password">New Password</label>
                                @endif 
                                    <input type="password" name="password" id="newpassword" class="form-control" >
                                    <i class="fa fa-eye-slash input-icon" id="new-password-toggle"></i>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group">
                                    @if(session('locale') === 'en')   
                                    <label for="confirm_password">Confirm Password</label>
                                @elseif(session('locale') === 'ar')
                                    <label for="confirm_password">تأكيد كلمة المرور</label>
                                @else  
                                    <label for="confirm_password">Confirm Password</label>
                                @endif 
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" >
                                    <i class="fa fa-eye-slash input-icon" id="confirm-password-toggle"></i>
                                </div>
                            </div>

                            <div class="col-md-6 text-center">
                            @if(session('locale') === 'en')   
                                <button type="submit" class="btn btn-secondary login-btn text-capitalize">Submit</button>
                            @elseif(session('locale') === 'ar')
                                <button type="submit" class="btn btn-secondary login-btn text-capitalize">إرسال</button>
                            @else
                                <button type="submit" class="btn btn-secondary login-btn text-capitalize">Submit</button>
                              @endif 
                                
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   $(document).ready(function() {
    $('form').submit(function(event) {
        var currentPassword = $('input[name="current_password"]').val();
        var newPassword = $('input[name="password"]').val();
        var confirmPassword = $('input[name="confirm_password"]').val();

        var errors = [];

        // Validate current password
        if (currentPassword === '') {
            errors.push('Old password is required.');
        } else {

            $.ajax({
                type: 'POST',
                url: 'validate-current-password', 
                data: {
                    current_password: currentPassword
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                async: false,
                success: function(response) {
                    if (response !== 'valid') {
                        errors.push('Old password is incorrect.');
                    }
                },
                error: function() {
                    errors.push('Error validating current password.');
                }
            });
        }

        // Validate new password
        if (newPassword === '') {
            errors.push('New password is required.');
        } else if (newPassword.length < 6) {
            errors.push('New password should be at least 6 characters.');
        }

        // Validate password confirmation
        if (confirmPassword === '') {
            errors.push('Confirm password is required.');
        } else if (newPassword !== confirmPassword) {
            errors.push('New password and confirm password do not match.');
        }

        // Display errors
        if (errors.length > 0) {
            event.preventDefault();
            var errorHtml = '';
            for (var i = 0; i < errors.length; i++) {
                errorHtml += '<li>' + errors[i] + '</li>';
            }
            $('.error-messages').html(errorHtml); 
            $('.error-container').show(); 
        } else {
            $('.error-container').hide(); 
        }
    });
});


</script>
<script src="{{asset('frontend/js/jquery.min.js')}}"></script> 
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script> 
    <script src="{{asset('frontend/js/main.js')}}"></script> 
    <script>
$(document).ready(function() {
    $('#password-toggle').click(function() {
        const passwordInput = $('#password');
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            $('#password-toggle').removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            passwordInput.attr('type', 'password');
            $('#password-toggle').removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });

    $('#confirm-password-toggle').click(function() {
        const confirmPasswordInput = $('#confirm_password');
        if (confirmPasswordInput.attr('type') === 'password') {
            confirmPasswordInput.attr('type', 'text');
            $('#confirm-password-toggle').removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            confirmPasswordInput.attr('type', 'password');
            $('#confirm-password-toggle').removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });
    $('#new-password-toggle').click(function() {
        const confirmPasswordInput = $('#newpassword');
        if (confirmPasswordInput.attr('type') === 'password') {
            confirmPasswordInput.attr('type', 'text');
            $('#new-password-toggle').removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            confirmPasswordInput.attr('type', 'password');
            $('#new-password-toggle').removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });
    $('.navTrigger').click(function () {
  $(this).toggleClass('active');
  console.log("Clicked menu");
  $("#mainListDiv").toggleClass("show_list");
  $("#mainListDiv").fadeIn();

});
$('.menu-show-mn').click(function () {
  $('.menu-ul').toggleClass('show-mnu');
});
});
</script>

@include('frontend.layouts.footer')