<style>
    .active-menu-item {
        background: #0D3858;
        color: white;
    }

    .white-icon {
        filter: brightness(0) invert(1);
    }

</style>
<div class="col-md-3"
     style="padding: 0 {{ session('locale') === 'en' ? '33px 0 0px' : '0px 0 33px' }};">

    <div class="profile-sidebar card">
        <div class="profile-side">
            {{-- <div class="img-prfe">
                @if (Auth::user()->profile_image)
                    <img src="{{ Auth::user()->profile_image }}" alt="User Profile Image">
                @else
                    <img src="{{ asset('frontend/images/dummyuser.png') }}" alt="Default Image">
                @endif
            </div> --}}
            {{-- <h2>{{ Auth::user()->first_name }}</h2>
            <a href="">{{ Auth::user()->email }}</a> --}}
        </div>
        <div class="account-menu">
            <h5>Menu Profile
                <button class="menu-show-mn" type="button">
                    <img style="width: 30px;" src="{{ asset('frontend/images/menu.svg') }}" alt="">
                </button>
            </h5>

            @if (session('locale') === 'en')
                <ul class="menu-ul">
                    <li style="margin-top: -10px !important;">
                        <a href="{{ route('userdashboard') }}"
                            style="{{ request()->routeIs('userdashboard') ? 'background: #0D3858; color: white;' : '' }}">
                            <img src="{{ asset('frontend/user.png') }}"
                                class="{{ request()->routeIs('userdashboard') ? 'white-icon' : '' }}"
                                style="width: 30px; margin-right: 5px;" alt="Edit Profile Icon"> Edit Profile
                        </a>
                    </li>
                    <li style="margin-top: -10px !important;">
                        <a href="{{ route('auction') }}"
                            style="{{ request()->routeIs('auction') ? 'background: #0D3858; color: white;' : '' }}">
                            <img src="{{ asset('frontend/hammer.png') }}"
                                class="{{ request()->routeIs('auction') ? 'white-icon' : '' }}"
                                style="width: 30px; margin-right: 5px;" alt="Auction Icon"> Auctions
                        </a>
                    </li>
                </ul>
            @elseif(session('locale') === 'ar')
                <ul class="menu-ul">
                    <li style="margin-top: -10px !important;">
                        <a href="{{ route('userdashboard') }}"
                            style="{{ request()->routeIs('userdashboard') ? 'background: #0D3858; color: white;' : '' }}">
                            <img src="{{ asset('frontend/user.png') }}"
                                class="{{ request()->routeIs('userdashboard') ? 'white-icon' : '' }}"
                                style="width: 30px; margin-right: 5px;" alt="Edit Profile Icon"> تعديل البروفايل
                        </a>
                    </li>
                    <li style="margin-top: -10px !important;">
                        <a href="{{ route('auction') }}"
                            style="{{ request()->routeIs('auction') ? 'background: #0D3858; color: white;' : '' }}">
                            <img src="{{ asset('frontend/hammer.png') }}"
                                class="{{ request()->routeIs('auction') ? 'white-icon' : '' }}"
                                style="width: 30px; margin-right: 5px;" alt="Auction Icon"> المزادات
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>
