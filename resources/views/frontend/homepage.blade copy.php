@include('frontend.layouts.header')

<style>
    .most-bid p span {
        font-size: 14px;
    }

    .project-link {
        text-decoration: none;
        color: black;
    }

    .project-link:hover h3 {
        color: #3E0269;
    }

    .pop-link {
        text-decoration: none;
        color: black;
    }

    .pop-link:hover h3 {
        color: #3E0269;
    }

    .hero-section-btn .view-result-btn{
        background-color: #0D3858 !important;
        /* color: #0D3858 !important; */
    }

</style>

<style>
    .trending-auction-section {
        background-color: #f8f9fa;
        margin:0;
        padding-top:50px;
    }

    .card {
        border: 0;
        width: 304px;
        max-width: 19rem;
    }
     @media screen and (max-width:768px) {
   .card{
        width: 90% !important;
        max-width: 25rem;
   }
}
    .card-product {
        /* border: 0;
        width: 304px; */
        max-width: 19rem;
    }
     @media screen and (max-width:768px) {
   .card-product{
        width: 90% !important;
        max-width: 25rem;
   }
}


    .card-body {
        border: 0;
    }

    .card-footer {
        border: 0;
    }

    .card-header {
        border: 0;
    }

    .clickable {
        cursor: pointer;
    }
    /* Group 41 */

    .view-text {
        color: #0D3858;
    }


    /* Adjust the container spacing */
    .container {
        padding-left: 5px;
        padding-right: 5px;
        margin: 0 auto; /* Center the content */
    }


</style>
<section class="home home_slider">
    <div class="owl-carousel owl-theme">
        @foreach($banners as $b)
            @php
                $project = App\Models\Project::where('slug', $b->url)->first();
                $currentDateTime = now();
            @endphp
            @if(!empty($b->image_path))
                <div class="item" style="background-image: url('{{ asset('img/users/' . $b->image_path) }}');">
                    @else
                        <div class="item"
                             style="background-image: url('{{ asset('frontend/images/slider-bg.png') }}');">
                            @endif
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hero-section">
                                            @if(session('locale') === 'en')
                                                <h1>{{$b->title}} <br></h1>
                                                <p>{{ strip_tags($b->description) }}</p>
                                            @elseif(session('locale') === 'ar')
                                                <h1>{{$b->title_ar}} <br></h1>
                                                {{-- <p>{{ strip_tags($b->description_ar) }}</p> --}}
                                            @else
                                                <h1>{{$b->title}} <br></h1>
                                                <p>{{ strip_tags($b->description) }}</p>
                                            @endif
                                            @if ($project && $project->count() > 0)

                                                @if ($project && $currentDateTime > $project->end_date_time)
                                                    <div class="hero-section-btn">
                                                        <a href="{{ url('products',  $b->url) }}"
                                                           class="btn text-white px-4 view-result-btn">{{ session('locale') === 'en' ? 'View Results' : (session('locale') === 'ar' ? 'عرض النتائج' : 'View Results') }} </a>
                                                    </div>
                                                @else
                                                    <div class="hero-section-btn">
                                                        <a href="{{ url('products', $b->url) }}"
                                                           class="btn btn-secondary  ">{{ session('locale') === 'en' ? 'Explore Now' : (session('locale') === 'ar' ? 'استكشاف الآن' : 'Explore Now') }}</a>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                </div>
