@include('frontend.layouts.header')
<style>
  .hide{
    display: none;
  }
  .pointer{
    cursor: pointer;
  }
</style>
<body>
  <div class="user-login align-just">
    <div class="container">
      <div class="login-outer-box">
        <div class="row">
          <div class="col-md-6 auction-type align-just">
            <div>
              <img src="{{asset('frontend/images/logo-light.svg')}}" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="login-detail">
              <h2>Login</h2>
               
                <form action="{{ route('loggedin') }}" method="POST" class="cmn-frm">
                   @csrf
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" id="email">
                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                  </div>
                  <br>
                  <div class="form-group">
                    <label for="">Password </label>
                    <input class="pe-4" type="password" name="password" id="password">
                    <i class="fa fa-eye-slash input-icon" id="password-toggle"></i>
                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                  </div>
                  <a  class="text-btn forgt-btn edit-number" data-bs-toggle="modal" href="#forgotpassword">Forgot Password?</a>
                  <!-- <button class="btn btn-secondary login-btn" data-bs-toggle="modal" href="#exampleModalToggle" type="button"> Login</button> -->
                  <button class="btn btn-secondary login-btn" type="submit">Login</button>
                </form>
                <span class="sign-tag-line">if you don't have an account? <a href="{{route('register')}}" class="text-btn">Sign Up</a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   
  <div class="modal fade" id="forgotpassword" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="login-mdl text-center ">
            <img src="{{asset('frontend/images/logo.svg')}}" alt="">
            <h2>Forgot Password</h2>
            <div class="numberArea">
              
              <p>Enter the email associated with your account and we’ll send an
                email with instructions to reset your password.</p>
              <form action="" class="cmn-frm mt-4">
                <div class="form-group text-start">
                  <label for=" ">Email</label>
                  <input type="text" class="forgetPasswordPhone" name=" " id="" required>
                    <div id="emailError" class="error-message text-danger"></div>

                </div>
                
              </form>
              <!-- data-bs-target="#newpassword" data-bs-toggle="modal" data-bs-dismiss="modal" -->
              <button  class="my-4 btn btn-secondary px-5 sendForgotPasswordOtpBtn" type="button">Send</button>
              <a class="text-btn d-flex justify-content-center gap-2 align-items-center pointer" data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('frontend/images/back-arrow.svg')}}" alt=""> Back to login </a>
            </div>
            <div class="otpArea hide">
              <p>Verify otp to proceed.</p>
              <form action="" class="cmn-frm mt-4">
                <div class="form-group text-start otp-filds" id="otp-verification-form">
                  <!-- <label for=" ">OTP</label> -->
                  <!-- <input type="number" class="forgetPasswordOTP" name="" id="" required> -->
              
                  <input type="number" class="otpValue" name="otp" id="first" maxlength="1" oninput="moveToNextInput(this, 'second')" onkeydown="moveToPreviousInput(this, '')" />
                  <input type="number" class="otpValue" name="otp" id="second" maxlength="1" oninput="moveToNextInput(this, 'third')" onkeydown="moveToPreviousInput(this, 'first')" />
                  <input type="number" class="otpValue" name="otp" id="third" maxlength="1" oninput="moveToNextInput(this, 'fourth')" onkeydown="moveToPreviousInput(this, 'second')" />
                  <input type="number" class="otpValue" name="otp" id="fourth" maxlength="1" onkeydown="moveToPreviousInput(this, 'third')" />

                </div>                
              </form>
              <a  class="my-4 btn btn-secondary px-5 verifyForgotPasswordOtpBtn"   type="button"> Verify Otp</a>
            </div>
                          
          </div>
        </div>
         
      </div>
    </div>
  </div>


  <div class="modal fade" id="newpassword" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="login-mdl text-center">
            <img src="{{asset('frontend/images/logo.svg')}}" alt="">
            <h2 class="fndt-bld">Set New Password</h2>
            <!-- <p>Your new password must be different from <br>
              previous used password.</p> -->
              <form action="" class="cmn-frm mt-4">
              <div class="form-group text-start">
                  <label for="ResetPassword">New Password </label>
                  <input class="pe-5" type="password" name="ResetPassword" id="ResetPassword">
                  <i class="fa fa-eye-slash input-icon" id="togglePassword"></i>
                  <span class="error-msg" id="passwordError"></span>
              </div>
              <div class="form-group text-start">
                  <label for="ResetConfirmPassword">Confirm New Password </label>
                  <input class="pe-5" type="password" name="ResetConfirmPassword" id="ResetConfirmPassword">
                  <!-- <i class="fa fa-eye-slash input-icon"></i> -->
                  <i class="fa fa-eye-slash input-icon" id="toggleConfirmPassword"></i>
                  <span class="error-msg" id="confirmPasswordError"></span>
              </div>
              <div class="error-msg text-danger" id="passwordMatchError"></div>
              <div class="success-msg" id="successMessage"></div>

                 
              </form>
              <a href="javascript:void(0);" class="my-4 btn btn-secondary px-5 resetPasswordButton" > Reset Password</a>
              <a   class="text-btn d-flex justify-content-center gap-2 align-items-center" data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('frontend/images/back-arrow.svg')}}" alt=""> Back to login </a>
          </div>
        </div>
         
      </div>
    </div>
  </div>
  
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script> 
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script> 
    <script src="{{asset('frontend/js/main.js')}}"></script> 
    <script>
  // Toggle Password Visibility
  document.getElementById('togglePassword').addEventListener('click', function () {
      var passwordInput = document.getElementById('ResetPassword');
      var icon = document.getElementById('togglePassword');
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
      if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
      } else {
          passwordInput.type = 'password';
      }
  });

  // Toggle Confirm Password Visibility
  document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
      var confirmPasswordInput = document.getElementById('ResetConfirmPassword');
      var icon = document.getElementById('toggleConfirmPassword');
      icon.classList.toggle('fa-eye');
      icon.classList.toggle('fa-eye-slash');
      if (confirmPasswordInput.type === 'password') {
          confirmPasswordInput.type = 'text';
      } else {
          confirmPasswordInput.type = 'password';
      }
  });
