
<section class="hero-ther">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 text-center">
            
          @if (session('locale') === 'en')
           <!-- <h1>Terms & Conditions</h1> -->
           <!-- <p>
            <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> Terms & Conditions
          </p> -->
        @elseif (session('locale') === 'ar')
            <!-- <h1>الشروط والأحكام</h1> -->
              <!-- <p>
                <a href="{{url('/')}}"><i class="fa fa-home"></i> وطن /</a> الشروط والأحكام
              </p> -->
        @else
           <!-- <h1>Terms & Conditions</h1> -->
           <!-- <p>
            <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> Terms & Conditions
          </p> -->
        @endif
        </div>
      </div>
    </div>
  </section>
 


  <section class="policy-content">
   
    @if (session('locale') === 'en')
    <div class="container">
      <div class="outr-box">
        <h2>{{$terms->title}}</h2>
        <p>{{ strip_tags($terms->content) }}</p>
      </div>
    </div>
  @elseif (session('locale') === 'ar')
    <div class="container">
      <div class="outr-box">
        <h2>{{$terms->title_ar}}</h2>
        <p>{{ strip_tags($terms->content_ar) }}</p>
      </div>
    </div>
  @else
  <div class="container">
    <div class="outr-box">
        <h2>{{$terms->title}}</h2>
        <p>{{ strip_tags($terms->content) }}</p>
      </div>
    </div>
  @endif
</section>
