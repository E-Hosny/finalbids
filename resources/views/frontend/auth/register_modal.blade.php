<div class="modal fade" id="registerModal" aria-hidden="true" aria-labelledby="otpModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-lg custom-modal-size">
        <div class="modal-content">
            <div class="modal-body border-0">
                <div class="login-mdl text-center">
                    <span class="login-title">{{__('Create Account')}}</span>
                    <div class="form-size">
                        <form action="{{ route('registerTemp') }}" method="POST" class="cmn-frm">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="row col-12 mb-1 mt-4">
                                    <div class="col-md-6 mb-2">
                                        <label for="full_name" class="d-flex justify-content-start mb-1">{{__('Full Name')}}</label>
                                        <input type="text" name="full_name" id="full_name" placeholder="" class="form-control">
                                        <span class="text-danger full_name-error"></span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="phone" class="d-flex justify-content-start mb-1">{{__('Phone Number')}}</label>
                                        <input type="text" name="phone" id="phone" placeholder="" class="form-control">
                                        <span class="text-danger phone-error" id=""></span>
                                    </div>
                                </div>
                                <div class="row col-12 mb-1">
                                    <div class="col-md-6 mb-2">
                                        <label for="email" class="d-flex justify-content-start mb-1">{{__('Email')}}</label>
                                        <input type="email" name="email" id="email" placeholder="" class="form-control">
                                        <span class="text-danger email-error"></span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="password" class="d-flex justify-content-start mb-1">{{__('Password')}}</label>
                                        <input type="password" name="password" id="password" placeholder="" class="form-control">
                                        <span class="text-danger password-error"></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group d-flex gap-2 align-items-center mt-2 ">
                                        <div class="form-check register_check">

                                            <input class="form-check-label" type="checkbox" name="is_term" id="is_term" value="1">
                                            <label for="is_term">{{__('I have read, understood and agree to ')}}  <a href="{{route('terms-conditions')}}" class="text-decoration-underline">
                                                    {{__('Privacy Policy')}}</a> {{__('and terms and conditions of website usage.')}}</label>
                                        </div>
                                    </div>
                                    <span class="text-danger is_term-error"></span>
                                </div>





                            </div>
                            <button class="login-btn" type="submit">{{__('Create Account')}}</button>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            <div class="form-group d-flex justify-content-center">
                                <a class="mt-3 switch-to-login" href="#">
                                    <span class="btn-create-account">{{__('Already have an account ?')}} {{__('Login')}}</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="otpModalToggle" aria-hidden="true" aria-labelledby="otpModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">
                <input type="hidden" id="otp-email" name="otp-email">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="login-mdl text-center">
                    <img src="{{asset('logo.png')}}" alt="">
                    <p>{{__('Please enter 4-digit verification code that was send to your Email')}}</p>
                    <form action="{{ route('verify-otp') }}" method="post" class="cmn-frm otp-filds" id="otp-verification-form">
                        <input type="number" class="otpValue" name="otp" id="first" maxlength="1" oninput="moveToNextInput(this, 'second')" onkeydown="moveToPreviousInput(this, '')" />
                        <input type="number" class="otpValue" name="otp" id="second" maxlength="1" oninput="moveToNextInput(this, 'third')" onkeydown="moveToPreviousInput(this, 'first')" />
                        <input type="number" class="otpValue" name="otp" id="third" maxlength="1" oninput="moveToNextInput(this, 'fourth')" onkeydown="moveToPreviousInput(this, 'second')" />
                        <input type="number" class="otpValue" name="otp" id="fourth" maxlength="1" onkeydown="moveToPreviousInput(this, 'third')" />
                    </form>
                    <p>{{__('Didn’t Receive the Code?')}} <a href="#" class="text-btn edit-number my-text-color" id="resend-code">{{__('Resend')}}</a></p>


                    <button type="button" name="verify-otp" class="mt-4 btn text-white  px-5 btn-verify-otp">{{__('Verify')}}</button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>

    .btn-verify-otp{
        background-color: #0B3058 !important;
    }

     .my-text-color{
        color: #0B3058 !important;
     }
    .login-mdl {
        padding: 20px 60px 20px 80px;
    }
    .custom-modal-size {
        width: 993px;
        height: 590px;
        top: 163px;
        gap: 0px;
        opacity: 0px;
        background-color: #FAFAFA;
    }

    .form-size {


        width: 790px;
        height: 463px;
        top: 199px;
        left: 325px;
        gap: 0px;
        border: 1px 0px 0px 0px;
        opacity: 0px;


    }

    .login-title {
        width: 107px;
        height: 51px;
        top: 201px;
        left: 666px;
        gap: 0px;
        opacity: 0px;
        font-family: Montserrat;
        font-size: 32px;
        font-weight: 700;
        line-height: 51.2px;
        text-align: left;
        color: #000000;
    }


    .custom-modal-size .modal-content {
        height: 100%;
        max-height: 100%;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-content {
        background-color: #FAFAFA;
    }

    .login-btn {
        background-color: #0B3058;
        max-width: 482px;
        height: 60px;
        color: #ffffff;
    }

    .btn-create-account {
        width: 107px;
        height: 51px;
        top: 201px;
        left: 666px;
        gap: 0px;
        opacity: 0px;
        font-family: Montserrat;
        font-size: 16px;
        font-weight: 700;
        line-height: 25.6px;
        text-align: left;
        color: #000000;

    }

    .btn-close {
        position: absolute;
        right: 10px;
        top: 10px;
    }

    .login-mdl img {
        max-width: 150px;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .custom-modal-size {
            max-width: 100%;
            margin: 10px;
        }

        .login-mdl {
            padding: 15px 20px;
        }

        .login-title {
            font-size: 24px;
        }

        .form-size {
            width: 100%;
        }

        .login-btn {
            height: 45px;
        }

        .btn-create-account {
            font-size: 14px;
        }
    }

    @media (max-height: 600px) {
        .custom-modal-size .modal-content {
            max-height: 100%;
            overflow-y: auto;
        }

        .modal-body {
            padding: 15px;
            overflow-y: auto;
        }

        .custom-modal-size {
            height: auto;
        }
    }
</style>

<script>
    document.querySelector('#registerModal form').addEventListener('submit', function (event) {
        event.preventDefault();



        document.querySelectorAll('.text-danger').forEach(el => el.innerText = '');

        const formData = new FormData(this);

        fetch("{{ route('registerTemp') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log(data);
                    document.querySelector('#registerModal').classList.remove('show');
                    document.querySelector('form').reset();
                    document.body.classList.remove('modal-open');
                    document.querySelector('.modal-backdrop').remove();

                    // store for otp verify and resend
                    let email = data.email;

                    openOtpVerificationModal(email);

                } else if (data.status === 'error') {
                    for (const key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) {
                            const errorElement = document.querySelector(`.${key}-error`);
                            if (errorElement) {
                                errorElement.innerText = data.errors[key][0];
                            }
                        }

                        if (data.errors.email) {
                            document.getElementById('email-error').innerText = data.errors.email;
                        }
                        if (data.errors.password) {
                            document.getElementById('password-error').innerText = data.errors.password;
                        }
                    }

                } else {
                    alert(data.message || 'An unexpected error occurred.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            });
    });

    document.querySelector('.switch-to-login').addEventListener('click', function (e) {
        e.preventDefault();

        let loginModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
        loginModal.hide();

        let registerModal = new bootstrap.Modal(document.getElementById('LoginModal'));
        registerModal.show();
    });

    // Function to open modal
    function openOtpVerificationModal(email) {

        document.querySelector('#otp-email').value = email;

         $("#otpModalToggle").modal("show");
    }



</script>

<script>
    $(document).ready(function() {
        $('#resend-code').click(function(event) {
            event.preventDefault();
            resendCode();
        });

        function resendCode() {

            let email = $('#otp-email').val();
            console.log(email);

            $.ajax({
                type: "POST",
                url: "{{ route('resend_otp') }}",
                data: { email: email },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert("{{__('Verification code has been resent to your email.')}}");
                    } else {
                        alert("{{__('Failed to resend verification code. Please try again later.')}}");
                    }
                },
                error: function() {
                    alert("{{__('An error occurred while resending verification code.')}}");
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('body').on('click','.btn-verify-otp', function(){
            verifyOTP();
        });

        function verifyOTP() {
            const otpValue = $('#first').val() + $('#second').val() + $('#third').val() + $('#fourth').val();

            let email = $('#otp-email').val();
            console.log(email);
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


                        setTimeout(function() {
                            Swal.fire({
                                title: "{{__('Congratulations!')}}",
                                text: "{{__('User Created Successfully.')}}",
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href = "{{ route('homepage') }}";
                            });
                        }, 500);

                        // $("#otpModalToggle").modal("hide");

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
