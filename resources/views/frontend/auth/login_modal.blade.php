
<div class="modal fade" id="LoginModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog custom-modal-size">
        <div class="modal-content">
            <div class="modal-body border-0">
                <div class="login-mdl text-center">
                    <span class="login-title">{{session('ar')?'تسجيل الدخول':'Login'}}</span>
                    <div class="numberArea mt-3">
                        <form id="loginForm" class="cmn-frm" method="POST" novalidate>
                            @csrf
                            <div class="row justify-content-center">
                                <span class="text-danger" id="text-error"></span>

                                <div class="form-group mb-3" style="max-width:482px;">
                                    <label for="email" class="d-flex justify-content-start mb-1">{{__('Email')}}</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           placeholder="email@app.com" required>
                                    <span class="text-danger" id="email-error"></span>
                                </div>

                                <div class="form-group mb-3" style="max-width:482px;">
                                    <label for="password" class="d-flex justify-content-start mb-1">{{__('Password')}}</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="Enter Your Password" required>
                                    <span class="text-danger" id="password-error"></span>
                                </div>
                            </div>

                            <!-- Forgot Password Link -->
                            <div class="d-flex justify-content-center">
                                <a href="#"><span class="forget-passowrd">{{__('Forgot Password?')}}</span></a>
                            </div>

                            <!-- Login Button -->
                            <button type="submit" class="login-btn btn btn-primary mt-3">{{__('Login')}}</button>

                            <!-- Close Modal Button -->
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            <!-- Register Modal Trigger -->
                            <div class="form-group d-flex justify-content-center mt-3">
                                <a class="switch-to-register" href="#">
                                    <span class="btn-create-account">{{__('New to MOZAIDA?')}} {{__('Create Account')}}</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.classList.add('was-validated');
    });
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();

        document.getElementById('email-error').innerText = '';
        document.getElementById('password-error').innerText = '';

        const formData = new FormData(this);

        fetch("{{ route('loggedin') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    // console.log(data.errors)
                    if (data.errors.email) {
                        document.getElementById('email-error').innerText = data.errors.email;
                    }
                    if (data.errors.password) {
                        document.getElementById('password-error').innerText = data.errors.password;
                    }
                }
            }).catch(error => console.error('Error:', error));
    });

</script>

<style>
    .custom-modal-size {
        max-width: 993px;
        height: 536px;
        top: 165px;

        background-color: #FAFAFA;
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


    .forget-passowrd {
        width: 106px;
        height: 19px;
        top: 507px;
        left: 666px;
        gap: 0px;
        opacity: 0px;

        font-family: Montserrat;
        font-size: 12px;
        font-weight: 700;
        line-height: 19.2px;
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
    document.querySelector('.switch-to-register').addEventListener('click', function (e) {
        e.preventDefault();

        let loginModal = bootstrap.Modal.getInstance(document.getElementById('LoginModal'));
        loginModal.hide();

        let registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
        registerModal.show();
    });
</script>
