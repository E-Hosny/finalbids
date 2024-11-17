<div class="col-md-3">
    <div class="profile-sidebar">
        <div class="profile-side">
            <div class="img-prfe">
                @if(Auth::user()->profile_image)
                    <img src="{{(Auth::user()->profile_image)}}" alt="User Profile Image">
                @else
                    <img src="{{ asset('frontend/images/dummyuser.png') }}" alt="Default Image">
                @endif
            </div>
            <h2>{{ Auth::user()->first_name }}</h2>
            <a href="">{{ Auth::user()->email }}</a>
        </div>
        <div class="account-menu">
            <h5>Menu Profile 
                <button class="menu-show-mn" type="button">
                    <img style="width: 30px;" src="{{ asset('frontend/images/menu.svg') }}" alt="">
                </button>
            </h5>
            @if(session('locale') === 'en')   
                <ul class="menu-ul">
                    <li><a href="{{ route('userdashboard') }}">My Account</a></li>
                    <li><a href="{{ route('useraddress') }}">Manage Address</a></li>
                    <li><a href="{{ route('auction') }}">Auctions</a></li>
                    <li><a href="{{ route('user.products') }}">My Products</a></li> <!-- رابط مشاهدة المنتجات -->
                    <li><a href="{{ route('logouts') }}">Logout</a></li>
                </ul>
            @elseif(session('locale') === 'ar')
                <ul class="menu-ul">
                    <li><a href="{{ route('userdashboard') }}">حسابي</a></li>
                    <li><a href="{{ route('useraddress') }}">إدارة العنوان</a></li>
                    <li><a href="{{ route('auction') }}">المزادات</a></li>
                    <li><a href="{{ route('user.products') }}">منتجاتي</a></li> <!-- رابط مشاهدة المنتجات -->
                    <li><a href="{{ route('logouts') }}">الخروج</a></li>
                </ul>
            @else
                <ul class="menu-ul">
                    <li><a href="{{ route('userdashboard') }}">My Account</a></li>
                    <li><a href="{{ route('useraddress') }}">Manage Address</a></li>
                    <li><a href="{{ route('auction') }}">Auctions</a></li>
                    <li><a href="{{ route('user.products') }}">My Products</a></li> <!-- رابط مشاهدة المنتجات -->
                    <li><a href="{{ route('logouts') }}">Logout</a></li>
                </ul>
            @endif
        </div>
    </div>
</div>
