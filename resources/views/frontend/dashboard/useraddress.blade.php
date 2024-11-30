@include('frontend.layouts.header')

<section class="dtl-user-box">
    <div class="container">
        <div class="account-outer-box">
            <div class="row">
                @include('frontend.dashboard.sidebar')
                <div class="col-md-9 ">
                    <div class="heading-act">
                    @if(session('locale') === 'en')   
                        <h2>Manage Address</h2>
                    @elseif(session('locale') === 'ar')
                       <h2>إدارة العنوان</h2>
                    @else 
                       <h2>Manage Address</h2>
                    @endif 
                    </div>
                    <div class="manage-adress">
                        @if(session('locale') === 'en')   
                            <a class="text-btn edit-number d-flex align-items-center border-bottom px-3 py-4"
                                data-bs-target="#addressman" data-bs-toggle="modal" data-bs-dismiss="modal"
                                type="button"><img class="me-2" src="{{asset('frontend/images/add-address.svg')}}"
                                    alt="">Add
                                New Address</a>
                        @elseif(session('locale') === 'ar')
                            <a class="text-btn edit-number d-flex align-items-center border-bottom px-3 py-4"
                                data-bs-target="#addressman" data-bs-toggle="modal" data-bs-dismiss="modal"
                                type="button"><img class="me-2" src="{{asset('frontend/images/add-address.svg')}}"
                                    alt="">إضافة عنوان جديد</a>
                        @else
                            <a class="text-btn edit-number d-flex align-items-center border-bottom px-3 py-4"
                                data-bs-target="#addressman" data-bs-toggle="modal" data-bs-dismiss="modal"
                                type="button"><img class="me-2" src="{{asset('frontend/images/add-address.svg')}}"
                                    alt="">Add
                                New Address</a>
                        @endif
                        @foreach($userAddresses as $address)
                        <div class="border-bottom">
                            <div class="address-filds">
                                <img class="location-icon" src="{{ asset('frontend/images/location.svg') }}" alt="">
                                <h4>Address {{ $loop->iteration }}</h4>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    @php
                                       $city = App\Models\City::find($address->city);
                                       $city_name = $city->name;

                                       $country = App\Models\Country::find($address->country);
                                       $country_name =  $country->name;

                                       $state =App\Models\State::find($address->state);
                                       $state_name =  $state->name;
                                    @endphp
                                    <p>
                                        {{ $address->first_name }} {{ $address->last_name }} -
                                        {{ $address->apartment }}, {{ $city_name }}, {{ $country_name }},
                                        {{  $state_name}}, {{ $address->zipcode }}
                                    </p>
                                    <div class="action-btn">
                                    @if(session('locale') === 'en')   
                                    <div >
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault{{ $address->id }}" data-address-id="{{ $address->id }}" onchange="makePrimary({{ $address->id }})" {{ $address->is_primary ? 'checked' : '' }} {{ $address->is_primary ? 'disabled' : '' }}>
                                   <label class="form-check-label" for="flexSwitchCheckDefault{{ $address->id }}"></label>
                                    </div>
                                    <a href="{{ route('addresseedit', ['id' => $address->id]) }}" class="text-btn">Edit</a>
                                        <a href="{{ route('addresses.delete', $address->id)}}"
                                            class="text-btn text-danger">Delete</a>
                                    @elseif(session('locale') === 'ar')
                                    <div >
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault{{ $address->id }}" data-address-id="{{ $address->id }}" onchange="makePrimary({{ $address->id }})" {{ $address->is_primary ? 'checked' : '' }} {{ $address->is_primary ? 'disabled' : '' }}>
                        <label class="form-check-label" for="flexSwitchCheckDefault{{ $address->id }}"></label>
                                    </div>
                                    <a href="{{ route('addresseedit', ['id' => $address->id]) }}" class="text-btn">حرر</a>
                                        <a href="{{ route('addresses.delete', $address->id)}}"
                                            class="text-btn text-danger">حذف</a>
                                    @else 
                                    <div >
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault{{ $address->id }}" data-address-id="{{ $address->id }}" onchange="makePrimary({{ $address->id }})" {{ $address->is_primary ? 'checked' : '' }} {{ $address->is_primary ? 'disabled' : '' }}>
                        <label class="form-check-label" for="flexSwitchCheckDefault{{ $address->id }}"></label>
                                    </div>
                                    <a href="{{ route('addresseedit', ['id' => $address->id]) }}" class="text-btn">Edit</a>
                                        <a href="{{ route('addresses.delete', $address->id)}}"
                                            class="text-btn text-danger">Delete</a>
                                    @endif
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


