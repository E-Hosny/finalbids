@include('frontend.layouts.header')

<section class="dtl-user-box">
    <div class="container">
        <div class="account-outer-box">
            <div class="row">
                @include('frontend.dashboard.sidebar')
                <div class="col-md-9 ">
                    <div class="heading-act">
                    @if(session('locale') === 'en')   
                        <h2>Edit Address</h2>
                    @elseif(session('locale') === 'ar')
                       <h2>إدارة العنوان</h2>
                    @else 
                       <h2>Edit Address</h2>
                    @endif 
                    </div>
                    <div id="validation-errors" class="alert alert-danger" style="display: none;"></div>

  
            <div class="modal-body">
               
                <div class="px-2 ">
                   
                    <form  method="post" class="cmn-frm" id="address-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">First Name </label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $data->first_name) }}" id="first_name_input" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Last Name </label>
                                    <input type="text" name="last_name" value="{{ old('first_name', $data->last_name) }}" id="last_name_input" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Appartment, Suite, etc </label>
                                    <input type="text" name="apartment" value="{{ old('first_name', $data->apartment) }}" id="apartment" required>
                                </div>
                            </div>
                           
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Country / Region </label>
                                    <select name="country" id="country" class="form-control" onchange="loadStates(this.value)">
                                            @foreach ($countries as $c)
                                               
                                                <option value="{{ $c->id }}" @if($c->id == $data->country) selected @endif>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">State </label>
                                    <select name="state" id="state" class="form-control" >
                                           @foreach ($states as $st)
                                                <option value="{{ $st->id }}" @if($st->id == $data->state) selected @endif >{{ $st->name }}</option>
                                            @endforeach
                                   </select>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">City </label>
                                    <select name="city" class="form-control" id="city">
                                           @foreach ($cities as $ct)
                                                <option value="{{ $ct->id }}" @if($ct->id == $data->city) selected @endif >{{ $ct->name }}</option>
                                            @endforeach
                                          </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="">Zip Code </label>
                                    <input type="text" name="zipcode" value="{{ old('first_name', $data->zipcode) }}" id="zipcode" required>
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
                      
                            <div class="text-center">
                                    <button class="my-4 btn btn-secondary px-5 mb-0" id="submit-address" title="Submit">Submit</button>
                                </div>

                                <div class="text-center" id="wait-btn" style="display: none;">
                                        <button class="my-4 btn btn-secondary px-5 mb-0">Please Wait</button>
                                    </div>

                    </form>
                </div>
            </div>

     
</div>

                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('frontend/js/jquery.min.js')}}"></script> 
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script> 


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
                // alert(countryId)
                showLoader();
                $.ajax({
                    // url: '{{ route("get-states", ["countryId" => $data->country]) }}',
                    url: '/get-states/' + countryId,
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
                    // url: '{{ route("get-cities", ["stateId" => $data->state]) }}',
                    url: '/get-cities/' + stateId,
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
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#address-form').submit(function (e) {
        e.preventDefault(); 

        $('#submit-address').hide();
        $('#wait-btn').show();

        // Serialize form data
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{ route('addresses.update', ['id' => $data->id]) }}", 
            data: formData,
            success: function (response) {
                Swal.fire({ 
                    title: "Success!",
                    text: "Address updated successfully.",
                    icon: "success",
                    button: "OK",
                }).then(() => {
                    window.location.href = '/useraddress'; 
                });
            },
            error: function (xhr, status, error) {
                
                Swal.fire({ 
                    title: "Error!",
                    text: "Error updating address.",
                    icon: "error",
                    button: "OK",
                });
                console.error(xhr.responseText);
            },
            complete: function () {
                // Hide the "Please Wait" button and show the submit button again
                $('#wait-btn').hide();
                $('#submit-address').show();
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