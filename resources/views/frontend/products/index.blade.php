@include('frontend.layouts.header')
@php

        $bidRequest = \App\Models\BidRequest::where('project_id', $projects->id)->first();
    @endphp
<style>
button.text-btns {
    position: absolute;
    right: 50px;
    top: 40px;
    font-size: 20px;
    border: 0;
    background-color: transparent;
    padding: 0;
    color: #e93d14;
    font-size: 29px;
    font-weight: 500;
    text-transform: uppercase
}
.data-bid {
    display: flex;
    justify-content: center;
}
.btn-primary {
    color: #fff;
    border-radius: 10px;
    background: linear-gradient(90deg, #0D3858 0%, #0D3858 100%);
    padding: 13px 30px;
    color: #fff !important;
    font-size: 16px;
    border: 0;
    text-transform: uppercase;
    white-space: nowrap;
}
.product-listtest {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.nodata {
    color: black;
    font-size: 38px;
    text-align: center;
}

.no-products-found {
    text-align: center;
}

.prd-link {
    text-decoration: none;
    color: black;
}

.prd-link:hover h3 {
    color:#0D3858;
}
  </style>

<section class="hero-ther inner_heade">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 bid-btn-right">
          <div class="data-bid d-block">
          <div class="data-btn text-center">



           @if(session('locale') === 'en')
                        <h1>{{$projects->name}}</h1>
                        @elseif(session('locale') === 'ar')
                        <h1>{{$projects->name_ar}}</h1>
                        @else
                        <h1>{{$projects->name}}</h1>
                        @endif


           @php
                $originalDateTime = $projects->start_date_time;
                $timestamp = strtotime($originalDateTime);
                $formattedDateTime = date("F j, g:i A", $timestamp);
                $endDatetime = $projects->end_date_time;
                $end =strtotime($endDatetime);
                $formattedEnddateTime = date("F j, g:i A",  $end);
                $currentDateTime = now();
            @endphp
           <p>{{$formattedDateTime}} - {{$formattedEnddateTime}}</p>
             @if ($projects->auctionType->name == 'Live' && $currentDateTime > $endDatetime)
                    <button class="text-btns" style="display: none;">{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق الدفعة' : 'Lot Closed') }}</button>
                @elseif($projects->auctionType->name == 'Live')
                <a href="{{ url('productslive', $projects->slug) }}"><button class="btn btn-danger enter_live">Enter Live Auction</button></a>
              @endif
              <div class="bid-box-status">
                  <div class="bid-box-status-ic">
                      @php
                          $auctionTypeName = $projects->auctionType->name;
                          $auctionTypeIcon = '';

                          if ($auctionTypeName === 'Private') {
                              $auctionTypeIcon = asset('auctionicon/private_icon.png');
                          } elseif ($auctionTypeName === 'Timed') {
                              $auctionTypeIcon = asset('auctionicon/time.png');
                          } elseif ($auctionTypeName === 'Live') {
                              $auctionTypeIcon = asset('auctionicon/live.png');
                          }
                      @endphp

                      <img src="{{ !empty($auctionTypeIcon) ? $auctionTypeIcon : asset('frontend/images/default_icon.png') }}" alt="Auction Type Icon">
                      @if(session('locale') === 'en')
                     <span>{{ $projects->auctionType->name }}</span>

                      @elseif(session('locale') === 'ar')
                      <span>{{ $projects->auctionType->name_ar }}</span>
                      @else
                     <span>{{ $projects->auctionType->name }}</span>

                      @endif
                  </div>
              </div>
              <!--  -->
              @php
                  $loggedInUserId = Auth::id();
                  $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                          ->where('project_id', $projects->id)
                                          ->first();
              @endphp
                              @php
                                $originalDateTime = $projects->start_date_time;
                                $originalDatesTime = new Carbon\Carbon($originalDateTime);
                                $twoWeeksBefore = $originalDatesTime->copy()->subWeeks(2);
                                $currentDateTime = now()->timezone('Asia/Kolkata');

                                $enddate = $projects->end_date_time;
                                $enddatetime  = new Carbon\Carbon($enddate);

                                @endphp

              <div class="serach_topbar">
                <form action="" class="search-frm-prdt" id="searchForm">
            <input type="text" name="search" id="searchInput" placeholder="{{ session('locale') === 'en' ? 'Search products...' : (session('locale') === 'ar' ? 'ابحث عن منتجات' : 'Search products...') }}">

                    <button type="button" onclick="submitSearchForm()">
                        {{-- <img class="w-100" src="{{ asset('frontend/images/rounded-sr.svg') }}" alt=""> --}}
                        {{-- <button class="search-btn bg-info">
                            <i class="fa fa-search"></i>
                        </button> --}}
                        <i class="fa fa-search mt-3 fs-4"></i>

                    </button>
                </form>
               <!-- timed auction -->
               @if ($projects->auctionType->name == 'Timed' && $currentDateTime > $enddatetime)
                    <button class="text-btns" style="display: none;">{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق الدفعة' : 'Lot Closed') }}</button>
                @else
                      @if ($projects->auctionType->name == 'Timed'  && $currentDateTime >= $originalDateTime)
                          <button class="text-btns" style="display: none;">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }} </button>
                      @elseif ($projects->auctionType->name == 'Timed' && $currentDateTime >= $twoWeeksBefore)
                          <button class="btn btn-primary"> {{ session('locale') === 'en' ? 'EXPLORE NOW' : (session('locale') === 'ar' ? 'استكشف الآن' : 'EXPLORE NOW') }} </button>
                      @endif
              @endif

                <!-- Private Auction -->
                @if ($projects->auctionType->name == 'Private' && $currentDateTime > $enddatetime)
                    <button class="text-btns" style="display: none;">{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق القطعة' : 'Lot Closed') }}</button>
                @else
                          @if ($bidRequest && $bidRequest->status == 1 && $projects->auctionType->name == 'Private' && $currentDateTime >= $originalDateTime)
                              <button class="text-btns" style="display: none;">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }} </button>
                          @elseif ($bidRequest && $bidRequest->status == 0 && $projects->auctionType->name == 'Private')
                              <button class="btn btn-primary" >
                                {{ session('locale') === 'en' ? 'Requested' : (session('locale') === 'ar' ? 'تم الطلب' : 'Requested') }}
                              </button>
                          @elseif  ($bidRequest && $bidRequest->status == 1 && $projects->auctionType->name == 'Private' && $currentDateTime <= $originalDateTime)
                                          <button class="btn btn-primary" style="display: none;" >

                                              Project Not start
                                        </button>
                          @elseif ($projects->auctionType->name == 'Private' && $currentDateTime >= $twoWeeksBefore)
                          <button class="btn btn-primary" onclick="requestBid('{{ $projects->name }}', '{{ $projects->id }}', '{{ $projects->auction_type_id }}', '{{ $projects->deposit_amount }}')">
                              {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب المزايدة' : 'Request Bid') }}</button>
                          @endif
                @endif

                <!-- Live Auction -->
                @if ($projects->auctionType->name == 'Live' && $currentDateTime > $enddatetime)
                    <button class="text-btns" style="display: none;">{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق الدفعة' : 'Lot Closed') }}</button>
                @else
                        @if ($bidRequest && $bidRequest->status == 1 && $projects->auctionType->name == 'Live' && $currentDateTime >= $originalDateTime)
                            <button class="text-btns" style="display: none;">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }} </button>
                        @elseif ($bidRequest && $bidRequest->status == 0 && $projects->auctionType->name == 'Live')
                            <button class="btn btn-primary" >
                              {{ session('locale') === 'en' ? 'Requested' : (session('locale') === 'ar' ? 'تم الطلب' : 'Requested') }}
                            </button>
                        @elseif  ($bidRequest && $bidRequest->status == 1 && $projects->auctionType->name == 'Live' && $currentDateTime <= $originalDateTime)
                                        <button class="btn btn-primary" style="display: none;" >

                                            Project Not start
                                      </button>
                        @elseif ($projects->auctionType->name == 'Live' && $currentDateTime >= $twoWeeksBefore)
                        <button class="btn btn-primary" onclick="requestBid('{{ $projects->name }}', '{{ $projects->id }}', '{{ $projects->auction_type_id }}', '{{ $projects->deposit_amount }}')">
                            {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب المزايدة' : 'Request Bid') }}</button>
                        @endif
                @endif


              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  <section class="list-fliter px-5">
    <div class="container">
      <div class="result-lst mx-auto">
        <h3>{{ session('locale') === 'en' ? 'Items' : (session('locale') === 'ar' ? 'المنتجات' : 'Items') }} <span>{{ ' : '. $totalItems }}</span></h3>

        <div class="fliter-short">
          <form action="" class="cmn-frm">
            <!-- <select name="sort" class="m-0" onchange="this.form.submit()">
                <option value="price_low_high">Price: Low to High</option>
                <option value="price_high_low">Price: High to Low</option>
            </select> -->
            <select name="sort" class="m-0" onchange="this.form.submit()">
        <option value="price_low_high" {{ isset($_GET['sort']) && $_GET['sort'] == 'price_low_high' ? 'selected' : '' }}>{{ session('locale') === 'en' ? 'Price: Low to High' : (session('locale') === 'ar' ? 'السعر : من الأقل الى الأعلى' : 'Price: Low to High') }}</option>
        <option value="price_high_low" {{ isset($_GET['sort']) && $_GET['sort'] == 'price_high_low' ? 'selected' : '' }}>{{ session('locale') === 'en' ? 'Price: High to Low' : (session('locale') === 'ar' ? 'السعر : من الأعلى الى الأقل' : 'Price: High to Low') }}</option>
    </select>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="product-list-man">
    <div class="container px-5">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2">
      @foreach($products as $product)
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
                            <img src="{{ asset($imagePath) }}" alt="Product Image"  width="268" height="276"  >
                        @else
                            <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image" width="268" height="276" >
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
              @if ($projects->auctionType->name == 'Timed' && $currentDateTime > $enddatetime)
                    <button class="text-btn" style="color: red;">{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'قدم العرض الآن' : 'Lot Closed') }}</button>
                @else
                      @if ($projects->auctionType->name == 'Timed' && $currentDateTime >= $originalDateTime && $product->auction_end_date >= $formattedDateTime)
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
                @if ($projects->auctionType->name == 'Live' && $currentDateTime > $enddatetime)
                    <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'قدم العرض الآن' : 'Lot Closed') }}</button>
                @else
                            @if ($lastBid && $lastBid->bid_amount >= $product->minsellingprice && $projects->auctionType->name == 'Live')
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
              @if ($projects->auctionType->name == 'Private' && $currentDateTime > $enddatetime)
                    <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'قدم العرض الآن' : 'Lot Closed') }}</button>
                @else
                    @if ($bidRequest && $bidRequest->status == 1 &&  $projects->auctionType->name == 'Private' && $currentDateTime >= $originalDateTime && $product->auction_end_date >= $formattedDateTime)
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

        <ul class="pagination">

           {{ $products->appends($_GET)->links('pagination::bootstrap-5') }}

        </ul>

    </div>
  </section>
  <section class="product-list">


    @if($products->isEmpty())
        <div class="no-products-found">

        <h2 class="nodata">{{ session('locale') === 'en' ? 'No Data Found' : (session('locale') === 'ar' ? 'لا يوجد بيانات' : 'No Data Found') }}</h2>
        </div>
    @endif
