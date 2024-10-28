@php
$social = App\Models\Setting::where('is_static',1)->orderBy('title','ASC')->get();
$logo = App\Models\Setting::where('is_static', 2)->orderBy('title', 'ASC')->first();
$pages =App\Models\Page::where('is_static', 1)->orderBy('title', 'ASC')->first();

@endphp
@include('frontend.auth.login_modal')
@include('frontend.auth.register_modal')

{{-- <footer>
    <div class="container">
        <div class="row">
       <!--  <div class="col-md-4">
                @if ($logo)
                    <div class="ftr-mang-eb">
                    @if (session('locale') === 'en')
                        <img class="f-logo" src="{{ asset('img/settings/' . $logo->image) }}" alt="" />
                        @elseif (session('locale') === 'ar')
                        <img class="f-logo" src="{{ asset('img/settings/' . $logo->image_ar) }}" alt="" />
                            @else
                            <img class="f-logo" src="{{ asset('img/settings/' . $logo->image) }}" alt="" />
                            @endif
                        <p>
                            @if (session('locale') === 'en')
                                {{ $logo->value }}
                            @elseif (session('locale') === 'ar')
                                {{ $logo->value_ar }}
                            @else
                                {{ $logo->value }}
                            @endif
                        </p>
                    </div>
                @else
                    <div class="ftr-mang-eb">
                        <img class="f-logo" src="{{ asset('frontend/images/logo.svg') }}" alt="" />
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </p>
                    </div>
                @endif
            </div> -->


            <!-- <div class="col-md-4">
            <h3>{{ session('locale') === 'en' ? 'Company' : (session('locale') === 'ar' ? 'الشركة' : 'Company') }}</h3>

                <ul class="use-fulllink">


                </ul>
            </div> -->
            <!-- <div class="col-md-4">
            <h3>{{ session('locale') === 'en' ? 'Stay up to date' : (session('locale') === 'ar' ? 'ابقَ على اطلاع' : 'Stay up to date') }}</h3>

                <form action="{{ route('subscribe') }}" method="post" class="news-letter" id="subscribeForm">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" placeholder="{{ session('locale') === 'en' ? 'Enter Your Email' : (session('locale') === 'ar' ? 'أدخل بريدك الإلكتروني' : 'Enter Your Email') }}" required />
                        <button type="submit">{{ session('locale') === 'en' ? 'Submit' : (session('locale') === 'ar' ? 'قدِّم' : 'Submit') }}</button>

                    </div>
                </form>

            </div> -->
        </div>
        <div class="privacy-link">
            <div>
                @if ($logo)
                    <div class="ftr-mang-eb">
                    @if (session('locale') === 'en')
                    <a href="{{url('/')}}"><img class="f-logo" src="{{ asset('img/settings/' . $logo->image) }}" alt="" /></a>
                        @elseif (session('locale') === 'ar')
                        <a href="{{url('/')}}"> <img class="f-logo" src="{{ asset('img/settings/' . $logo->image_ar) }}" alt="" /></a>
                            @else
                            <a href="{{url('/')}}"> <img class="f-logo" src="{{ asset('img/settings/' . $logo->image) }}" alt="" /></a>
                            @endif
<!--                         <p>
                            @if (session('locale') === 'en')
                                {{ $logo->value }}
                            @elseif (session('locale') === 'ar')
                                {{ $logo->value_ar }}
                            @else
                                {{ $logo->value }}
                            @endif
                        </p> -->
                    </div>
                @else
                    <div class="ftr-mang-eb">
                    <a href="{{url('/')}}"><img class="f-logo" src="{{ asset('frontend/images/logo.svg') }}" alt="" /></a>
                      <!--   <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </p> -->
                    </div>
                @endif
            </div>
            <ul>
 <li><a href="{{ route('about-us') }}">{{ session('locale') === 'en' ? 'About Us' : (session('locale') === 'ar' ? 'من نحن' : 'About Us') }}</a></li>
  <li><a href="{{ route('contact-us') }}">{{ session('locale') === 'en' ? 'Contact Us' : (session('locale') === 'ar' ? 'تواصل معنا' : 'Contact Us') }}</a></li>
               <li><a href="{{ route('terms-conditions') }}">{{ session('locale') === 'en' ? 'Terms' : (session('locale') === 'ar' ? 'الشروط' : 'Terms') }}</a></li>
               <li><a href="{{ route('privacy-policy') }}">{{ session('locale') === 'en' ? 'Privacy' : (session('locale') === 'ar' ? 'الخصوصية' : 'Privacy') }}</a></li>

            </ul>
        </div>
    </div>
</footer>


<div class="wts_fixed">
    <a href="https://wa.me/966555424101" class="whatappFixBtn" target="_blank" id="">
        <img src="{{asset('frontend/images/wts_ic.svg')}}" alt="whatsapp" width="45px" height="45px">
    </a>
</div> --}}




