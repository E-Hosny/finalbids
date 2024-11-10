@include('frontend.layouts.header')
<style>
.pop-box {
    display: inline;
    position: relative !important;
}

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

.form-group i {
    cursor: pointer !important;
    padding-right: 40px;
}

.form-group .pop-box:hover .popup-data {
    display: block;
    cursor: pointer !important;
}

.shiping-add {
    margin-top: 10px;
}

.product-feature-box-2 {
    border-radius: 10px;
    background: #FFF;
    box-shadow: 0px 4px 35px 0px rgba(0, 0, 0, 0.07);
    padding: 20px;
}

.product-descs h4 {
    font-size: 20px;
    margin-top: 30px;
    font-weight: 600;
    margin-bottom: 20px;
}

.form-control:focus {
    -webkit-box-shadow: none;
    box-shadow: none;
}

textarea:focus,
input:focus {
    outline: none;
}
#loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        display: none;
        margin: 0 auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<!-- for loader -->
<style>
    .loader {
  --dim: 3rem;
  width: var(--dim);
  height: var(--dim);
  position: relative;
  animation: spin988 2s linear infinite;
}

.loader .circle {
  --color: #333;
  --dim: 1.2rem;
  width: var(--dim);
  height: var(--dim);
  background-color: var(--color);
  border-radius: 50%;
  position: absolute;
}

.loader .circle:nth-child(1) {
  top: 0;
  left: 0;
}

.loader .circle:nth-child(2) {
  top: 0;
  right: 0;
}

.loader .circle:nth-child(3) {
  bottom: 0;
  left: 0;
}

.loader .circle:nth-child(4) {
  bottom: 0;
  right: 0;
}
.loader {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px; 
}


@keyframes spin988 {
  0% {
    transform: scale(1) rotate(0);
  }

  20%, 25% {
    transform: scale(1.3) rotate(90deg);
  }

  45%, 50% {
    transform: scale(1) rotate(180deg);
  }

  70%, 75% {
    transform: scale(1.3) rotate(270deg);
  }

  95%, 100% {
    transform: scale(1) rotate(360deg);
  }
}
    </style>
