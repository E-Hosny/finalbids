<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Users', 'link' => 'admin.users.index', 'page' => 'Edit User'])
        <div class="container-fluid py-4">
            <div class="row mt-4">
                <div class="card">
                    <div class="col-12 col-lg-8 m-auto">
                        <form action="{{route('admin.users.update', $user)}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                <h5 class="font-weight-bolder mb-0">Edit User</h5>
                                <p class="mb-0 text-sm">Mandatory informations</p>
                                <div class="multisteps-form__content">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <label>First Name</label>
                                            <input class="multisteps-form__input form-control" type="text"
                                                name="first_name" placeholder="Eg. Michael" onfocus="focused(this)"
                                                onfocusout="defocused(this)"
                                                value="{{old('first_name', $user->first_name)}}">
                                            @if($errors->has('first_name'))
                                            <div class="error">{{$errors->first('first_name')}}</div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                            <label>Last Name</label>
                                            <input class="multisteps-form__input form-control" name="last_name"
                                                type="text" placeholder="Eg. Prior" onfocus="focused(this)"
                                                onfocusout="defocused(this)"
                                                value="{{old('last_name', $user->last_name)}}">
                                            @if($errors->has('last_name'))
                                            <div class="error">{{$errors->first('last_name')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label>Mobile</label>
                                            <input type="hidden" name="country_code"
                                                value="{{old('country_code', $user->country_code)}}">
                                            <input class="multisteps-form__input form-control" type="tel" id="phone"
                                                name="phone" placeholder="Eg. +17894561230" onfocus="focused(this)"
                                                onfocusout="defocused(this)" value="{{old('phone', $user->mobile)}}">
                                            <span id="valid-msg" class="hide">✓ Valid</span>
                                            <span id="error-msg" class="hide"></span>
                                            @if($errors->has('phone'))
                                            <div class="error">{{$errors->first('phone')}}</div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                            <label>Email Address</label>
                                            <input class="multisteps-form__input form-control" type="email"
                                                placeholder="Eg. argon@dashboard.com" name="email"
                                                onfocus="focused(this)" onfocusout="defocused(this)"
                                                value="{{old('email', $user->email)}}">
                                            @if($errors->has('email'))
                                            <div class="error">{{$errors->first('email')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label>Profile Image</label>
                                        <input class="form-control" type="file" placeholder="Profile Image"
                                            onfocus="focused(this)" name="profile_image"
                                            accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)"
                                            onchange="previewImage(this)">
                                        @if($errors->has('profile_image'))
                                        <div class="error">{{$errors->first('profile_image')}}</div>
                                        @endif
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label>Profile Image Preview</label>
                                            <img id="profileImagePreview"
                                                src="{{ asset('img/users/' . $user->profile_image) }}"
                                                alt="Profile Image Preview" width="100px">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                        <label>status</label>
                                        <select class="choices__list choices__list--single form-control" name="status"
                                            id="choices-gender" tabindex="-1">
                                            <option {{old('status', $user->status) == 0 ? "selected" : ""}} value="0">
                                                Inactive</option>
                                            <option {{old('status', $user->status) == 1 ? "selected" : ""}} value="1">
                                                Active
                                            </option>
                                        </select>
                                        @if($errors->has('status'))
                                        <div class="error">{{$errors->first('status')}}</div>
                                        @endif
                                    </div>
                                    <!-- <div class="row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label>Password</label>
                                            <input class="multisteps-form__input form-control" type="password"
                                                placeholder="******" onfocus="focused(this)" name="password"
                                                onfocusout="defocused(this)">
                                            @if($errors->has('password'))
                                            <div class="error">{{$errors->first('password')}}</div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                            <label>Repeat Password</label>
                                            <input class="multisteps-form__input form-control" type="password"
                                                placeholder="******" onfocus="focused(this)"
                                                name="password_confirmation" onfocusout="defocused(this)">
                                            @if($errors->has('confirmed_password'))
                                            <div class="error">{{$errors->first('confirmed_password')}}</div>
                                            @endif
                                        </div>
                                    </div> -->
                                    <div class="button-row d-flex mt-4">
                                        <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                            title="Submit">Update User</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('css')
    <link href='{{asset("css/intlTelInput.css")}}' rel="stylesheet">
    <style>
    #error-msg {
        color: red;
    }

    #valid-msg {
        color: #00C900;
    }

    input.error {
        border: 1px solid #FF7C7C;
    }

    .hide {
        display: none;
    }
    </style>
    @endpush
    @push('script')
    <script src='{{asset("js/intlTelInput-jquery.js")}}'></script>
    <script src='{{asset("js/intlTelInput.js")}}'></script>
    <script>
    var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    // initialise plugin
    var iti = window.intlTelInput(input, {
        preferredCountries: ['us', 'in'],
        utilsScript: '{{asset("js/utils.js")}}'
    });
    var reset = function() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };
    input.addEventListener('blur', function() {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });
    input.addEventListener("countrychange", function() {
        var sc = iti.getSelectedCountryData();
        $('input[name="country_code"]').val('+' + sc.dialCode);
    });
    // on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);
    </script>
    <script>
    function previewImage(input) {
        var preview = document.getElementById('profileImagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            // If no file is selected, show the default image
            preview.src = "{{ asset('path_to_default_image.jpg') }}";
            preview.style.display = 'block';
        }
    }
    </script>
    @endpush
</x-admin-layout>