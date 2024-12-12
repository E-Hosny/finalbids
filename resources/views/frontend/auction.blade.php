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
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                @if(session('locale') === 'en')
                                    <label class="form-check-label" for="flexRadioDefault1">Current</label>
                                @elseif(session('locale') === 'ar')
                                    <label class="form-check-label" for="flexRadioDefault1">حالي</label>
                                @else
                                    <label class="form-check-label" for="flexRadioDefault1">Current</label>
                                @endif
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                @if(session('locale') === 'en')
                                    <label class="form-check-label" for="flexRadioDefault2">Past</label>
                                @elseif(session('locale') === 'ar')
                                    <label class="form-check-label" for="flexRadioDefault2">الماضي</label>
                                @else
                                    <label class="form-check-label" for="flexRadioDefault2">Past</label>
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
                            <div class="row align-items-top">
                                @foreach($groupedBids as $productId => $productBids)
                                    <div class="col-md-3 mt-3">
                                        <div class="item-img">
                                            @php
                                                $galleries = \App\Models\Gallery::where('product_id', $productBids->first()->product->id)->get();
                                            @endphp

                                            @if ($galleries->isNotEmpty())
                                                <a href="{{ url('productsdetail', $productBids->first()->product->slug) }}" class="prd-link">
                                                    <img src="{{ asset($galleries->first()->image_path) }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-9 mt-3">
                                        <div class="item-data">
                                            @if(session('locale') === 'en')
                                                <a href="{{ url('productsdetail', $productBids->first()->product->slug) }}" class="prd-link">
                                                    <h5>{{ $productBids->first()->product->lot_no }} : {{ $productBids->first()->product->title }}</h5>
                                                </a>
                                                <h6>
                                                    Est : {{ formatPrice($productBids->first()->product->start_price, session()->get('currency')) }} {{$currency}} -
                                                    {{ formatPrice($productBids->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                </h6>
                                            @elseif(session('locale') === 'ar')
                                                <h5>{{ $productBids->first()->product->lot_no }} : {{ $productBids->first()->product->title_ar }}</h5>
                                                <h6>
                                                    مؤسسه :  {{ formatPrice($productBids->first()->product->start_price, session()->get('currency')) }} {{$currency}} -
                                                    {{ formatPrice($productBids->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                </h6>
                                            @else
                                                <h5>{{ $productBids->first()->product->lot_no }} : {{ $productBids->first()->product->title }}</h5>
                                                <h6>
                                                    Est : {{ formatPrice($productBids->first()->product->start_price, session()->get('currency')) }} {{$currency}} -
                                                    {{ formatPrice($productBids->first()->product->end_price, session()->get('currency')) }} {{$currency}}
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

                                            <div id="collapse{{ $productId }}" class="accordion-collapse collapse"
                                                 aria-labelledby="heading{{ $productId }}"
                                                 data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="accor-table table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'عارض' : 'Bidder' }}</th>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'نوع المزاد' : 'Auction Type' }}</th>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'تاريخ/وقت المناقصة' : 'Bid Date/Time' }}</th>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'مبلغ' : 'Bidding Amount' }}</th>
                                                                    {{-- <th scope="col">{{ session('locale') === 'ar' ? 'المبلغ الإجمالي' : 'Total Amount' }}</th> --}}
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'حالة' : 'Status' }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($productBids as $bid)
                                                                    <tr>
                                                                        <td>{{ $bid->user->first_name }}</td>
                                                                        
                                                                        <td>{{ session('locale') === 'ar' ? $bid->product->project->auctionType->name_ar : $bid->product->project->auctionType->name }}</td>
                                                                        <td>{{ $bid->created_at }}</td>
                                                                        <td>{{ formatPrice($bid->bid_amount, session()->get('currency')) }} {{ $currency }}</td>
                                                                        {{-- <td>{{ formatPrice($bid->total_amount, session()->get('currency')) }} {{ $currency }}</td> --}}
                                                                        <td>
                                                                            @php
                                                                                $statusText = '';
                                                                                
                                                                                if($bid->status == 0) {
                                                                                    $statusText = session('locale') === 'ar' ? 'قيد الانتظار' : 'Pending';
                                                                                } elseif($bid->status == 1) {
                                                                                    $statusText = session('locale') === 'ar' ? 'مقبول' : 'Accepted';
                                                                                } elseif($bid->status == 2) {
                                                                                    $statusText = session('locale') === 'ar' ? 'مرفوض' : 'Rejected';
                                                                                } elseif($bid->status == 3) {
                                                                                    $statusText = session('locale') === 'ar' ? 'فائز' : 'Winner';
                                                                                } elseif($bid->status == 4) {
                                                                                    $statusText = session('locale') === 'ar' ? 'خاسر' : 'Lost';
                                                                                }
                                                                            @endphp
                                                                            {{ $statusText }}

                                                                            {{-- @if($bid->payment_status == 1)
                                                                                <!-- مدفوع -->
                                                                                <span class="text-success">{{ session('locale') === 'ar' ? 'مدفوع' : 'Paid' }}</span>
                                                                            @elseif($bid->status == 3 && $bid->user_id == auth()->id() && $bid->payment_status == 0)
                                                                                <!-- زر الدفع -->
                                                                                <form action="{{ route('pay.now') }}" method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    <input type="hidden" name="product_id" value="{{ $bid->product->id }}">
                                                                                    <input type="hidden" name="bid_place_id" value="{{ $bid->id }}">
                                                                                    <input type="hidden" name="price" value="{{ $bid->total_amount }}">
                                                                                    <button type="submit" class="rounded-pill btn btn-secondary testp">
                                                                                        {{ session('locale') === 'ar' ? 'ادفع الآن' : 'Pay Now' }}
                                                                                    </button>
                                                                                </form>
                                                                            @endif --}}
                                                                          @if($bid->payment_status == 'paid')
                                                                            <!-- مدفوع -->
                                                                            <span class="text-success">{{ session('locale') === 'ar' ? 'مدفوع' : 'Paid' }}</span>
                                                                        @elseif($bid->status == 3 && $bid->user_id == auth()->id() && $bid->payment_status == 'unpaid')
                                                                            <!-- زر الدفع -->
                                                                            <form action="{{ route('myfatoorah.pay') }}" method="POST" style="display:inline;">
                                                                                @csrf
                                                                                <input type="hidden" name="bid_place_id" value="{{ $bid->id }}">
                                                                                <button type="submit" class="rounded-pill btn btn-secondary testp">
                                                                                    {{ session('locale') === 'ar' ? 'ادفع الآن' : 'Pay Now' }}
                                                                                </button>
                                                                            </form>
                                                                            
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
                                    <div class="divide"></div>
                                @endforeach
                            </div>
                        </div>
                        <!-- محتويات العطاءات السابقة -->
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
                                                <a href="{{ url('productsdetail', $productBidspast->first()->product->slug) }}" class="prd-link">
                                                    <img src="{{ asset($galleriespast->first()->image_path) }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-9 mt-3">
                                        <div class="item-data">
                                            <a href="{{ url('productsdetail', $productBidspast->first()->product->slug) }}" class="prd-link">
                                                <h5>{{ $productBidspast->first()->product->lot_no }} :
                                                    @if(session('locale') === 'en')
                                                        {{ $productBidspast->first()->product->title }}
                                                    @elseif(session('locale') === 'ar')
                                                        {{ $productBidspast->first()->product->title_ar }}
                                                    @else
                                                        {{ $productBidspast->first()->product->title }}
                                                    @endif
                                                </h5>
                                            </a>
                                            <h6>
                                                @if(session('locale') === 'en')
                                                    Est : {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} -
                                                    {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                @elseif(session('locale') === 'ar')
                                                    مؤسسه :  {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} -
                                                    {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                @else
                                                    Est : {{ formatPrice($productBidspast->first()->product->start_price, session()->get('currency')) }} {{$currency}} -
                                                    {{ formatPrice($productBidspast->first()->product->end_price, session()->get('currency')) }} {{$currency}}
                                                @endif
                                            </h6>
                                            <strong>
                                                @if(session('locale') === 'en')
                                                    Sold :  @php 
                                                        $highestBidAmount = $productBidspast->max('bid_amount'); 
                                                        echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency; 
                                                    @endphp
                                                @elseif(session('locale') === 'ar')
                                                    مباع :  @php 
                                                        $highestBidAmount = $productBidspast->max('bid_amount'); 
                                                        echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency; 
                                                    @endphp
                                                @else
                                                    Sold :  @php 
                                                        $highestBidAmount = $productBidspast->max('bid_amount'); 
                                                        echo formatPrice($highestBidAmount, session()->get('currency')) . ' ' . $currency; 
                                                    @endphp
                                                @endif
                                            </strong>
                                            <strong>
                                                @if($productBidspast->where('user_id', auth()->id())->where('status', 2)->isNotEmpty())
                                                    <a href="{{ url('download-invoice') }}" class="btn btn-secondary rounded-pill download_invoice_btn">
                                                        Download Invoice
                                                    </a>
                                                @endif
                                            </strong>

                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading{{ $productIdpast }}">
                                                        @if(session('locale') === 'en')
                                                            <div class="accordion-button collapsed" type="button"
                                                                 data-bs-toggle="collapse"
                                                                 data-bs-target="#collapse{{ $productIdpast }}" aria-expanded="false"
                                                                 aria-controls="collapse{{ $productIdpast }}">
                                                                View Bid History
                                                            </div>
                                                        @elseif(session('locale') === 'ar')
                                                            <div class="accordion-button collapsed" type="button"
                                                                 data-bs-toggle="collapse"
                                                                 data-bs-target="#collapse{{ $productIdpast }}" aria-expanded="false"
                                                                 aria-controls="collapse{{ $productIdpast }}">
                                                                عرض سجل العطاءات
                                                            </div>
                                                        @else
                                                            <div class="accordion-button collapsed" type="button"
                                                                 data-bs-toggle="collapse"
                                                                 data-bs-target="#collapse{{ $productIdpast }}" aria-expanded="false"
                                                                 aria-controls="collapse{{ $productIdpast }}">
                                                                View Bid History
                                                            </div>
                                                        @endif
                                                    </h2>
                                                </div>
                                            </div>

                                            <div id="collapse{{ $productIdpast }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $productIdpast }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="accor-table table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'عارض' : 'Bidder' }}</th>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'نوع المزاد' : 'Auction Type' }}</th>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'تاريخ/وقت المناقصة' : 'Bid Date/Time' }}</th>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'مبلغ' : 'Bidding Amount' }}</th>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'المبلغ الإجمالي' : 'Total Amount' }}</th>
                                                                    <th scope="col">{{ session('locale') === 'ar' ? 'حالة' : 'Status' }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($productBidspast as $bidpast)
                                                                    <tr>
                                                                        <td>{{ $bidpast->user->first_name }}</td>
                                                                        <td>{{ session('locale') === 'ar' ? $bidpast->product->project->auctionType->name_ar : $bidpast->product->project->auctionType->name }}</td>
                                                                        <td>{{ $bidpast->created_at }}</td>
                                                                        <td>{{ formatPrice($bidpast->bid_amount, session()->get('currency')) }} {{ $currency }}</td>
                                                                        <td>{{ formatPrice($bidpast->total_amount, session()->get('currency')) }} {{ $currency }}</td>
                                                                        <td>
                                                                            @php
                                                                                $statusText = '';
                                                                                if($bidpast->status == 0) {
                                                                                    $statusText = session('locale') === 'ar' ? 'قيد الانتظار' : 'Pending';
                                                                                } elseif($bidpast->status == 1) {
                                                                                    $statusText = session('locale') === 'ar' ? 'مقبول' : 'Accepted';
                                                                                } elseif($bidpast->status == 2) {
                                                                                    $statusText = session('locale') === 'ar' ? 'مرفوض' : 'Rejected';
                                                                                } elseif($bidpast->status == 3) {
                                                                                    $statusText = session('locale') === 'ar' ? 'فائز' : 'Winner';
                                                                                } elseif($bidpast->status == 4) {
                                                                                    $statusText = session('locale') === 'ar' ? 'خاسر' : 'Lost';
                                                                                }
                                                                            @endphp
                                                                            {{ $statusText }}

                                                                            @if($bidpast->payment_status == 'paid')
                                                                                <!-- مدفوع -->
                                                                                <span class="text-success">{{ session('locale') === 'ar' ? 'مدفوع' : 'Paid' }}</span>
                                                                            @elseif($bidpast->status == 3 && $bidpast->user_id == auth()->id() && $bidpast->payment_status == 'unpaid')
                                                                                <!-- زر الدفع -->
                                                                                <form action="{{ route('myfatoorah.pay') }}" method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    <input type="hidden" name="product_id" value="{{ $bid->product->id }}">
                                                                                    <input type="hidden" name="price" value="{{ $bid->total_amount }}">
                                                                                    <button type="submit" class="rounded-pill btn btn-secondary testp">
                                                                                        {{ session('locale') === 'ar' ? 'ادفع الآن' : 'Pay Now' }}
                                                                                    </button>
                                                                                </form>
                                                                                
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
                                    <div class="divide"></div>
                                @endforeach
                            </div>
                        </div>
                        <!-- نهاية محتويات العطاءات السابقة -->
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
    // يمكنك إزالة هذا الكود إذا لم تعد بحاجة إليه
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
        // عرض رسالة نجاح باستخدام SweetAlert
        Swal.fire({
            icon: 'success',
            title: '{{ session('locale') === 'ar' ? 'نجاح' : 'Success' }}',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: '{{ session('locale') === 'ar' ? 'موافق' : 'OK' }}'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('auction') }}";
            }
        });


        $.ajax({
    url: '/pay-now/' + bidId, // مرر bidId هنا
    type: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        product_id: productId,
        price: totalAmount,
    },
    success: function (response) {
        console.log(response);
    },
    error: function (error) {
        console.error(error);
    }
});

    </script>
@endif
@include('frontend.layouts.footer')
