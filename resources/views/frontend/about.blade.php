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

    <div class="container mx-auto my-4">

        <div class="row">
            <div class="col-md-5">
                {{-- <h2>{{ session('locale')=='en' ? 'About Us' : 'من نحن' }}</h2> --}}
                <img class="w-100 p-3" src="{{ asset('img/about/about-us.png') }}" alt="about us">

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


    <div class="container mx-auto my-2  ">
      <div class="row {{ session('locale')=='en' ? 'text-start ms-4' : 'text-end me-4' }}">
        <h2 class=" fw-bold fs-1   ">{{ session('locale')=='en' ? 'Know About Our Category' : 'تعرف على فئاتنا' }}</h2>
        <p class="my-4">{{ session('locale')=='en'?'Bronze sculptures are a common feature in art decor, known for their timeless beauty, durability, and intricate detail. Bronze is an alloy primarily consisting of copper, often combined with tin, which gives sculptures a warm, reddish-brown hue that ages beautifully, developing a natural patina over time. 
            ' : 'تعتبر المنحوتات البرونزية سمة شائعة في الديكور الفني، وهي معروفة بجمالها الخالد ومتانتها وتفاصيلها المعقدة. البرونز عبارة عن سبيكة تتكون أساسًا من النحاس، وغالبًا ما يتم دمجها مع القصدير، مما يمنح المنحوتات لونًا بنيًا محمرًا دافئًا يتقادم بشكل جميل، ويتطور مع مرور الوقت.'}}
        </p>

        <div class="about-card col-lg-2 col-md-2 col-4  text-center py-2  ">
            <img src="{{ asset('img/about/antiquites.png') }}" alt="">
            <h4>{{ session('locale')=='en' ? 'Antiquities' : 'الآثار' }}</h4>
        </div>

      </div>

    </div>

</section>
  @include('frontend.layouts.footer')
