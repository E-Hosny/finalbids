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
        width: 300px;
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
    <div class="container ">
        <div class="section-heading px-4">
            <h2>{{ session('locale') === 'en' ? 'Recommended Auctions' : (session('locale') === 'ar' ? 'المزادات الموصى بها' : 'Recommended Auctions') }}</h2>
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
                        <div class="card mb-3" style="max-width: 19rem;">
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
        <h2 class="fw-bold px-3 pb-4 ">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الآن' : 'Bid Now') }}</h2>

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
               @endphp


              <div>
                <a href="{{ url('productsdetail', $product->slug) }}">
                  <div class="card-product mx-auto" style="max-width: 19rem;">
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

                                      $currentDateTime = now();
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
                          <button class="text-btn" style="color: red;">{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'قدم العرض الآن' : 'Lot Closed') }}</button>
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
                          <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'قدم العرض الآن' : 'Lot Closed') }}</button>
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
                          <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'قدم العرض الآن' : 'Lot Closed') }}</button>
                      @else
                          @if ($bidRequest && $bidRequest->status == 1 &&  $product->auctionType->name == 'Private' && $currentDateTime >= $originalDateTime && $product->auction_end_date >= $formattedDateTime)
                          <a href="{{ url('productsdetail', $product->slug) }}">   <button class="text-btn">
                                      {{-- {{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }} --}}
                                  </button></a>
                            @endif
                  @endif

                  <div class="card-product-price pt-2 mt-2">
                      <h5>{{ formatPrice($product->reserved_price, session()->get('currency')) }} {{$currency}}</h5>

                      <!-- @if ($currentBid)
                           <p>
                               {{ session('locale') === 'en' ? 'Current Bid:' : (session('locale') === 'ar' ? 'المزايدة الحالية' : 'Current Bid:') }}
                               <span>{{ formatPrice($currentBid->bid_amount, session()->get('currency')) }} {{$currency}} </span>

                           </p>
                      @endif -->
                      <!--  -->
                        @if ($sold)
                           <p>
                               {{ session('locale') === 'en' ? 'Sold:' : (session('locale') === 'ar' ? 'مباع' : 'Sold:') }}
                               <span>{{ formatPrice($sold->bid_amount, session()->get('currency')) }} {{$currency}} </span>
                           </p>
                         @elseif ($currentBid)
                         <p>
                               {{ session('locale') === 'en' ? 'Current Bid:' : (session('locale') === 'ar' ? 'المزايدة الحالية' : 'Current Bid:') }}
                               <span>{{ formatPrice($currentBid->bid_amount, session()->get('currency')) }} {{$currency}} </span>
                           </p>
                         @endif
                  </div>

                    </div>
                  </div>
                </a>
              </div>





              @endforeach
    </div>

</section>




