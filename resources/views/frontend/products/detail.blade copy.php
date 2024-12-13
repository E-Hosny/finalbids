
<body>
    @if($product)
    @php
        $currentDateTime = now();
        $endDateTime = $product->project->end_date_time;
        $isClosed = $currentDateTime > $endDateTime;

        // تم تحديد ما إذا كان المنتج قد تم بيعه في الـ Controller
        $currency = session()->get('currency');
    @endphp

        <div class="product-container">
            <div class="row">
                <!-- Gallery Section -->
                <div class="col-md-6">
                    <div class="gallery-section">
                        <div class="main-image-container">
                            @if($product->productGalleries && $product->productGalleries->isNotEmpty())
                                <img src="{{ asset($product->productGalleries->first()->image_path) }}" alt="{{ $product->title }}" class="main-image" id="mainImage">
                            @else
                                <img src="https://placehold.co/800x600" alt="No image available" class="main-image" id="mainImage">
                            @endif
                        </div>

                        <div class="thumbnails">
                            @if($product->productGalleries && $product->productGalleries->isNotEmpty())
                                @foreach($product->productGalleries as $index => $image)
                                    <div class="thumb {{ $loop->first ? 'active' : '' }}" onclick="showSlide({{ $loop->index }})">
                                        <img src="{{ asset($image->image_path) }}" alt="Thumbnail {{ $loop->iteration }}">
                                    </div>
                                @endforeach
                            @else
                                <div class="thumb">
                                    <img src="https://placehold.co/800x600" alt="No Thumbnail Available">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Info Section -->
                <div class="col-md-6">
                    <h1 class="product-title">{{ session('locale') === 'en' ? $product->title : $product->title_ar }}</h1>

                    <p class="product-subtitle">{{ $product->subtitle }}</p>

                    <div class="product-description">
                        <p>{{ session('locale') === 'en' ? 'Description' : 'الوصف' }}: <span class="bid-amount">{!! strip_tags(session('locale') === 'en' ? $product->description : $product->description_ar) !!}</span></p>
                        <p>{{ session('locale') === 'en' ? 'Auction ending' : 'انتهاء المزاد' }} : {{ $product->project->end_date_time }}</p>
                        <p>{{ session('locale') === 'en' ? 'Estimated Price Range' : 'النطاق السعري المقدر' }} : ${{ $product->start_price }} - ${{ $product->end_price }}</p>
                    </div>

    <!-- قسم المزايدة -->
    @if(!$isClosed)
        <!-- المزاد مفتوح -->
        <div class="bid-section">
            <!-- عرض أعلى مزايدة مقبولة أو السعر الابتدائي -->
            <div class="starting-bid">
                <strong>{{ session('locale') === 'en' ? 'Highest Bid' : 'أعلى مزايدة' }}:</strong>
                <span class="bid-amount">
                    @if($highestBidAmount > $product->start_price)
                        {{ formatPrice($highestBidAmount, $currency) }} {{ $currency }}
                    @else
                        {{ formatPrice($product->start_price, $currency) }} {{ $currency }}
                    @endif
                </span>
            </div>

            @if(Auth::check())
                <!-- نموذج تقديم المزايدة -->
                <form id="bidForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="project_id" value="{{ $product->project->id }}">
                    <input type="hidden" name="auction_type_id" value="{{ $product->auction_type_id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="form-group">
                        <label for="bidValue">{{ session('locale') === 'en' ? 'Enter Your Bid' : 'أدخل قيمة المزايدة' }}:</label>
                        <select name="bid_amount" id="bidValue" class="form-control">
                            @foreach ($calculatedBids as $bidValue)
                                @if($bidValue->cal_amount > ($highestBidAmount ?? $product->start_price))
                                    <option value="{{ $bidValue->cal_amount }}">
                                        {{ formatPrice($bidValue->cal_amount, $currency) }} {{ $currency }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <button type="button" class="btn-bid" id="placeBidButton">
                        {{ session('locale') === 'en' ? 'Place Bid' : 'وضع مزايدة' }}
                    </button>
                </form>
            @else
                <a class="btn-bid" data-bs-toggle="modal" data-bs-target="#LoginModal">
                    {{ session('locale') === 'en' ? 'LOGIN TO BID' : 'تسجيل الدخول للمزايدة' }}
                </a>
            @endif
        </div>
    @else
        <!-- المزاد مغلق -->
        <div class="bid-section">
            @if($isSold)
                <div class="starting-bid">
                    <strong>{{ session('locale') === 'en' ? 'Sale Price' : 'سعر البيع' }}:</strong>
                    <span class="bid-amount">
                        {{ formatPrice($highestBidAmount, $currency) }} {{ $currency }}
                    </span>
                </div>
            @else
                <p style="color: red;">
                    {{ session('locale') === 'en' ? 'This lot is closed and was not sold.' : 'هذا المنتج مغلق ولم يتم بيعه.' }}
                </p>
            @endif

            <!-- عرض تاريخ المزايدات المقبولة -->
            @if($acceptedBids->isNotEmpty())
                <div class="bid-history mt-4">
                    <h4>{{ session('locale') === 'en' ? 'Bid History' : 'تاريخ المزايدات' }}</h4>
                    <div class="bid-list">
                        @foreach($acceptedBids as $bid)
                            <div class="bid-item">
                                <span class="bid-amount">
                                    {{ formatPrice($bid->bid_amount, $currency) }} {{ $currency }}
                                </span>
                                <span class="bid-date">
                                    {{ $bid->created_at->format('Y-m-d H:i') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif

                    <div class="share-section">
                        <span class="share-text">{{ session('locale') === 'en' ? 'Share' : 'مشاركة' }}</span>
                        <div class="share-icons">
                            <a href="#"><i class="fa fa-share-alt fa-lg"></i></a>
                            <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                            <a href="#"><i class="fa fa-instagram fa-lg"></i></a>
                            <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                        </div>
                    </div>

                    <div class="info-links">
                        <a href="#" class="info-link">
                            <i class="fa fa-question-circle"></i> {{ session('locale') === 'en' ? 'How to bid' : 'كيف تقديم المزاد' }}
                        </a>
                        <a href="#" class="info-link">
                            <i class="fa fa-file-text"></i> {{ session('locale') === 'en' ? 'Request condition report' : 'طلب تقرير الحالة' }}
                        </a>
                        <a href="#" class="info-link">
                            <i class="fa fa-eye"></i> {{ session('locale') === 'en' ? 'Auction Viewings' : 'مشاهدات المزاد' }}
                        </a>
                        <a href="#" class="info-link">
                            <i class="fa fa-info-circle"></i> {{ session('locale') === 'en' ? 'How to buy' : 'كيفية الشراء' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>{{ session('locale') === 'en' ? 'Product not found.' : 'المنتج غير موجود.' }}</p>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.thumb img');
        const thumbs = document.querySelectorAll('.thumb');
        const mainImage = document.getElementById('mainImage');

        function showSlide(index) {
            thumbs.forEach(thumb => thumb.classList.remove('active'));
            thumbs[index].classList.add('active');
            mainImage.src = slides[index].src;
            currentSlide = index;
        }

        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 5000);

        var placeBidButton = document.getElementById('placeBidButton');
        if (placeBidButton) {
            placeBidButton.addEventListener('click', function() {
                const bidValue = document.getElementById('bidValue').value;
                const projectId = '{{ $product->project->id }}';
                const auctionTypeId = '{{ $product->auction_type_id }}';
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
                    window.location.href = '{{ route("checkout") }}?bid_placed_id=' + bidPlacedId + '&product_id=' + productId;
                })
                .catch(function(error) {
                    console.error(error);
                    let errorMessage = 'Something went wrong!';
                    if (error.response && error.response.data && error.response.data.message) {
                        errorMessage = error.response.data.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage,
                    });
                });
            });
        }
    </script>

@include('frontend.layouts.footer')
@include('frontend.products.script.addToWishListScript')
