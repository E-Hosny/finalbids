@include('frontend.layouts.header')
<style>
.register_check {
    display: flex;
    align-items: center;
    gap: 5px;
    width: 100%;
}
.register_check .error-message {
    position: absolute;
    top: calc(100% + 7px);
    line-height: 1.2;
    color: #f00;
}
.error-message{color: #f00;font-size: 14px;}
.error-message {
    position: relative;
    bottom: 20px;
}
.form-check{
  
  margin-top: 2.125rem;
}
.star {
    color:#c97f7f;
}
.text-btns {
    border: 0;
    background-color: transparent;
    padding: 0;
    color: #7F12DD;
    font-size: 16px;
    font-weight: 600;
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
            <div class="login-detail p-5 pb-5">
              <h2>Sign Up</h2>
                <form action="{{ route('registration') }}" method="post" class="cmn-frm">
                  @csrf
                  <div class="row">
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group">
                        <label for="">First Name <span class="star">*</span></label>
                        <input type="text" name="first_name" id="first_name">
                      
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group">
                        <label for="">Last Name <span class="star">*</span></label>
                        <input type="text" name="last_name" id="last_name">
                      
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group">
                        <label for="">Email Address <span class="star">*</span></label>
                        <input type="text" name="email" id="email">
                     
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group">
                        <label for="">Country code <span class="star">*</span></label>
                        <select name="country_code" class="choices__list choices__list--single form-control" id="country_code" tabindex="-1" data-choice="active">
                          <option value="">Choose Country</option>
                          @foreach ($cont as $at)
                          <option value="+{{ $at->phonecode }}">{{ $at->name }}</option>
                          @endforeach
                      </select>
                     
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                      <div class="form-group">
                        <label for="">Phone Number <span class="star">*</span> </label>
                       <input type="tel"  placeholder="Phone Number" name="phone" id="phone" maxlength=10>
                       
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">Address <span class="star">*</span></label>
                        <input type="text" name="address" id="address">
                      
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="">Password <span class="star">*</span></label>
                            <input class="pe-5" type="password" name="password" id="password">
                            <i class="fa fa-eye-slash input-icon" id="password-toggle"></i>
                           
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="">Confirm Password <span class="star">*</span></label>
                            <input type="password" name="confirm_password" id="confirm_password">
                            <i class="fa fa-eye-slash input-icon" id="confirm-password-toggle"></i>
                        </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group d-flex gap-2 align-items-center">
                       <div class="form-check register_check">
                        <input class="form-check-label" type="checkbox" name="is_term" id="is_term" value="1">
                        <label for="is_term">Accept <a href="{{route('terms-conditions')}}" class="text-btn text-capitalize">Terms & Conditions.</a></label> 
                      </div>
                      </div>
                    </div>
                  </div>
                    <button class="btn btn-secondary login-btn font-bld"  title="Submit"> Sign Up</button>
                                      
                </form>
                <span class="sign-tag-line">if you have an account? <a href="{{route('signin')}}" class="text-btn">Login</a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="login-mdl text-center">
            <img src="{{asset('frontend/images/logo.svg')}}" alt="">
            <h2 class="fndt-bld">Verify OTP</h2>
            <p>Please enter 4-digit verification code that was send to your
              Email <a href="" class="text-btns edit-number numberTag">"+91 1234567890"</a></p>
              <form action="{{ route('verify-otp') }}" method="post" class="cmn-frm otp-filds" id="otp-verification-form">
                <input type="number" class="otpValue" name="otp" id="first" maxlength="1" oninput="moveToNextInput(this, 'second')" onkeydown="moveToPreviousInput(this, '')" />
                <input type="number" class="otpValue" name="otp" id="second" maxlength="1" oninput="moveToNextInput(this, 'third')" onkeydown="moveToPreviousInput(this, 'first')" />
                <input type="number" class="otpValue" name="otp" id="third" maxlength="1" oninput="moveToNextInput(this, 'fourth')" onkeydown="moveToPreviousInput(this, 'second')" />
                <input type="number" class="otpValue" name="otp" id="fourth" maxlength="1" onkeydown="moveToPreviousInput(this, 'third')" />
              </form>
              <!-- <p>Didn’t Receive the Code? <a href="" class="text-btn edit-number">Resend</a></p> -->
              <p>Didn’t Receive the Code? <a href="#" class="text-btn edit-number" id="resend-code">Resend</a></p>

             
              <button type="button" name="verify-otp" class="mt-4 btn btn-secondary px-5 btn-verify-otp">Verify</button>
          </div>
        </div>
         
      </div>
    </div>
  </div>

    <script src="{{asset('frontend/js/jquery.min.js')}}"></script> 
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script> 
    <script src="{{asset('frontend/js/main.js')}}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>
    <script>
    function focusOnNextInput(currentInput, nextInputId) {
      if (currentInput.value && currentInput.value.length === 1) {
        document.getElementById(nextInputId).focus();
      }
    }
  </script>

<script>
$(document).ready(function () {
    $("form.cmn-frm").submit(function (event) {
        event.preventDefault();
        $(".error-message").remove();
        var valid = true;
      
        var validationRules = {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
                remote: {
                      url: "/check-email-unique",
                      type: "post",
                      data: {
                          email: function() {
                              return $("#email").val();
                          }
                      }
                  }
            },
            country_code: {
                required: true,
            },
            phone: {
                required: true,
                minlength: 10,
                number:true,
            },
            address: {
                required: true,
            },
            password: {
                required: true,
                minlength: 8,
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: "password",
            },
            is_term: {
                required: true,
            },
            
        };

        $.each(validationRules, function (elementId, rules) {
            var element = $("#" + elementId);
            var value = element.val();

            if (rules.required && (!value || value.trim() === "")) {
                element.after('<div class="error-message">' + element.attr("name").replace("_", " ") + ' is required.</div>');
                valid = false;
            }

            if (rules.email && value && !isValidEmail(value)) {
                element.after('<div class="error-message">Invalid ' + element.attr("name").replace("_", " ") + ' format.</div>');
                valid = false;
            }

            if (rules.minlength && value && value.length < rules.minlength) {
                element.after('<div class="error-message">' + element.attr("name").replace("_", " ") + ' should be at least ' + rules.minlength + ' characters long.</div>');
                valid = false;
            }

            if (rules.equalTo && value !== $("#" + rules.equalTo).val()) {
                element.after('<div class="error-message">' + element.attr("name").replace("_", " ") + ' does not match.</div>');
                valid = false;
            }
            if (elementId === 'is_term' && rules.required && !$("#" + elementId).prop('checked')) {
                $("#" + elementId).after('<div class="error-message">Please accept the Terms & Conditions.</div>');
                valid = false;
            }
         
            // Input event to remove error message on change
            element.on("input", function () {
                $(this).next(".error-message").remove();
            });
        });

        if (valid) {
          // $('.login-btn').html('<i class="fa fa-spinner fa-spin"></i> Sending OTP...').prop('disabled', true);
          $.ajax({
                type: "POST",
                url: "{{ route('registration') }}",
                data: $("form.cmn-frm").serialize(),
                success: function(response) {
                  if(response.status == 'error') {
                    $(".error-message").remove();
                        $("#email").after('<div class="error-message">' + response.error + '</div>');
                  } else {
                     // Set spinner and disable button
                     $('.login-btn').html('<i class="fa fa-spinner fa-spin"></i> Sending OTP...').prop('disabled', true);
                    $('.numberTag').text(" "+ ' '+$('#email').val().toLowerCase());
                    openOtpVerificationModal();
                  }                    
                },
                error: function() {
                   alert('Error in request!');
                }
            });
        }
    });
  
    // Function to validate email format
    function isValidEmail(email) {
        var emailRegex = /\S+@\S+\.\S+/;
        return emailRegex.test(email);
    }

    // Function to open modal
    function openOtpVerificationModal() {
        $("#exampleModalToggle").modal("show");
    }

    // Initialize intlTelInput for mobile code
    $("#mobile_code-login").intlTelInput({
        initialCountry: "in",
        separateDialCode: true,
    });
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
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$(document).ready(function() {
    $('body').on('click','.btn-verify-otp', function(){
      verifyOTP();
    });

    function verifyOTP() {
      const otpValue = $('#first').val() + $('#second').val() + $('#third').val() + $('#fourth').val();
      let email = $('#email').val();

      $.ajax({
        type: "POST",
        url: "{{ route('verify-otp') }}",
        data: { otpValue: otpValue, email: email },
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
          if (response.status === 'error') {
            alert("Invalid OTP. Please try again.");
          } else if (response.status === 'success') {
            Swal.fire({
              title: 'Congratulations!',
              text: 'User Created Successfully.',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(function() {
              window.location.href = "{{ url('signin') }}";
            });
          }
        },
        error: function() {
          alert("An error occurred while verifying OTP.");
        }
      });
    }
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
<script>
    $(document).ready(function() {
        $('#resend-code').click(function(event) {
            event.preventDefault();
            resendCode();
        });

        function resendCode() {
            let email = $('#email').val(); 

            $.ajax({
                type: "POST",
                url: "{{ route('resend_otp') }}",
                data: { email: email },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert("Verification code has been resent to your email.");
                    } else {
                        alert("Failed to resend verification code. Please try again later.");
                    }
                },
                error: function() {
                    alert("An error occurred while resending verification code.");
                }
            });
        }
    });
</script>


  </body>
@include('frontend.layouts.footer')