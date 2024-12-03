@include('frontend.layouts.header')
<style>
ul,
.error-messages {
    margin-top: 0;
    margin-bottom: 1rem;
    color: red;
}

.bids-items {
    padding: 50px 0px;
}

.divide {
    margin-top: 20px;
    border-bottom: 3px solid #dedede;
}

.custom-radio {
    display: flex;
    margin-top: 20px;
}

.bids-items .accordion-header {
    display: flex;
    padding-right: 10px;
}

.bids-items .accordion-header button {
    white-space: nowrap;
}

.custom-radio .form-check {
    gap: 10px;
    display: flex;
    align-items: center;
}

.item-data p {
    margin-bottom: 10px;
}

.item-data span {
    font-size: 16px;
    color: #aeaeae;
}

.dropdown-with {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
}

.accordion-button {
    font-size: 15px;
}

.dropdown-btn .form-select {
    outline: none;
    box-shadow: none;
}

.accordion-button:not(.collapsed) {
    color: #0c63e4;
    background-color: transparent;
    box-shadow: none;
    border: transparent;
    outline: none;
}

.accordion-item {
    background-color: #fff;
    border: none;
}

.accordion-button {
    padding: 2px;
}

.accordion-button::after {
    margin-left: 20px;
}

.table> :not(:last-child)> :last-child>* {
    border-bottom-color: transparent !important;
}

.table {
    margin-bottom: 0;
    color: #212529;
    border: 1px solid;
    vertical-align: top;
    border-color: #dee2e6;
}

.table th,
td {
    border: 1px solid #dee2e6;
    font-size: 13px;
}

.bid-box-status .bid-box-status-ic {
    background: #f5f6f6;
    padding: 4px 10px;
    border-radius: 30px;
    font-size: 14px;
    display: flex;
    align-items: center;
    position: relative;
    right: 10px;
    bottom: 10px;
}

.accordion-button {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    font-size: 1rem;
    color: #0c63e4;
    text-align: left;
    background-color: #fff;
    border: 0;
    border-radius: 0;
    overflow-anchor: none;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, border-radius 0.15s ease;
}

