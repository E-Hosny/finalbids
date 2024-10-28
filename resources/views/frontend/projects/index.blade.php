@include('frontend.layouts.header')
<style>
  .nodata {
    color: black;
    font-size: 38px;
    text-align: center;
}

.no-products-found {
    text-align: center;
}
.project-link {
    text-decoration: none;
    color: black;
}

.project-link:hover h3 {
    color: #3E0269;
}
  </style>
<section class="hero-ther">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 text-center">
           <h1>{{ session('locale') === 'en' ? 'Projects' : (session('locale') === 'ar' ? 'مشاريع': 'Projects') }}</h1>

            <form action="" class="search-frm-prdt" id="searchForm">
            <input type="text" name="search" id="searchInput" placeholder="{{ session('locale') === 'en' ? 'Search projects...' : (session('locale') === 'ar' ? 'ابحث عن المشاريع...' : 'Search projects...') }}">

              <button type="button" onclick="submitSearchForm()"><img class="w-100" src="{{ asset('frontend/images/rounded-sr.svg') }}" alt=""></button>
            </form>
        </div>
      </div>
    </div>
  </section>


  <section class="product-list-man mt-5">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2 trending-auction-section-items">
     {{-- @foreach($projects as $pro)

        <div class="col-md-3  bg-info">
                <div class="card-product bg-danger product-blndle">
                <a href="{{ url('products', $pro->slug) }}">
                <div class="product-image">
                        @if (!empty($pro->image_path))
                                <img src="{{ asset("img/projects/$pro->image_path") }}" alt="{{ $pro->title }}">
                            @else
                                <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image">
                            @endif

                </div>
                </a>

                <div class="bid-box-status">
                  <div class="bid-box-status-ic">
                      @php
                          $auctionTypeName = $pro->auctionType->name;
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
                      <span>{{ $pro->auctionType->name }}</span>

                      @elseif(session('locale') === 'ar')
                          <h2>{{$pro->auctionType->name_ar}}</h2>
                      @else
                      <span>{{ $pro->auctionType->name }}</span>

                      @endif
                  </div>
              </div>
                 @php
                      $originalDateTime = $pro->start_date_time;
                      $timestamp = strtotime($originalDateTime);
                      $formattedDateTime = date("F j, g:i A", $timestamp);
                      $endDatetime = $pro->end_date_time;
                      $end =strtotime($endDatetime);
                      $formattedEnddateTime = date("F j, g:i A",  $end);
                      $formattedEndDateTimeconvert = date("M j, g:i A", $end);
                      $currentDateTime = now();

                  @endphp
                <div class="card-product-dtl p-0">

                    <!-- @if(session('locale') === 'en')
                           <h3>{{$pro->name}}  </h3>
                        @elseif(session('locale') === 'ar')
                        <h3>{{$pro->name_ar}}  </h3>
                        @else
                           <h3>{{$pro->name}}  </h3>
                        @endif -->

                        <a href="{{ url('products', $pro->slug) }}" class="project-link">
                            <h3 >
                                {{ session('locale') === 'en' ? $pro->name : (session('locale') === 'ar' ? $pro->name_ar : $pro->name) }}
                            </h3>
                        </a>
                    @if ($pro->auctionType->name == 'Live' || $pro->auctionType->name == 'Private')
                    <h5>{{ formatPrice($pro->deposit_amount, session()->get('currency')) }}  {{$currency}}</h5>
                    @endif
                         @php
                            $originalDateTime = $pro->start_date_time;
                            $timestamp = strtotime($originalDateTime);
                            $formattedDateTime = date("F j, g:i A", $timestamp);
                            $formattedDateTimeconvert = date("M j, g:i A", $timestamp);
                        @endphp
                    <p>{{  $formattedDateTimeconvert }} - {{$formattedEndDateTimeconvert}}</p>
                    @php
                        $loggedInUserId = Auth::id();
                        $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                            ->where('project_id', $pro->id)
                            ->first();
                    @endphp

                                @php
                                    $originalDateTime = $pro->start_date_time;
                                    $originalDatesTime = new Carbon\Carbon($originalDateTime);
                                    $twoWeeksBefore = $originalDatesTime->copy()->subWeeks(2);
                                    $currentDateTime = now()->timezone('Asia/Kolkata');
                                @endphp

                                @if ($pro->auctionType->name == 'Timed'  && $currentDateTime >= $originalDateTime)
                                <a href="{{ url('products', $pro->slug) }}"> <button class="text-btn">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }} </button></a>
                                @elseif ($pro->auctionType->name == 'Timed' && $currentDateTime >= $twoWeeksBefore)
                                    <button class="text-btn"> {{ session('locale') === 'en' ? 'EXPLORE NOW' : (session('locale') === 'ar' ? 'استكشف الآن' : 'EXPLORE NOW') }} </button>
                                @endif

                                <!-- For Live Auction -->
                                <!-- @if ($bidRequest && $bidRequest->status == 1 && $pro->auctionType->name == 'Live' && $currentDateTime >= $originalDateTime) <button
                                        class="text-btn" onclick="bidNow()">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'قدم العرض الآن' : 'Bid Now') }}  </button>
                                @elseif  ($pro->auctionType->name == 'Live' && $currentDateTime >= $twoWeeksBefore) <button class="text-btn"
                                    onclick="requestBid('{{ $pro->name }}', '{{ $pro->id }}', '{{ $pro->auction_type_id }}', '{{ $pro->deposit_amount }}')">
                                     {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب عرض أسعار' : 'Request Bid') }}</button>
                                @endif -->

                                @if ($bidRequest && $bidRequest->status == 1 && $pro->auctionType->name == 'Live' && $currentDateTime >= $originalDateTime) <a href="{{ url('products', $pro->slug) }}"><button
                                            class="text-btn" >{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }}  </button></a>
                                    @elseif ($bidRequest && $bidRequest->status == 0 && $pro->auctionType->name == 'Live')
                                    <button class="text-btn" >

                                          {{ session('locale') === 'en' ? 'Requested' : (session('locale') === 'ar' ? 'تم الطلب' : 'Requested') }}
                                    </button>
                                    @elseif  ($bidRequest && $bidRequest->status == 1 && $pro->auctionType->name == 'Live' && $currentDateTime <= $originalDateTime)
                                    <button class="text-btn" style="display: none;" >

                                        Project Not start
                                  </button>

                                    @elseif  ($pro->auctionType->name == 'Live' && $currentDateTime >= $twoWeeksBefore) <button class="text-btn"
                                    onclick="requestBid('{{ $pro->name }}', '{{ $pro->id }}', '{{ $pro->auction_type_id }}', '{{ $pro->deposit_amount }}')">
                                     {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب المزايدة' : 'Request Bid') }}</button>
                                @endif


                                <!-- For Private Auction -->
                                <!-- @if ($bidRequest && $bidRequest->status == 1 && $pro->auctionType->name == 'Private' && $currentDateTime >= $originalDateTime) <button
                                        class="text-btn" onclick="bidNow()">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'قدم العرض الآن' : 'Bid Now') }} </button>
                                @elseif  ($pro->auctionType->name == 'Private' && $currentDateTime >= $twoWeeksBefore) <button class="text-btn"
                                    onclick="requestBid('{{ $pro->name }}', '{{ $pro->id }}', '{{ $pro->auction_type_id }}', '{{ $pro->deposit_amount }}')">
                                    {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب عرض أسعار' : 'Request Bid') }}</button>
                                @endif -->

                                @if ($bidRequest && $bidRequest->status == 1 && $pro->auctionType->name == 'Private' && $currentDateTime >= $originalDateTime)
                                <a href="{{ url('products', $pro->slug) }}"> <button class="text-btn" onclick="bidNow()">
                                            {{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }}
                                        </button></a>
                                    @elseif ($bidRequest && $bidRequest->status == 0 && $pro->auctionType->name == 'Private')
                                        <button class="text-btn" >
                                            {{ session('locale') === 'en' ? 'Requested' : (session('locale') === 'ar' ? 'تم الطلب' : 'Requested') }}
                                        </button>
                                     @elseif  ($bidRequest && $bidRequest->status == 1 && $pro->auctionType->name == 'Private' && $currentDateTime <= $originalDateTime)
                                        <button class="text-btn" style="display: none;" >

                                                Project Not start
                                        </button>
                                    @elseif  ($pro->auctionType->name == 'Private' && $currentDateTime >= $twoWeeksBefore)
                                    <button class="text-btn"
                                          onclick="requestBid('{{ $pro->name }}', '{{ $pro->id }}', '{{ $pro->auction_type_id }}', '{{ $pro->deposit_amount }}')">
                                          {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب المزايدة' : 'Request Bid') }}</button>
                                  @endif

                </div>
                </div>

            </div>
     @endforeach --}}

     @foreach($projects as $project)
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
        <div class="card mb-3" style="width: 300px;">
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
                     <span class="view-text my-color">
                     {{ session('locale') === 'ar' ? 'عرض  '.count($project->products).' قطعة أرض ': 'View '.count($project->products).' lots'   }}
                     </span>
                 </a>
             </div>
         </div>
     </div>





 @endforeach
      </div>




        <ul class="pagination">
        {{ $projects->appends($_GET)->links('pagination::bootstrap-5') }}
        </ul>

    </div>
  </section>
  <section class="product-list-man mt-5">


   @if($projects->isEmpty())
       <div class="no-products-found">
       <h2 class="nodata">{{ session('locale') === 'en' ? 'No Data Found' : (session('locale') === 'ar' ? 'لا يوجد بيانات' : 'No Data Found') }}</h2>

       </div>
   @endif