</section>
<section class="trending-auction-section mb-5">
    <div class="container  ">
        <div class="section-heading px-4">
            <h2>{{ session('locale') === 'en' ? 'Upcoming Auctions' : (session('locale') === 'ar' ? 'المزادات الموصى بها' : 'Upcoming Auctions') }}</h2>
        </div>
        @foreach($auctionTypesWithProject as $at)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2 trending-auction-section-items">
                @foreach($at->projects as $project)
                    @php
                        $loggedInUserId = auth()->id();
                        $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                                            ->where('project_id', $project->id)
                                                            ->first();


                        $formattedStartDateTimeconvert  = date("j-M", strtotime($project->start_date_time));
                        $formattedEndDateTimeconvert    = date("j-M", strtotime($project->end_date_time));

                         $currentDateTime = now();



                    @endphp

                    <div class="col d-flex justify-content-center">
                        <div class="card mb-3">
                            <div class="card-header bg-transparent">

                                @if(session('locale') === 'en')
                                    <p class="fw-bold" href="{{ url('products', $project->slug) }}" >{{ $project->name }}</p>
                                @elseif(session('locale') === 'ar')
                                    <p href="{{ url('products', $project->slug) }}" >{{$project->name_ar}}</p>
                                @else
                                    <p href="{{ url('products', $project->slug) }}" >{{ $project->name }}</p>
                                @endif
                                <p>{{ $formattedStartDateTimeconvert }} | {{ $formattedEndDateTimeconvert }}</p>
                            </div>
                            <a href="{{ url('products', $project->slug) }}">
                                <div class="card-body text-success">
                                        @if (!empty($project->image_path))
                                            <img src="{{  asset("img/projects/$project->image_path")}}" class="card-img-top" height="276" width="243"
                                                 alt="{{ $project->title }}">
                                        @else
                                            <img   src="{{ asset('img/default-images/pro-1.png') }}" height="276" width="243"
                                                alt="Default Image">
                                        @endif
                                </div>
                            </a>

                            <div class="card-footer bg-transparent">
                                @if ($project->end_date_time>=$currentDateTime)
                                <p class="text-muted">{{ session('locale') === 'en' ? 'OPEN FOR BIDDING' : (session('locale') === 'ar' ? 'مفتوح للمزايدة' : 'OPEN FOR BIDDING') }}</p>

                                @endif
                                <a href="{{ url('products', $project->slug) }}" class="text-decoration-">
                                    <span class="view-text">
                                    {{ session('locale') === 'ar' ? 'عرض  '.count($project->products).' قطعة أرض ': 'View '.count($project->products).' lots'   }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>


                @endforeach
            </div>
        @endforeach
    </div>
</section>

<section class="publishedProducts pb-3">
    <div class="container">
        <h2 class="fw-bold px-3 pb-4 ">
            @if(session('locale') === 'en')
                Bid Now
            @elseif(session('locale') === 'ar')
                زاود الآن
            @else
                Bid Now
            @endif
        </h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2">
            @foreach($homeProducts as $product)
               @php
               $currentBid = \App\Models\BidPlaced::where('product_id', $product->id)
                                          ->where('sold', 1)
                                          ->where('status', '!=', 0)
                                          ->orderBy('bid_amount', 'desc')
                                          ->first();
              $sold = \App\Models\BidPlaced::where('product_id', $product->id)
                      ->where('sold', 2)
                      ->where('status', '!=', 0)
                      ->orderBy('bid_amount', 'desc')
                      ->first();

                $currentDateTime = now();
                $endDateTime = $product->auction_end_date;
                $isClosed = $currentDateTime > $endDateTime;
               @endphp


              <div>
                <a href="{{ url('productsdetail', $product->slug) }}">
                  <div class="card-product mx-auto">
                    <div class="product-image  text-center">
                                 @php
                                      $imagePath = \App\Models\Gallery::where('lot_no', $product->lot_no)->orderBy('id')->value('image_path');
                                  @endphp

                              @if ($imagePath)
                                  <img class="w-100" src="{{ asset($imagePath) }}" alt="Product Image"  width="268" height="276"  >
                              @else
                                  <img class="w-100" src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image" width="268" height="276" >
                              @endif
                              @auth
                      {{-- <div class="heat-like wishlist-heart @if(in_array($product->id, $wishlist)) active @endif" data-product-id="{{ $product->id }}">
                          <input type="checkbox" name="" id="" @if(in_array($product->id, $wishlist)) checked @endif>
                          <img src="{{asset('frontend/images/heart.png')}}" alt="">
                      </div> --}}
                        @else
                              {{-- <a href="{{ route('signin') }}"> <i class="fa fa-heart-o "></i></a> --}}
                              @endauth
                    </div>
                    <div class="card-product-dtl px-1">
                              @if(session('locale') === 'en')
                              <a href="{{ url('productsdetail', $product->slug) }}" class="prd-link"><h3 class="pt-2" >{{$product->lot_no}}: {{$product->title}}</h3></a>
                              @elseif(session('locale') === 'ar')
                              <a href="{{ url('productsdetail', $product->slug) }}" class="prd-link"><h3 class="pt-2" >{{$product->lot_no}}: {{$product->title_ar}}</h3></a>
                              @else
                              <a href="{{ url('productsdetail', $product->slug) }}" class="prd-link"> <h3 class="pt-2" >{{$product->lot_no}}: {{$product->title}}</h3></a>
                              @endif

                              <div class="card-product-desc" >
                                  @if(session('locale') === 'en')
                                  <a href="{{ url('productsdetail', $product->slug) }}" class="prd-link"><p >{{strip_tags($product->description) }}</p></a>
                                  @elseif(session('locale') === 'ar')
                                  <a href="{{ url('productsdetail', $product->slug) }}" class="prd-link"><p >{{ strip_tags($product->description_ar); }}</p></a>
                                  @else
                                  <a href="{{ url('productsdetail', $product->slug) }}" class="prd-link"> <p >{{ strip_tags($product->description); }}</p></a>
                                  @endif
                              </div>
                       <!--  -->
                                @php

                                      $formattedCurrentDateTime = $currentDateTime->format('Y-m-d H:i:s');
                                      $currentDateTimeUTC = new DateTime('now');
                                      $prductenddatetime =$product->auction_end_date;
                                      $currentDateTimeUTC->setTimezone(new DateTimeZone('Asia/Kolkata'));
                                      $formattedDateTime = $currentDateTimeUTC->format('Y-m-d H:i:s');
                                      $enddatetime=$product->auction_end_date;

                                      $project_id=$product->project_id;
                                      $project=\App\Models\Project::find($project_id);
                                      $originalDateTime = $project->start_date_time;



                                  @endphp
                      @if ($product->auction_end_date >= $formattedDateTime )
                      @if (($product->auctionType->name == 'Private' || $product->auctionType->name == 'Timed') && ($product->auctionType->name != 'Live'))
                              @if(strtotime($product->auction_end_date) > strtotime('now'))
                                    <div class=" countdown-time thisisdemoclass" data-id='{{ $product->id }}' data-date='{{ $product->auction_end_date }}'
                                        id="countdown-{{ $product->id }}">
                                        <ul>
                                            @if ($product->auctionType->name == 'Private'|| $product->auctionType->name == 'Timed')
                                                <li class="days-wrapper"><span class="days"></span>days</li>
                                            @endif

                                            <li ><span class="hours"></span>Hours</li>

                                            <li><span class="minutes"></span>Minutes</li>
                                            <li><span class="seconds"></span>Seconds </li>
                                        </ul>
                                    </div>
                              @endif
                          @endif
                          @else

                        @endif
                                 @php
                                      $loggedInUserId = Auth::id();
                                      $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                                                          ->where('project_id', $product->project_id)

                                                                          ->first();
                                @endphp

                    <!-- For Timed Auction -->
                    @if ($product->auctionType->name == 'Timed' && $currentDateTime > $enddatetime)
                          <button class="text-btn" style="color: red;">{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'المزاد مغلق' : 'Lot Closed') }}</button>
                      @else
                            @if ($product->auctionType->name == 'Timed' && $currentDateTime >= $originalDateTime && $product->auction_end_date >= $formattedDateTime)
                            <a href="{{ url('productsdetail', $product->slug) }}"> <button class="text-btn">
                                      {{-- {{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }} --}}
                                  </button></a>
                            @endif
                    @endif
                     <!-- For Live Auction -->
                            @php
                              $lastBid = \App\Models\BidPlaced::where('product_id', $product->id)
                                                        ->orderBy('created_at', 'desc')
                                                        ->first();
                              @endphp
                      @if ($product->auctionType->name == 'Live' && $currentDateTime > $enddatetime)
                          <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'المزاد مغلق' : 'Lot Closed') }}</button>
                      @else
                                  @if ($lastBid && $lastBid->bid_amount >= $product->minsellingprice && $product->auctionType->name == 'Live')
                                        <p><strong><span style="color: red;">Bid Closed</span></strong></p>
                                        @else
                                                  @if ($bidRequest && $bidRequest->status == 1 && $projects->auctionType->name == 'Live' && $currentDateTime >= $originalDateTime)
                                                  <a href="{{ url('productsdetail', $product->slug) }}">  <button class="text-btn">
                                                            {{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }}
                                                        </button></a>
                                                  @endif
                                    @endif
                      @endif

                   <!-- For Private Auction -->
                    @if ($product->auctionType->name == 'Private' && $currentDateTime > $enddatetime)
                          <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'المزاد مغلق' : 'Lot Closed') }}</button>
                      @else
                          @if ($bidRequest && $bidRequest->status == 1 &&  $product->auctionType->name == 'Private' && $currentDateTime >= $originalDateTime && $product->auction_end_date >= $formattedDateTime)
                          <a href="{{ url('productsdetail', $product->slug) }}">   <button class="text-btn">
                                      {{-- {{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }} --}}
                                  </button></a>
                            @endif
                  @endif

                  <div class="card-product-price pt-2 mt-2">
                      @if ($isClosed)
                          @if ($sold)
                              <p>
                                  {{ session('locale') === 'en' ? 'Sold:' : (session('locale') === 'ar' ? 'مباع' : 'Sold:') }}
                                  <span>{{ formatPrice($sold->bid_amount, session()->get('currency')) }} {{$currency}} </span>
                              </p>
                          @else
                              <h5>
                                  {{ session('locale') === 'en' ? 'Sale Price:' : (session('locale') === 'ar' ? 'سعر البيع:' : 'Sale Price:') }}
                                  {{ formatPrice($product->reserved_price, session()->get('currency')) }} {{$currency}}
                              </h5>
                          @endif
                      @else
                          @if ($currentBid)
                              <p>
                                  {{ session('locale') === 'en' ? 'Current Bid:' : (session('locale') === 'ar' ? 'المزايدة الحالية:' : 'Current Bid:') }}
                                  <span>{{ formatPrice($currentBid->bid_amount, session()->get('currency')) }} {{$currency}} </span>
                              </p>
                          @else
                              <h5>
                                  {{ formatPrice($product->reserved_price, session()->get('currency')) }} {{$currency}}
                              </h5>
                          @endif
                      @endif
                  </div>

                    </div>
                  </div>
                </a>
              </div>
              @endforeach
    </div>

</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@include('frontend.products.script.addToWishListScript')

@include('frontend.layouts.requestbidscript')

@include('frontend.layouts.footer')