<!--  -->
<div class="modal fade" id="addressman" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="px-2 ">
                    <h2 class="mb-5 text-dark">Add Address</h2>

                    <form action="{{ route('adduseraddress') }}" method="post" class="cmn-frm" id="address-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">First Name </label>
                                    <input type="text" name="first_name" id="first_name">

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Last Name </label>
                                    <input type="text" name="last_name" id="">
                                </div>
                            </div>
                           
                          
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Country / Region </label>
                                  
                                    <select name="country" class="form-control" onchange="loadStates(this.value)">
                                            @foreach ($countries as $c)
                                                <option value="{{ $c->id }}" @if($c->id == $selectedAddress->country) selected @endif>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                           
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">State </label>
                                    <!-- <input type="text" name="state" id=""> -->
                                    <select name="state" class="form-control" id="stateDropdown" onchange="loadCities(this.value)">
                                        
                                      </select>
                                </div>
                            </div>
                           
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">City </label>
                                    <!-- <input type="text" name="city" id=""> -->
                                    <select name="city" class="form-control" id="cityDropdown">
                                          
                                          </select>
                                </div>
                            </div>
                           
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Zip Code </label>
                                    <input type="text" name="zipcode" id="">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Appartment, Suite, etc </label>
                                    <input type="text" name="apartment" id="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group d-flex gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_save"
                                            id="is_save">
                                        <label class="form-check-label" for="is_save"></label>
                                    </div>
                                    <label for="is_save">Save this information for next time</label>
                                </div>
                            </div>
                        </div>
                        <button class="my-4 btn btn-secondary px-5 mb-0 login-btn" id="submit-address" title="Submit">Save the
                            Address</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="validation-errors" class="alert alert-danger" style="display: none;"></div>

<div class="modal fade" id="editAddress" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="px-2 ">
                    <h2 class="mb-5 text-dark">Edit Address</h2>

                    <form action="{{ isset($address) ? url('/addresses/update/' . $address->id) : url('/addresses/update/') }}" method="post" class="cmn-frm" id="address-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">First Name </label>
                                    <input type="text" name="first_name" id="first_name_input" required>

                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Last Name </label>
                                    <input type="text" name="last_name" id="last_name_input" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Appartment, Suite, etc </label>
                                    <input type="text" name="apartment" id="apartment" required>
                                </div>
                            </div>
                           
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Country / Region </label>
                                    <select name="country" id="country" class="form-control" onchange="loadStates(this.value)">
                                    <!-- <option value="">Choose Country</option> -->
                                            @foreach ($countries as $c)
                                               

                                                <option value="{{ $c->id }}" @if($c->id == $selectedAddress->country) selected @endif>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">State </label>
                                    <!-- <input type="text" name="state" id="state" required> -->
                                    <select name="state" id="state" class="form-control" >
                                           @foreach ($states as $st)
                                                <option value="{{ $st->id }}" @if($st->id == $selectedAddress->state) selected @endif>{{ $st->name }}</option>
                                            @endforeach
                                   </select>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">City </label>
                                    <!-- <input type="text" name="city" id="city" required> -->

                                    <select name="city" class="form-control" id="city">
                                           @foreach ($cities as $ct)
                                                <option value="{{ $ct->id }}" @if($ct->id == $selectedAddress->city) selected @endif>{{ $ct->name }}</option>
                                            @endforeach
                                          </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Zip Code </label>
                                    <input type="text" name="zipcode" id="zipcode" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group d-flex gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_save"
                                            id="is_save">
                                        <label class="form-check-label" for="is_save"></label>
                                    </div>
                                    <label for="is_save">Save this information for next time</label>
                                </div>
                            </div>
                        </div>
                        <button class="my-4 btn btn-secondary px-5 mb-0" id="submit-address" title="Submit">Save the
                            Address</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('frontend/js/jquery.min.js')}}"></script> 
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script> 
    <script src="{{asset('frontend/js/main.js')}}"></script> 

