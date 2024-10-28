@include('frontend.layouts.header')
<style type="text/css">
/*----------------------*/
.popup-data {
    font-size: 12px;
    padding: 5px;
    background: white;
    border: 1px solid #d9d9d9;
    border-radius: 5px;
    position: absolute;
    width: auto;
    left: 16px;
    z-index: 9;
    display: none;
    min-width: 200px;
    width: 100%;
    top: 0px;
}

.popup-data span a {
    color: blue !important;
}

.popup .form-group i {
    cursor: pointer !important;
    padding-right: 40px;
}

.popup .form-group .pop-box:hover .popup-data {
    display: block;
    cursor: pointer !important;
}

.pop-box {
    display: inline;
    position: relative !important;
}

.base-timer {
    position: relative;
    width: 190px;
    height: 190px;
    margin: 30px auto 0;
}

.base-timer__svg {
    transform: scaleX(-1);
}

.base-timer__circle {
    fill: none;
    stroke: none;
}

.base-timer__path-elapsed {
    stroke-width: 6px;
    stroke: #efefef;
}

.base-timer__path-remaining {
    stroke-width: 4px;
    stroke-linecap: round;
    transform: rotate(90deg);
    transform-origin: center;
    transition: 1s linear all;
    fill-rule: nonzero;
    stroke: currentColor;
}

.base-timer__path-remaining.green {
    color: #39b37d;
}

.base-timer__path-remaining.orange {
    color: orange;
}

.base-timer__path-remaining.red {
    color: red;
}

.base-timer__label {
    position: absolute;
    width: 190px;
    height: 190px;
    top: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.timer-countdn {
    position: relative;
    border-radius: 20px;
}

.timer-countdn .close {
    position: absolute;
    right: 10px;
    top: 0px;
    background: transparent;
    border: 0;
    padding: 0;
    font-size: 35px;
}

.timer-countdn h4 {
    font-size: 30px;
    color: #000;
}

.bid-and-time {
    margin-top: 24px;
}

.prty-sect {
    background: #F7F7F7;
    padding: 10px;
}

.prty-sect p,
.prty-sect a {
    color: #fff;
}

.bidplaced {
    color: white;
    background-color: #838383;
    font-size: 14px;
    font-weight: 500;
    padding: 10px;
    border-radius: 25px;
}
.img-zoom-container_1 {
    display: flex;
    margin-top: 10px;
}
.img-zoom-container_1 a {
    flex: 0 0 60px;
}
.xzoom-container_1 {
    border: 1px solid #ddd;
    text-align: center;
    padding: 10px;
    width: 100%;
}
.xzoom-container {
    width: 100%;
}
section#default {
    width: 100%;
}
</style>
<style>
* {box-sizing: border-box;}

.img-zoom-container {
  position: relative;
}

.img-zoom-lens {
  position: absolute;
  border: 1px solid #d4d4d4;
  /*set the size of the lens:*/
  width: 150px;
  height: 150px;
}

.img-zoom-result {
  border: 1px solid #d4d4d4;
  /*set the size of the result div:*/
  width: 768px;
  height: 600px;
}
.product-imgs .xzoom-container img {
    max-height: 750px !important;
    width: auto !important;
    max-width: 100% !important;
    margin: 0 auto;
}
.bid-and-time {
    position: relative;
}
.img-zoom-result {
    border: 1px solid #d4d4d4;
    width: 100%;
    height: 524px;
    position: absolute;
    top: 0;
    left: 0;
}
.enter_live{
    background-color: red;
}
</style>
<link rel="stylesheet" media="screen" href="https://unpkg.com/xzoom/dist/xzoom.css" id="cm-theme" />
<section class="prty-sect">
    <div class="container">
        <div class="row  ">
            <div class=" ">
                <p class="m-0">
                    <a href="{{url('/')}}"> {{ session('locale') === 'en' ? 'Home' : (session('locale') === 'ar' ? 'الرئيسية' : 'Home') }} /</a>
    {{ session('locale') === 'en' ? $product->auctionType->name : (session('locale') === 'ar' ? $product->auctionType->name_ar : $product->auctionType->name) }} /
    {{ session('locale') === 'en' ? $product->project->name : (session('locale') === 'ar' ? $product->project->name_ar : $product->project->name) }}
