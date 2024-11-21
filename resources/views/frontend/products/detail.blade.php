@include('frontend.layouts.header')
 <style>
        :root {
            --primary: #003452;
            --text-gray: #666;
            --bg-light: #fff;
            --transition: 0.3s ease;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.5;
        }

        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Gallery Styles */
        .gallery-section {
            position: relative;
            margin-bottom: 20px;
        }

        .main-image-container {
            width: 100%;
            background: var(--bg-light);
            margin-bottom: 15px;
            overflow: hidden;
        }

        .main-image {
            width: 100%;
            height: auto;
            object-fit: contain;
            background: var(--bg-light);
        }

        .thumbnails {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }

        .thumb {
            position: relative;
            cursor: pointer;
            background: var(--bg-light);
            overflow: hidden;
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumb.active {
            border: 2px solid var(--primary);
        }

        /* Product Info Styles */
        .product-title {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #000;
        }

        .product-subtitle {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .product-details p {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .product-code {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 20px;
        }

        .bid-section {
            margin-bottom: 20px;
        }

        .starting-bid {
            font-size: 14px;
            margin-bottom: 10px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .bid-amount {
            font-weight: bold;
        }

        .btn-bid {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        /* Share Section */
        .share-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 30px 0;
            padding: 20px 0;
            border-top: 1px solid #eee;
        }

        .share-text {
            font-size: 14px;
        }

        .share-icons {
            display: flex;
            gap: 15px;
        }

        .share-icons a {
            color: #666;
            text-decoration: none;
        }

        /* Info Links */
        .info-links {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 15px;
        }

        .info-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-gray);
            text-decoration: none;
            font-size: 14px;
        }

        .info-link i {
            font-size: 16px;
        }

        /* Description Section */
        .product-full-description {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .product-full-description h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #000;
        }

        .product-full-description p {
            color: var(--text-gray);
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .thumbnails {
                gap: 10px;
            }
        }
    </style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
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
                    <p>{{ session('locale') === 'en' ? 'Auction ending' : 'انتهاء المزاد' }} : {{ $product->auction_end_date }}</p>
                    <p>{{ session('locale') === 'en' ? 'Estimated Price Range' : 'النطاق السعري المقدر' }} : ${{ $product->start_price }} - ${{ $product->end_price }} </p>
                </div>

                <div class="product-code">
                    <p>{{ $product->year_range }}</p>
                    <p>{{ $product->reference_number }}</p>
                </div>

                <div class="bid-section">
                    <div class="starting-bid">
                        {{ session('locale') === 'en' ? 'STARTING BID' : 'بداية المزاد' }} <span class="bid-amount">${{ $product->start_price }}</span>
                    </div>
                    {{-- <a href="{{ route('login') }}" class="btn-bid">LOGIN TO BID</a> --}}
                    
                    {{-- <a class="btn-bid" data-bs-toggle="modal" data-bs-target="#LoginModal" >{{ session('locale') === 'en' ? 'LOGIN TO BID' : (session('locale') === 'ar' ? 'تسجيل الدخول' : 'Login') }}</a> --}}

                    @if(Auth::check())
                    <button  class="btn-bid" type="button" id="placeBidButton" data-bs-toggle="modal" data-bs-target="#myModal">
                        {{ session('locale') === 'en' ? 'Place Bid' : (session('locale') === 'ar' ? 'وضع مزايدة' : 'Place Bid') }}
                    </button>
                    @else
                    <a class="btn-bid" data-bs-toggle="modal" data-bs-target="#LoginModal">
                        {{ session('locale') === 'en' ? 'LOGIN TO BID' : (session('locale') === 'ar' ? 'تسجيل الدخول' : 'Login') }}
                    </a>
                    @endif

                </div>

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
    </script>








@include('frontend.layouts.footer')

@include('frontend.products.script.addToWishListScript')
