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
            <div class="item" style="background-image: url('{{ asset('frontend/images/slider-bg.png') }}');">
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
                                <p>{{ strip_tags($b->description_ar) }}</p>
                                @else
                                <h1>{{$b->title}} <br></h1>
                                <p>{{ strip_tags($b->description) }}</p>
                                @endif
                              @if ($project && $project->count() > 0)

                                @if ($project && $currentDateTime > $project->end_date_time)
                                    <div class="hero-section-btn">
                                        <a href="{{ url('products',  $b->url) }}" class="btn btn-secondary">{{ session('locale') === 'en' ? 'View Results' : (session('locale') === 'ar' ? 'عرض النتائج' : 'View Results') }} </a>
                                        </div>
                                        @else
                                    <div class="hero-section-btn">
                                        <a href="{{ url('products', $b->url) }}"
                                            class="btn btn-secondary">{{ session('locale') === 'en' ? 'Explore Now' : (session('locale') === 'ar' ? 'استكشاف الآن' : 'Explore Now') }}</a>
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
<section class="trending-auction-section">
    <div class="container">
        <div class="section-heading">
            <h2>{{ session('locale') === 'en' ? 'Trending Auctions' : (session('locale') === 'ar' ? 'المزادات الرائجة' : 'Trending Auctions') }}
            </h2>

        </div>
        <div class="trending-auction-section-itms">
        @foreach($auctionTypesWithProject as $at)
        <div class="trending-auction-section-itm">
            <div class="row action_row">
                <div class="col-lg-3 col-md-12 auction-type   align-just">
                    <div class="">
                        <div>
                            @if(session('locale') === 'en')
                            <h2>{{$at->name}}</h2>
                            @elseif(session('locale') === 'ar')
                            <h2>{{$at->name_ar}}</h2>
                            @else
                            <h2>{{$at->name}}</h2>
                            @endif

                            <a href="{{ url('projects', $at->slug) }}"
                                class="border-white-btn">{{ session('locale') === 'en' ? 'VIEW ALL' : (session('locale') === 'ar' ? 'عرض الكل' : 'VIEW ALL') }}</a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div class="row">
                        @foreach($at->projects as $project)
                        <div class="col-xl-6 col-md-12">
                            <div class="card-product">
                                <a href="{{ url('products', $project->slug) }}">

                                    <div class="product-image">
                                        @if (!empty($project->image_path))
                                        <img src="{{ asset("img/projects/$project->image_path") }}"
                                            alt="{{ $project->title }}">
                                        @else
                                        <img src="{{ asset('frontend/images/default-product-image.png') }}"
                                            alt="Default Image">
                                        @endif
                                    </div>
                                </a>

                                <div class="card-product-dtl">

                                    @if(session('locale') === 'en')
                                    <a href="{{ url('products', $project->slug) }}" class="project-link"><h3>{{ $project->name }} </h3></a>
                                    @elseif(session('locale') === 'ar')
                                    <a href="{{ url('products', $project->slug) }}" class="project-link"><h3>{{$project->name_ar}}</h3></a>
                                    @else
                                    <a href="{{ url('products', $project->slug) }}" class="project-link"><h3>{{ $project->name }} </h3></a>
                                    @endif
                                    @php
                                    $originalDateTime = $project->start_date_time;
                                    $timestamp = strtotime($originalDateTime);
                                    $formattedDateTime = date("F j, g:i A", $timestamp);
                                    $formattedDateTimeconvert = date("M j, g:i A", $timestamp);
                                    $endDatetime = $project->end_date_time;
                                    $end =strtotime($endDatetime);
                                    $formattedEnddateTime = date("F j, g:i A",  $end);
                                    $formattedEndDateTimeconvert = date("M j, g:i A", $end);
                                    $currentDateTime = now();

                                    @endphp
                                    @if ($at->name == 'Live' || $at->name == 'Private')
                                    <h5>{{ formatPrice($project->deposit_amount, session()->get('currency')) }}  {{$currency}}</h5>

                                    @endif

                                    <p>{{  $formattedDateTimeconvert }} - {{$formattedEndDateTimeconvert}}</p>
                                    @php
                                    $loggedInUserId = Auth::id();
                                    $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                                                        ->where('project_id', $project->id)
                                                                        ->first();

                                    @endphp

                                    <!-- for timed auction  -->

                                    @php
                                    $originalDateTime = $project->start_date_time;
                                    $originalDatesTime = new Carbon\Carbon($originalDateTime);
                                    $twoWeeksBefore = $originalDatesTime->copy()->subWeeks(2);
                                    $currentDateTime = now()->timezone('Asia/Kolkata');

                                    @endphp



                                    @if ($at->name == 'Timed'  && $currentDateTime >= $originalDateTime)
                                        <button class="text-btn">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }} </button>
                                    @elseif ($at->name == 'Timed' && $currentDateTime >= $twoWeeksBefore)
                                        <button class="text-btn"> {{ session('locale') === 'en' ? 'EXPLORE NOW' : (session('locale') === 'ar' ? 'استكشف الآن' : 'EXPLORE NOW') }} </button>
                                    @endif

                                    <!-- For Live Auction -->

                                    @if ($bidRequest && $bidRequest->status == 1 && $at->name == 'Live' && $currentDateTime >= $originalDateTime) <button
                                            class="text-btn" onclick="bidNow()">{{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }}  </button>
                                    @elseif ($bidRequest && $bidRequest->status == 0 && $at->name == 'Live')
                                    <button class="text-btn" >

                                          {{ session('locale') === 'en' ? 'Requested' : (session('locale') === 'ar' ? 'تم الطلب' : 'Requested') }}
                                    </button>
                                    @elseif  ($bidRequest && $bidRequest->status == 1 && $at->name == 'Live' && $currentDateTime <= $originalDateTime)
                                    <button class="text-btn" style="display: none;" >

                                        Project Not start
                                  </button>

                                    @elseif  ($at->name == 'Live' && $currentDateTime >= $twoWeeksBefore) <button class="text-btn"
                                        onclick="requestBid('{{ $project->name }}', '{{ $project->id }}', '{{ $project->auction_type_id }}', '{{ $project->deposit_amount }}')">
                                         {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب المزايدة' : 'Request Bid') }}</button>
                                    @endif


                                    <!-- For Private Auction -->
                                    @if ($bidRequest && $bidRequest->status == 1 && $at->name == 'Private' && $currentDateTime >= $originalDateTime)
                                        <button class="text-btn" onclick="bidNow()">
                                            {{ session('locale') === 'en' ? 'Bid Now' : (session('locale') === 'ar' ? 'زاود الان' : 'Bid Now') }}
                                        </button>
                                    @elseif ($bidRequest && $bidRequest->status == 0 && $at->name == 'Private')
                                        <button class="text-btn" >
                                            {{ session('locale') === 'en' ? 'Requested' : (session('locale') === 'ar' ? 'تم الطلب' : 'Requested') }}
                                        </button>
                                     @elseif  ($bidRequest && $bidRequest->status == 1 && $at->name == 'Private' && $currentDateTime <= $originalDateTime)
                                        <button class="text-btn" style="display: none;" >

                                                Project Not start
                                        </button>
                                    @elseif  ($at->name == 'Private' && $currentDateTime >= $twoWeeksBefore)
                                        <button class="text-btn" onclick="requestBid('{{ $project->name }}', '{{ $project->id }}', '{{ $project->auction_type_id }}', '{{ $project->deposit_amount }}')">
                                            {{ session('locale') === 'en' ? 'Request Bid' : (session('locale') === 'ar' ? 'طلب عرض أسعار' : 'Request Bid') }}
                                        </button>
                                    @endif


                                </div>

                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="most-view-product">
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
            @endphp

            @if ($galleries->isNotEmpty())
                @if ($bidRequest && $bidRequest->status == 1)
                    <a href="{{ url('productsdetail', $product->slug) }}">
                        <img src="{{ asset($galleries->first()->image_path) }}" alt="">
                    </a>
                @else
                    <a href="{{ url('products', optional($product->project)->slug) }}" onclick="return showPopups(event)">
                        <img src="{{ asset($galleries->first()->image_path) }}" alt="">
                    </a>
                @endif
            @else
                <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image">
            @endif

            @auth
                <div class="heat-like wishlist-heart @if(in_array($product->id, $wishlist)) active @endif" data-product-id="{{ $product->id }}">
                    <input type="checkbox" name="" id="" @if(in_array($product->id, $wishlist)) checked @endif>
                    <img src="{{ asset('frontend/images/heart.png') }}" alt="">
                </div>
            @else
                <a href="{{ route('signin') }}"><i class="fa fa-heart-o "></i></a>
            @endauth

            <div class="bid-box-status">
                <div class="bid-box-status-ic">
                    @php
                        $auctionTypeName = optional($auctionType)->name;
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
                    <span>
                        @if(session('locale') === 'en')
                            {{ $auctionTypeName }}
                        @elseif(session('locale') === 'ar')
                            {{ optional($auctionType)->name_ar }}
                        @else
                            {{ $auctionTypeName }}
                        @endif
                    </span>
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
                        data-date='{{ $product->auction_end_date }}' id="countdown-{{ $product->id }}">
                        <ul>
                            <li class="days-wrapper"><span class="days"></span> days</li>
                            <li><span class="hours"></span> Hours</li>
                            <li><span class="minutes"></span> Minutes</li>
                            <li><span class="seconds"></span> Seconds</li>
                        </ul>
                    </div>
                @else
                    <p><span style="color: red;">Lot closed</span></p>
                @endif
            @endif

            @if ($auctionTypeName == 'Live')
                @if ($lastBids && $lastBids->bid_amount < $product->minsellingprice)
                    <p><span style="color: #3E0269;">Auction is in progress</span></p>
                @elseif ($lastBids && $lastBids->bid_amount >= $product->minsellingprice)
                    <p><span style="color: red;">Bid Closed</span></p>
                @endif
            @endif
        </div>

        @if ($bidRequest && $bidRequest->status == 1)
            <a href="{{ url('productsdetail', $product->slug) }}" class="pop-link">
                <h3>
                    {{ session('locale') === 'en' ? $product->lot_no . ': ' . substr(strip_tags($product->title), 0, 20) . (strlen(strip_tags($product->title)) > 20 ? '...' : '') :
                    (session('locale') === 'ar' ? $product->lot_no . ': ' . substr(strip_tags($product->title_ar), 0, 20) . (strlen(strip_tags($product->title_ar)) > 20 ? '...' : '') :
                    $product->lot_no . ': ' . substr(strip_tags($product->title), 0, 20) . (strlen(strip_tags($product->title)) > 20 ? '...' : '')) }}
                </h3>
            </a>
        @else
            <a href="{{ url('products', optional($product->project)->slug) }}" class="pop-link" onclick="return showPopups(event)">
                <h3>
                    {{ session('locale') === 'en' ? $product->lot_no . ': ' . substr(strip_tags($product->title), 0, 20) . (strlen(strip_tags($product->title)) > 20 ? '...' : '') :
                    (session('locale') === 'ar' ? $product->lot_no . ': ' . substr(strip_tags($product->title_ar), 0, 20) . (strlen(strip_tags($product->title_ar)) > 20 ? '...' : '') :
                    $product->lot_no . ': ' . substr(strip_tags($product->title), 0, 20) . (strlen(strip_tags($product->title)) > 20 ? '...' : '')) }}
                </h3>
            </a>
        @endif

        <p>
            @if(session('locale') === 'en')
                {{ substr(strip_tags($product->description), 0, 100) }} {{ strlen(strip_tags($product->description)) > 100 ? '...' : '' }}
            @elseif(session('locale') === 'ar')
                {{ substr(strip_tags($product->description_ar), 0, 100) }} {{ strlen(strip_tags($product->description_ar)) > 100 ? '...' : '' }}
            @else
                {{ substr(strip_tags($product->description), 0, 100) }} {{ strlen(strip_tags($product->description)) > 100 ? '...' : '' }}
            @endif
        </p>

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

        <a href="#" class="next-btn-img"><img src="{{ asset('frontend/images/next-btn.svg') }}" alt=""></a>
    </div>
</div>

            @endforeach
            @endif
            @endforeach
        </div>
    </div>
</section>

<section class="most-bid">
    <div class="container">
        <div class="section-heading">
            <h2>{{ session('locale') === 'en' ? 'Most Bids' : (session('locale') === 'ar' ? 'الاكثر مزايدة' : 'Most Bids') }}</h2>
        </div>
        <div class="row">
            @foreach($mostRecentBids as $productId => $mostRecentBid)
                @php
                    $loggedInUserId = Auth::id();
                    $bidRequest = null;
                    $galleries = null;

                    if (isset($mostRecentBid->product)) {
                        $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                        ->where('project_id', $mostRecentBid->product->project_id)
                                        ->where('status', 1)
                                        ->first();

                        $galleries = \App\Models\Gallery::where('lot_no', $mostRecentBid->product->lot_no)->get();
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
                                    <a href="{{ url('productsdetail', $mostRecentBid->product->slug) }}">
                                        <img src="{{ asset($galleries->first()->image_path) }}" alt="">
                                    </a>
                                @else
                                    @php
                                        $projectSlug = $mostRecentBid->product->project->slug;
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
                                        <div class="countdown-time thisisdemoclass" data-id='{{ $mostRecentBid->product->id }}' data-date='{{ $mostRecentBid->product->auction_end_date }}' id="countdown-{{ $mostRecentBid->product->id }}">
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
                                        $auctionTypeName = isset($mostRecentBid->product->auctionType) ? $mostRecentBid->product->auctionType->name : '';
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
                                        <span>{{ $auctionTypeName }}</span>
                                    @elseif(session('locale') === 'ar')
                                        <span>{{ optional($mostRecentBid->product->auctionType)->name_ar }}</span>
                                    @else
                                        <span>{{ $auctionTypeName }}</span>
                                    @endif
                                </div>
                            </div>

                            @if (isset($mostRecentBid->product->slug))
                                @if(session('locale') === 'en')
                                    <h3><a href="{{ url('productsdetail', $mostRecentBid->product->slug) }}">{{ $mostRecentBid->product->lot_no }}: {{ $mostRecentBid->product->title }}</a></h3>
                                @elseif(session('locale') === 'ar')
                                    <h3><a href="{{ url('productsdetail', $mostRecentBid->product->slug) }}">{{ $mostRecentBid->product->lot_no }}: {{ $mostRecentBid->product->title_ar }}</a></h3>
                                @else
                                    <h3><a href="{{ url('productsdetail', $mostRecentBid->product->slug) }}">{{ $mostRecentBid->product->lot_no }}: {{ $mostRecentBid->product->title }}</a></h3>
                                @endif
                                <p>{{ formatPrice($mostRecentBid->max_bid_amount, session()->get('currency')) }} {{$currency}} <span>{{ $mostRecentBid->bid_count }} bids</span></p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>



  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>





@include('frontend.products.script.addToWishListScript')

@include('frontend.layouts.requestbidscript')

@include('frontend.layouts.footer')
