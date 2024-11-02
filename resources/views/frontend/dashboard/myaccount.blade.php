@include('frontend.layouts.header')

<section class="dtl-user-box">
    <div class="container">
        <div class="account-outer-box">

            <div class="row">

                @include('frontend.dashboard.sidebar')

                <div class="col-md-9">
                    <div class="heading-act">
                        <h2>
                            @if (session('locale') === 'en')
                                Personal Info
                            @elseif(session('locale') === 'ar')
                                المعلومات الشخصية
                            @else
                                My Account
                            @endif
                        </h2>
                    </div>

                    <div class="profile-detail-section">
                        <form action="{{ route('profileupdate', ['id' => $users->id]) }}" class="cmn-frm px-4"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">
                                            @if (session('locale') === 'ar')
                                                الاسم بالكامل
                                            @else
                                                Full Name
                                            @endif
                                        </label>
                                        <input type="text" name="first_name"
                                            value="{{ old('first_name', $users->first_name) }}" readonly required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">
                                            @if (session('locale') === 'ar')
                                                رقم الهاتف
                                            @else
                                                Phone Number
                                            @endif
                                        </label>
                                        <input type="text" name="phone" value="{{ old('phone', $users->phone) }}"
                                            readonly required>
                                    </div>


                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">
                                            @if (session('locale') === 'ar')
                                                البريد الإلكتروني
                                            @else
                                                Email Address
                                            @endif
                                        </label>

                                        <input type="email" name="email" value="{{ old('email', $users->email) }}"
                                            readonly required>
                                    </div>
                                </div>

                                <div class="col-md-6 text-end my-4">
                                    <button type="submit" class="btn btn-purple"
                                        style="background-color: purple; color: white;">
                                        @if (session('locale') === 'ar')
                                            حفظ التغيير
                                        @else
                                            Save Changes
                                        @endif
                                    </button>
                                </div>

                                <hr>
                                    <div class="heading-act">
                                        <h2>
                                            @if (session('locale') === 'ar')
                                                تغيير كلمة المرور
                                            @else
                                                Change Password
                                            @endif
                                        </h2>
                                    </div>

                                    <div class="profile-detail-section">
                                        <form action="{{ route('change-password') }}" class="cmn-frm px-4" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="current_password">
                                                            @if (session('locale') === 'ar')
                                                                كلمة المرور القديمة
                                                            @else
                                                                Old Password
                                                            @endif
                                                        </label>
                                                        <input type="password" name="current_password" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">
                                                            @if (session('locale') === 'ar')
                                                                كلمة مرور جديدة
                                                            @else
                                                                New Password
                                                            @endif
                                                        </label>
                                                        <input type="password" name="password" class="form-control">
                                                    </div>


                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="confirm_password">
                                                            @if (session('locale') === 'ar')
                                                                تأكيد كلمة المرور
                                                            @else
                                                                Confirm Password
                                                            @endif
                                                        </label>
                                                        <input type="password" name="confirm_password" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 text-end my-4">
                                                    <button type="submit" class="btn btn-purple"
                                                        style="background-color: purple; color: white;">
                                                        @if (session('locale') === 'ar')
                                                            حفظ التغيير
                                                        @else
                                                            Save Changes
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <section class="dtl-user-box">
                <div class="account-outer-box">
                    <div class="row">

                    </div>
                </div>
            </section>
        </div>
    </div>
</section>


@include('frontend.layouts.footer')


<style>
    .row {
        --bs-gutter-x: 1.5rem;
        --bs-gutter-y: 0;
        display: flex;
        flex-wrap: wrap;
        margin-top: calc(var(--bs-gutter-y)* -1);
        margin-right: calc(var(--bs-gutter-x)* 3.5);
        margin-left: calc(var(--bs-gutter-x)* -.5);




    }



    .rtl .heading-act h2 {
        margin: 40px 119px 40px 22px;
    }

    .col-md-9 {
        flex: 1 0 auto;
        width: 75%;
    }
</style>