</section>


  <div class="modal fade" id="prtyfilter" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="prty-filter p-4">
              <h2 class="text-dark">Filter</h2>
              <form action="" class="cmn-frm mt-4">
                <div class="form-group">
                  <select name="" id="">
                    <option value="">Room type,</option>
                    <option value="">Room type,</option>
                  </select>
                </div>
                <div class="form-group mt-2">
                  <div class="wrapper mb-4">
                    <h3>Price</h3>
                    <div class="price-input">
                      <div class="field">
                        <span>Min Price</span>

                        <input type="number" class="input-min" value="2500">
                      </div>
                      <div class="field">
                        <span>Max Price</span>
                        <input type="number" class="input-max" value="7500">
                      </div>
                    </div>
                    <div class="slider">
                      <div class="progress"></div>
                    </div>
                    <div class="range-input">
                      <input type="range" class="range-min" min="0" max="10000" value="2500" step="100">
                      <input type="range" class="range-max" min="0" max="10000" value="7500" step="100">
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <h3>Auction Type</h3>
                  <ul class="categry-list">
                    <li>
                      <div class="form-check">
                            <input class="form-check-input w-auto" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                            Private
                            </label>
                          </div> </li>
                                              <li><div class="form-check">
                            <input class="form-check-input w-auto" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Timed
                            </label>
                          </div> </li>
                                              <li><div class="form-check">
                            <input class="form-check-input w-auto" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Live
                            </label>
                          </div> </li>
                  </ul>
                </div>
                <div class="form-group mt-4">
                  <h3>Auction</h3>
                  <ul class="categry-list">
                    <li><div class="form-check">
                            <input class="form-check-input w-auto" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                            Active
                            </label>
                          </div>
                           </li>
                    <li><div class="form-check">
                            <input class="form-check-input w-auto" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                            Upcoming
                            </label>
                          </div>
                           </li>
                    <li><div class="form-check">
                            <input class="form-check-input w-auto" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                            Ended
                            </label>
                          </div>
                           </li>
                    <li><div class="form-check">
                            <input class="form-check-input w-auto" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                            All
                            </label>
                          </div>
                           </li>
                  </ul>
                </div>
                <div class="btn-submit-flter mt-5">
                  <button class="btn btn-secondary w-100">Apply filters</button>
                  <button class="btn btn-border w-100">Clear All</button>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>

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


@include('frontend.layouts.requestbidscript')

@include('frontend.layouts.footer')
