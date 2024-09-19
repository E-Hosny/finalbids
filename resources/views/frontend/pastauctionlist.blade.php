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
           <h1>{{ session('locale') === 'en' ? 'Projects' : (session('locale') === 'ar' ? 'المشاريع' : 'Projects') }}</h1>
          
           <form action="{{ route('pastauction') }}" method="GET" class="search-frm-prdt" id="searchForm">
              <input type="text" name="search" id="searchInput" placeholder="Search projects..." value="{{ request()->input('search') }}">
              <button type="submit"><img class="w-100" src="{{ asset('frontend/images/rounded-sr.svg') }}" alt=""></button>
          </form>
        </div>
      </div>
    </div>
  </section>
 

  <section class="product-list-man mt-5">
    <div class="container">
      <div class="row">
        @foreach($projects as $pro) <div class="col-xl-4 col-lg-6 col-md-6">
            
                <div class="card-product product-blndle">
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
                                    $originalDateTime = $pro->end_date_time;
                                    $originalDatesTime = new Carbon\Carbon($originalDateTime);
                                    $currentDateTime = now()->timezone('Asia/Kolkata');
                                @endphp

                                @if ($pro->auctionType->name == 'Timed'  && $currentDateTime > $originalDateTime)
                                <a href="{{ url('products', $pro->slug) }}"><button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'View Results' : (session('locale') === 'ar' ? 'الكثير مغلق' : 'View Results') }}  </button></a>
                                @endif

                                
                                @if ($pro->auctionType->name == 'Live' && $currentDateTime > $originalDateTime) 
                                <a href="{{ url('products', $pro->slug) }}"><button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'View Results' : (session('locale') === 'ar' ? 'الكثير مغلق' : 'View Results') }}  </button></a>
                                    
                                @endif
                                      

                                @if ($pro->auctionType->name == 'Private' && $currentDateTime > $originalDateTime) 
                                <a href="{{ url('products', $pro->slug) }}"><button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'View Results' : (session('locale') === 'ar' ? 'الكثير مغلق' : 'View Results') }}  </button></a>
                                    
                                @endif
                                      
                  
                </div>
                </div>
           
            </div>
            @endforeach
      </div>
      
      <ul class="pagination">
      {{ $projects->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
        </ul>
       
    </div>
  </section>
  <section class="product-list-man mt-5">
   

   @if($projects->isEmpty())
       <div class="no-products-found">
       <h2 class="nodata">Projects not found </h2>
       </div>
   @endif
</section>

  
 

    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script>
    <script src="{{asset('frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
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

document.addEventListener('DOMContentLoaded', function () {
  // Retrieve the search parameter from the URL
  var urlSearchParams = new URLSearchParams(window.location.search);
  var searchInputValue = urlSearchParams.get('search');

  // Set the search input value if it exists
  if (searchInputValue !== null) {
      document.getElementById('searchInput').value = decodeURIComponent(searchInputValue);
  }
});
 </script>

 
@include('frontend.layouts.requestbidscript')

@include('frontend.layouts.footer')
 