.item-data h5 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 9px;
}
.btn.btn-secondary.testp {
    border-radius: 10px;
    background: linear-gradient(90deg, #0d3858 0%, #0d3858 100%);
    padding: 7px 27px;
    color: #fff !important;
    font-size: 11px;
    border: 0;
    text-transform: uppercase;
    white-space: nowrap;
}
.btn.btn-secondary {
    border-radius: 10px;
    background: linear-gradient(90deg, #0d3858 0%, #0d3858 100%);
    padding: 7px 5px;
    color: #fff !important;
    font-size: 13px;
    border: 0;
    text-transform: uppercase;
    white-space: nowrap;
}
</style>
<section class="dtl-user-box">
    <div class="container">
        <div class="account-outer-box">
            <div class="row">
                @include('frontend.dashboard.sidebar')
                <div class="col-md-9">
                    <div class="bids-items">
                        @if(session('locale') === 'en')
                        <h3>Bids</h3>
          
                        @elseif(session('locale') === 'ar')
                        <h3>العطاءات</h3>
                       
                        @else
                        <h3>Bids</h3>
                      
                        @endif
                        <div class="divide"></div>

                        <div class="custom-radio">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault1" checked>
                                @if(session('locale') === 'en')
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Current
                                </label>
                                @elseif(session('locale') === 'ar')
                                <label class="form-check-label" for="flexRadioDefault1">
                                    حالي
                                </label>
                                @else
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Current
                                </label>
                                @endif
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2">
                                @if(session('locale') === 'en')
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Past
                                </label>
                                @elseif(session('locale') === 'ar')
                                <label class="form-check-label" for="flexRadioDefault2">
                                    الماضي
                                </label>
                                @else
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Past
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="content mange-bids" id="currentTabContent">
                         @if(session('locale') === 'en')
		               
		                <h6>Bids ({{ $bidsCountByUserAndProduct->count() }} Item )</h6>
		                @elseif(session('locale') === 'ar')
		               
		                <h6>العطاءات ({{ $bidsCountByUserAndProduct->count() }} بند )</h6>
		                @else
		              
		                <h6>Bids ({{ $bidsCountByUserAndProduct->count() }} Item )</h6>
		                @endif
                            <div class="row align-items-top ">
                                @foreach($groupedBids as $productId => $productBids)
                                <div class="col-md-3 mt-3">
                                    <div class="item-img">
                                        @php
                                        $galleries = \App\Models\Gallery::where('product_id',
                                        $productBids->first()->product->id)->get();
                                        @endphp

                                        @if ($galleries->isNotEmpty())
                                        <a href="{{ url('productsdetail', $productBids->first()->product->slug) }}" class="prd-link"><img src="{{ asset($galleries->first()->image_path) }}" alt=""></a>
                                        @else
                                        <img src="{{ asset('frontend/images/default-product-image.png') }}"
                                            alt="Default Image">
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-9 mt-3">
                                    <div class="item-data">
                                        @if(session('locale') === 'en')
                                        <a href="{{ url('productsdetail', $productBids->first()->product->slug) }}" class="prd-link">  <h5>{{ $productBids->first()->product->lot_no }} :
                                            {{ $productBids->first()->product->title }}</h5></a>
                                        <h6>Est : {{ formatPrice($productBids->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBids->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                                   </h6>
                                        
                                      
                                        @elseif(session('locale') === 'ar')
                                        <h5>{{ $productBids->first()->product->lot_no }} :
                                            {{ $productBids->first()->product->title_ar }}</h5>
                                            <h6>مؤسسه :  {{ formatPrice($productBids->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBids->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                                    </h6>
                                      
                                            
                                        @else
                                        <h5>{{ $productBids->first()->product->lot_no }} :
                                            {{ $productBids->first()->product->title }}</h5>
                                            <h6>Est : {{ formatPrice($productBids->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBids->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                                    </h6>
                                      
                                            
                                        @endif

                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $productId }}">
                                                    @if(session('locale') === 'en')
                                                    <div class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $productId }}" aria-expanded="false"
                                                        aria-controls="collapse{{ $productId }}">
                                                        View Bid History
                                                    </div>
                                                    
                                                  
                                                    @elseif(session('locale') === 'ar')
                                                    <div class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $productId }}" aria-expanded="false"
                                                        aria-controls="collapse{{ $productId }}">
                                                        عرض سجل العطاءات
                                                    </div>
                                                  
                                                    @else
                                                    <div class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $productId }}" aria-expanded="false"
                                                        aria-controls="collapse{{ $productId }}">
                                                        View Bid History
                                                    </div>
                                                  
                                                    @endif

                                                </h2>
                                            </div>
                                        </div>

                                        {{-- <div id="collapse{{ $productId }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $productId }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="accor-table table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            @if(session('locale') === 'en')
                                                            <tr>
                                                                <th scope="col">Bidder</th>
                                                                <th scope="col">Auction Type</th>
                                                                <th scope="col">Bid Date/Time</th>
                                                                <th scope="col">Bidding Amount</th>
                                                                <th scope="col">Total Amount</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                            @elseif(session('locale') === 'ar')
                                                            <tr>
                                                                <th scope="col">عارض</th>
                                                                <th scope="col">نوع المزاد</th>
                                                                <th scope="col">تاريخ/وقت المناقصة</th>
                                                                <th scope="col">مبلغ</th>
                                                                 <th scope="col">Total Amount</th>
                                                                <th scope="col">حالة</th>
                                                            </tr>
                                                            @else
                                                            <tr>
                                                                <th scope="col">Bidder</th>
                                                                <th scope="col">Auction Type</th>
                                                                <th scope="col">Bid Date/Time</th>
                                                                <th scope="col">Bidding Amount</th>

                                                                <th scope="col">Total Amount</th>

                                                                <th scope="col">Status</th>
                                                            </tr>
                                                            @endif
                                                        </thead>
                                                        <tbody>
                                                            @foreach($productBids as $bid)
                                                            <tr>
                                                                <td>{{ $bid->user->first_name }}</td>
                                                                @if(session('locale') === 'en')
                                                                <td>{{ $bid->product->project->auctionType->name }}</td>
                                                                @elseif(session('locale') === 'ar')
                                                                <td>{{ $bid->product->project->auctionType->name_ar }}
                                                                </td>
                                                                @else
                                                                <td>{{ $bid->product->project->auctionType->name }}</td>
                                                                @endif
                                                                <td>{{ $bid->created_at }}</td>
                                                                <td>{{ formatPrice($bid->bid_amount, session()->get('currency')) }}
                                                                    {{$currency}}</td>
                                                                <td>{{ formatPrice($bid->total_amount, session()->get('currency')) }}
                                                                    {{$currency}}</td>
                                                                <td>
                                                                @if(session('locale') === 'en')
                                                                    @if($bid->status == 1)
                                                                        Accepted
                                                                    @elseif($bid->status == 2 && $bid->user_id == auth()->id())
                                                                   Winner &nbsp;
                                                               <a href="{{url('/')}}/public/payment/index.php?user_id={{auth()->id()}}&bid_place_id={{ $bid->id }}&product_id={{ $bid->product->id }}&price={{ formatPrice($bid->total_amount, session()->get('currency')) }}" class="rounded-pill btn btn-secondary testp">Pay Now</a>
                                                                       
                                                                    @else ($bid->status == 2)
                                                                          Winner
                                                                    @endif
                                                                @elseif(session('locale') === 'ar')
                                                                    @if($bid->status == 1)
                                                                        قبلت
                                                                    @elseif($bid->status == 2 && $bid->user_id == auth()->id())
                                                                    <!-- <button  class="rounded-pill btn btn-secondary testp" onclick="requestBid('{{ $bid->product->id }}')">>ادفع الآن</button> -->
                                                                    <a href="{{url('/')}}/public/payment/index.php?user_id={{auth()->id()}}&bid_place_id={{ $bid->id }}&product_id={{ $bid->product->id }}&price={{ formatPrice($bid->total_amount, session()->get('currency')) }}" class="rounded-pill btn btn-secondary testp">ادفع الآن</a>
                                                                    @else ($bid->status == 2)
                                                                          Winner
                                                                    @endif
                                                                @else
                                                                    @if($bid->status == 1)
                                                                        Accepted
                                                                    @elseif($bid->status == 2 && $bid->user_id == auth()->id())
                                                                    Winner &nbsp;
                                                                    <a href="{{url('/')}}/public/payment/index.php?user_id={{auth()->id()}}&bid_place_id={{ $bid->id }}&product_id={{ $bid->product->id }}&price={{ formatPrice($bid->total_amount, session()->get('currency')) }}" class="rounded-pill btn btn-secondary testp">Pay Now</a>

                                                                    @else ($bid->status == 2)
                                                                          Winner
                                                                    @endif
                                                                @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div id="collapse{{ $productId }}" class="accordion-collapse collapse"
    aria-labelledby="heading{{ $productId }}"
    data-bs-parent="#accordionExample">
    <div class="accordion-body">
        <div class="accor-table table-responsive">
            <table class="table table-striped">
                <thead>
                    @if(session('locale') === 'en')
                    <tr>
                        <th scope="col">Bidder</th>
                        <th scope="col">Auction Type</th>
                        <th scope="col">Bid Date/Time</th>
                        <th scope="col">Bidding Amount</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Status</th>
                    </tr>
                    @elseif(session('locale') === 'ar')
                    <tr>
                        <th scope="col">عارض</th>
                        <th scope="col">نوع المزاد</th>
                        <th scope="col">تاريخ/وقت المناقصة</th>
                        <th scope="col">مبلغ</th>
                        <th scope="col">المبلغ الإجمالي</th>
                        <th scope="col">حالة</th>
                    </tr>
                    @else
                    <tr>
                        <th scope="col">Bidder</th>
                        <th scope="col">Auction Type</th>
                        <th scope="col">Bid Date/Time</th>
                        <th scope="col">Bidding Amount</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Status</th>
                    </tr>
                    @endif
                </thead>
                <tbody>
                    @foreach($bidsCountByUserAndProduct as $bidCount)
                    @foreach($productBids as $bid)
                    <tr>
                        <td>{{ $bid->user->first_name }}</td>
                        <td>{{ $bid->product->project->auctionType->name }}</td>
                        <td>{{ $bid->created_at }}</td>
                        <td>{{ formatPrice($bid->bid_amount, session()->get('currency')) }} {{ $currency }}</td>
                        <td>{{ formatPrice($bid->total_amount, session()->get('currency')) }} {{ $currency }}</td>
                        <td>
                            @if($bid->status == 0)  <!-- Accepted -->
                                @if(session('locale') === 'en')
                                pending
                                @elseif(session('locale') === 'ar')
                            انتظار  
                                @endif
                          @elseif($bid->status == 1)  <!-- Accepted -->
                                @if(session('locale') === 'en')
                                approved
                                @elseif(session('locale') === 'ar')
                                    قبلت
                                @endif     
                            @elseif($bid->status == 2)  <!-- Rejected -->
                                @if(session('locale') === 'en')
                                    Rejected
                                @elseif(session('locale') === 'ar')
                                    مرفوض
                                @endif
                            @elseif($bid->status == 3)  <!-- Winner -->
                                @if($bid->user_id == auth()->id())  <!-- If it's the current user -->
                                    @if(session('locale') === 'en')
                                        Winner &nbsp;
                                    @elseif(session('locale') === 'ar')
                                        فائز &nbsp;
                                    @endif
                                    <a href="{{ url('/payment/index.php?user_id=' . auth()->id() . '&bid_place_id=' . $bid->id . '&product_id=' . $bid->product->id . '&price=' . formatPrice($bid->total_amount, session()->get('currency'))) }}" class="rounded-pill btn btn-secondary">Pay Now</a>
                                @else
                                    @if(session('locale') === 'en')
                                        Winner
                                    @elseif(session('locale') === 'ar')
                                        فائز
                                    @endif
                                @endif
                            @elseif($bid->status == 4)  <!-- Loser -->
                                @if(session('locale') === 'en')
                                    Loser
                                @elseif(session('locale') === 'ar')
                                    خاسر
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

                                    </div>
                                </div>
                                <div class="divide"></div>
                                @endforeach
                            </div>
                        </div>
                        <!-- for past bid contents  -->
                        <!-- <div class="content mange-bids" id="pastTabContent" style="display: none; text-align: center;">
                            <div class="row align-items-top ">
                                @foreach($groupedBidspast as $productIdpast => $productBidspast)
                                <div class="col-md-3 mt-3">
                                    <div class="item-img">
                                        @php
                                        $galleriespast = \App\Models\Gallery::where('product_id',
                                        $productBidspast->first()->product->id)->get();
                                        @endphp

                                        @if ($galleriespast->isNotEmpty())
                                        <img src="{{ asset($galleriespast->first()->image_path) }}" alt="">
                                        @else
                                        <img src="{{ asset('frontend/images/default-product-image.png') }}"
                                            alt="Default Image">
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-9 mt-3">
                                    <div class="item-data">
                                        @if(session('locale') === 'en')
                                        <h5>{{ $productBidspast->first()->product->lot_no }} :
                                            {{ $productBidspast->first()->product->title }}</h5>
                                        <h6>Est : {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                                   </h6>
                                        <strong>Sold :  @php
                                            $highestBidAmount = $productBidspast->max('bid_amount');
                                            echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency;
                                        @endphp</strong>
                                       
                                        @elseif(session('locale') === 'ar')
                                        <h5>{{ $productBidspast->first()->product->lot_no }} :
                                            {{ $productBidspast->first()->product->title_ar }}</h5>
                                            <h6>مؤسسه :  {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                                    </h6>
                                        <strong>Sold :  @php
                                            $highestBidAmount = $productBidspast->max('bid_amount');
                                            echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency;
                                        @endphp</strong>
                                            
                                        @else
                                        <h5>{{ $productBidspast->first()->product->lot_no }} :
                                            {{ $productBidspast->first()->product->title }}</h5>
                                            <h6>Est : {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                                    </h6>
                                        <strong>Sold :  @php
                                                $highestBidAmount = $productBidspast->max('bid_amount');
                                                echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency;
                                            @endphp</strong>
                                            
                                        @endif

                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $productIdpast }}">
                                                    @if(session('locale') === 'en')
                                                    <div class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $productIdpast }}" aria-expanded="true"
                                                        aria-controls="collapse{{ $productIdpast }}">
                                                        View Bid History
                                                    </div>
                                                    
                                                  
                                                    @elseif(session('locale') === 'ar')
                                                    <div class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $productIdpast }}" aria-expanded="true"
                                                        aria-controls="collapse{{ $productIdpast }}">
                                                        عرض سجل العطاءات
                                                    </div>
                                                  
                                                    @else
                                                    <div class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $productIdpast }}" aria-expanded="true"
                                                        aria-controls="collapse{{ $productIdpast }}">
                                                        View Bid History
                                                    </div>
                                                  
                                                    @endif

                                                </h2>
                                            </div>
                                        </div>

                                        <div id="collapse{{ $productIdpast }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $productIdpast }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="accor-table table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            @if(session('locale') === 'en')
                                                            <tr>
                                                                <th scope="col">Bidder</th>
                                                                <th scope="col">Auction Type</th>
                                                                <th scope="col">Bid Date/Time</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                            @elseif(session('locale') === 'ar')
                                                            <tr>
                                                                <th scope="col">عارض</th>
                                                                <th scope="col">نوع المزاد</th>
                                                                <th scope="col">تاريخ/وقت المناقصة</th>
                                                                <th scope="col">مبلغ</th>
                                                                <th scope="col">حالة</th>
                                                            </tr>
                                                            @else
                                                            <tr>
                                                                <th scope="col">Bidder</th>
                                                                <th scope="col">Auction Type</th>
                                                                <th scope="col">Bid Date/Time</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                            @endif
                                                        </thead>
                                                        <tbody>
                                                            @foreach($productBidspast as $bidpast)
                                                            <tr>
                                                                <td>{{ $bidpast->user->first_name }}</td>
                                                                @if(session('locale') === 'en')
                                                                <td>{{ $bidpast->product->project->auctionType->name }}</td>
                                                                @elseif(session('locale') === 'ar')
                                                                <td>{{ $bidpast->product->project->auctionType->name_ar }}
                                                                </td>
                                                                @else
                                                                <td>{{ $bidpast->product->project->auctionType->name }}</td>
                                                                @endif
                                                                <td>{{ $bidpast->created_at }}</td>
                                                                <td>{{ formatPrice($bidpast->bid_amount, session()->get('currency')) }}
                                                                    {{$currency}}</td>
                                                                <td>
                                                                @if(session('locale') === 'en')
                                                                    @if($bidpast->status == 1)
                                                                        Accepted
                                                                    @else ($bidpast->status == 2)
                                                                          Winner
                                                                    @endif
                                                                @elseif(session('locale') === 'ar')
                                                                    @if($bidpast->status == 1)
                                                                        قبلت
                                                                    @else ($bidpast->status == 2)
                                                                          Winner
                                                                    @endif
                                                                @else
                                                                    @if($bidpast->status == 1)
                                                                        Accepted
                                                                   
                                                                    @else ($bidpast->status == 2)
                                                                          Winner
                                                                    @endif
                                                                @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div> -->
                        <!-- for past bid contents  -->