{{-- <section class="most-view-product">
    <div class="container">
        <div class="section-heading">
            <h2>{{ session('locale') === 'en' ? 'Popular Lots' : (session('locale') === 'ar' ? 'الاصناف الاكثر رواجاً' : 'Popular Lots') }}
            </h2>
        </div>
        <div class="popular_slider owl-carousel owl-theme">
            @foreach ($productauction as $auctionType)
                @if ($auctionType->name == 'Live' || $auctionType->name == 'Private' || $auctionType->name == 'Timed')
                    @foreach ($auctionType->products as $product)
                        @php
                            $loggedInUserId = Auth::id();
                                    $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                    ->where('project_id', $product->project_id)
                                    ->where('status',1)
                                    ->first();
                        @endphp

                        <div class="item">
                            <div class="popular_slider_item card-most-product">
                                <div class="img-card">
                                    @php
                                        $galleries = \App\Models\Gallery::where('lot_no', $product->lot_no)->get();
                                        $mostRecentBid = \App\Models\BidPlaced::where('product_id', $product->id)->orderBy('created_at', 'desc')->first();
                                    @endphp

                                    @if ($galleries->isNotEmpty())
                                        @if($bidRequest && $bidRequest->status == 1)
                                            <a href="{{ url('productsdetail', $product->slug) }}">
                                                <img src="{{ asset($galleries->first()->image_path) }}" alt="">
                                            </a>
                                        @else
                                            <a href="{{ url('products', optional($product->project)->slug) }}"
                                               onclick="return showPopups(event)">
                                                <img src="{{ asset($galleries->first()->image_path) }}" alt="">
                                            </a>
                                        @endif
                                    @else
                                        <img src="{{ asset('frontend/images/default-product-image.png') }}"
                                             alt="Default Image">
                                    @endif

                                    @auth
                                        <div
                                            class="heat-like wishlist-heart @if(in_array($product->id, $wishlist)) active @endif"
                                            data-product-id="{{ $product->id }}">
                                            <input type="checkbox" name="" id=""
                                                   @if(in_array($product->id, $wishlist)) checked @endif>
                                            <img src="{{ asset('frontend/images/heart.png') }}" alt="">
                                        </div>
                                    @else
                                        <a href="{{ route('signin') }}">
                                            <i class="fa fa-heart-o "></i>
                                        </a>
                                    @endauth

                                    <div class="bid-box-status">
                                        <div class="bid-box-status-ic">
                                            @php
                                                $auctionTypeName = '';
                                                $auctionTypeIcon = '';

                                                if (isset($mostRecentBid) && isset($mostRecentBid->product)) {
                                                    $auctionTypeName = optional($mostRecentBid->product->auctionType)->name;

                                                    if ($auctionTypeName === 'Private') {
                                                        $auctionTypeIcon = asset('auctionicon/private_icon.png');
                                                    } elseif ($auctionTypeName === 'Timed') {
                                                        $auctionTypeIcon = asset('auctionicon/time.png');
                                                    } elseif ($auctionTypeName === 'Live') {
                                                        $auctionTypeIcon = asset('auctionicon/live.png');
                                                    }
                                                }
                                            @endphp

                                            <img
                                                src="{{ !empty($auctionTypeIcon) ? $auctionTypeIcon : asset('frontend/images/default_icon.png') }}"
                                                alt="Auction Type Icon">
                                            @if(session('locale') === 'en')
                                                <span>{{ $auctionTypeName }}</span>
                                            @elseif(session('locale') === 'ar')
                                                <span>{{ optional($mostRecentBid?->product?->auctionType)->name_ar }}</span>
                                            @else
                                                <span>{{ $auctionTypeName }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $lastBids = \App\Models\BidPlaced::where('product_id', $product->id)
                                                    ->orderBy('created_at', 'desc')
                                                    ->first();
                                @endphp

                                <div class="popular_lnt">
                                    <span>{{ formatPrice($product->reserved_price, session()->get('currency')) }} {{$currency}}</span>

                                    @if ($auctionTypeName == 'Private' || $auctionTypeName == 'Timed')
                                        @if(strtotime($product->auction_end_date) > strtotime('now'))
                                            <div class="countdown-time thisisdemoclass" data-id='{{ $product->id }}'
                                                 data-date='{{ $product->auction_end_date }}'
                                                 id="countdown-{{ $product->id }}">
                                                <ul>
                                                    @if ($auctionTypeName == 'Private' || $auctionTypeName == 'Timed')
                                                        <li class="days-wrapper"><span class="days"></span>days</li>
                                                    @endif
                                                    <li><span class="hours"></span>Hours</li>
                                                    <li><span class="minutes"></span>Minutes</li>
                                                    <li><span class="seconds"></span>Seconds</li>
                                                </ul>
                                            </div>
                                        @else
                                            <p><span style="color: red;">Lot closed</span></p>
                                        @endif
                                    @endif

                                    @if ($auctionTypeName == 'Live' && $lastBids && $lastBids->bid_amount < $product->minsellingprice)
                                        <p><span style="color: #3E0269;">Auction is in progress</span></p>
                                    @elseif ($auctionTypeName == 'Live' && $lastBids && $lastBids->bid_amount >= $product->minsellingprice)
                                        <p><span style="color: red;">Bid Closed</span></p>
                                    @endif
                                </div>

                                @if($bidRequest && $bidRequest->status == 1)
                                    <a href="{{ url('productsdetail', $product->slug) }}" class="pop-link">
                                        <h3>
                                            {{ session('locale') === 'en' ? $product->lot_no . ': ' . substr(strip_tags($product->title), 0, 20) . (strlen(strip_tags($product->title)) > 20 ? '...' : '') :
                                            (session('locale') === 'ar' ? $product->lot_no . ': ' . substr(strip_tags($product->title_ar), 0, 20) . (strlen(strip_tags($product->title_ar)) > 20 ? '...' : '') :
                                            $product->lot_no . ': ' . substr(strip_tags($product->title), 0, 20) . (strlen(strip_tags($product->title)) > 20 ? '...' : '')) }}
                                        </h3>
                                    </a>
                                @else
                                    <a href="{{ url('products', optional($product->project)->slug) }}" class="pop-link"
                                       onclick="return showPopups(event)">
                                        <h3>
                                            {{ session('locale') === 'en' ? $product->lot_no . ': ' . substr(strip_tags($product->title), 0, 20) . (strlen(strip_tags($product->title)) > 20 ? '...' : '') :
                                            (session('locale') === 'ar' ? $product->lot_no . ': ' . substr(strip_tags($product->title_ar), 0, 20) . (strlen(strip_tags($product->title_ar)) > 20 ? '...' : '') :
                                            $product->lot_no . ': ' . substr(strip_tags($product->title), 0, 20) . (strlen(strip_tags($product->title)) > 20 ? '...' : '')) }}
                                        </h3>
                                    </a>
                                @endif

                                @if(session('locale') === 'en')
                                    <p>
                                        {{ substr(strip_tags($product->description), 0, 100) }}
                                        {{ strlen(strip_tags($product->description)) > 100 ? '...' : '' }}
                                    </p>
                                @elseif(session('locale') === 'ar')
                                    <p>
                                        {{ substr(strip_tags($product->description_ar), 0, 100) }}
                                        {{ strlen(strip_tags($product->description_ar)) > 100 ? '...' : '' }}
                                    </p>
                                @else
                                    <p>
                                        {{ substr(strip_tags($product->description), 0, 100) }}
                                        {{ strlen(strip_tags($product->description)) > 100 ? '...' : '' }}
                                    </p>
                                @endif

                                @php
                                    $currentBid = \App\Models\BidPlaced::where('product_id', $product->id)
                                                    ->where('status', 1)
                                                    ->orderBy('bid_amount', 'desc')
                                                    ->first();
                                    $sold = \App\Models\BidPlaced::where('product_id', $product->id)
                                                    ->where('sold', 2)
                                                    ->where('status', '!=', 0)
                                                    ->orderBy('bid_amount', 'desc')
                                                    ->first();
                                @endphp

                                @if ($sold)
                                    <span class="curnt-bid-man">
                {{ session('locale') === 'en' ? 'Sold' : (session('locale') === 'ar' ? 'باع' : 'Sold:') }}: {{ formatPrice($sold->bid_amount, session()->get('currency')) }} {{$currency}}
            </span>
                                @elseif ($currentBid)
                                    <span class="curnt-bid-man">
                {{ session('locale') === 'en' ? 'Current Bid' : (session('locale') === 'ar' ? 'المزايدة الحالية' : 'Current Bid:') }}: {{ formatPrice($currentBid->bid_amount, session()->get('currency')) }} {{$currency}}
            </span>
                                @endif

                                <a href="#" class="next-btn-img"><img src="{{ asset('frontend/images/next-btn.svg') }}"
                                                                      alt=""></a>
                            </div>
                        </div>

                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
</section> --}}

{{-- <section class="most-bid">
    <div class="container">
        <div class="section-heading">
            <h2>{{ session('locale') === 'en' ? 'Most Bids' : (session('locale') === 'ar' ? 'الاكثر مزايدة' : 'Most Bids') }}</h2>
        </div>
        <div class="row">
            @foreach($mostRecentBids as $productId => $mostRecentBid)
                @php
                    $loggedInUserId = Auth::id();
                    $projectId = optional($mostRecentBid->product)->project_id;
                    $bidRequest = null;

                    if ($projectId) {
                        $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                            ->where('project_id', $projectId)
                            ->where('status', 1)
                            ->first();
                    }
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="bid-box">
                        <div class="heat-like">
                            <input type="checkbox" name="" id="">
                            <img src="{{ asset('frontend/images/heart.png') }}" alt="">
                        </div>
                        <div class="box-img">
                            @if (isset($galleries) && $galleries->count() > 0)
                                @if ($bidRequest && $bidRequest->status == 1)
                                    <a href="{{ url('productsdetail', optional($mostRecentBid->product)->slug) }}">
                                        <img src="{{ asset($galleries->first()->image_path) }}" alt="">
                                    </a>
                                @else
                                    @php
                                        $projectSlug = optional(optional($mostRecentBid)->product)->project->slug ?? null;
                                    @endphp
                                    <a href="{{ url('products', $projectSlug) }}" onclick="return showPopup(event)">
                                        <img src="{{ asset($galleries->first()->image_path) }}" alt="">
                                    </a>
                                @endif
                            @else
                                <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image">
                            @endif
                        </div>
                        <div>
                            @php
                                $lastBid = isset($mostRecentBid->product) ? \App\Models\BidPlaced::where('product_id', $mostRecentBid->product->id)
                                    ->orderBy('created_at', 'desc')
                                    ->first() : null;
                            @endphp

                            @if (isset($mostRecentBid->product->auctionType))
                                @if ($mostRecentBid->product->auctionType->name == 'Private' || $mostRecentBid->product->auctionType->name == 'Timed')
                                    @if (strtotime($mostRecentBid->product->auction_end_date) > strtotime('now'))
                                        <div class="countdown-time thisisdemoclass"
                                             data-id='{{ $mostRecentBid->product->id }}'
                                             data-date='{{ $mostRecentBid->product->auction_end_date }}'
                                             id="countdown-{{ $mostRecentBid->product->id }}">
                                            <ul>
                                                <li class="days-wrapper"><span class="days"></span> days</li>
                                                <li><span class="hours"></span> Hours</li>
                                                <li><span class="minutes"></span> Minutes</li>
                                                <li><span class="seconds"></span> Seconds</li>
                                            </ul>
                                        </div>
                                    @else
                                        <p><strong><span style="color: red;">Lot closed</span></strong></p>
                                    @endif
                                @endif

                                @if ($mostRecentBid->product->auctionType->name == 'Live')
                                    @if ($lastBid && $lastBid->bid_amount < $mostRecentBid->product->minsellingprice)
                                        <p><span style="color: #3E0269;">Auction is in progress</span></p>
                                    @elseif ($lastBid && $lastBid->bid_amount >= $mostRecentBid->product->minsellingprice)
                                        <p><span style="color: red;">Bid Closed</span></p>
                                    @endif
                                @endif
                            @endif

                            <div class="bid-box-status">
                                <div class="bid-box-status-ic">
                                    @php
                                        $auctionTypeName = '';
                                        $auctionTypeIcon = '';

                                        if (isset($mostRecentBid) && isset($mostRecentBid->product)) {
                                            $auctionTypeName = optional($mostRecentBid->product->auctionType)->name;

                                            if ($auctionTypeName === 'Private') {
                                                $auctionTypeIcon = asset('auctionicon/private_icon.png');
                                            } elseif ($auctionTypeName === 'Timed') {
                                                $auctionTypeIcon = asset('auctionicon/time.png');
                                            } elseif ($auctionTypeName === 'Live') {
                                                $auctionTypeIcon = asset('auctionicon/live.png');
                                            }
                                        }
                                    @endphp
                                    <img
                                        src="{{ !empty($auctionTypeIcon) ? $auctionTypeIcon : asset('frontend/images/default_icon.png') }}"
                                        alt="Auction Type Icon">
                                    @if(session('locale') === 'en')
                                        <span>{{ $auctionTypeName }}</span>
                                    @elseif(session('locale') === 'ar')
                                        {{-- <span>{{ optional($mostRecentBid->product->auctionType)->name_ar }}</span> --}}
                                        {{-- <span><p>نوع المزاد</p></span>
                                    @else
                                        <span>{{ $auctionTypeName }}</span>
                                    @endif
                                </div>
                            </div>

                            @if (isset($mostRecentBid->product->slug))
                                @if(session('locale') === 'en')
                                    <h3>
                                        <a href="{{ url('productsdetail', $mostRecentBid->product->slug) }}">{{ $mostRecentBid->product->lot_no }}
                                            : {{ $mostRecentBid->product->title }}</a></h3>
                                @elseif(session('locale') === 'ar')
                                    <h3>
                                        <a href="{{ url('productsdetail', $mostRecentBid->product->slug) }}">{{ $mostRecentBid->product->lot_no }}
                                            : {{ $mostRecentBid->product->title_ar }}</a></h3>
                                @else
                                    <h3>
                                        <a href="{{ url('productsdetail', $mostRecentBid->product->slug) }}">{{ $mostRecentBid->product->lot_no }}
                                            : {{ $mostRecentBid->product->title }}</a></h3>
                                @endif
                                <p>{{ formatPrice($mostRecentBid->max_bid_amount, session()->get('currency')) }} {{$currency}}
                                    <span>{{ $mostRecentBid->bid_count }} bids</span></p>
                            @endif
                        </div>
                    </div>


                </div>
            @endforeach
        </div>
    </div>
</section>
 --}}



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


@include('frontend.products.script.addToWishListScript')

@include('frontend.layouts.requestbidscript')

@include('frontend.layouts.footer')