<footer class="bg-light text-dark py-3">
    <div class="container  p-5">
        <div class="row p-3">
            <!-- Left Section: Logo and Social Icons (30%) -->
            <div class="col-lg-3 d-flex flex-column align-items-center mb-3 text-center">
                <img src="{{ asset('footer-logo.png') }}" alt="Logo" class="mt-5 w-50" style="width: 100px;">
                <div class="d-flex justify-content-center gap-3 py-3">
                    <a href="#" class="text-dark px-1"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-dark px-1"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fa-solid fa-x px-1"></i></a>
                    <a href="#" class="text-dark px-1"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            <!-- Right Section: Links (70%) -->
            <div class="col-lg-9">
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="fw-bold">{{ session('locale') === 'en' ? 'Category' : (session('locale') === 'ar' ? 'الفئات' : 'Category') }}</h4>
                        <hr class="mx-auto" style="width: 25%; background-color: black;">
                        <ul class="list-unstyled">
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Furniture' : (session('locale') === 'ar' ? 'أثاث' : 'Furniture') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Jewelry' : (session('locale') === 'ar' ? 'مجوهرات' : 'Jewelry') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Ceramics' : (session('locale') === 'ar' ? 'الخزف' : 'Ceramics') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'ArtWork' : (session('locale') === 'ar' ? 'لوحات فنية' : 'ArtWork') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Clocks' : (session('locale') === 'ar' ? 'ساعات' : 'Clocks') }}</a></li>
                        </ul>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="fw-bold">{{ session('locale') === 'en' ? 'How It Work' : (session('locale') === 'ar' ? 'كيفية العمل' : 'How It Work') }}</h4>
                        <hr class="mx-auto" style="width: 25%; background-color: black;">
                        <ul class="list-unstyled">
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Registration' : (session('locale') === 'ar' ? 'تسجيل الدخول' : 'Registration') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Select Product' : (session('locale') === 'ar' ? 'اختر المنتج' : 'Select Product') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Go To Bidding' : (session('locale') === 'ar' ? 'الانتقال الى المزايدة' : 'Go To Bidding') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Make Payment' : (session('locale') === 'ar' ? 'إتمام الدفع' : 'Make Payment') }}</a></li>
                        </ul>
                    </div>

                    <!-- Column 3 -->
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="fw-bold">{{ session('locale') === 'en' ? 'Support' : (session('locale') === 'ar' ? 'الدعم الفني' : 'Support') }}</h4>
                        <hr class="mx-auto" style="width: 25%; background-color: black;">
                        <ul class="list-unstyled">
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Help & Support' : (session('locale') === 'ar' ? 'المساعدة والدعم' : 'Help & Support') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Contact Us' : (session('locale') === 'ar' ? 'تواصل معنا' : 'Contact Us') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'About Us' : (session('locale') === 'ar' ? 'من نحن' : 'About Us') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Our Policy' : (session('locale') === 'ar' ? 'سياستنا' : 'Our Policy') }}</a></li>
                        </ul>
                    </div>

                    <!-- Column 4 -->
                    {{-- <div class="col-md-3 mb-3 text-center">
                        <h4 class="fw-bold">{{ session('locale') === 'en' ? 'Category' : (session('locale') === 'ar' ? '' : 'Category') }}</h4>
                        <hr class="mx-auto" style="width: 25%; background-color: black;">
                        <ul class="list-unstyled">
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Furniture' : (session('locale') === 'ar' ? '' : 'Furniture') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Jewelry' : (session('locale') === 'ar' ? '' : 'Jewelry') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Caramics' : (session('locale') === 'ar' ? '' : 'Caramics') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'ArtWork' : (session('locale') === 'ar' ? '' : 'ArtWork') }}</a></li>
                            <li class="py-1"><a href="#" class="text-dark fs-5">{{ session('locale') === 'en' ? 'Clocks' : (session('locale') === 'ar' ? '' : 'Clocks') }}</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Add Font Awesome for Social Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="{{asset('frontend/js/bootstrap.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script src="{{asset('frontend/js/main.js')}}"></script>

<script type="text/javascript">
$('.home_slider .owl-carousel').owlCarousel({
    loop: false,
    margin: 0,
    dots: true,
    loop: true,
    autoplay: true,
    autoplaySpeed: 3000,
    autoplayHoverPause: false,
    nav: false,
    items: 1,
    rtl: false,
});
$('.popular_slider.owl-carousel').owlCarousel({
    items: 3,
    rtl: false,
    margin: 30,
    dots: false,
    loop: false,
    nav: false,
    autoplay: false,
    autoplaySpeed: 3000,
    autoplayHoverPause: false,
    responsive: {
        0: {
            items: 1,
        },
        600: {
            items: 2,
        },
        1000: {
            items: 3,
        }
    }
});
</script>
<!-- <script>
$(document).ready(function() {
    setInterval(() => {
        $('.thisisdemoclass').each(function() {
            var date = $(this).data('date');
            var id = $(this).data('id');
            const targetDate = new Date(date).getTime();
            const currentDate = new Date().getTime();
            const timeRemaining = targetDate - currentDate;
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 *
                60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);
            $(this).find('.days').text(days);
            $(this).find('.hours').text(hours);
            $(this).find('.minutes').text(minutes);
            $(this).find('.seconds').text(seconds);
        });
    }, 1000);
})
</script> -->
<script>
    $(document).ready(function() {

        setInterval(() => {
            $('.thisisdemoclass').each(function() {
                var date = $(this).data('date');
                var id = $(this).data('id');
                const targetDate = new Date(date).getTime();
                const currentDate = new Date().getTime();
                const timeRemaining = targetDate - currentDate;

                if (timeRemaining <= 0) {
                    // $(this).find('ul').hide();
                    $('#bidnow').hide();
                    $(this).parent().find('.countdown-time').html('<p><span style="color: red;">Lot closed</span></p>');
                    $('#bidForm').hide();

                } else {
                    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                    if (timeRemaining <= 300000) {
                    // Change color to red when 5 minutes or less remaining
                    $(this).find('.days').css('color', 'red');
                    $(this).find('.hours').css('color', 'red');
                    $(this).find('.minutes').css('color', 'red');
                    $(this).find('.seconds').css('color', 'red');
                }
                    // Update the display values and hide if equal to zero
                    $(this).find('.days').text(days);
                    if (days === 0) {
                        $(this).find('.days-wrapper').hide();
                    } else {
                        $(this).find('.days-wrapper').show();
                    }

                    $(this).find('.hours').text(hours);
                    $(this).find('.minutes').text(minutes);
                    $(this).find('.seconds').text(seconds);
                }
            });
        }, 1000);
    });
</script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('subscribeForm').addEventListener('submit', function (event) {
        event.preventDefault();

        fetch(this.action, {
            method: this.method,
            body: new FormData(this),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const privacyPolicyLink = '<a href="{{route('privacy-policy')}}">Privacy Policy</a>';
                Swal.fire({
                    title: 'Thank you for subscribing!',
                    html: `You will receive auction updates, curated items, and more in your inbox. You can unsubscribe at any time. View our ${privacyPolicyLink}.`,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script> -->


</body>

</html>


