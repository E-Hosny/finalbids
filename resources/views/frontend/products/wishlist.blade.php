@include('frontend.layouts.header')
<style>
  .text-muted {
   
    display: none;
}
h2, .h2 {
    align: center;
    font-size: 5rem;
}
.nodata {
    color: black;
    font-size: 38px;
    text-align: center; 
}

.no-products-found {
    text-align: center; 
}
  </style>
<section class="hero-ther">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 text-center">
                <h1>{{ session('locale') === 'en' ? 'Favourite' : (session('locale') === 'ar' ? 'المفضلة' : 'Favourite') }}</h1>

                <p></p>
                <form action="" class="search-frm-prdt">
                    <input type="text" name="" id="" placeholder="{{ session('locale') === 'en' ? 'Search products...' : (session('locale') === 'ar' ? 'ابحث عن منتجات' : 'Search products...') }}">
                    
                    <button><img class="w-100" src="{{ asset('frontend/images/rounded-sr.svg') }}" alt=""></button>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="product-list-man mt-5">
    <div class="container">
        <div class="row">
            @php
            $wishlist = [];
            foreach($wishlistItems as $it) {
                $wishlist[] = $it->product->id;
            };              
        @endphp
        @forelse ($wishlistItems as $item)
            @php
            $currentBid = \App\Models\BidPlaced::where('product_id', $it->product->id)
                                        ->where('sold', 1)
                                        ->where('status', '!=', 0)
                                        ->orderBy('bid_amount', 'desc')
                                        ->first();
            @endphp
            <div class="col-md-6">
                <a href="{{ url('productsdetail', $item->product->slug) }}">
                    <div class="card-product">
                        <div class="product-image">
                        @php
                        $galleries = \App\Models\Gallery::where('lot_no', $item->product->lot_no)->get();
                       @endphp
                               @php 
                                $loggedInUserId = Auth::id();
                                        $bidRequest = \App\Models\BidRequest::where('user_id', $loggedInUserId)
                                        ->where('project_id', $item->product->project_id)
                                        ->where('status',1)
                                        ->first();
                                @endphp
                            @if ($galleries)
                            @if($bidRequest && $bidRequest->status == 1)
                            <a href="{{ url('productsdetail', $item->product->slug) }}"><img src="{{ asset($galleries->first()->image_path) }}" alt=""></a>
                            <!-- <i class="fa fa-heart-o"></i> -->
                            @else
                            <a href="{{ url('products', optional($item->product->project)->slug) }}" onclick="return showPopups(event)"><img src="{{ asset($galleries->first()->image_path) }}" alt=""></a>
                            <!-- <i class="fa fa-heart-o"></i> -->
                            @endif
                            @else
                                <img src="{{asset('frontend/images/default-product-image.png')}}" alt="Default Image">
                            @endif

                            <div class="heat-like wishlist-heart active" data-product-id="{{ $item->product->id }}">
                                <input type="checkbox" name="" id="" @if(in_array($item->product->id, $wishlist)) checked @endif>
                                <img src="{{asset('frontend/images/heart.png')}}" alt="">
                            </div>

                        </div>
                        <div class="card-product-dtl">
                           
                            @if(session('locale') === 'en')
                                <h3>{{$item->product->lot_no}} : {{ $item->product->title }}</h3>
                                @elseif(session('locale') === 'ar')
                                <h3>{{$item->product->lot_no}} : {{$item->product->title_ar }}</h3>
                                @else
                                <h3>{{$item->product->lot_no}} : {{$item->product->title }}</h3>
                            @endif
                      <h5>{{ formatPrice($item->product->reserved_price, session()->get('currency')) }}</h5>

                            <!-- <p>Current Bid: <span>00</span></p> -->
                            
                            @if ($item->product->auctionType->name == 'Private' || $item->product->auctionType->name == 'Timed')
                            <div class="countdown-time thisisdemoclass" data-id='{{ $item->product->id }}'
                                    data-date='{{ $item->product->auction_end_date }}' id="countdown-{{ $item->product->id }}">
                                    <ul>
                                        <li><span class="days"></span>days</li>
                                        <li><span class="hours"></span>Hours</li>
                                        <li><span class="minutes"></span>Minutes</li>
                                        <li><span class="seconds"></span>Seconds</li>
                                    </ul>
                            </div>
                            @endif
                            <div class="bid-box-status">
                            <div class="bid-box-status-ic"><img
                                    src="{{asset('frontend/images/live.svg')}}">
                                    @if(session('locale') === 'en')
                                   <span>{{ $item->product->auctionType->name }}</span>
                                    @elseif(session('locale') === 'ar')
                                    <span>{{ $item->product->auctionType->name_ar }}</span>
                                    @else
                                   <span>{{ $item->product->auctionType->name }}</span>
                                    @endif
                                    
                            </div>
                        </div>
                          

                            <!-- <button class="text-btn">Bid Now <img class="img-fluid ms-3"
                                    src="{{ asset('images/next-arrow.svg') }}" alt=""></button> -->
                        <!-- 09 feb changes -->
                        
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-md-12">
            <div class="no-products-found">
                 <!-- <h2 class="nodata"> No Data Found </h2> -->
        <h2 class="nodata">{{ session('locale') === 'en' ? 'No Data Found' : (session('locale') === 'ar' ? 'لا يوجد بيانات' : 'No Data Found') }}</h2>

        </div> 
            </div>
            @endforelse
        </div>
        <ul class="pagination">
           
              {{ $wishlistItems->appends($_GET)->links('pagination::bootstrap-5') }} 
          
        </ul>

    </div>
</section>
@include('frontend.layouts.footer')
@include('frontend.products.script.addToWishListScript')
