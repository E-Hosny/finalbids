<div class="modal fade" id="registerModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog custom-modal-size">
        <div class="modal-content">
            <div class="modal-body border-0">
                <div class="login-mdl text-center">
                    <span class="login-title">Creat Account</span>
                    <div class="form-size">
                        <form action="{{ route('registerTemp') }}" method="POST" class="cmn-frm">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="row col-md-12 mb-1 mt-4">
                                    <div class="col-md-6">
                                        <label for="email" class="d-flex justify-content-start  mb-1">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" placeholder="Ebtahim Ahmed">
                                        <span class="text-danger" id="full_name-error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="d-flex justify-content-start  mb-1">Phone Number</label>
                                        <input type="text" name="phone" id="phone" placeholder="966 214 896 321">
                                        <span class="text-danger" id="phone-error"></span>

                                    </div>
                                </div>
                                <br>
                                <div class="row col-md-12 mb-1">
                                    <div class="col-md-6">
                                        <label for="email" class="d-flex justify-content-start  mb-1">Email</label>
                                        <input type="text" name="email" id="email" placeholder="email@app.com">
                                        <span class="text-danger" id="email-error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="d-flex justify-content-start  mb-1">Password</label>
                                        <input class="pe-4" type="password" name="password" id="password" placeholder="Enter Your Password">
                                        <span class="text-danger" id="password-error"></span>

                                    </div>
                                </div>

{{--                                <div class="col-md-12">--}}
{{--                                    <div class="form-group d-flex gap-2 align-items-center">--}}
{{--                                        <div class="form-check register_check">--}}
{{--                                            <input class="form-check-label" type="checkbox" name="cancel_receive" id="cancel_receive" value="1">--}}
{{--                                            <label for="cancel_receive">Please check this box if you do not wish to receive marketing communications from us.</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-md-12">
                                    <div class="form-group d-flex gap-2 align-items-center mb-4">
                                        <div class="form-check register_check">
                                            <input class="form-check-label" type="checkbox" name="is_term" id="is_term" value="1">
                                            <label for="is_term">I have read, understood and agree to Bonhams  <a href="{{route('terms-conditions')}}" class="text-decoration-underline">Privacy Policy</a> and terms and conditions of website usage.</label>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="is_term-error"></span>
                                </div>
                            </div>
                            <button class="login-btn" type="submit" style="margin-top: 10px;">Creat Account</button>


                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            <div class="form-group d-flex justify-content-center">
                                <a class="mt-3 switch-to-login" href="#">
                                    <span class="btn-create-account">Already have an account ? Log in</span>
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
    document.querySelector('#registerModal form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form's default submission

        // Clear all previous error messages
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
                    // alert(data.message)
                    window.location.href = data.redirect;
                    document.querySelector('#registerModal').classList.remove('show'); // Close modal
                    document.querySelector('form').reset(); // Reset the form
                    document.body.classList.remove('modal-open'); // Fix overlay if needed
                    document.querySelector('.modal-backdrop').remove(); // Remove backdrop

                } else if (data.status === 'error') {
                    for (const key in data.errors) {
                        if (data.errors.hasOwnProperty(key)) {
                            const errorElement = document.getElementById(`${key}-error`);
                            if (errorElement) {
                                errorElement.innerText = data.errors[key][0];
                            }
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

</script>

<style>

    .login-mdl {
        padding: 20px 60px 20px 80px;
    }
    .custom-modal-size {
        width: 993px;
        height: 536px;
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
</style>


<script>
    document.querySelector('.switch-to-login').addEventListener('click', function (e) {
        e.preventDefault();

        let loginModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
        loginModal.hide();

        let registerModal = new bootstrap.Modal(document.getElementById('LoginModal'));
        registerModal.show();
    });
</script>