<!--  -->
<section class="my-5 check_out_s">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="outr-box w-100">
                @if(session('locale') === 'en')
                    <h6 class="mb-3">{{$products->lot_no}} : {{$products->title}}</h6>
                @elseif(session('locale') === 'ar')
                    <h6 class="mb-3">{{$products->lot_no}} : {{$products->title_ar}}</h6>
                @else
                   <h6 class="mb-3">{{$products->lot_no}} : {{$products->title}}</h6>
                @endif
                            @php
                                $imagePath = \App\Models\Gallery::where('lot_no', $products->lot_no)->orderBy('id')->value('image_path');
                            @endphp

                      
                    <div class="discri">
                        <div class="product-imgs">
                            <div class="img-display">
                                <div class="img-showcase h-auto">
                                    
                                        @if ($imagePath)
                                            <img src="{{ asset($imagePath) }}" alt="Product Image">
                                        @else
                                            <img src="{{ asset('frontend/images/default-product-image.png') }}" alt="Default Image">
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="product-feature-box-2">
                        @if(session('locale') === 'en')
                            <h4>{{$products->project->name}}</h4>
                            @elseif(session('locale') === 'ar')
                            <h4 class="mb-3">{{$products->project->name_ar}}</h4>
                        @else
                        <h4>{{$products->project->name}}</h4>
                        @endif
                        @php
                              $originalDateTime = $products->project->start_date_time;
                              $timestamp = strtotime($originalDateTime);
                              $formattedDateTime = date("F j, g:i A", $timestamp);
                       @endphp

                               @php
                                $auctionTypeName = $products->auctionType->name;
                                $auctionTypeIcon = '';

                                if ($auctionTypeName === 'Private') {
                                $auctionTypeIcon = asset('auctionicon/private_icon.png');
                                } elseif ($auctionTypeName === 'Timed') {
                                $auctionTypeIcon = asset('auctionicon/time.png');
                                } elseif ($auctionTypeName === 'Live') {
                                $auctionTypeIcon = asset('auctionicon/live.png');
                                }
                                @endphp
                            <p>{{$formattedDateTime}}
                              <!-- <img class="ms-3"
                                    src="http://localhost/bids/public/frontend/images/private.svg"> -->
                                  <img class="ms-3" src="{{ !empty($auctionTypeIcon) ? $auctionTypeIcon : asset('frontend/images/default_icon.png') }}"
                                    alt="Auction Type Icon">
                               
                                  @if(session('locale') === 'en')
                                      <span >{{ $products->auctionType->name }}</span></p>
                                  @elseif(session('locale') === 'ar')
                                  <span >{{ $products->auctionType->name_ar }}</span></p>
                                  @else
                                      <span >{{ $products->auctionType->name }}</span></p>
                                  @endif
                            </p>
                        </div>
                        <div class="product-descs">
                            <!-- <h4>Description</h4> -->
                            <h4>{{ session('locale') === 'en' ? 'Description' : (session('locale') === 'ar' ? 'الوصف' : 'Description') }}</h4>
                            @if(session('locale') === 'en')
                              <p> {{ strip_tags($products->description) }}</p>
                            @elseif(session('locale') === 'ar')
                            <p>{{ strip_tags($products->description_ar) }}</p>
                            @else
                              <p>{{ strip_tags($products->description) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="outr-box w-100">
                   @if(session('locale') === 'en')
                          <h4 class="modal-title">Submit Your Bid</h4>
                          <p>Select the highest amount you are willing to bid. If you are outbid, we will increase your bid by
                              one increment, up to your max.</p>

                  @elseif(session('locale') === 'ar')
                        <h4 class="modal-title">أرسل عرضك</h4>
                          <p>حدد أعلى مبلغ ترغب في المزايدة عليه. إذا كنت تقوم بالمزايدة ، فسنزيد عرض السعر الخاص بك بنسبة
                              زيادة واحدة ، تصل إلى الحد الأقصى الخاص بك.</p>
                  @else
                      <h4 class="modal-title">Submit Your Bid</h4>
                          <p>Select the highest amount you are willing to bid. If you are outbid, we will increase your bid by
                              one increment, up to your max.</p>

                  @endif
        
                    <form class="cmn-frm" id="bidForms">
                    <input type="hidden" name="bid_placed_id" value="{{ $bidPlacedId ? $bidPlacedId : '' }}">
                        <div class="row">

                              <div class="col-md-12">
                                <div class="form-group">
                                   @if(session('locale') === 'en')
                                       <label>Estimate : {{$products->start_price}} - {{$products->end_price}}</label>
                                   @elseif(session('locale') === 'ar')
                                         <label>تقدير : {{$products->start_price}} - {{$products->end_price}}</label>
                                   @else 
                                       <label>Estimate : {{$products->start_price}} - {{$products->end_price}}</label>
                                  @endif
                                </div>
                           
                            </div>

                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                   @if(session('locale') === 'en')
                                       <label>Current bid : {{ $lastBidAmount}}</label>
                                   @elseif(session('locale') === 'ar')
                                        <label>العطاء الحالي : {{ $lastBidAmount}}</label>
                                   @else 
                                       <label>Current bid : {{ $lastBidAmount}}</label>
                                  @endif
                                </div>
                           
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                @if(session('locale') === 'en')
                                    <label>Your max bid </label>
                                @elseif(session('locale') === 'ar')
                                        <label>عرض السعر الأقصى</label>
                                @else 
                                     <label>Your max bid </label>
                                @endif
                                    <div class="pop-box">
                                        <i class="fa fa-info-circle">

                                        </i>
                                        <div class="popup-data">
                                            Your Max Bid is the highest amount you are willing to bid on this item. We
                                            will automatically place a bid one increment higher then the last competing
                                            bid until your max is reached. Your max will not be disclosed to anyone,
                                            including the auctioneer, and the final hammer price is based on competing
                                            bids
                                        </div>
                                    </div>
                                    
                                    <select class="form-control mb-0" name="max_bid" id="bidValueSelect" >
                                        @if ($bidPlacedAmount)
                                            <option value="{{ $bidPlacedAmount }}" data-buyers-premium="{{ $products->project->buyers_premium }}" selected>
                                                <!-- {{ $bidPlacedAmount }} {{$currency}} -->
                                                {{ formatPrice($bidPlacedAmount, session()->get('currency')) }} {{$currency}}
                                            </option>
                                        @else
                                            <option value="" disabled selected>Select Bid Amount</option>
                                        @endif

                                        @foreach($bidValues as $bidValue)
                                            <option value="{{ $bidValue->cal_amount }}" data-buyers-premium="{{ $products->project->buyers_premium }}">
                                                {{ $bidValue->cal_amount }} {{$currency}}
                                                <!-- {{ formatPrice($bidValue->cal_amount, session()->get('currency')) }} {{$currency}} -->
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                     @if(session('locale') === 'en')
                                            <label class="mt-1 mb-1">Buyer's Premium Amount: <span id="buyerPremiumAmount">0</span></label>
                                     @elseif(session('locale') === 'ar')
                                           <label class="mt-1 mb-1">مبلغ قسط المشتري: <span id="buyerPremiumAmount">0</span></label>
                                     @else 
                                          <label class="mt-1 mb-1">Buyer's Premium Amount: <span id="buyerPremiumAmount">0</span></label>

                                     @endif
                                    <div class="pop-box">
                                        <i class="fa fa-info-circle">
                                        </i>
                                        <div class="popup-data">
                                            If you win, you agree to pay a buyer's premium of up to {{$products->project->buyers_premium}}% and any
                                            applicable taxes as described in the <span><a href=""
                                                    style="color:blue;">terms</a> and <a href=""
                                                    style="color:blue;">conditions</a>.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    @if(session('locale') === 'en')
                                        <label class="mt-1 mb-1"><b>Total : <span id="totalAmount">0 {{$currency}} (+Shipping, taxes & fees)</span></b></label>
                                    @elseif(session('locale') === 'ar')
                                          <label class="mt-1 mb-1"><b>مجموع : <span id="totalAmount">0 {{$currency}} (+Shipping, taxes & fees)</span></b></label>
                                    @else 
                                    <label class="mt-1 mb-1"><b>Total : <span id="totalAmount">0 {{$currency}} (+Shipping, taxes & fees)</span></b></label>

                                     @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row shiping-add">
                                <div class="col-md-12">
                                @if(session('locale') === 'en')
                                       <h3>Shipping Address</h3>
                                @elseif(session('locale') === 'ar')
                                      <h3>عنوان الشحن</h3>
                                @else 
                                     <h3>Shipping Address</h3>
                                @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">First Name</label>
                                      <input type="text" name="first_name" value="{{ old('first_name', isset($userAddresses[0]) ? $userAddresses[0]['first_name'] : '') }}" placeholder="Enter Your Name" class="form-control">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', isset($userAddresses[0]) ? $userAddresses[0]['last_name'] : '') }}" placeholder="Enter Your Last Name"  class="form-control">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="">Apartment </label>
                                    <input type="text" name="apartment" value="{{ old('apartment', isset($userAddresses[0]) ? $userAddresses[0]['apartment'] : '') }}" placeholder="Address"  class="form-control">

                                    </div>
                                </div>
                      
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Choose Country</label>
                                        <select name="country" class="form-control" id="countryDropdown">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $c)
                                                <option value="{{ $c->id }}" @if($c->id == $selectedAddress->country) selected @endif>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="stateContainer" style="display:none;">
                                    <div class="form-group">
                                        <label for="">Choose State</label>
                                        <select name="state" class="form-control" id="stateDropdown">
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" @if($state->id == $selectedAddress->state) selected @endif>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="cityContainer" style="display:none;">
                                    <div class="form-group">
                                        <label for="">Choose City</label>
                                        <select name="city" class="form-control" id="cityDropdown">
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" @if($city->id == $selectedAddress->city) selected @endif>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="">Zip Code</label>
                                    <input type="text" name="zipcode" value="{{ old('zipcode', isset($userAddresses[0]) ? $userAddresses[0]['zipcode'] : '') }}" placeholder="Zip Code"  class="form-control">

                                    </div>
                                </div>
                               
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="">Mobile Number</label>
                                    <input type="text" name="phone" value="{{ old('phone', isset($userAddresses[0]) ? $userAddresses[0]['phone'] : '') }}" placeholder="Enter Phone Number"  class="form-control">

                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-group check_gr">
                                        <input type="checkbox" class="w-auto" id="outbidCheckbox"
                                            name="outbidNotification">
                                        <label for="outbidCheckbox">Text me if I'm outbid and before the auction starts
                                            for my lots.</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-center" id="placeBidButton">
                                        <button type="submit" class="btn btn-secondary">Place Bid</button>
                                    </div>
                                    
                                    <div class="form-group text-center" id="waitButton" style="display: none;">
                                        <button class="btn btn-secondary">Please Wait...</button>
                                    </div>

                                </div>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        function showLoader() {
            $('#loader').show();
        }
        function hideLoader() {
            $('#loader').hide();
        }

        $('#countryDropdown').on('change', function(){
            var countryId = $(this).val();
            if(countryId){
                showLoader();
                $.ajax({
                    url: 'get-states/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        hideLoader();
                        $('#stateContainer').show(); 
                        $('select[name="state"]').empty().append('<option value="">Select State</option>'); 
                        $('#cityContainer').hide();
                        $.each(data.states, function(key, value){
                            $('select[name="state"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#stateContainer').hide(); 
                $('#cityContainer').hide(); 
                $('select[name="state"]').empty();
                $('select[name="city"]').empty();
            }
        });

        $('select[name="state"]').on('change', function(){
            var stateId = $(this).val();
            if(stateId){
                showLoader();
                $.ajax({
                    url: 'get-cities/' + stateId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        hideLoader();
                        $('#cityContainer').show(); 
                        $('select[name="city"]').empty().append('<option value="">Select City</option>');
                        $.each(data.cities, function(key, value){
                            $('select[name="city"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#cityContainer').hide(); 
                $('select[name="city"]').empty();
            }
        });

        var selectedCountryId = "{{ $selectedAddress->country }}";
        if (selectedCountryId !== "") {
            $('#countryDropdown').val(selectedCountryId).trigger('change');
        }
    });
</script>



<script>
  document.addEventListener("DOMContentLoaded", function() {
    const bidValueSelect = document.getElementById('bidValueSelect');
    const totalAmount = document.getElementById('totalAmount');
    const buyerPremiumAmount = document.getElementById('buyerPremiumAmount');
    const vatPercentage = 15; 

    function calculateTotalAndPremium(selectedBid) {
      const buyersPremiumPercentage = parseFloat(bidValueSelect.options[bidValueSelect.selectedIndex].getAttribute('data-buyers-premium'));

    //   const total = selectedBid * (1 + (buyersPremiumPercentage / 100));
    //   totalAmount.textContent = `${total.toFixed(2)}  (+Shipping, taxes & fees)`;

      const buyerPremium = selectedBid * (buyersPremiumPercentage / 100);
      buyerPremiumAmount.textContent = `${buyerPremium.toFixed(2)}`;

      // Calculate VAT
      const vat = selectedBid * (vatPercentage / 100);

      const total = selectedBid + buyerPremium + vat;
      totalAmount.textContent = `${total.toFixed(2)}  (+Shipping, taxes & fees)`;
    }

    bidValueSelect.addEventListener('change', function() {
      const selectedBid = parseFloat(this.value);
      calculateTotalAndPremium(selectedBid);
    });

    const defaultSelectedBid = parseFloat(bidValueSelect.value);
    calculateTotalAndPremium(defaultSelectedBid);
  });
</script> 

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const bidValueSelect = document.getElementById('bidValueSelect');
    const totalAmount = document.getElementById('totalAmount');
    const buyerPremiumAmount = document.getElementById('buyerPremiumAmount');
    let totalAmountValue;

    function calculateTotalAndPremium(selectedBid, buyersPremium) {
    const total = selectedBid * (1 + (buyersPremium / 100));
    totalAmount.textContent = `$${total.toFixed(2)}  (+Shipping, taxes & fees)`;

    const buyerPremium = selectedBid * (buyersPremium / 100);
    buyerPremiumAmount.textContent = `$${buyerPremium.toFixed(2)}`;
    totalAmountValue = total; // Assign total amount to the variable
      return total;
    }

    bidValueSelect.addEventListener('change', function() {
    const selectedBid = parseFloat(this.value);
    const buyersPremium = parseFloat(this.options[this.selectedIndex].getAttribute('data-buyers-premium'));

      const totalAmount = calculateTotalAndPremium(selectedBid, buyersPremium);
      const totalAmountWithVat = totalAmount + (totalAmount * 0.15); // Calculate total amount with VAT
      document.getElementById('totalAmount').textContent = `$${totalAmountWithVat.toFixed(2)}  (+Shipping, taxes & fees)`;
    });
    const bidForms = document.getElementById('bidForms');
    const placeBidButton = document.getElementById('placeBidButton');
    
    bidForms.addEventListener('submit', function(e) {
      e.preventDefault();
      // Create a new button element with the "Please wait..." text
      const waitButton = document.createElement('button');
    waitButton.setAttribute('type', 'submit');
    waitButton.setAttribute('class', 'btn btn-secondary');
    waitButton.setAttribute('disabled', 'true');
    waitButton.textContent = 'Please wait...';
    const placeBidButtonParent = placeBidButton.parentNode;
    placeBidButtonParent.removeChild(placeBidButton);
    placeBidButtonParent.appendChild(waitButton);

      const formData = new FormData(this);
      const bidPlacedId = '{{ $bidPlacedId ? $bidPlacedId : '' }}';
      const isChecked = document.getElementById('outbidCheckbox').checked ? 1 : 0;

      const bidValue = $('#bidValueSelect').val();
      const projectId = '{{ $products->project->id }}';
      const auctionTypeId = '{{ $products->auctionType->id }}';
      const productId = '{{ $products->id }}';
      const userId = '{{ Auth::id() }}';
      const buyersPremium = '{{$products->project->buyers_premium}}';
    //   const totalamount = calculateTotalAndPremium(bidValue, buyersPremium);
      const totalAmount = calculateTotalAndPremium(bidValue, buyersPremium); // Calculate total amount
      const totalvat= bidValue * 0.15;
      const totalAmountWithVat =totalAmountValue + totalvat   // Calculate total amount with VAT
      const status     = 1;

      const firstName = $('input[name="first_name"]').val();
      const lastName = $('input[name="last_name"]').val();
      const country = $('select[name="country"]').val();
      const state  =$('select[name="state"]').val();
      const city  =$('select[name="city"]').val();
      const zipcode = $('input[name="zipcode"]').val();
      const phone = $('input[name="phone"]').val();

       
    

      axios.post('{{ route("bidingplaced") }}', {
        user_id: userId,
        project_id: projectId,
        auction_type_id: auctionTypeId,
        bid_amount: bidValue,
        product_id: productId,
        buyers_premium: buyersPremium,
        total_amount: totalAmountWithVat,
        bid_placed_id: bidPlacedId,
        status:status ,
        outbid: isChecked,
        first_name: firstName, 
        last_name: lastName,   
        country: country   ,  
        state: state,
        city: city,
        zipcode:zipcode,
        phone:phone,
      })
      .then(function(response) {
        Swal.fire({
          title: 'Congratulations!',
          text: 'Your bid has been placed successfully.',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '{{ route("auction") }}';
          }
        });
      })
      .catch(function (error) {
     
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;
                        let errorMessage = '';
                        for (const field in errors) {
                            errorMessage += `${field}: ${errors[field].join(', ')}\n`;
                        }
                        Swal.fire({
                            title: 'Validation Error',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        console.error(error);
                    }
                 // Re-enable the button and replace the "Please wait..." button with the original "Place Bid" button
        placeBidButtonParent.removeChild(waitButton);
        placeBidButtonParent.appendChild(placeBidButton);
                });
    });
  });
</script>
@include('frontend.layouts.footer')