</section>


    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script>
    <script src="{{asset('frontend/js/slick.min.js')}}"></script>
    <!-- <script src="{{asset('frontend/js/main.js')}}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
 <script>


  const rangeInput = document.querySelectorAll(".range-input input"),
  priceInput = document.querySelectorAll(".price-input input"),
  range = document.querySelector(".slider .progress");
let priceGap = 1000;

priceInput.forEach((input) => {
  input.addEventListener("input", (e) => {
    let minPrice = parseInt(priceInput[0].value),
      maxPrice = parseInt(priceInput[1].value);

    if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
      if (e.target.className === "input-min") {
        rangeInput[0].value = minPrice;
        range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
      } else {
        rangeInput[1].value = maxPrice;
        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
      }
    }
  });
});

rangeInput.forEach((input) => {
  input.addEventListener("input", (e) => {
    let minVal = parseInt(rangeInput[0].value),
      maxVal = parseInt(rangeInput[1].value);

    if (maxVal - minVal < priceGap) {
      if (e.target.className === "range-min") {
        rangeInput[0].value = maxVal - priceGap;
      } else {
        rangeInput[1].value = minVal + priceGap;
      }
    } else {
      priceInput[0].value = minVal;
      priceInput[1].value = maxVal;
      range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
      range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
    }
  });
});