</script>
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
    });

    $('body').on('click', '.sendForgotPasswordOtpBtn', function() {
      let email = $('.forgetPasswordPhone').val();
      let emailInput = $('#emailInput');
      let emailError = $('#emailError');

      if (email) {
        
        let emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email.match(emailFormat)) {
          $('.sendForgotPasswordOtpBtn').html('<i class="fa fa-spinner fa-spin"></i> Sending OTP...').prop('disabled', true);
          $.ajax({
            type: 'get',
            url: "{{ route('sendOtpForgetPassword') }}",
            data: { email: email },
            success: function(res) {
              console.log("res", res);
              if (res.status === 'success') {
                $('.numberArea').addClass('hide');
                $('.otpArea').removeClass('hide');
              } else {
                alert(`${res.message}: ${res.error}`);
              }
            },
            error: function(res) {
              console.log("error in request!");
            }
          });
        } else {
          emailError.text('Please enter a valid email address.');
        }
      } else {
        emailError.text('Email is required.');
      }
    });

    $('body').on('click','.changeNumber', function(){
      $('.numberArea').removeClass('hide');
      $('.otpArea').addClass('hide');
    });

    $('body').on('click', '.verifyForgotPasswordOtpBtn', function(){
      // otp = $('.forgetPasswordOTP').val();
      const otp = document.getElementById("first").value + document.getElementById("second").value + document.getElementById("third").value + document.getElementById("fourth").value;

      email = $('.forgetPasswordPhone').val();
      if(otp) {
        $.ajax({
          type:'get',
          url:"{{route('verifyOtpForgetPassword')}}",
          data: {email: email, otp: otp},
          success:function(res){
            console.log("res", res);
            if(res.status == 'success') {
              $('#forgotpassword').modal('hide');              
              $('#newpassword').modal('show');
              $('.numberArea').removeClass('hide');
              $('.otpArea').addClass('hide');
            } else {
              alert(`${res.message}: ${res.error}`);
            }            
          },error:function(res){
            console.log("error in request!");
          }
        })
      }
    });

$('body').on('click', '.resetPasswordButton', function() {
  let password = $('#ResetPassword').val();
  let confirmPassword = $('#ResetConfirmPassword').val();
  let passwordError = $('#passwordError');
  let confirmPasswordError = $('#confirmPasswordError');
  let passwordMatchError = $('#passwordMatchError');

  passwordError.text('');
  confirmPasswordError.text('');
  passwordMatchError.text('');
  $('#successMessage').text('');

  if (password !== confirmPassword) {
      passwordMatchError.text("Confirm Password must be the same as New Password.");
      return false;
  }

  $.ajax({
      type: 'get',
      url: "{{ route('updateNewPassword') }}",
      data: { email: email, password: password },
      success: function(res) {
          if (res.status == 'success') {
              $('#successMessage').text('Password reset successfully.');
              location.reload();
          } else {
              alert(`${res.message}: ${res.error}`);
          }
      },
      error: function(res) {
          console.log("error in request!");
      }
  })
});
    function moveToNextInput(currentInput, nextInputId) {
        var maxLength = parseInt(currentInput.getAttribute('maxlength'));

        if (currentInput.value.length === maxLength) {
            // Move to the next input field
            document.getElementById(nextInputId).focus();
        }
    }

    function restrictInput(currentInput) {
        var maxLength = parseInt(currentInput.getAttribute('maxlength'));
    
        if (currentInput.value.length > 1) {
            // If more than one character is entered, keep only the first character
            currentInput.value = currentInput.value.charAt(0);
        }
    }

    function moveToPreviousInput(currentInput, previousInputId) {
        if (event.key === 'Backspace' && currentInput.value.length === 0) {
            // Move to the previous input field
            document.getElementById(previousInputId).focus();
        }
    }

    $('.otpValue').on('input', function() {
        restrictInput(this);
        moveToNextInput(this, $(this).data('next'));
    });
    
    $('.otpValue').on('keydown', function(event) {
        moveToPreviousInput(this, $(this).data('prev'));
    });
</script>
  </body>

  @include('frontend.layouts.footer')