<div class="content mange-bids" id="pastTabContent" style="display: none;">
@if(session('locale') === 'en')
		               
		                <h6>Bids ({{ $groupedBidspast->count() }} Item )</h6>
		                @elseif(session('locale') === 'ar')
		               
		                <h6>العطاءات ({{ $groupedBidspast->count() }} بند )</h6>
		                @else
		              
		                <h6>Bids ({{ $groupedBidspast->count() }} Item )</h6>
		                @endif
    <div class="row align-items-top">
        @foreach($groupedBidspast as $productIdpast => $productBidspast)
        <div class="col-md-3 mt-3">
            <div class="item-img">
                @php
                $galleriespast = \App\Models\Gallery::where('product_id', $productBidspast->first()->product->id)->get();
                @endphp
                @if ($galleriespast->isNotEmpty())
                <a href="{{ url('productsdetail', $productBidspast->first()->product->slug) }}" class="prd-link"><img src="{{ asset($galleriespast->first()->image_path) }}" alt=""></a>
                @else
                <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image">
                @endif
            </div>
        </div>

        <div class="col-md-9 mt-3">
            <div class="item-data">
            <a href="{{ url('productsdetail', $productBidspast->first()->product->slug) }}" class="prd-link"> <h5>{{ $productBidspast->first()->product->lot_no }} :
                    @if(session('locale') === 'en')
                    {{ $productBidspast->first()->product->title }}
                    @elseif(session('locale') === 'ar')
                    {{ $productBidspast->first()->product->title_ar }}
                    @else
                    {{ $productBidspast->first()->product->title }}
                    @endif
                </h5></a>
                <h6>
                    @if(session('locale') === 'en')
                    Est : {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                    @elseif(session('locale') === 'ar')
                    مؤسسه :  {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                    @else
                    Est : {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} - {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                    @endif
                </h6>
                <strong>
                    @if(session('locale') === 'en')
                    Sold :  @php $highestBidAmount = $productBidspast->max('bid_amount'); echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency; @endphp
                    @elseif(session('locale') === 'ar')
                    مباع :  @php $highestBidAmount = $productBidspast->max('bid_amount'); echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency; @endphp
                    @else
                    Sold :  @php $highestBidAmount = $productBidspast->max('bid_amount'); echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency; @endphp
                    @endif
                </strong>
                <strong>
                    @if($productBidspast->where('user_id', auth()->id())->where('status', 2)->isNotEmpty())
                        <a href="{{url('download-invoice')}}" class="btn btn-secondary rounded-pill download_invoice_btn">Download Invoice</a>
                    @endif
                </strong>

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $productIdpast }}">
                            <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $productIdpast }}" aria-expanded="true" aria-controls="collapse{{ $productIdpast }}">
                                @if(session('locale') === 'en')
                                View Bid History
                                @elseif(session('locale') === 'ar')
                                عرض سجل العطاءات
                                @else
                                View Bid History
                                @endif
                            </div>
                        </h2>
                    </div>
                </div>

                <div id="collapse{{ $productIdpast }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $productIdpast }}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="accor-table table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    @if(session('locale') === 'en')
                                    <tr>
                                        <th scope="col">Bidder</th>
                                        <th scope="col">Auction Type</th>
                                        <th scope="col">Bid Date/Time</th>
                                        <th scope="col">Bidding Amount</th>

                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    @elseif(session('locale') === 'ar')
                                    <tr>
                                        <th scope="col">عارض</th>
                                        <th scope="col">نوع المزاد</th>
                                        <th scope="col">تاريخ/وقت المناقصة</th>
                                        <th scope="col">مبلغ</th>
                                        <th scope="col">Total Amount</th>

                                        <th scope="col">حالة</th>
                                    </tr>
                                    @else
                                    <tr>
                                        <th scope="col">Bidder</th>
                                        <th scope="col">Auction Type</th>
                                        <th scope="col">Bid Date/Time</th>
                                        <th scope="col">Bidding Amount</th>

                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    @endif
                                </thead>
                                <tbody>
                                    @foreach($productBidspast as $bidpast)
                                    <tr>
                                        <td>{{ $bidpast->user->first_name }}</td>
                                        @if(session('locale') === 'en')
                                        <td>{{ $bidpast->product->project->auctionType->name }}</td>
                                        @elseif(session('locale') === 'ar')
                                        <td>{{ $bidpast->product->project->auctionType->name_ar }}</td>
                                        @else
                                        <td>{{ $bidpast->product->project->auctionType->name }}</td>
                                        @endif
                                        <td>{{ $bidpast->created_at }}</td>
                                        <td>{{ formatPrice($bidpast->bid_amount, session()->get('currency')) }} {{$currency}}</td>
                                        <td>{{ formatPrice($bidpast->total_amount, session()->get('currency')) }} {{$currency}}</td>

                                        <td>
                                            @if(session('locale') === 'en')
                                            @if($bidpast->status == 1)
                                            Accepted
                                            @else
                                            Winner
                                            @endif
                                            @elseif(session('locale') === 'ar')
                                            @if($bidpast->status == 1)
                                            قبلت
                                            @else
                                            Winner
                                            @endif
                                            @else
                                            @if($bidpast->status == 1)
                                            Accepted
                                            @else
                                            Winner
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

                </div>
                
            </div>

        </div>