// function submitSearchForm() {
//   var searchInputValue = document.getElementById('searchInput').value.trim();


//   if (searchInputValue !== '') {

//       var currentUrl = window.location.href;


//       var separator = currentUrl.includes('?') ? '&' : '?';

//       var newUrl = currentUrl + separator + 'search=' + encodeURIComponent(searchInputValue);


//       window.location.href = newUrl;
//   }
// }

// document.addEventListener('DOMContentLoaded', function () {

//   var urlSearchParams = new URLSearchParams(window.location.search);
//   var searchInputValue = urlSearchParams.get('search');


//   if (searchInputValue !== null) {
//       document.getElementById('searchInput').value = decodeURIComponent(searchInputValue);
//   }
// });

document.addEventListener('DOMContentLoaded', function () {
    // Retrieve the search parameter from the URL
    var urlSearchParams = new URLSearchParams(window.location.search);
    var searchInputValue = urlSearchParams.get('search');

    // Set the search input value if it exists
    if (searchInputValue !== null) {
      document.getElementById('searchInput').value = decodeURIComponent(searchInputValue);
    }

    // Clear search input and URL parameters on page refresh
    window.onload = function () {
      if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_RELOAD) {
        document.getElementById('searchInput').value = ''; // Clear search input
        history.replaceState({}, document.title, window.location.pathname); // Clear URL parameters
      }
    };
  });

  function submitSearchForm() {
    var searchInputValue = document.getElementById('searchInput').value.trim();

    // Check if the search input is not empty
    if (searchInputValue !== '') {
      // Get the current URL
      var currentUrl = window.location.href;

      // Check if the URL already has parameters
      var separator = currentUrl.includes('?') ? '&' : '?';

      // Add the search parameter to the current URL
      var newUrl = currentUrl + separator + 'search=' + encodeURIComponent(searchInputValue);

      // Redirect to the new URL
      window.location.href = newUrl;
    }
  }

</script>


@include('frontend.layouts.footer')
@include('frontend.products.script.addToWishListScript')
@include('frontend.layouts.requestbidscript')