<script>
$(document).ready(function() {
    $("#submit-address").click(function(e) {
        e.preventDefault();

        $(".error-message").remove();

        $("#address-form input").each(function() {
            var fieldValue = $(this).val();
            var fieldName = $(this).attr("name");

            if (!fieldValue) {
                $(this).addClass("is-invalid");
                $(this).after('<div class="error-message">Please enter ' + fieldName.replace("_", " ") + '.</div>');
            }
        });

        var formData = $("#address-form").serialize();
        $('.login-btn').html('<i class="fa fa-spinner fa-spin"></i> Wait For Adding Details ...').prop('disabled', true);
        
        $.ajax({
            type: "POST",
            url: "{{ route('adduseraddress') }}",
            data: formData,
            success: function(data) {
               
                    window.location.reload();
             
            },
            error: function(xhr, status, error) {
                console.log(xhr);
            }
        });
    });

    $("input").focus(function() {
        $(this).removeClass("is-invalid");
        $(this).next(".error-message").remove();
    });

    $('.navTrigger').click(function () {
        $(this).toggleClass('active');
        console.log("Clicked menu");
        $("#mainListDiv").toggleClass("show_list");
        $("#mainListDiv").fadeIn();
    });

    $('.menu-show-mn').click(function () {
        $('.menu-ul').toggleClass('show-mnu');
    });
});

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        function showLoader() {
            $('#loader').show();
        }
        function hideLoader() {
            $('#loader').hide();
        }
        $('select[name="country"]').on('change', function(){
            var countryId = $(this).val();
            if(countryId){
                showLoader();
                $.ajax({
                    url: 'get-states/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        hideLoader();
                        $('select[name="state"]').empty();
                        $.each(data.states, function(key, value){
                            $('select[name="state"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            }else{
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
                        $('select[name="city"]').empty();
                        $.each(data.cities, function(key, value){
                            $('select[name="city"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
    });
</script>
<script>
    function editAddress(address) {
        // Populate the form fields with the address data
        document.getElementById("first_name_input").value = address.first_name;
        document.getElementById("last_name_input").value = address.last_name;
        document.getElementById("apartment").value = address.apartment;
        document.getElementById("city").value = address.city;
        document.getElementById("country").value = address.country;
        document.getElementById("state").value = address.state;
        document.getElementById("zipcode").value = address.zipcode;
        document.getElementById("is_save").checked = address.is_save;
        $('#editAddress').modal('show');
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
    $('.form-check-input').click(function() {
        var addressId = $(this).data('address-id');
        var isChecked = $(this).is(':checked');

        $.ajax({
            url: '/addressesprimary/' + addressId,
            type: 'GET',
            data: { is_primary: 1 }, 
            success: function(response) {
                console.log(response); 
                console.log('Address updated successfully');
            Swal.fire({
              title: 'Success!',
              text: 'Address Will be Set As Default.',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(function() {
                window.location.reload();
            });
            },
            error: function(xhr, status, error) {
                console.error('Error updating address:', error);
            }
        });
    });
});
</script>


<style>
.error-message {
    color: red;
    position: relative;
    bottom: 20px;
    font-size: 14px;
}
    </style>

@include('frontend.layouts.footer')