</section>
<script>
const currentTab = document.getElementById('flexRadioDefault1');
const pastTab = document.getElementById('flexRadioDefault2');
const currentTabContent = document.getElementById('currentTabContent');
const pastTabContent = document.getElementById('pastTabContent');
document.addEventListener("DOMContentLoaded", function () {
        const pastTabContent = document.getElementById('pastTabContent');
        pastTabContent.style.display = 'none';
    });

currentTab.addEventListener('change', () => {
    if (currentTab.checked) {
        currentTabContent.style.display = 'block';
        pastTabContent.style.display = 'none';
    }
});

pastTab.addEventListener('change', () => {
    if (pastTab.checked) {
        pastTabContent.style.display = 'block';
        currentTabContent.style.display = 'none';
    }
});
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    // function requestBid(productId, projectId) {
    //     var csrfToken = "{{ csrf_token() }}";
    //     $.ajax({
    //         url: 'paynow',
    //         type: 'POST',
    //         data: {
    //             _token: csrfToken,
    //             product_id: productId,
    //             project_id: projectId
    //         },
    //         success: function(response) {
    //             alert('Payment Successful');
    //             window.location.reload();

    //         },
    //         error: function(error) {
    //             alert('Error occurred while processing payment');
    //         }
    //     });
    // }
</script>
@if(session('success'))
    <script>
        // Show SweetAlert success message popup
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route("auction") }}";
            }
        });
    </script>
@endif
@include('frontend.layouts.footer')
