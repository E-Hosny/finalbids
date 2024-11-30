@include('frontend.layouts.header')

<section class="hero-ther">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 text-center">
           <h1>{{ $page->title }}</h1>
           <p>
            <a href="index.html"><i class="fa fa-home"></i> Home /</a> {{ $page->title }}
          </p>
           
        </div>
      </div>
    </div>
  </section>
 
  <section class="policy-content">
    <div class="container">
      <h2>{{ $page->title }}</h2>
      <h4>What is Lorem Ipsum?</h4>
      <p>{{ $page->content }}</p>
     
    </div>
  </section>
  @include('frontend.layouts.footer')
