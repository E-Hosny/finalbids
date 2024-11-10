<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Admin', 'page' => 'Admin Profile Setting'])
        <div class="container-fluid py-4">
            <div class="row mt-4">
                <div class="card">
                    <div class="col-12 col-lg-8 m-auto">
                        <form action="{{route('admin.profilesettingupdate', $user)}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                <h5 class="font-weight-bolder mb-0">Profile Setting </h5>
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

 
</x-admin-layout>