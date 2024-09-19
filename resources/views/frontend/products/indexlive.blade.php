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
  .data-bid{
    height :calc(100vh - 110px);
    overflow-y:auto;
  }
  /* .data-bid {
    display: flex;
    justify-content: center;
  } */
  .btn-primary {
    color: #fff;
    border-radius: 10px;
    background: linear-gradient(90deg, #9501ff 0%, #7c16d4 100%);
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
    color: #3E0269; 
  }
  .product-list-man {

    margin-top: 50px;
  }
  .list-product-mange{
    display:flex;
    gap:10px;
    position: relative;
    margin-bottom:20px;
    border-bottom: 1px solid #e7e7e7;
    padding-bottom: 12px;
  }
  .pr-img-img{
    width: 91px; 
    border-radius: 10px;
    flex:0 0 auto; 
  }
  .list-product-mange img.product-img{
    width: 100%;
    height:80px;
    border-radius: 10px;
  }
  .list-product-mange h3 {
    font-size: 15px;
    color: #4d4d4d;
    line-height: 24px;
  }
  .list-product-mange h3 span{
    display:block;
    color:#f00;
  }

  .bid-search-mange{
    display: flex;
    align-items:center;
  }
  .bid-search-mange select{
    padding: 11px 15px;
    width:100%;
  }
  .list-competing-bids {
    position: relative;
    
  }
  .over-scrl-mge{
    height: calc(100vh - 200px);
      overflow-y: auto;
  }
  .list-competing-bids:before{
    position: absolute;
  content:"";
  width: 4px;
      height: 87%;
      background:#00000024;
      left: 11px;
      top: 6px; 
  }
  .list-competing-bids li{
    display: flex;
    justify-content: space-between;
      margin-bottom: 20px;
      position: relative;
  }
  .list-competing-bids li:before{
  position: absolute;
  content:"";
  width: 10px;
      height: 10px;
      background:#000;
      left: -24px;
      top: 6px;
      border-radius: 30px;
  }
  .list-competing-bids li span{
    text-align:right;
  }
  .product-title-mang{
    font-size:24px;
  }
  .live-auction{ 
    font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom:15px;
  }
  .live-auction span{
    color:#f00;
  }
  .live-auction-dtl{
    background: #f7f7f7;
      padding: 10px;
      border-radius: 10px;
  }
  .heat-like{
    top:0;
  }


  ::-webkit-scrollbar-track
  {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
    background-color: #fff;
  }

  ::-webkit-scrollbar
  {
    width: 4px;
    background-color: #fff;
  }

  ::-webkit-scrollbar-thumb
  {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #ddd;
  }
  .live-now{
    color: #fff;
      background: #f00;
      padding: 3px 15px;
      font-size: 14px;
      display: inline-block;
      margin-bottom: 0;
      margin-top: 5px;
      border-radius: 4px;
  }
  .list-mid-text{
    text-align:center;
    font-size:12px;
  }
  .sold{
    color:#000;
    font-size: 18px;
  }
  .img-showcase img {
    width: 100% !important;
    flex: 0 0 auto;
    object-fit: cover;
    height: 100%;
    border-radius: 6px;
  }
  #timer {
        font-size: 20px;
        display: flex;
    }
    .red {
        color: red;
    }
    .btn-primary {
    color: #fff;
    border-radius: 23px;
    background: linear-gradient(90deg, #9501ff 0%, #7c16d4 100%);
    padding: 3px 30px;
    color: #fff !important;
    font-size: 16px;
    border: 0;
    text-transform: uppercase;
    white-space: nowrap;
}
.won{
  color: #7c16d4;
  font-size: 18px;
}
.btn-container {
        display: flex;
        justify-content: center;
        align-items: center;
   }

   .btn-with-padding-right {
        padding-right: 10px;
        margin-bottom: 15px;
   }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.css">
<section class="mt-4">
    <div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-lg-3 col-md-3 product-list">
        <h2>{{$product->project->name}}</h2><hr>
				<div class="data-bid allProductList d-block" style="border-right:1px solid #ddd; padding-right:10px;">
        @php
            $liveProductId = $product->id;
            $lotAwayCount = 0;
        @endphp
					@foreach($products as $pro)
         
          @php
               $currentBid = \App\Models\BidPlaced::where('product_id', $pro->id)
                                    ->where('sold', 1)
                                    ->where('status', '!=', 0)
                                    ->orderBy('bid_amount', 'desc')
                                    ->first();
                                    $productmsp = $product->minsellingprice;
                $sold = \App\Models\BidPlaced::where('product_id', $pro->id)
                            ->where('status', 2)
                            ->orderBy('bid_amount', 'desc')
                            ->first();
              
                $loggedInUserId = auth()->id(); 
            @endphp
						<div class="list-product-mange"> 
            <div class="heat-like wishlist-heart @if(in_array($pro->id, $wishlist)) active @endif"
                        data-product-id="{{ $pro->id }}">
                        <input type="checkbox" name="" id="" @if(in_array($pro->id, $wishlist)) checked @endif>
                        <img src="{{asset('frontend/images/heart.png')}}" alt="">
                    </div>
							<div class="pr-img-img">
              @php
								$imagePath = \App\Models\Gallery::where('lot_no', $pro->lot_no)->orderBy('id')->value('image_path');
							@endphp
							@if ($imagePath)
								<img class="product-img" src="{{ asset($imagePath) }}" alt="Product Image">
							@else
								<img class="product-img"  src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image">
							@endif
            
              @if($pro->id == $liveProductId)
                        <h6 class="live-now">Live Now</h6>
                @endif
                @if($lotAwayCount > 0)
                <h6>{{ $lotAwayCount }} Lot Away</h6>
                @php $lotAwayCount++; @endphp
                @endif
              </div>
						<div class="w-100">
            @if(session('locale') === 'en')
							<a href="{{ url('productsdetail', $pro->slug) }}" class="prd-link"><h3 ><span>{{$pro->lot_no}}:</span> {{$pro->title}}</h3></a>
						@elseif(session('locale') === 'ar')
							<a href="{{ url('productsdetail', $pro->slug) }}" class="prd-link"><h3 ><span>{{$pro->lot_no}}:</span> {{$pro->title_ar}}</h3></a>
						@else
							<a href="{{ url('productsdetail', $pro->slug) }}" class="prd-link"> <h3 ><span>{{$pro->lot_no}}:</span> {{$pro->title}}</h3></a>

						@endif
            @if ($sold)
                @php
                    $winnerId = $sold->user_id;
                @endphp

                @if ($winnerId == $loggedInUserId)
                    <p class="won"> 
                        <span>You Won :{{ formatPrice($sold->bid_amount, session()->get('currency')) }} {{$currency}}</span>
                    </p>
                @elseif ($winnerId != $loggedInUserId)
                    <p class="sold">
                        <span>Sold :{{ formatPrice($sold->bid_amount, session()->get('currency')) }} {{$currency}}  </span>
                    </p>
                @endif
            @elseif ($currentBid)
                <p>
                    {{ session('locale') === 'en' ? 'Current:' : (session('locale') === 'ar' ? 'المزايدة الحالية' : 'Current:') }}
                    <span>{{ formatPrice($currentBid->bid_amount, session()->get('currency')) }} {{$currency}} </span>
                </p>
                @else
                <p>
                {{ session('locale') === 'en' ? 'Current:' : (session('locale') === 'ar' ? 'المزايدة الحالية' : 'Current:') }}
                    <span>{{ formatPrice($product->reserved_price, session()->get('currency')) }} {{$currency}} </span>
                </p>
            @endif

             
            </div>
            </div>
            @if($pro->id == $liveProductId)
            @php $lotAwayCount++; @endphp
                    @endif
					@endforeach
            
				 
				</div>
			</div>
			<div class="col-lg-6 col-md-6 current-product-details">
				<div class="data-bid live-auction-dtl d-block">
        <!-- <img src="{{asset('frontend/images/resizeclock.png')}}" alt=""> -->
          <h2 class="live-auction"><span>Live Now</span>  <div id="timer">--:--</div></h2>
					<h1 class="product-title-mang">{{$product->lot_no ?? ''}}: {{$product->title ?? ''}}</h1>
         
                <div class="product-imgs mt-4">
                  @auth
                    <div class="heat-like wishlist-heart @if(in_array($product->id, $wishlist)) active @endif"
                        data-product-id="{{ $product->id }}">
                        <input type="checkbox" name="" id="" @if(in_array($product->id, $wishlist)) checked @endif>
                        <img src="{{asset('frontend/images/heart.png')}}" alt="">
                    </div>
                    @else
                        <a href="{{ route('signin') }}"> <i class="fa fa-heart-o "></i></a>
                        @endauth
                    @php
                    $galleries = \App\Models\Gallery::where('lot_no', $product->lot_no)->get();
                    @endphp
                    <div class="img-display"> 
                      
                        <div class="img-showcase slider">
                            @php
                            $galleries = \App\Models\Gallery::where('lot_no', $product->lot_no)->get();
                            @endphp
                            @if ($galleries)
                            @foreach ($galleries as $gallery)
                            <div><img src="{{ asset($gallery->image_path) }}" alt="shoe image"></div>
                            @endforeach
                            @else
                            <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="shoe image" />
                            @endif
                        </div>
                    </div>

                </div>		
                &nbsp;
            <div>Estimate: {{$product->start_price}} -{{$product->end_price}} </div>
            <h4 class="mt-4">Description</h4>
            <div class="description">
                {!! $product->description !!}
            </div>
				</div>
        
			</div>
			<div class="col-lg-3 col-md-3 bids-section">
				<div class="data-bid d-block">
						<!-- <h4>bids section</h4>	
						<div></div> -->
						<!-- <p>{{ session('locale') === 'en' ? 'Set Max Bid:' : (session('locale') === 'ar' ? 'تعيين أقصى مزايدة:
                                                ' : 'Set Max Bid:') }}</p> -->
              @php
                $loggedInUserId = Auth::id();
                $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                        ->where('project_id', $projects->id)
                                        ->first();
              @endphp
              @if ($bidRequest && $bidRequest->status == 1 )
              @if ($lastBidAmount && is_object($lastBidAmount) && $lastBidAmount->bid_amount >= $product->minsellingprice)
                      <p><strong><span style="color: red;">Sold</span></strong></p>
                      @else
                <form action="" class="news-letter" id="bidForm">
                    <div class="form-group bid-search-mange">
                        <select id="bidValuecal">
                            @foreach ($bidValues as $bidValue)
                            @if ($bidValue->cal_amount > $lastBidAmount)
                            <option value="{{ $bidValue->cal_amount }}" @if(isset($closestBid) && $closestBid->id
                                === $bidValue->id) selected @endif>
                                {{ formatPrice($bidValue->cal_amount, session()->get('currency')) }} {{$currency}}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    
                        @if(Auth::check())
                        <button type="button" id="placeBidButton"
                            >{{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع مزايدة' : 'Place Bid') }}</button>
                        @else
                        <button type="button" id="placeBidButton">{{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع مزايدة' : 'Place Bid') }}</button>
                        @endif
                    </div>
                </form>
                @endif
                @else
                <div class="btn-container">
                <button  class="btn btn-primary btn-with-padding-right"  onclick="requestBid('{{ $projects->name }}', '{{ $projects->id }}', '{{ $projects->auction_type_id }}', '{{ $projects->deposit_amount }}')">
                              {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب المزايدة' : 'Request Bid') }}</button>
                
                </div>
                @endif
                <div class="over-scrl-mge" id="bidListContainer">
                  <p class="list-mid-text">
                    <img  alt="bidding icon" src="https://live.invaluable.com/static/images/info-circle.svg">
                    {{$product->lot_no}} open for bidding</p>
                  <ul class="list-competing-bids" id="bidsList">
                  @foreach($bids as $key => $bid)
                  @if($key == 0)
                  <li>{{session()->get('currency')}} {{$bid['bid_amount']}} <span>Starting Bid</span></li>
                  @else 
                    @if($bid['status'] == 1)
                    <li>{{session()->get('currency')}} {{$bid['bid_amount']}} <span>Competing Bid</span></li>
                    @endif
                    @if($bid['status'] == 2)
                    <li class="live-auction">{{session()->get('currency')}} {{$bid['bid_amount']}} <span>Sold</span></li>
                    @endif
                  @endif
                
                  @endforeach
                  @if(!empty($lastBid) && $lastBid->status == 2)
                  <p class="list-mid-text mb-0 mt-2">{{$product->lot_no}} Sold</p>
                  @endif
                  </ul>
                </div>

				</div>
			</div>
		</div>
    </div>
</section>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script src="{{asset('frontend/js/bootstrap.js')}}"></script>
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js" integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
</script>
<script>
  let lastBidAmount = {{ $lastBidAmount }};
    // Function to display fair warning message
    function showFairWarning(bidAmount) {
      var fairWarningElement = $('<li></li>').html("{{ session()->get('currency') }}" + bidAmount + "<span>Fair Warning</span>");
      fairWarningElement.find('span').css('color', 'red'); // Applying warning color
      $('#bidsList').append(fairWarningElement);
    }

    @if(!empty($bids) && count($bids) > 0)
      setTimeout(function() {
              showFairWarning(lastBidAmount);
        }, 10000);
      @endif
  </script>


<script>
	const socket = io("wss://bid.sa:3000");

	// server-side
	socket.on("connection", (socket) => {
		console.log(socket.id);
	});

	// client-side
	socket.on("connect", () => {
		socket.emit("join", {
			project_id: {{$projects->id}}
		})
	});

	socket.on("disconnect", () => {
		console.log(socket.id); // undefined
	});

	socket.on('bid_placed', (data) => {
    lastBidAmount = data.bid_amount;
		appendBid(data);
    removeOptionsLessThan(data.bid_amount);
	})

  function appendBid(data){
    $('#bidsList').append('<li>{{session()->get("currency")}} '+data.bid_amount+' <span>Competing Bid</span></li>')
  }


  const currentTime = new Date();
  const millisecondsUntilNextMinute = 60000 - (currentTime.getSeconds() * 1000 + currentTime.getMilliseconds()) + 1000;
  setTimeout(() => {
      location.reload();
  }, millisecondsUntilNextMinute);

  function scrollToTopOfDiv() {
    var $parentDiv = $('.allProductList');
    var $element = $('.live-now').closest('.list-product-mange');
    var elementTop = $element.position().top;
    var parentDivTop = $parentDiv.offset().top;
    var newScrollTop = elementTop - parentDivTop + $parentDiv.scrollTop();
    $parentDiv.animate({
        scrollTop: newScrollTop
    }, 500); 
  }




  function removeOptionsLessThan(amount) {
        $("#bidValuecal option").each(function() {
            if (parseFloat($(this).val()) <= amount) {
                $(this).remove();
            }
        });
    }

    // Call the function to scroll the element to the top of its parent div
    scrollToTopOfDiv();
  $(document).ready(function() {
    jQuery.noConflict();
    $('.slider').slick({
      dots: true,
      infinite: true,
      speed: 500,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      arrows: true,
  });
  
      $("#placeBidButton").click(function() {
        var isLoggedIn = "{{ auth()->check() }}"; 
        if (!isLoggedIn) {
                Swal.fire({
                    icon: 'info',
                    title: 'Please Login First',
                    text: 'You need to log in to perform this action.',
                    showCancelButton: true,
                    confirmButtonText: 'Login'
                }).then((result) => {
                    if (result.isConfirmed) {
  
                        localStorage.setItem('redirect_url', window.location.href);

                        window.location.href = '{{ route("signin") }}';
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.reload();
                    }
                });
                return;
            }

          var bidValue = $("#bidValuecal").val();
          var msp = {{ $product->minsellingprice }};
          console.log(msp);
          var buyersPremium = {{ $product->project->buyers_premium }};
          var vatRate = 0.15;
          var formData = new FormData();
          formData.append('user_id', '{{ Auth::id() }}');
          formData.append('product_id', '{{ $product->id }}');
          formData.append('project_id', '{{ $product->project_id }}');
          formData.append('bid_amount', bidValue);
          formData.append('status', 1);
          formData.append('buyers_premium', buyersPremium);

          var buyerPremium = bidValue * (buyersPremium / 100);
          var vat = bidValue * vatRate;
          formData.append('total_amount', parseFloat(bidValue) + parseFloat(buyerPremium) + parseFloat(vat));
         
          // Get CSRF token from meta tag
          var csrfToken = $('meta[name="csrf-token"]').attr('content');

          $.ajax({
              url: "{{ route('bidingplacedlive') }}",
              type: "POST",
              data: formData,
              processData: false,
              contentType: false,
              headers: {
                  'X-CSRF-TOKEN': csrfToken
              },
              success: function(response) {
                  socket.emit('bid_place', {
                      project_id: '{{ $product->project_id }}',
                      product_id: '{{ $product->id }}',
                      bid_amount: bidValue
                  });
               // Check if the user placed the previous bid
            var previousBidPlaced = response.previousBidPlaced; 

            // Change the button text based on the previous bid
            if (previousBidPlaced) {
                $("#placeBidButton").text("Increase Bid");
            } else {
                $("#placeBidButton").text("Increase Bid");
            }
              // Check if minSellingPrice is greater than or equal to bidValue
            if (msp <= bidValue) {
                console.log("Bid Value is less than or equal to Min Selling Price. Hiding bid form.");
                $("#bidForm").hide();
                return;
            }
            },
              error: function() {
                  alert("Failed to place bid. Please try again.");
              }
          });
      });
    });

    // Calculate the time remaining until the next minute
    var secondsUntilNextMinute = 61 - currentTime.getSeconds();
    
    // Display initial time
    displayTime(secondsUntilNextMinute);
    
    // Update the timer every second
    setInterval(function(){
        secondsUntilNextMinute--;
        if(secondsUntilNextMinute < 0) {
            secondsUntilNextMinute = 59;
        }
        displayTime(secondsUntilNextMinute);
    }, 1000);
    
    // Function to display time
    function displayTime(seconds) {
      var minutes = Math.floor(seconds / 60);
      var remainingSeconds = seconds % 60;
        var formattedSeconds = padZero(remainingSeconds);
        var secondsClass = (remainingSeconds < 10) ? "red" : "";
        var formattedTime = padZero(minutes) + ":" + '<p class="' + secondsClass + '">' + formattedSeconds + '</p>';
        $("#timer").html(formattedTime);
    }
    
    // Function to add leading zero to single digit numbers
    function padZero(num) {
        return (num < 10 ? '0' : '') + num;
    }

</script>
@include('frontend.layouts.requestbidscript')

@include('frontend.layouts.footer')
@include('frontend.products.script.addToWishListScript')


