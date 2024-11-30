@include('frontend.layouts.header')

<section class="hero-ther">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 text-center">
         
          @if (session('locale') === 'en')
           <h1>Privacy Policy</h1>
           <p>
            <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> Privacy Policy
          </p>
        @elseif (session('locale') === 'ar')
            <h1>سياسة الخصوصية</h1>
              <p>
                <a href="{{url('/')}}"><i class="fa fa-home"></i> وطن /</a> سياسة الخصوصية
              </p>
        @else
           <h1>Privacy Policy</h1>
           <p>
            <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> Privacy Policy
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
        <h2>{{$privacy->title}}</h2>
        <p>{{ strip_tags($privacy->content) }}</p>
         </div>
    </div>
  @elseif (session('locale') === 'ar')
    <div class="container">
       <div class="outr-box">
        <h2>{{$privacy->title_ar}}</h2>
        <p>{{ strip_tags($privacy->content_ar) }}</p>
         </div>
    </div>
  @else
  <div class="container">
     <div class="outr-box">
        <h2>{{$privacy->title}}</h2>
        <p>{{ strip_tags($privacy->content) }}</p>
         </div>
    </div>
  @endif
</section>

  @include('frontend.layouts.footer')
