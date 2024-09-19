@include('frontend.layouts.header')

<section class="hero-ther">
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
  </section>
 


  <section class="policy-content">
  @if (session('locale') === 'en')
    <div class="container">
        <div class="outr-box">
          <h2>{{$about->title}}</h2>
        <p>{{ strip_tags($about->content) }}</p>
        </div>
    </div>
  @elseif (session('locale') === 'ar')
    <div class="container">
      <div class="outr-box">
        <h2>{{$about->title_ar}}</h2>
        <p>{{ strip_tags($about->content_ar) }}</p>
        </div>
    </div>
  @else
  <div class="container">
    <div class="outr-box">
        <h2>{{$about->title}}</h2>
        <p>{{ strip_tags($about->content) }}</p>
      </div>
    </div>
  @endif
</section>
  @include('frontend.layouts.footer')
