@include('frontend.layouts.header')


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

<style>
    * {
        text-decoration: none !important,
    }

    .accordion {
        /* background-color: #eee; */
        /* color: #444; */
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }


    .accordion-button {
        background-color: transparent !important;
        /* جعل الخلفية شفافة */
        border: none !important;
        /* إزالة الحدود */
        color: #000;
        /* اختيار لون النص، يمكنك تغييره حسب الحاجة */
    }

    .accordion-button:not(.collapsed) {
        background-color: transparent !important;
        /* إزالة الخلفية عند الضغط */
        color: #0D3858;
        /* يمكنك تغيير اللون هنا */
    }


    .active,
    .accordion:hover {
        /* background-color: #ccc; */
    }

    .panel {
        padding: 0 18px;
        display: none;
        background-color: white;
        overflow: hidden;
    }
</style>

<style>
    img {
        max-width: 100%;
    }

    .preview {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    @media screen and (max-width: 996px) {
        .preview {
            margin-bottom: 20px;
        }
    }

    .preview-pic {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }

    .preview-thumbnail.nav-tabs {
        border: none;
        margin-top: 15px;
        width: 170%;
    }

    .accordion-button::after {
        display: none;
        /* إخفاء السهم الافتراضي */
    }




    .accordion-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-icon {
        margin-left: auto;
        font-size: 1.5em;
        color: #000;
    }

    .custom-bg-white {
        background-color: white !important;
        padding: 10px;
    }


    .preview-thumbnail.nav-tabs li {
        width: 18%;
        margin-right: 2.5%;
    }

    .preview-thumbnail.nav-tabs li img {
        max-width: 100%;
        display: block;
    }



    .col-md-12 {
        background-color: white !important;
    }


    .preview-thumbnail.nav-tabs li a {
        padding: 0;
        margin: 0;
    }

    .preview-thumbnail.nav-tabs li:last-of-type {
        margin-right: 0;
    }

    .tab-content {
        overflow: hidden;
    }

    .tab-content img {
        width: 100%;
        -webkit-animation-name: opacity;
        animation-name: opacity;
        -webkit-animation-duration: .3s;
        animation-duration: .3s;
    }

    .card {
        margin-top: 50px;
        /* background: #eee;
  padding: 3em; */
        line-height: 1.5em;
    }

    @media screen and (min-width: 997px) {
        .wrapper {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }
    }

    .details {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .colors {
        -webkit-box-flex: 1;
        -webkit-flex-grow: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
    }

    .product-title,
    .price,
    .sizes,
    .colors {
        text-transform: capitalize;
        font-weight: 500;
    }

    .checked,
    .price span {
        color: ;
    }

    .product-title,
    .rating,
    .product-description,
    .price,
    .vote,
    .sizes {
        margin-bottom: 15px;
    }

    .product-title {
        margin-top: 0;
    }

    .size {
        margin-right: 10px;
    }

    .size:first-of-type {
        margin-left: 40px;
    }

    .color {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        height: 2em;
        width: 2em;
        border-radius: 2px;
    }

    .color:first-of-type {
        margin-left: 20px;
    }

    .add-to-cart,
    .like {
        background: #ff9f1a;
        padding: 1.2em 1.5em;
        border: none;
        text-transform: UPPERCASE;
        font-weight: bold;
        color: #fff;
        -webkit-transition: background .3s ease;
        transition: background .3s ease;
    }

    .add-to-cart:hover,
    .like:hover {
        background: #b36800;
        color: #fff;
    }

    .not-available {
        text-align: center;
        line-height: 2em;
    }

    .not-available:before {
        font-family: fontawesome;
        content: "\f00d";
        color: #fff;
    }

    .orange {
        background: #ff9f1a;
    }

    .green {
        background: #85ad00;
    }

    .blue {
        background: #0076ad;
    }

    .tooltip-inner {
        padding: 1.3em;
    }

    @-webkit-keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes opacity {
        0% {
            opacity: 0;
            -webkit-transform: scale(3);
            transform: scale(3);
        }

        100% {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }
</style>

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
        background: #3e0269;
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
    * {
        box-sizing: border-box;
    }

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

    /* .img-zoom-result {
  border: 1px solid #d4d4d4;
  /*set the size of the result div:*/
    /* width: 768px; */
    /* height: 600px; */
    /* } */
    .product-imgs .xzoom-container img {
        max-height: 750px !important;
        width: auto !important;
        max-width: 100% !important;
        margin: 0 auto;
    }

    .bid-and-time {
        position: relative;
    }

    /* .img-zoom-result {
    border: 1px solid #d4d4d4;
    width: 100%;
    height: 524px;
    position: absolute;
    top: 0;
    left: 0;
} */
    .enter_live {
        background-color: red;
    }


    .dark-icon {
        filter: grayscale(100%);
        transition: filter 0.3s;
    }

    .dark-icon:hover {
        filter: grayscale(0%);
    }
</style>
{{-- <link rel="stylesheet" media="screen" href="https://unpkg.com/xzoom/dist/xzoom.css" id="cm-theme" /> --}}

<section class="prty-sect">
    <div class="container">
        <div class="row ">
            <div class=" ">
                <p class="m-0">
                    <a href="{{ url('/') }}">
                        {{ session('locale') === 'en' ? 'Home' : (session('locale') === 'ar' ? 'الرئيسية' : 'Home') }}
                        /</a>
                    {{ session('locale') === 'en' ? $product->auctionType->name : (session('locale') === 'ar' ? $product->auctionType->name_ar : $product->auctionType->name) }}
                    /
                    {{ session('locale') === 'en' ? $product->project->name : (session('locale') === 'ar' ? $product->project->name_ar : $product->project->name) }}
                </p>

            </div>
        </div>
    </div>
</section>

<section class="detail-section">
    <div class="container">
        <div class="row">
            {{-- @if (session('locale') === 'en')
            <h3>{{$product->lot_no}} : {{$product->title}}</h3>
            @elseif(session('locale') === 'ar')
            <h3>{{$product->lot_no}} : {{$product->title_ar}}</h3>
            @else
            <h3>{{$product->lot_no}} : {{$product->title}}</h3>
            @endif --}}


            <div class="col-md-12">
                <!-- <div class="product-imgs mt-4">
                @auth
                                                                                                                                            <div class="heat-like wishlist-heart @if (in_array($product->id, $wishlist)) active @endif"
                                                                                                                                                data-product-id="{{ $product->id }}">
                                                                                                                                                <input type="checkbox" name="" id="" @if (in_array($product->id, $wishlist)) checked @endif>
                                                                                                                                                <img src="{{ asset('frontend/images/heart.png') }}" alt="">
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

                <div class="row">
                    <div class="wrapper preview col-md-6">
                        <div class="">
                            <!-- Full-Width Preview Images -->
                            <div class="preview-pic tab-content">
                                @foreach ($galleries as $key => $gallery)
                                    <div class="tab-pane {{ $key == 0 ? 'active' : '' }}"
                                        id="pic-{{ $key + 1 }}">
                                        <img src="{{ asset($gallery->image_path) }}" class="img-fluid" />
                                    </div>
                                @endforeach
                            </div>

                            <!-- Thumbnail Navigation -->
                            <ul class="preview-thumbnail nav nav-tabs"
                                style="{{ session('locale') == 'ar' ? 'position: relative; left: 68px;' : '' }}">
                                @foreach ($galleries as $key => $gallery)
                                    <li class="{{ $key == 0 ? 'active' : '' }}"
                                        style="width: 18%; {{ session('locale') == 'ar' ? 'margin-left: 2.5%;' : 'margin-right: 2.5%;' }}">
                                        <a data-target="#pic-{{ $key + 1 }}" data-toggle="tab">
                                            <img src="{{ asset($gallery->image_path) }}" />
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>


                    <div class="details col-md-6">
                        <h1 class="product-title">
                            {{ session('locale') == 'ar' ? $product->title_ar : $product->title }}
                        </h1>

                        <h4 class="price" style="font-weight:600">
                            {!! session('locale') == 'ar' ? $product->description_ar : $product->description !!}
                        </h4>
                        <h3 class="product-description">
                            {{ session('locale') == 'ar' ? $product->auctiontype->name_ar : $product->auctiontype->name }}
                        </h3>

                        <h4 class="price">
                            <span>{{ $product->reserved_price }}$</span>
                        </h4>

                        <h4 class="price">
                            <span style="color: #82828b;">
                                EGP{{ $product->start_price }} - EGP{{ $product->end_price }}
                            </span>
                        </h4>

                        <p class="vote" style="color: #0D3858; font-size: 1.5em;">
                            {{ session('locale') == 'ar' ? 'الحد الأدنى للمزايدة' : 'STARTING BID' }}
                            <strong
                                style="margin-left: 30px; color: #0D3858;">${{ $product->minsellingprice }}</strong>
                            <!-- زيادة المسافة -->
                        </p>

                        <a style="width: 163px!important; text-align: center; position: relative; top: 30px; background-color: #0D3858; color: #fff;"
                            class="btn btn-secondary px-5 w-25 d-flex justify-content-center"
                            href="{{ route('signin') }}">
                            {{ session('locale') == 'ar' ? 'تسجيل الدخول' : 'LOGIN TO bID' }}
                        </a>

                        <div class="row" style="margin-top: 40px;"> <!-- Adjusted margin-top -->
                            <div class="social-icons"
                                style="display: flex; align-items: center; margin-top: 20px; position: relative; top: 20px;">
                                <!-- Increased top value -->
                                <a href="https://example.com/share" class="mr-3" title="Share"
                                    style="margin-right: 15px; text-decoration: none; display: flex; align-items: center;">
                                    <i style="color: #000; font-size: 1.5em; margin-right: 5px;"
                                        class="fa fa-share-square-o"></i>
                                    <span style="color: #000;">Share</span>
                                </a>
                                <a href="https://facebook.com" class="mr-3" title="Facebook"
                                    style="margin-right: 15px; text-decoration: none; display: flex; align-items: center;">
                                    <i style="color: #000; font-size: 1.5em; margin-right: 5px;"
                                        class="fa fa-facebook-square"></i>
                                </a>
                                <a href="https://instagram.com" class="mr-3" title="Instagram"
                                    style="margin-right: 15px; text-decoration: none; display: flex; align-items: center;">
                                    <i style="color: #000; font-size: 1.5em; margin-right: 5px;"
                                        class="fa fa-instagram"></i>
                                </a>
                                <a href="https://X.com" title="X"
                                    style="margin-right: 15px; text-decoration: none; display: flex; align-items: center;">
                                    <i style="color: #000; font-size: 1.5em; margin-right: 5px;"
                                        class="fa fa-twitter"></i>
                                </a>
                            </div>

                            <hr style="margin-top: 35px!important;">

                            <!-- Sentences with Icons -->
                            <div class="row" style="margin-top: 10px;"> <!-- Adjusted margin-top -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i style="color: #000; padding: 0 5px 0 0; font-size: 20px"
                                            class="fa fa-question-circle-o mr-2"></i>
                                        <span>{{ session('locale') == 'ar' ? 'كيف تزايد' : 'How to bid' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i style="color: #000; padding: 0 5px 0 0; font-size: 20px"
                                            class="fa fa-eye mr-2"></i>
                                        <span>{{ session('locale') == 'ar' ? 'مشاهدة المزاد' : 'Auction Viewings' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <i style="color: #000; padding: 0 5px 0 0; font-size: 20px"
                                            class="fa fa-user-plus mr-2"></i>
                                        <span>{{ session('locale') == 'ar' ? 'طلب تقرير الحالة' : 'Request condition report' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i style="color: #000; padding: 0 5px 0 0; font-size: 20px"
                                            class="fa fa-shopping-bag mr-2"></i>
                                        <span>{{ session('locale') == 'ar' ? 'كيف تشتري' : 'How to buy' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h3 class="{{ session('locale') == 'ar' ? 'text-end' : 'text-start' }}">
                                {{ session('locale') == 'ar' ? 'تمثال برونزي مزخرف' : 'Art decorat bronze sculpture' }}
                            </h3>

                            <p class="mt-3">
                                Bronze sculptures are a common feature in art decor, known for their timeless beauty,
                                durability, and intricate detail. Bronze is an alloy primarily consisting of copper,
                                often
                                combined with tin, which gives sculptures a warm, reddish-brown hue that ages
                                beautifully,
                                developing a natural patina over time.
                            </p>

                            <p class="mt-3">
                                In terms of style, bronze sculptures have been a part of various movements:
                            </p>
                            <p>Art Deco: Characterized by geometric shapes, clean lines, and a sleek, modern feel, often
                                featuring stylized human figures, animals, or abstract forms. <br>
                            <p>Classical: Inspired by ancient Greek and Roman art, featuring realistic depictions of the
                                human form or mythological figures. <br>
                            <p>Modern and Abstract: Featuring more fluid, minimalist, or experimental forms.
                            <p class="mt-3">
                                Bronze is often used in outdoor art decor for gardens, parks, or monumental statues due
                                to
                                its
                                resistance to weathering. Indoors, smaller bronze sculptures serve as striking decor
                                pieces,
                                adding a sense of elegance and history to a space.
                            </p>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h3 class="{{ session('locale') == 'ar' ? 'text-end' : 'text-start' }}">
                                {{ session('locale') == 'ar' ? 'تمثال برونزي مزخرف' : 'Art decorat bronze sculpture' }}
                            </h3>

                            <p class="mt-3">
                                Bronze sculptures are a common feature in art decor, known for their timeless beauty,
                                durability, and intricate detail. Bronze is an alloy primarily consisting of copper,
                                often
                                combined with tin, which gives sculptures a warm, reddish-brown hue that ages
                                beautifully,
                                developing a natural patina over time.
                            </p>

                            <p class="mt-3">
                                In terms of style, bronze sculptures have been a part of various movements:
                            </p>
                            <p>Art Deco: Characterized by geometric shapes, clean lines, and a sleek, modern feel, often
                                featuring stylized human figures, animals, or abstract forms. <br>
                            <p>Classical: Inspired by ancient Greek and Roman art, featuring realistic depictions of the
                                human form or mythological figures. <br>
                            <p>Modern and Abstract: Featuring more fluid, minimalist, or experimental forms.
                            <p class="mt-3">
                                Bronze is often used in outdoor art decor for gardens, parks, or monumental statues due
                                to
                                its
                                resistance to weathering. Indoors, smaller bronze sculptures serve as striking decor
                                pieces,
                                adding a sense of elegance and history to a space.
                            </p>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h3 class="{{ session('locale') == 'ar' ? 'text-end' : 'text-start' }}">
                                {{ session('locale') == 'ar' ? 'معلومات إضافية' : 'Additional information' }}
                            </h3>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Auction information
                                        <span class="accordion-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by
                                        default,
                                        until the collapse plugin adds the appropriate classes that we use to style each
                                        element. These classes control the overall appearance, as well as the showing
                                        and hiding
                                        via CSS transitions. You can modify any of this with custom CSS or overriding
                                        our
                                        default variables. It's also worth noting that just about any HTML can go within
                                        the
                                        <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Accordion Item #2
                                        <span class="accordion-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the second item's accordion body.</strong> It is hidden by
                                        default, until the collapse plugin adds the appropriate classes that we use to
                                        style each
                                        element. These classes control the overall appearance, as well as the showing
                                        and hiding via CSS transitions. You can modify any of this with custom CSS or
                                        overriding
                                        our default variables. It's also worth noting that just about any HTML can go
                                        within
                                        the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        Accordion Item #3
                                        <span class="accordion-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the third item's accordion body.</strong> It is hidden by
                                        default, until the collapse plugin adds the appropriate classes that we use to
                                        style each
                                        element. These classes control the overall appearance, as well as the showing
                                        and hiding
                                        via CSS transitions. You can modify any of this with custom CSS or overriding
                                        our default variables. It's also worth noting that just about any HTML can go
                                        within
                                        the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h3 class="{{ session('locale') == 'ar' ? 'text-end' : 'text-start' }}">
                                {{ session('locale') == 'ar' ? 'المزيد من القطع من هذا المزاد' : 'More lots from this auction' }}
                            </h3>

                        </div>
                        <div class="row">
                            <!-- Card 1 -->
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ url('frontend/product.png') }}" class="card-img-top"
                                        alt="Product 1">
                                    <div class="card-body">
                                        <h5 class="card-title">Product Title 1</h5>
                                        <p class="card-text">Short description of product 1. Lorem
                                            ipsum dolor sit amet.
                                        </p>
                                        <p class="small">Additional details about product 1.</p>
                                        <h3 class="px-2">150$ - 200$</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ url('frontend/product.png') }}" class="card-img-top"
                                        alt="Product 2">
                                    <div class="card-body">
                                        <h5 class="card-title">Product Title 2</h5>
                                        <p class="card-text">Short description of product 2. Lorem
                                            ipsum dolor sit amet.
                                        </p>
                                        <p class="small">Additional details about product 2.</p>
                                        <h3 class="px-2">150$ - 200$</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ url('frontend/product.png') }}" class="card-img-top"
                                        alt="Product 3">
                                    <div class="card-body">
                                        <h5 class="card-title">Product Title 3</h5>
                                        <p class="card-text">Short description of product 3. Lorem
                                            ipsum dolor sit amet.
                                        </p>
                                        <p class="small">Additional details about product 3.</p>
                                        <h3 class="px-2">150$ - 200$</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4 -->
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ url('frontend/product.png') }}" class="card-img-top"
                                        alt="Product 4">
                                    <div class="card-body">
                                        <h5 class="card-title">Product Title 4</h5>
                                        <p class="card-text">Short description of product 4. Lorem
                                            ipsum dolor sit amet.
                                        </p>
                                        <p class="small">Additional details about product 4.</p>
                                        <h3 class="px-2">150$ - 200$</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ url('frontend/product.png') }}" class="card-img-top"
                                        alt="Product 4">
                                    <div class="card-body">
                                        <h5 class="card-title">Product Title 4</h5>
                                        <p class="card-text">Short description of product 4. Lorem
                                            ipsum dolor sit amet.
                                        </p>
                                        <p class="small">Additional details about product 4.</p>
                                        <h3 class="px-2">150$ - 200$</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ url('frontend/product.png') }}" class="card-img-top"
                                        alt="Product 4">
                                    <div class="card-body">
                                        <h5 class="card-title">Product Title 4</h5>
                                        <p class="card-text">Short description of product 4. Lorem
                                            ipsum dolor sit amet.
                                        </p>
                                        <p class="small">Additional details about product 4.</p>
                                        <h3 class="px-2">150$ - 200$</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ url('frontend/product.png') }}" class="card-img-top"
                                        alt="Product 4">
                                    <div class="card-body">
                                        <h5 class="card-title">Product Title 4</h5>
                                        <p class="card-text">Short description of product 4. Lorem
                                            ipsum dolor sit amet.
                                        </p>
                                        <p class="small">Additional details about product 4.</p>
                                        <h3 class="px-2">150$ - 200$</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ url('frontend/product.png') }}" class="card-img-top"
                                        alt="Product 4">
                                    <div class="card-body">
                                        <h5 class="card-title">Product Title 4</h5>
                                        <p class="card-text">Short description of product 4. Lorem
                                            ipsum dolor sit amet.
                                        </p>
                                        <p class="small">Additional details about product 4.</p>
                                        <h3 class="px-2">150$ - 200$</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- @php
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

            @endphp --}}

                    {{-- <div class="col-md-6">
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
            </div> --}}


                    {{-- @php
            $currentTime = now()->timestamp;
              $auctionEndTime = strtotime($product->auction_end_date);
            @endphp --}}

                    {{-- <div class="bid-now-container">
                <div class="product-feature-box">
                    @if ($bidPlacedId)
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
                        @if (($product->project->auctionType->name == 'Timed' && $currentDateTime > $enddatetime) || ($product->project->auctionType->name == 'Timed' && $currentDateTime > $product->auction_end_date))
                            <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق القطعة' : 'Lot Closed') }}</button>

                        @else
                                        @if ($product->project->auctionType->name == 'Timed')
                                        @if ($auctionEndTime <= $currentDateTime)

                                            @if ($product->auction_end_date >= $formattedDateTime)

                                            <p>{{ session('locale') === 'en' ? 'Set Max Bid:' : (session('locale') === 'ar' ? 'تعيين أقصى مزايدة:
                                                ' : 'Set Max Bid:') }}</p>

                                            <form action="" class="news-letter" id="bidForm">
                                                <div class="form-group">
                                                    <select id="bidValuecal">
                                                        @foreach ($calculatedBids as $bidValue)
                                                        @if ($bidValue->cal_amount > $lastBidAmount)
                                                        <option value="{{ $bidValue->cal_amount }}" @if (isset($closestBid) && $closestBid->id === $bidValue->id) selected @endif>
                                                            {{ formatPrice($bidValue->cal_amount, session()->get('currency')) }} {{$currency}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>

                                                    @if (Auth::check())
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
                @if (($product->project->auctionType->name == 'Private' && $currentDateTime > $enddatetime) || ($product->project->auctionType->name == 'Private' && $currentDateTime > $product->auction_end_date))
                    <button class="text-btn" style="color: red;" >{{ session('locale') === 'en' ? 'Lot Closed' : (session('locale') === 'ar' ? 'تم إغلاق الدفعة' : 'Lot Closed') }}</button>
                @else
                        @if ($product->project->auctionType->name == 'Private')
                            @if ($auctionEndTime <= $currentDateTime)
                            @if ($bidRequest && $bidRequest->status == 1)
                                @if ($product->auction_end_date >= $formattedDateTime)

                                <p>{{ session('locale') === 'en' ? 'Set Max Bid:' : (session('locale') === 'ar' ? 'تعيين الحد الأقصى لعرض السعر:
                                    ' : 'Set Max Bid:') }}</p>

                                <form action="" class="news-letter" id="bidForm">
                                    <div class="form-group">
                                        <select id="bidValuecal">
                                            @foreach ($calculatedBids as $bidValue)
                                            @if ($bidValue->cal_amount > $lastBidAmount)
                                            <option value="{{ $bidValue->cal_amount }}" @if (isset($closestBid) && $closestBid->id === $bidValue->id) selected @endif>
                                                {{ formatPrice($bidValue->cal_amount, session()->get('currency')) }} {{$currency}}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>

                                        @if (Auth::check())
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
                                                    @if ($bidRequest && $bidRequest->status == 1)
                                                        <p>{{ session('locale') === 'en' ? 'Set Max Bid:' : (session('locale') === 'ar' ? 'تعيين أقصى مزايدة:' : 'Set Max Bid:') }}</p>


                                                        <form action="" class="news-letter" id="bidForm">
                                                            <div class="form-group">
                                                                <select id="bidValuecal">
                                                                    @foreach ($calculatedBids as $bidValue)
                                                                        @if ($bidValue->cal_amount > $lastBidAmount)
                                                                            <option value="{{ $bidValue->cal_amount }}" @if (isset($closestBid) && $closestBid->id === $bidValue->id) selected @endif>
                                                                                {{ formatPrice($bidValue->cal_amount, session()->get('currency')) }} {{$currency}}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>

                                                                @if (Auth::check())
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
            </div> --}}

                    {{-- details --}}
                    {{-- <div class="product-feature-box">
                @if (session('locale') === 'en')
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
                    @if (session('locale') === 'en')
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
            </div> --}}

                    {{-- <div class="product-feature-box">
                <h4>{{ session('locale') === 'en' ? 'Share Now' : (session('locale') === 'ar' ? 'المشاركة الان' : 'Share Now') }}</h4>

                <ul class="social-link mt-4">
                    <!-- Share Icon -->
                    <li>
                        <a href="#">
                            <img class="dark-icon" src="{{ asset('frontend/images/share.svg') }}" alt="Share">
                        </a>
                    </li>

                    <!-- Social Media Icons -->
                    <li>
                        <a href="https://www.facebook.com/login/">
                            <img class="dark-icon" src="{{ asset('frontend/images/facebook.svg') }}" alt="Facebook">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/accounts/login/?hl=en">
                            <img class="dark-icon" src="{{ asset('frontend/images/instagram.svg') }}" alt="Instagram">
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/i/flow/login">
                            <img class="dark-icon" src="{{ asset('frontend/images/twitt.png') }}" alt="Twitter">
                        </a>
                    </li>
                </ul>
            </div> --}}



                </div>
            </div>
        </div>

</section>

<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script> --}}
<script src="{{ asset('frontend/js/bootstrap.js') }}"></script>
<script src="{{ asset('frontend/js/slick.min.js') }}"></script>
<!-- <script src="{{ asset('frontend/js/main.js') }}"></script> -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script> --}}

{{-- <script>
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
</script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}

{{-- <script>
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
</script> --}}


{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" /> --}}


@include('frontend.layouts.footer')
<!-- <script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomWidth: 400,
                title: true,
                tint: '#333',
                Xoffset: 15
            });
            $('.xzoom2, .xzoom-gallery2').xzoom({
                position: '#xzoom2-id',
                tint: '#ffa200'
            });
            $('.xzoom3, .xzoom-gallery3').xzoom({
                position: 'lens',
                lensShape: 'circle',
                sourceClass: 'xzoom-hidden'
            });
            $('.xzoom4, .xzoom-gallery4').xzoom({
                tint: '#006699',
                Xoffset: 15
            });
            $('.xzoom5, .xzoom-gallery5').xzoom({
                tint: '#006699',
                Xoffset: 15
            });

            //Integration with hammer.js
            var isTouchSupported = 'ontouchstart' in window;

            if (isTouchSupported) {
                //If touch device
                $('.xzoom, .xzoom2, .xzoom3, .xzoom4, .xzoom5').each(function() {
                    var xzoom = $(this).data('xzoom');
                    xzoom.eventunbind();
                });

                $('.xzoom, .xzoom2, .xzoom3').each(function() {
                    var xzoom = $(this).data('xzoom');
                    $(this).hammer().on("tap", function(event) {
                        event.pageX = event.gesture.center.pageX;
                        event.pageY = event.gesture.center.pageY;
                        var s = 1,
                            ls;

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
                        var s = 1,
                            ls;

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
                                if (counter == 1) setTimeout(openfancy, 300);
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
                        var s = 1,
                            ls;

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
                                if (counter == 1) setTimeout(openmagnific, 300);
                                event.gesture.preventDefault();
                            });
                        }

                        function openmagnific() {
                            if (counter == 2) {
                                xzoom.closezoom();
                                var gallery = xzoom.gallery().cgallery;
                                var i, images = new Array();
                                for (i in gallery) {
                                    images[i] = {
                                        src: gallery[i]
                                    };
                                }
                                $.magnificPopup.open({
                                    items: images,
                                    type: 'image',
                                    gallery: {
                                        enabled: true
                                    }
                                });
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
                    $.fancybox.open(xzoom.gallery().cgallery, {
                        padding: 0,
                        helpers: {
                            overlay: {
                                locked: false
                            }
                        }
                    });
                    event.preventDefault();
                });

                //Integration with magnific popup plugin
                $('#xzoom-magnific').bind('click', function(event) {
                    var xzoom = $(this).data('xzoom');
                    xzoom.closezoom();
                    var gallery = xzoom.gallery().cgallery;
                    var i, images = new Array();
                    for (i in gallery) {
                        images[i] = {
                            src: gallery[i]
                        };
                    }
                    $.magnificPopup.open({
                        items: images,
                        type: 'image',
                        gallery: {
                            enabled: true
                        }
                    });
                    event.preventDefault();
                });
            }
        });
    })(jQuery);
