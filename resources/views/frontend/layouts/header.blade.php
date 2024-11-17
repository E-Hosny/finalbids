
<style>
@font-face {
    font-family: 'Luxury-1.0';
    src: url('/fonts/Luxury-1.0.otf') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'IBMPlexSansArabic-Regular';
    src: url('/fonts/IBMPlexSansArabic-Regular.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

body {
        /* font-family: 'Luxury-1.0', sans-serif !important; */
        /* font-weight: bold !important; */
    }

    h1, h2, h3, h4, h5, h6, li {
    font-family: 'Luxury-1.0', sans-serif !important;
}

p {
    font-family: 'IBMPlexSansArabic-Regular', sans-serif !important ;
}

    .category-list {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #fff;
        border: 1px solid #ddd;
        z-index: 1;
        width: 150px;
        text-align: left;
    }
    .error{
      color: red!important;
      width: 100%;
      text-transform: lowercase;

    }
    .error::first-letter {
       text-transform: uppercase;
      }

      .error-message{
      color: red!important;
      width: 100%;
      text-transform: lowercase;

    }
    .error-message::first-letter {
       text-transform: uppercase;
      }
      .notification-all {
    max-height: 200px;
    overflow-y: auto;

}
.notification-all ul li a h4 {
    font-size: 16px;
    margin: 0;
    color: #545050;
}

.logo{

}

    </style>
@php
$cat = App\Models\Category::where('status',1)->orderBy('name','ASC')->get();
$logo = App\Models\Setting::where('is_static', 2)->orderBy('title', 'ASC')->first();
@endphp
@php
if (Auth::check()) {
    $user = Auth::user();
    $not = App\Models\Appnotification::orderBy('id', 'desc')->get();
    $notcount = App\Models\Appnotification::where('is_read', 0)
                 ->where('user_id', $user->id)
                 ->count();
} else {
    $not = [];
    $notcount = 0;
}
@endphp

@php
    $langId = session('locale');
    $currentDateTime = now();

    $categories = App\Models\Category::where('status', 1)
        ->whereHas('projects.products')
        ->withCount([
            'projects' => function ($query) use ($currentDateTime) {
                $query->whereHas('products', function ($productQuery) use ($currentDateTime) {
                    $productQuery->where('end_date_time', '>=', $currentDateTime);
                })->orderBy('start_date_time', 'ASC');
            },
        ])
        ->orderBy('name', 'ASC')
        ->get();
@endphp


@php
    $user = Auth::user();
    $wishlistCount = $user ? App\Models\Wishlist::where('user_id', $user->id)->count() : 0;
@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{asset('frontend/images/logo.svg')}}">
    <title>Bid</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Add this CSS to your existing style section -->
<style>
    .sell-link {
        display: flex !important;
        align-items: center;
        background-color: #0D3858;
        color: white !important;
        padding: 8px 20px !important;
        border-radius: 25px;
        transition: all 0.3s ease;
    }
    
    .sell-link:hover {
        background-color: #0D3858;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .sell-link i {
        margin-right: 5px;
        font-size: 18px;
    }
    
    /* RTL Support */
    .rtl .sell-link i {
        margin-right: 0;
        margin-left: 5px;
    }
    
    @media only screen and (max-width: 1000px) {
        .sell-link {
            margin: 10px 0;
        }
    }
    </style>
  </head>

  <body @if(session()->get('locale') == 'ar') class="rtl" @endif>

    <nav class="nav header">

          <div class="search-logo">

          {{-- @if ($logo)
            <div class="logo">
              <!-- <a href="{{url('/')}}"><img src="{{ asset('img/settings/' . $logo->image) }}" alt=""></a> -->
              @if (session('locale') === 'en')
              <a href="{{url('/')}}"><img class="f-logo" src="{{ asset('img/settings/' . $logo->image) }}" alt="" /></a>
              @elseif (session('locale') === 'ar')
              <a href="{{url('/')}}"><img class="f-logo" src="{{ asset('img/settings/' . $logo->image_ar) }}" alt="" /></a>
             @else
             <a href="{{url('/')}}"><img class="f-logo" src="{{ asset('img/settings/' . $logo->image) }}" alt="" /></a>
             @endif
            </div>
          @else --}}
          <div class="">
              <a href="{{url('/')}}"><img src="{{asset('logo.png')}}" alt="" class="w-100"></a>
            </div>

          {{-- @endif --}}

          </div>




          <div id="mainListDiv" class="main_list  w-100 d-flex px-4  ">
              <ul class="navlinks  px-2">
              <li><a href="{{ url('/') }}">{{ session('locale') === 'en' ? 'Home' : (session('locale') === 'ar' ? 'الرئيسية' : 'Home') }}</a></li>

              <li class="category-menu">
              <a href="/categories/index">{{ session('locale') === 'en' ? 'Category' : (session('locale') === 'ar' ? 'الصنف' : 'Category') }}</a>
                    <div class="category-list">
                        <ul>
                        @foreach($categories as $category)
                                @if($category->projects_count > 0)

                                        @if(session('locale') === 'en')
                                        <li>
                                        <a href="{{ url('category', $category->slug) }}">
                                            {{ $category->name }} ({{ $category->projects_count }})
                                        </a>
                                    </li>
                                        @elseif(session('locale') === 'ar')
                                        <li>
                                        <a href="{{ url('category', $category->slug) }}">
                                            {{ $category->name_ar }} ({{ $category->projects_count }})
                                        </a>
                                        @else
                                        <li>
                                        <a href="{{ url('category', $category->slug) }}">
                                            {{ $category->name }} ({{ $category->projects_count }})
                                        </a>
                                    </li>
                                        @endif
                                                @endif
                                        @endforeach
                        </ul>
                    </div>
                </li>

                   {{-- <li><a href="{{route('pastauction')}}">{{ session('locale') === 'en' ? 'Past Auction' : (session('locale') === 'ar' ? 'المزادات السابقة' : 'Past Auction') }}</a></li> --}}

                    <li><a href="{{ route('about-us') }}">{{ session('locale') === 'en' ? 'About Us' : (session('locale') === 'ar' ? 'من نحن' : 'About Us') }}</a></li>

                    <li><a href="{{ route('contact-us') }}">{{ session('locale') === 'en' ? 'Contact Us' : (session('locale') === 'ar' ? 'تواصل معنا' : 'Contact Us') }}</a></li>


                 @guest
                    {{-- <li class="group-hidden">
                        <a  href="{{route('signin')}}">{{ session('locale') === 'en' ? 'Login' : (session('locale') === 'ar' ? 'تسجيل الدخول' : 'Login') }}</a>
                    </li>
                    <li class="group-hidden">
                        <a class=" " href="{{route('register')}}">{{ session('locale') === 'en' ? 'Sign Up' : (session('locale') === 'ar' ? 'التسجيل' : 'Sign Up') }}</a>
                    </li> --}}

                    <li class="group-hidden">
                        <a class=" " data-bs-toggle="modal" data-bs-target="#LoginModal" >{{ session('locale') === 'en' ? 'Login' : (session('locale') === 'ar' ? 'تسجيل الدخول' : 'Login') }}</a>
                    </li>
                    <li class="group-hidden">
                        <a class=" " data-bs-toggle="modal" data-bs-target="#registerModal">{{ session('locale') === 'en' ? 'Sign Up' : (session('locale') === 'ar' ? 'التسجيل' : 'Sign Up') }}</a>
                    </li>
                 @endguest


                    <li class="group-hidden">
                        <select class="changeLang lang-select">
                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ session()->get('locale') == 'ar' ? 'selected' : '' }}>عربي</option>

                        </select>
                    </li>
                             {{-- sell --}}
                          {{-- أولاً: زر البيع في القائمة --}}
                            <li>
                                @auth
                                    <a href="{{ url('/add-product') }}" class="sell-link">
                                        <i class="fa fa-plus-circle me-1"></i>
                                        {{ session('locale') === 'en' ? 'Sell' : (session('locale') === 'ar' ? 'بيع' : 'Sell') }}
                                    </a>
                                @else
                                    <a href="javascript:void(0)" class="sell-link" data-bs-toggle="modal" data-bs-target="#LoginModal">
                                        <i class="fa fa-plus-circle me-1"></i>
                                        {{ session('locale') === 'en' ? 'Sell' : (session('locale') === 'ar' ? 'بيع' : 'Sell') }}
                                    </a>
                                @endauth
                            </li>
                         {{-- sell --}}


                    @auth
                       <div class="me-auto">
                            <li class="group-hidden  "><a  class="profile-hdr" href="{{route('userdashboard')}}" >{{ Auth::user()->first_name }}<span class="header_nm">{{Auth::user()->first_name}}</span>
                            <img src="{{asset('frontend/images/dummyuser.png')}}" alt=""></a></li>
                       </div>

                        <li class="group-hidden"><a href="{{route('logouts')}}">{{ session('locale') === 'en' ? 'Logout' : (session('locale') === 'ar' ? 'تسجيل الخروج' : 'Logout') }}</a></li>

                    @endauth




              </ul>






              <div class="nav-right-group">

                <!-- <div class="drop-lange-select"> -->
                    {{-- <select class="form-select changecurrency">
                        <option value="SAR" {{ session()->get('currency', 'SAR') == 'SAR' ? 'selected' : '' }}>SAR</option>
                        <option value="USD" {{ session()->get('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                    </select> --}}
                    <!-- </div> -->

                    <ul class="my-1">
                @guest
                    <li class=" d-flex align-items-center">
                        <a class=" " data-bs-toggle="modal" data-bs-target="#LoginModal" >{{ session('locale') === 'en' ? 'Login' : (session('locale') === 'ar' ? 'تسجيل الدخول' : 'Login') }}</a>
                    </li>
                    <li class="d-flex align-items-center">
                        <a class=" " data-bs-toggle="modal" data-bs-target="#registerModal">{{ session('locale') === 'en' ? 'Sign Up' : (session('locale') === 'ar' ? 'التسجيل' : 'Sign Up') }}</a>
                    </li>

                    <li>

                @endguest


                    @auth
                    <li><a  class="profile-hdr" href="{{route('userdashboard')}}" ><span class="header_nm">{{Auth::user()->first_name }}</span>
                        <img src="{{asset('frontend/images/dummyuser.png')}}" alt=""></a></li>
                        <li><a href="{{route('logouts')}}">{{ session('locale') === 'en' ? 'Logout' : (session('locale') === 'ar' ? 'تسجيل الخروج' : 'Logout') }}</a></li>

                    @endauth

                    <li>
                        <select class="changeLang lang-select">
                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ session()->get('locale') == 'ar' ? 'selected' : '' }}>عربي</option>

                        </select>
                    </li>


    

                </ul>
                <div class="search-box">
                    <input type="text" class="search-input" placeholder={{ session('locale') === 'en' ? 'Search...' : (session('locale') === 'ar' ? 'ابحث...' : 'Search...') }}>
                    <button class="search-btn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>



                </div>



          </div>
{{--
          <div class="nav_links main_list">
              <ul  class="navlinks">
                  @if (auth()->check())

                  <li><button class="notification-btn"><img src="{{asset('frontend/images/resize-1714129767870338802notification.jpg')}}" alt="">
                  <!-- <span class="notification-count">{{$notcount}}</span> -->
                  <?php if ($notcount > 0): ?>
                        <span class="notification-count">{{$notcount}}</span>
                    <?php else: ?>
                        <span class="notification-count" style="display: none;">0</span>
                    <?php endif; ?>
                </button>
                        <div class="notification-all">
                        <h3>Notification</h3>

                        <ul>
                           @foreach($not as $notification)
                           @php
                                $project = $notification->project()->first();
                            @endphp
                            @if($project)
                                <li>
                                    <a href="{{ url('products', $project->slug) }}" class="notification-link" data-notification-id="{{ $notification->id }}">
                                        <img src="{{asset('frontend/images/notificn-icon.svg')}}" alt="">
                                        <!-- <h4>{{ $notification->title }}</h4> -->
                                        <h4 style="@if($notification->is_read == 0) color: #4949bd; @endif">{{ $notification->title }}</h4>

                                    </a>

                                    <?php
                                        // $created_at = $notification->created_at;

                                        // $formatted_date = date('j M g:i a', strtotime($created_at));
                                        $created_at = $notification->created_at;

                                            $dateTime = new DateTime($created_at, new DateTimeZone('UTC'));
                                            // $dateTime->setTimezone(new DateTimeZone('Asia/Riyadh'));
                                            $dateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));


                                            $formatted_date = $dateTime->format('j M g:i a');


                                        ?>
                                      <div style="text-align: right;width: 100%!important;font-size: 10px;margin-bottom: 1px;">{{ $formatted_date }}</div>


                                </li>
                            @endif
                            @endforeach
                        </ul>

                        </div>
                    </li>
                    <li><a href="{{route('getwishlist')}}"><img src="{{asset('frontend/images/like.svg')}}" alt="" style="width: 25px;"></a></li>
                    <li><a  class="profile-hdr" href="{{route('userdashboard')}}" ><span class="header_nm">{{Auth::user()->first_name }}</span>
                        <img src="{{asset('frontend/images/dummyuser.png')}}" alt=""></a></li>
                    @else
                        <li>
                        <a class="btn btn-secondary px-5" href="{{route('signin')}}">{{ session('locale') === 'en' ? 'Login' : (session('locale') === 'ar' ? 'تسجيل الدخول' : 'Login') }}</a>
                        </li>
                        <li>
                        <a class="btn btn-secondary px-5" href="{{route('register')}}">{{ session('locale') === 'en' ? 'Sign Up' : (session('locale') === 'ar' ? 'التسجيل' : 'Sign Up') }}</a>

                        </li>
                    @endif
              </ul>
          </div> --}}
          <span class="navTrigger">
              <i></i>
              <i></i>
              <i></i>
          </span>
  </nav>


  <style>

    .nav a{
        font-size: 20px !important;
        margin: 0px 7px;
    }
    .nav select{
        font-size: 20px !important;
    }


    .nav{
        height: 100px;
    }


.group-hidden {
    display: none;
}


@media only screen and (max-width: 1000px){
    .group-hidden{
        display: block;
    }
    .nav{
        height: 60px;
    }
}
@media only screen and (max-width: 1000px){
    .nav-right-group{
        display: none;
    }
}

@media only screen and (max-width: 1000px){
   .center-items{
    /* display: block; */
   }
}



.search-box {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    padding: 4px 100px 4px 30px;
    border: 2px solid #ccc;
    outline: none;
    font-size: 16px;
    transition: all 0.3s ease;
    /* width: 100%; */
}

.search-btn {
    background-color: transparent;
    border: none;
    cursor: pointer;
    position: absolute;
    right: 10px;
}

.search-input:focus {
    border-color: #007bff;
}

.search-btn i {
    color: black;
}






.lang-select{
    background-color: transparent;
    border: none;
}



   .category-menu {
    position: relative;
    display: inline-block;
}

.category-list {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    z-index: 1;
}

.category-menu:hover .category-list {
    display: block;
}

.category-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li {
    padding: 5px;
}

.category-list a {
    text-decoration: none;
    color: #333;
}

.category-list a:hover {
    color: #555;
}
/* Hide the language dropdown by default */
.drop-lange-select {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background-color: #fff;
  border: 1px solid #ddd;
  z-index: 1;
}

/* Show the language dropdown on hover */
.lange-drop:hover .drop-lange-select {
  display: block;
}

/* Style for the button */
.hover-trigger {
  cursor: pointer; /* Add a cursor pointer to indicate interactivity */
}

</style>
<script>
$(document).ready(function() {
    $('.category-menu').hover(
        function() {
            $('.category-list', this).show();
        },
        function() {
            $('.category-list', this).hide();
        }
    );
});

// Close the dropdown when the mouse leaves the dropdown area
const langeDrop = document.querySelector('.lange-drop');
const dropLangeSelect = document.querySelector('.drop-lange-select');

langeDrop.addEventListener('mouseleave', () => {
  dropLangeSelect.style.display = 'none';
});

</script>

<script type="text/javascript">
    var langUrl = "{{ route('changeLang') }}";
    $(".changeLang").change(function(){
        window.location.href = langUrl + "?lang="+ $(this).val();
    });

    var currencyUrl = "{{ route('currencychange') }}";
    $(".changecurrency").change(function(){
        window.location.href = currencyUrl + "?currency="+ $(this).val();
    });
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
$(document).ready(function() {
    $(".notification-link").click(function(event) {
        event.preventDefault();
        var notificationId = $(this).data("notification-id");
        markNotificationAsRead(notificationId);
    });

    function markNotificationAsRead(notificationId) {

        var csrfToken = $('meta[name="csrf-token"]').attr('content');


        $.ajax({
            url: '/mark-as-read/' + notificationId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {

            }
        });
    }
});
</script>




{{-- ثانياً: السكريبت الخاص بالتحقق --}}
<script>
    $(document).ready(function() {
        $('.sell-link').click(function(e) {
            @auth
                window.location.href = "{{ url('/add-product') }}";
            @else
                e.preventDefault();
                $('#LoginModal').modal('show');
            @endauth
        });
    });
    </script>