</p>

            </div>
        </div>
    </div>
</section>
<section class="detail-section">
    <div class="container">
        <div class="row">
            @if(session('locale') === 'en')
            <h3>{{$product->lot_no}} : {{$product->title}}</h3>
            @elseif(session('locale') === 'ar')
            <h3>{{$product->lot_no}} : {{$product->title_ar}}</h3>
            @else
            <h3>{{$product->lot_no}} : {{$product->title}}</h3>
            @endif


            <div class="col-md-6">
                <!-- <div class="product-imgs mt-4">
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

                    <div class="img-select">
                        @if ($galleries->isNotEmpty())
                        @foreach ($galleries as $gallery)
                        <div class="img-item">
                            <a href="#" data-id="{{ $loop->index + 1 }}">
                                <img src="{{ asset($gallery->image_path) }}" alt="shoe image" />
                            </a>
                        </div>
                        @endforeach
                        @else
                        <div class="img-item">
                            <a href="#" data-id="1">
                                <img src="{{ asset('frontend/images/default-product-image.svg') }}" alt="shoe image" />
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="img-display">
                        <div class="img-showcase">
                            @php
                            $galleries = \App\Models\Gallery::where('lot_no', $product->lot_no)->get();
                            @endphp
                            @if ($galleries)
                            @foreach ($galleries as $gallery)
                            <img src="{{ asset($gallery->image_path) }}" alt="shoe image">
                            @endforeach
                            @else
                            <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="shoe image" />
                            @endif
                        </div>
                    </div>

                </div> -->
                <div class="product-imgs mt-4">
                    <section id="default" class="padding-top0">

                    <div class="row">
                    <div class="large-5 column">

                        <!-- <div class="xzoom-container">
                            <div class="xzoom-container_1">
                                 <img class="xzoom" id="xzoom-default" src="{{ asset($gallery->image_path)}}" xoriginal="{{ asset($gallery->image_path) }}" />
                            </div>
                        <div class="xzoom-thumbs">
                            @if ($galleries->isNotEmpty())
                                        @foreach ($galleries as $gallery)
                            <a href="{{ asset($gallery->image_path) }}" data-id="{{ $loop->index + 1 }}">
                                <img class="xzoom-gallery"  src="{{ asset($gallery->image_path) }}"  xpreview="{{ asset($gallery->image_path) }}"></a>
                            @endforeach
                                        @endif

                        </div>
                        </div> -->

                        <div class="xzoom-container">

                            <div class="img-zoom-container">
                                <img id="myimage" src="{{ asset($gallery->image_path)}}" xoriginal="{{ asset($gallery->image_path) }}">
                            </div>
                            <div class="img-zoom-container_1">
                                @if ($galleries->isNotEmpty())
                                    @foreach ($galleries as $gallery)
                                        <a href="#" class="thumbnail-link" data-image="{{ asset($gallery->image_path) }}" data-preview="{{ asset($gallery->image_path) }}">
                                            <img class="xzoom-gallery" src="{{ asset($gallery->image_path) }}" xpreview="{{ asset($gallery->image_path) }}">
                                        </a>
                                    @endforeach
                                @endif
                            </div>

                       </div>






                    <!--  -->
                    <div class="large-7 column" ></div>
                    </div>
             </section>
                </div>
                <div class="product-desc">


                    <h4>{{ session('locale') === 'en' ? 'Description' : (session('locale') === 'ar' ? 'الوصف' : 'Description') }}
                    </h4>


                    @if(session('locale') === 'en')
                    <p> {{ strip_tags($product->description) }}</p>
                    @elseif(session('locale') === 'ar')
                    <p>{{ strip_tags($product->description_ar) }}</p>
                    @else
                    <p>{{ strip_tags($product->description) }}</p>
                    @endif
                </div>

            </div>
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
            <div class="col-md-6">
                <div class="bid-and-time">
                <div id="myresult" class="img-zoom-result" ></div>

                    <!-- @if ($currentBid)
                    <h4>{{ session('locale') === 'en' ? 'Current Bid:' : (session('locale') === 'ar' ? 'المزايدة الحالية' : 'Current Bid:') }}<span>{{ formatPrice($currentBid->bid_amount, session()->get('currency')) }}
                            {{$currency}}</span> </h4>
                    @else
                    <h4>{{ session('locale') === 'en' ? 'Current Bid:' : (session('locale') === 'ar' ? 'المزايدة الحالية' : 'Current Bid:') }}<span>{{ formatPrice($product->reserved_price, session()->get('currency')) }}
                            {{$currency}}</span> </h4>

                    @endif -->
                    @if ($sold)
                        <h4 >{{ session('locale') === 'en' ? 'Sold:' : (session('locale') === 'ar' ? 'تم البيع:' : 'Sold:') }}<span>{{ formatPrice($sold->bid_amount, session()->get('currency')) }} {{ $currency }}</span></h4>
                    @elseif ($currentBid)
                        <h4>{{ session('locale') === 'en' ? 'Current Bid:' : (session('locale') === 'ar' ? 'العرض الحالي:' : 'Current Bid:') }}<span>{{ formatPrice($currentBid->bid_amount, session()->get('currency')) }} {{ $currency }}</span></h4>
                    @else
                        <h4>{{ session('locale') === 'en' ? 'Current Bid:' : (session('locale') === 'ar' ? 'المزايدة الأولية:' : 'Current Bid:') }}<span>{{ formatPrice($product->reserved_price, session()->get('currency')) }} {{ $currency }}</span></h4>
                    @endif

                    @if ($product->auctionType->name == 'Private' || $product->auctionType->name == 'Timed')
                            @php
                            $currentTime = now()->timestamp;
                            $auctionEndTime = strtotime($product->auction_end_date);
                            @endphp
                    @if ($currentTime < $auctionEndTime) <div class="crt_bid">
                        <h6>Bidding Closes In</h6>
                        <div class="countdown-time thisisdemoclass" data-id='{{ $product->id }}'
                            data-date='{{ $product->auction_end_date }}' id="countdown-{{ $product->id }}">
                            <ul>
                                @if ($product->auctionType->name == 'Private' || $product->auctionType->name == 'Timed')
                                <li class="days-wrapper"><span class="days"></span>D</li>
                                <li class="days-wrapper">:</li>
                                @endif



                                <li><span class="hours"></span>H</li>
                                <li>:</li>
                                <li><span class="minutes"></span>M</li>
                                <li>:</li>
                                <li><span class="seconds"></span>S</li>
                            </ul>
                        </div>
                   </div>
                   @endif
                @endif
            </div>
            @php
            $currentTime = now()->timestamp;
              $auctionEndTime = strtotime($product->auction_end_date);
            @endphp

            <div class="bid-now-container">
                <div class="product-feature-box">
                    @if($bidPlacedId)
                    <h4>
                        {{ session('locale') === 'en' ? 'BID NOW:' : (session('locale') === 'ar' ? 'زاود الان' : 'BID NOW:') }}

                        <span class="bidplaced">Bid Placed</span>
                    </h4>
                    @else
                    <h4>
                        {{ session('locale') === 'en' ? 'BID NOW:' : (session('locale') === 'ar' ? 'زاود الان': 'BID NOW:') }}
                    </h4>
                    @endif
                    <p>{{ session('locale') === 'en' ? 'Bid Amount : Minimum Bid' : (session('locale') === 'ar' ? 'مبلغ العرض' : 'Bid Amount : Minimum Bid') }}
                        :

                        {{ formatPrice($product->reserved_price, session()->get('currency')) }} {{$currency}}
                    </p>
                     <!--changes 24 jan  -->
                            @php
                                $loggedInUserId = Auth::id();
                                $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                                        ->where('project_id', $product->project_id)
                                                        ->where('status',1)
                                                        ->first();
                            @endphp
                            @php
                                $currentDateTime = now();
                                $auctionEndTime = $product->project->start_date_time;
                                $formattedCurrentDateTime = $currentDateTime->format('Y-m-d H:i:s');
                                $currentDateTimeUTC = new DateTime('now');
                                $prductenddatetime =$product->auction_end_date;
                                $currentDateTimeUTC->setTimezone(new DateTimeZone('Asia/Kolkata'));
                                $formattedDateTime = $currentDateTimeUTC->format('Y-m-d H:i:s');
                                $enddate = $product->project->end_date_time;
                                $enddatetime  = new Carbon\Carbon($enddate);

                            @endphp
                        <!-- Timed Auction -->
                        @if ($product->project->auctionType->name == 'Timed' && $currentDateTime > $enddatetime || $product->project->auctionType->name == 'Timed' && $currentDateTime >$product->auction_end_date )
                            <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق القطعة' : 'Lot Closed') }}</button>

                        @else
                                        @if ($product->project->auctionType->name == 'Timed')
                                        @if ($auctionEndTime <= $currentDateTime)

                                            @if ($product->auction_end_date >= $formattedDateTime )

                                            <p>{{ session('locale') === 'en' ? 'Set Max Bid:' : (session('locale') === 'ar' ? 'تعيين أقصى مزايدة:
                                                ' : 'Set Max Bid:') }}</p>

                                            <form action="" class="news-letter" id="bidForm">
                                                <div class="form-group">
                                                    <select id="bidValuecal">
                                                        @foreach ($calculatedBids as $bidValue)
                                                        @if ($bidValue->cal_amount > $lastBidAmount)
                                                        <option value="{{ $bidValue->cal_amount }}" @if(isset($closestBid) && $closestBid->id
                                                            === $bidValue->id) selected @endif>
                                                            {{ formatPrice($bidValue->cal_amount, session()->get('currency')) }} {{$currency}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>

                                                    @if(Auth::check())
                                                    <button type="button" id="placeBidButton" data-bs-toggle="modal"
                                                        data-bs-target="#myModal">{{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع مزايدة' : 'Place Bid') }}</button>
                                                    @else
                                                    <button type="button" id="loginFirstButton">{{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع مزايدة' : 'Place Bid') }}</button>
                                                    @endif
                                                </div>
                                            </form>
                                        @endif
                                        @endif
                                    @endif
                        @endif
                  <!-- changes -->
                     <!-- Private Auction -->
                @if ($product->project->auctionType->name == 'Private' && $currentDateTime > $enddatetime || $product->project->auctionType->name == 'Private' && $currentDateTime >$product->auction_end_date)
                    <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق الدفعة' : 'Lot Closed') }}</button>
                @else
                        @if ($product->project->auctionType->name == 'Private')
                            @if ($auctionEndTime <= $currentDateTime)
                            @if($bidRequest && $bidRequest->status == 1)
                                @if ($product->auction_end_date >= $formattedDateTime )

                                <p>{{ session('locale') === 'en' ? 'Set Max Bid:' : (session('locale') === 'ar' ? 'تعيين الحد الأقصى لعرض السعر:
                                    ' : 'Set Max Bid:') }}</p>

                                <form action="" class="news-letter" id="bidForm">
                                    <div class="form-group">
                                        <select id="bidValuecal">
                                            @foreach ($calculatedBids as $bidValue)
                                            @if ($bidValue->cal_amount > $lastBidAmount)
                                            <option value="{{ $bidValue->cal_amount }}" @if(isset($closestBid) && $closestBid->id
                                                === $bidValue->id) selected @endif>
                                                {{ formatPrice($bidValue->cal_amount, session()->get('currency')) }} {{$currency}}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>

                                        @if(Auth::check())
                                        <button type="button" id="placeBidButton" data-bs-toggle="modal"
                                            data-bs-target="#myModal">{{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع مزايدة' : 'Place Bid') }}</button>
                                        @else
                                        <button type="button" id="loginFirstButton">{{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع مزايدة' : 'Place Bid') }}</button>
                                        @endif
                                    </div>
                                </form>
                            @endif
                            @endif
                        @endif
                        @endif
                    @endif

                    <!-- Live Case -->
                    <!-- @if ($product->project->auctionType->name == 'Live' && $currentDateTime > $enddatetime)
                            <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق القطعة' : 'Lot Closed') }}</button>
                        @else
                                @if ($lastBid && $lastBid->bid_amount >= $product->minsellingprice && $product->project->auctionType->name == 'Live')
                                        <p><strong><span style="color: red;">Bid Closed</span></strong></p>
                                    @else

                                            @if ($product->project->auctionType->name == 'Live')
                                                @if ($auctionEndTime <= $currentDateTime)
                                                    @if($bidRequest && $bidRequest->status == 1)
                                                        <p>{{ session('locale') === 'en' ? 'Set Max Bid:' : (session('locale') === 'ar' ? 'تعيين أقصى مزايدة:' : 'Set Max Bid:') }}</p>


                                                        <form action="" class="news-letter" id="bidForm">
                                                            <div class="form-group">
                                                                <select id="bidValuecal">
                                                                    @foreach ($calculatedBids as $bidValue)
                                                                        @if ($bidValue->cal_amount > $lastBidAmount)
                                                                            <option value="{{ $bidValue->cal_amount }}" @if(isset($closestBid) && $closestBid->id === $bidValue->id) selected @endif>
                                                                                {{ formatPrice($bidValue->cal_amount, session()->get('currency')) }} {{$currency}}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>

                                                                @if(Auth::check())
                                                                    <button type="button" id="placeBidButton" data-bs-toggle="modal" data-bs-target="#myModal">{{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع مزايدة' : 'Place Bid') }}</button>
                                                                @else
                                                                    <button type="button" id="loginFirstButton">{{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع المزايدة' : 'Place Bid') }}</button>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    @endif
                                                @endif
                                            @endif

                                    @endif
                    @endif -->


                </div>
            </div>

            <div class="product-feature-box">
                @if(session('locale') === 'en')
                <h4>{{$product->project->name}} </h4>
                @elseif(session('locale') === 'ar')
                <h3>{{$product->project->name_ar}} </h3>
                @else
                <h4>{{$product->project->name}} </h4>
                @endif
                @php
                $originalDateTime = $product->project->start_date_time;
                $timestamp = strtotime($originalDateTime);
                $formattedDateTime = date("F j, g:i A", $timestamp);
                $endDatetime = $product->project->end_date_time;
                $end =strtotime($endDatetime);
                $formattedEnddateTime = date("F j, g:i A", $end);
                @endphp
                <p>{{$formattedDateTime}} - {{$formattedEnddateTime}} <img class="ms-3"
                        src="{{ asset('frontend/images/private.svg')}}">
                    @if(session('locale') === 'en')
                    <span>{{ $product->auctionType->name }}</span>
                </p>
                @elseif(session('locale') === 'ar')
                <span>{{ $product->auctionType->name_ar }}</span></p>
                @else
                <span>{{ $product->auctionType->name }}</span></p>
                @endif
                    @if ($product->project->auctionType->name == 'Live')
                    <a href="{{ url('productslive', $product->project->slug) }}"><button class="btn btn-danger enter_live">Enter Live Auction</button></a>
                    @endif
            </div>

            <div class="product-feature-box">
                <h4>{{ session('locale') === 'en' ? 'Share Now' : (session('locale') === 'ar' ? 'المشاركة الان' : 'Share Now') }}
                </h4>

                <ul class="social-link mt-4">
                    <li>
                        <a href="https://www.youtube.com/hashtag/youtubelink"><img
                                src="{{ asset('frontend/images/youtube.svg') }}" alt=""></a>
                    </li>
                    <li>
                        <a href="https://twitter.com/i/flow/login"><img src="{{ asset('frontend/images/twitt.png') }}"
                                alt=""></a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/login/"><img src="{{ asset('frontend/images/facebook.svg') }}"
                                alt=""></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/accounts/login/?hl=en"><img
                                src="{{ asset('frontend/images/instagram.svg') }}" alt=""></a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/login"><img src="{{ asset('frontend/images/linkdin.png') }}"
                                alt=""></a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    </div>
</section>

<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="{{ asset('frontend/js/bootstrap.js') }}"></script>
<script src="{{ asset('frontend/js/slick.min.js') }}"></script>
<!-- <script src="{{ asset('frontend/js/main.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
<script>
const imgs = document.querySelectorAll(".img-select a");
const imgBtns = [...imgs];
let imgId = 1;

imgBtns.forEach((imgItem) => {
    imgItem.addEventListener("click", (event) => {
        event.preventDefault();
        imgId = imgItem.dataset.id;
        slideImage();
    });
});

function slideImage() {
    const displayWidth = document.querySelector(
        ".img-showcase img:first-child"
    ).clientWidth;

    document.querySelector(".img-showcase").style.transform = `translateX(${-(imgId - 1) * displayWidth
        }px)`;
}

window.addEventListener("resize", slideImage);


$(document).ready(function() {
    $('#alert-modal').modal('show');
});



// --------Reveser-timer-----------
if ($('#revese-timer').length) {

    const FULL_DASH_ARRAY = 283;
    const WARNING_THRESHOLD = 15;
    const ALERT_THRESHOLD = 10;

    const COLOR_CODES = {
        info: {
            color: "green"
        },
        warning: {
            color: "orange",
            threshold: WARNING_THRESHOLD
        },
        alert: {
            color: "red",
            threshold: ALERT_THRESHOLD
        }
    };


    var Minute = $('#revese-timer').data('minute');
    var Seconds = Math.round(60 * Minute);
    const TIME_LIMIT = Seconds;
    let timePassed = 0;
    let timeLeft = TIME_LIMIT;
    let timerInterval = null;
    let remainingPathColor = COLOR_CODES.info.color;

    document.getElementById("revese-timer").innerHTML = `
        <div class="base-timer">
          <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <g class="base-timer__circle">
              <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
              <path
                id="base-timer-path-remaining"
                stroke-dasharray="283"
                class="base-timer__path-remaining ${remainingPathColor}"
                d="
                  M 50, 50
                  m -45, 0
                  a 45,45 0 1,0 90,0
                  a 45,45 0 1,0 -90,0
                "
              ></path>
            </g>
          </svg>
          <span id="base-timer-label" class="base-timer__label">${formatTime(
        timeLeft
      )}</span>
        </div>
        `;

    startTimer();

    function onTimesUp() {
        clearInterval(timerInterval);
    }

    function startTimer() {
        timerInterval = setInterval(() => {
            timePassed = timePassed += 1;
            timeLeft = TIME_LIMIT - timePassed;
            document.getElementById("base-timer-label").innerHTML = formatTime(
                timeLeft
            );
            setCircleDasharray();
            setRemainingPathColor(timeLeft);

            if (timeLeft === 0) {
                onTimesUp();
            }
        }, 1000);
    }

    function formatTime(time) {
        const minutes = Math.floor(time / 60);
        let seconds = time % 60;

        if (seconds < 10) {
            seconds = `0${seconds}`;
        }

        return `${minutes}:${seconds}`;
    }

    function setRemainingPathColor(timeLeft) {
        const {
            alert,
            warning,
            info
        } = COLOR_CODES;
        if (timeLeft <= alert.threshold) {
            document
                .getElementById("base-timer-path-remaining")
                .classList.remove(warning.color);
            document
                .getElementById("base-timer-path-remaining")
                .classList.add(alert.color);

            var element = document.getElementById("base-timer-path-background")
            element.style.backgroundColor = ('#FFD9D9');
        } else if (timeLeft <= warning.threshold) {
            document
                .getElementById("base-timer-path-remaining")
                .classList.remove(info.color);
            document
                .getElementById("base-timer-path-remaining")
                .classList.add(warning.color);

            var element = document.getElementById("base-timer-path-background")
            element.style.backgroundColor = ('#FFECDF');
        }
    }

    function calculateTimeFraction() {
        const rawTimeFraction = timeLeft / TIME_LIMIT;
        return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
    }

    function setCircleDasharray() {
        const circleDasharray = `${(
          calculateTimeFraction() * FULL_DASH_ARRAY
        ).toFixed(0)} 283`;
        document
            .getElementById("base-timer-path-remaining")
            .setAttribute("stroke-dasharray", circleDasharray);
    }
    imageZoom
}
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const placeBidButton = document.getElementById('placeBidButton');
    const loginFirstButton = document.getElementById('loginFirstButton');

    if (placeBidButton) {
        placeBidButton.addEventListener('click', function() {
            placeBidButton.disabled = true;

            const bidValue = document.getElementById('bidValuecal').value;
            const projectId = '{{ $product->project->id }}';
            const auctionTypeId = '{{ $product->auctionType->id }}';
            const productId = '{{ $product->id }}';

            axios.post('{{ route("bidplaced") }}', {
                    user_id: '{{ Auth::id() }}',
                    project_id: projectId,
                    auction_type_id: auctionTypeId,
                    bid_amount: bidValue,
                    product_id: productId,
                })
                .then((response) => {
                    console.log(response);
                    const bidPlacedId = response.data.bid.id;
                    window.location.href = '{{ route("checkout") }}?bid_placed_id=' + bidPlacedId +
                        '&product_id=' + productId;
                })
                .catch(function(error) {
                    console.error(error);
                });

        });
    }

    if (loginFirstButton) {
        loginFirstButton.addEventListener('click', function() {

            Swal.fire({
                icon: 'info',
                title: 'Please Login First',
                text: 'You need to login to Place Bid.',
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
        });
    }
});
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />


@include('frontend.layouts.footer')
<!-- <script type="text/javascript">
(function ($) {
    $(document).ready(function() {
        $('.xzoom, .xzoom-gallery').xzoom({zoomWidth: 400, title: true, tint: '#333', Xoffset: 15});
        $('.xzoom2, .xzoom-gallery2').xzoom({position: '#xzoom2-id', tint: '#ffa200'});
        $('.xzoom3, .xzoom-gallery3').xzoom({position: 'lens', lensShape: 'circle', sourceClass: 'xzoom-hidden'});
        $('.xzoom4, .xzoom-gallery4').xzoom({tint: '#006699', Xoffset: 15});
        $('.xzoom5, .xzoom-gallery5').xzoom({tint: '#006699', Xoffset: 15});

        //Integration with hammer.js
        var isTouchSupported = 'ontouchstart' in window;

        if (isTouchSupported) {
            //If touch device
            $('.xzoom, .xzoom2, .xzoom3, .xzoom4, .xzoom5').each(function(){
                var xzoom = $(this).data('xzoom');
                xzoom.eventunbind();
            });

            $('.xzoom, .xzoom2, .xzoom3').each(function() {
                var xzoom = $(this).data('xzoom');
                $(this).hammer().on("tap", function(event) {
                    event.pageX = event.gesture.center.pageX;
                    event.pageY = event.gesture.center.pageY;
                    var s = 1, ls;

                    xzoom.eventmove = function(element) {
                        element.hammer().on('drag', function(event) {
                            event.pageX = event.gesture.center.pageX;
                            event.pageY = event.gesture.center.pageY;
                            xzoom.movezoom(event);
                            event.gesture.preventDefault();
                        });
                    }

                    xzoom.eventleave = function(element) {
                        element.hammer().on('tap', function(event) {
                            xzoom.closezoom();
                        });
                    }
                    xzoom.openzoom(event);
                });
            });

        $('.xzoom4').each(function() {
            var xzoom = $(this).data('xzoom');
            $(this).hammer().on("tap", function(event) {
                event.pageX = event.gesture.center.pageX;
                event.pageY = event.gesture.center.pageY;
                var s = 1, ls;

                xzoom.eventmove = function(element) {
                    element.hammer().on('drag', function(event) {
                        event.pageX = event.gesture.center.pageX;
                        event.pageY = event.gesture.center.pageY;
                        xzoom.movezoom(event);
                        event.gesture.preventDefault();
                    });
                }

                var counter = 0;
                xzoom.eventclick = function(element) {
                    element.hammer().on('tap', function() {
                        counter++;
                        if (counter == 1) setTimeout(openfancy,300);
                        event.gesture.preventDefault();
                    });
                }

                function openfancy() {
                    if (counter == 2) {
                        xzoom.closezoom();
                        $.fancybox.open(xzoom.gallery().cgallery);
                    } else {
                        xzoom.closezoom();
                    }
                    counter = 0;
                }
            xzoom.openzoom(event);
            });
        });

        $('.xzoom5').each(function() {
            var xzoom = $(this).data('xzoom');
            $(this).hammer().on("tap", function(event) {
                event.pageX = event.gesture.center.pageX;
                event.pageY = event.gesture.center.pageY;
                var s = 1, ls;

                xzoom.eventmove = function(element) {
                    element.hammer().on('drag', function(event) {
                        event.pageX = event.gesture.center.pageX;
                        event.pageY = event.gesture.center.pageY;
                        xzoom.movezoom(event);
                        event.gesture.preventDefault();
                    });
                }

                var counter = 0;
                xzoom.eventclick = function(element) {
                    element.hammer().on('tap', function() {
                        counter++;
                        if (counter == 1) setTimeout(openmagnific,300);
                        event.gesture.preventDefault();
                    });
                }

                function openmagnific() {
                    if (counter == 2) {
                        xzoom.closezoom();
                        var gallery = xzoom.gallery().cgallery;
                        var i, images = new Array();
                        for (i in gallery) {
                            images[i] = {src: gallery[i]};
                        }
                        $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                    } else {
                        xzoom.closezoom();
                    }
                    counter = 0;
                }
                xzoom.openzoom(event);
            });
        });

        } else {
            //If not touch device

            //Integration with fancybox plugin
            $('#xzoom-fancy').bind('click', function(event) {
                var xzoom = $(this).data('xzoom');
                xzoom.closezoom();
                $.fancybox.open(xzoom.gallery().cgallery, {padding: 0, helpers: {overlay: {locked: false}}});
                event.preventDefault();
            });

            //Integration with magnific popup plugin
            $('#xzoom-magnific').bind('click', function(event) {
                var xzoom = $(this).data('xzoom');
                xzoom.closezoom();
                var gallery = xzoom.gallery().cgallery;
                var i, images = new Array();
                for (i in gallery) {
                    images[i] = {src: gallery[i]};
                }
                $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                event.preventDefault();
            });
        }
    });
})(jQuery);
</script> -->
<script>

function imageZoom(imgID, resultID) {
    var img, lens, result, cx, cy;
    img = document.getElementById(imgID);
    result = document.getElementById(resultID);
    /*create lens:*/
    lens = document.createElement("DIV");
    lens.setAttribute("class", "img-zoom-lens");
    /*insert lens:*/
    img.parentElement.insertBefore(lens, img);
    /*calculate the ratio between result DIV and lens:*/
    cx = result.offsetWidth / lens.offsetWidth;
    cy = result.offsetHeight / lens.offsetHeight;
    /*set background properties for the result DIV:*/
    result.style.backgroundImage = "url('" + img.src + "')";
    result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";

    // Hide myresult by default
    $('#myresult').hide();

    // Show myresult on mousemove
    img.addEventListener("mousemove", showResult);
    lens.addEventListener("mousemove", showResult);

    // Hide myresult on touchend and mouseleave
    img.addEventListener("touchend", hideResult);
    lens.addEventListener("touchend", hideResult);
    img.addEventListener("mouseleave", hideResult);
    lens.addEventListener("mouseleave", hideResult);

    function showResult(e) {
        // Show myresult
        $('#myresult').show();
        $('.bid-now-container').hide();

        var pos, x, y;
        /*prevent any other actions that may occur when moving over the image:*/
        e.preventDefault();
        /*get the cursor's x and y positions:*/
        pos = getCursorPos(e);
        /*calculate the position of the lens:*/
        x = pos.x - (lens.offsetWidth / 2);
        y = pos.y - (lens.offsetHeight / 2);
        /*prevent the lens from being positioned outside the image:*/
        if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
        if (x < 0) {x = 0;}
        if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
        if (y < 0) {y = 0;}
        /*set the position of the lens:*/
        lens.style.left = x + "px";
        lens.style.top = y + "px";
        /*display what the lens "sees":*/
        result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
    }

    function hideResult() {
        // Hide myresult
        $('#myresult').hide();
        $('.bid-now-container').show();

    }

    function getCursorPos(e) {
        var a, x = 0, y = 0;
        e = e || window.event;
        /*get the x and y positions of the image:*/
        a = img.getBoundingClientRect();
        /*calculate the cursor's x and y coordinates, relative to the image:*/
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        /*consider any page scrolling:*/
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return {x : x, y : y};
    }
}

</script>

<script>
// Initiate zoom effect:
imageZoom("myimage", "myresult");
</script>
<script>

    document.addEventListener("DOMContentLoaded", function() {

        var thumbnailLinks = document.querySelectorAll('.thumbnail-link');


        thumbnailLinks.forEach(function(link) {

            link.addEventListener('click', function(event) {
                event.preventDefault();


                var imageSrc = this.getAttribute('data-image');
                var previewSrc = this.getAttribute('data-preview');


                document.getElementById('myimage').src = imageSrc;
                document.getElementById('myresult').style.backgroundImage = "url('" + previewSrc + "')";
            });
        });
    });
</script>
<script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>
<script type="text/javascript" src="https://hammerjs.github.io/dist/hammer.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.min.js"></script>
@include('frontend.products.script.addToWishListScript')