</script> -->
<script>
    // function imageZoom(imgID, resultID) {
    //     var img, lens, result, cx, cy;
    //     img = document.getElementById(imgID);
    //     result = document.getElementById(resultID);
    //     /*create lens:*/
    //     lens = document.createElement("DIV");
    //     lens.setAttribute("class", "img-zoom-lens");
    //     /*insert lens:*/
    //     img.parentElement.insertBefore(lens, img);
    //     /*calculate the ratio between result DIV and lens:*/
    //     cx = result.offsetWidth / lens.offsetWidth;
    //     cy = result.offsetHeight / lens.offsetHeight;
    //     /*set background properties for the result DIV:*/
    //     result.style.backgroundImage = "url('" + img.src + "')";
    //     result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";

    //     // Hide myresult by default
    //     $('#myresult').hide();

    //     // Show myresult on mousemove
    //     img.addEventListener("mousemove", showResult);
    //     lens.addEventListener("mousemove", showResult);

    //     // Hide myresult on touchend and mouseleave
    //     img.addEventListener("touchend", hideResult);
    //     lens.addEventListener("touchend", hideResult);
    //     img.addEventListener("mouseleave", hideResult);
    //     lens.addEventListener("mouseleave", hideResult);

    //     function showResult(e) {
    //         // Show myresult
    //         $('#myresult').show();
    //         $('.bid-now-container').hide();

    //         var pos, x, y;
    //         /*prevent any other actions that may occur when moving over the image:*/
    //         e.preventDefault();
    //         /*get the cursor's x and y positions:*/
    //         pos = getCursorPos(e);
    //         /*calculate the position of the lens:*/
    //         x = pos.x - (lens.offsetWidth / 2);
    //         y = pos.y - (lens.offsetHeight / 2);
    //         /*prevent the lens from being positioned outside the image:*/
    //         if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
    //         if (x < 0) {x = 0;}
    //         if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
    //         if (y < 0) {y = 0;}
    //         /*set the position of the lens:*/
    //         lens.style.left = x + "px";
    //         lens.style.top = y + "px";
    //         /*display what the lens "sees":*/
    //         result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
    //     }

    //     function hideResult() {
    //         // Hide myresult
    //         $('#myresult').hide();
    //         $('.bid-now-container').show();

    //     }

    //     // function getCursorPos(e) {
    //     //     var a, x = 0, y = 0;
    //     //     e = e || window.event;
    //     //     /*get the x and y positions of the image:*/
    //     //     a = img.getBoundingClientRect();
    //     //     /*calculate the cursor's x and y coordinates, relative to the image:*/
    //     //     x = e.pageX - a.left;
    //     //     y = e.pageY - a.top;
    //     //     /*consider any page scrolling:*/
    //     //     x = x - window.pageXOffset;
    //     //     y = y - window.pageYOffset;
    //     //     return {x : x, y : y};
    //     // }
    // }
</script>

{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


{{-- <script>

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
</script> --}}
{{-- <script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>
<script type="text/javascript" src="https://hammerjs.github.io/dist/hammer.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.min.js"></script> --}}
@include('frontend.products.script.addToWishListScript')
<script>
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('.accordion-icon');
            // إذا كان العنصر مفتوحًا، قم بتغيير العلامة إلى -
            if (button.getAttribute('aria-expanded') === 'true') {
                icon.textContent = '+'; // تغيير إلى +
            } else {
                icon.textContent = '-'; // تغيير إلى -
            }
        });
    });
</script>
