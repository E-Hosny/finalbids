@include('frontend.layouts.header')

{{-- <section class="hero-ther">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 text-center">
        @if (session('locale') === 'en')
           <h1>About Us</h1>
           <p>
            <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> About Us
          </p>
        @elseif (session('locale') === 'ar')
            <h1>من نحن</h1>
              <p>
                <a href="{{url('/')}}"><i class="fa fa-home"></i> وطن /</a> من نحن
              </p>
        @else
           <h1>About Us</h1>
           <p>
            <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> About Us
          </p>
        @endif
        </div>
      </div>
    </div>
  </section> --}}



  <section class="policy-content">

    <div class="container mx-auto">

        <div class="row">
            <div class="col-md-5">
                {{-- <h2>{{ session('locale')=='en' ? 'About Us' : 'من نحن' }}</h2> --}}
                <img class="w-100 p-3" src="{{ asset('img/about/about.png') }}" alt="about us">

            </div>

            @if (session('locale') === 'en')
            <div class="outr-box col-md-7 p-5">
              <h2 class="text-start my-4 fs-1 fw-bold">{{$about->title}}</h2>
            <p>{{ strip_tags($about->content) }}</p>
            <hr class="text-secondary">
            <div class="row">
                <div class="col-4">
                    <h3 class="my-color fw-bold">505</h3>
                    <p>Completed Auction</p>
                </div>
                <div class="col-4">
                    <h3 class="my-color fw-bold">80</h3>
                    <p>Satisfied Customers</p>
                </div>
                <div class="col-4">
                    <h3 class="my-color fw-bold">06</h3>
                    <p>Years of Expernice</p>
                </div>
            </div>
            <hr class="text-secondary">


            </div>
            @elseif (session('locale') === 'ar')
                <div class="outr-box col-md-7 p-5">
                    <h2 class="text-end my-4 fs-1 fw-bold">{{$about->title_ar}}</h2>
                    <p>{{ strip_tags($about->content_ar) }}</p>
                    <hr class="text-secondary">
                    <div class="row">
                        <div class="col-4">
                            <h3 class="my-color fw-bold">505</h3>
                            <p>مزادات مكتملة</p>
                        </div>
                        <div class="col-4">
                            <h3 class="my-color fw-bold">80</h3>
                            <p>العملاء الراضين</p>
                        </div>
                        <div class="col-4">
                            <h3 class="my-color fw-bold">06</h3>
                            <p>سنوات الخبرة</p>
                        </div>
                    </div>
                    <hr class="text-secondary">
                    </div>
            @else
                <div class="outr-box col-md-7 p-5">
                    <h2>{{$about->title}}</h2>
                    <p>{{ strip_tags($about->content) }}</p>
                    <hr class="text-secondary">

                </div>
            @endif

        </div>


    </div>

</section>
  @include('frontend.layouts.footer')
