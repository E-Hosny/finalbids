<x-admin-layout>
    <!--  -->
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Product Auction', 'link' => 'admin.products.index', 'page' =>
        'Edit
        Product Auction'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.products.update', $product)}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Edit ProductAuction</h5>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Product Title (EN)</label>
                                                <input class="multisteps-form__input form-control" type="text" name="title"
                                                    placeholder="eg.Title" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('title', $product->title)}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Product Title (AR) <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__input form-control" type="text"
                                                    name="title_ar" placeholder="مثل. عنوان المنتج" onfocus="focused(this)"
                                                    onfocusout="defocused(this)"value="{{old('title_ar', $product->title_ar)}}">
                                                @if($errors->has('title_ar'))
                                                <div class="error">{{$errors->first('title_ar')}}</div>
                                                @endif

                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose AuctionType <span class="star">*</span>:</strong></label>
                                                <select name="auction_type_id"
                                                    class="choices__list choices__list--single form-control" id="brand"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Select AuctionType</option>
                                                    @foreach ($auctiontype as $at)
                                                    <option value="{{ $at->id }}"
                                                    {{ old('auction_type_id', $product->auction_type_id) == $at->id ? 'selected' : '' }}>
                                                    {{ $at->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('auction_type_id'))
                                                <div class="error">{{$errors->first('auction_type_id')}}</div>
                                                @endif
                                            </div>
                                           
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label><strong>Status</strong></label>
                                                    <select name="status" class="form-control">
                                                        <option value="new" {{ old('status', $product->status) == 'new' ? 'selected' : '' }}>
                                                            {{ session('locale') === 'ar' ? 'جديد' : 'New' }}
                                                        </option>
                                                        <option value="open" {{ old('status', $product->status) == 'open' ? 'selected' : '' }}>
                                                            {{ session('locale') === 'ar' ? 'مفتوح' : 'Open' }}
                                                        </option>
                                                        <option value="suspended" {{ old('status', $product->status) == 'suspended' ? 'selected' : '' }}>
                                                            {{ session('locale') === 'ar' ? 'معلق' : 'Suspended' }}
                                                        </option>
                                                        <option value="closed" {{ old('status', $product->status) == 'closed' ? 'selected' : '' }}>
                                                            {{ session('locale') === 'ar' ? 'مغلق' : 'Closed' }}
                                                        </option>
                                                    </select>
                                                    @if($errors->has('status'))
                                                        <div class="error">{{ $errors->first('status') }}</div>
                                                    @endif
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label><strong> {{ session('locale') === 'ar' ? 'منشور' : 'Is Published' }}:</strong></label>
                                                    <!-- الحقل المخفي يضمن إرسال قيمة 0 إذا لم يتم تحديد الـ checkbox -->
                                                    <input type="hidden" name="is_published" value="0">
                                                    <input type="checkbox" name="is_published" value="1" 
                                                        {{ old('is_published', $product->is_published) ? 'checked' : '' }}>
                                                </div>
                                           
                                            
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose Project <span class="star">*</span>:</strong></label>
                                                <select name="project_id"
                                                    class="choices__list choices__list--single form-control" id="project"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Select Project</option>
                                                    @foreach ($projects as $pr)
                                                    <option value="{{ $pr->id }}"
                                                    {{ old('project_id', $product->project_id) == $pr->id ? 'selected' : '' }}>
                                                    {{ $pr->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('project_id'))
                                                <div class="error">{{$errors->first('project_id')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>End Date & Time</strong></label>
                                                <input class="multisteps-form__input form-control" type="text" id="end_date"
                                                    name="auction_end_date"
                                                    value="{{ old('auction_end_date', $product->auction_end_date) }}" data-input 
                                                    data-enable-time data-date-format="Y-m-d H:i" data-min-date="{{ date('Y-m-d') }}">
                                                @if($errors->has('auction_end_date'))
                                                <div class="error">{{ $errors->first('auction_end_date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                      
                                        <div class="row mt-3">
                                          <div class="col-12 col-sm-6 mb-3 test">
					    <label><strong>Is Popular:</strong></label>
					    <input type="checkbox" name="is_popular" value="1" @if($product->is_popular) checked @endif>
					</div>

                                           <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Price</strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="reserved_price" name="reserved_price"
                                                    placeholder="eg. Reserved Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('reserved_price', $product->reserved_price)}}">
                                                @if($errors->has('reserved_price'))
                                                <div class="error">{{ $errors->first('reserved_price') }}</div>
                                                @endif
                                            </div>
                                            
                                        </div>
                                            <h6>Estimated Price Range </h6>
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Start Price <span class="star">*</span> </strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="start_price"
                                                    placeholder="Eg. Estimated Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('start_price', $product->start_price)}}">
                                                @if($errors->has('start_price'))
                                                <div class="error">{{ $errors->first('start_price') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>End Price <span class="star">*</span> </strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="end_price"
                                                    placeholder="Eg. Estimated Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('end_price', $product->end_price)}}">
                                                @if($errors->has('end_price'))
                                                <div class="error">{{ $errors->first('end_price') }}</div>
                                                @endif
                                            </div>
                                           <!-- if auction type = live then enable otherwise hide -->
                                            <div class="col-12 col-sm-6 mb-3"  id="minsellingprice">
                                                <label><strong>Min Selling Price <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    name="minsellingprice"
                                                    placeholder="Eg. Min Selling  Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('minsellingprice') }}">
                                                @if($errors->has('minsellingprice'))
                                                <div class="error">{{ $errors->first('minsellingprice') }}</div>
                                                @endif
                                            </div>  
                                        </div>
                                        <!-- gallery image -->
                                        <div class="col-12 col-sm-12 mt-3 mb-3">
                                            <label><strong>Add or Update Gallery Images</strong></label>
                                            <input class="multisteps-form__input form-control" type="file" id="gallery" name="image_path[]" multiple accept="image/*" onchange="previewImages()">
                                            <div class="image-preview" id="image-preview">
                                            </div>
                                            <div class="image-preview">
                                                @foreach($galleryImages as $image)
                                                    <div class="image-container productImage{{$image->id}}">
                                                       
                                                        <img src="{{ asset($image->image_path) }}" alt="Gallery Image">
                                                        <!-- <button type="button" class="" > -->
                                                            <i class="fa fa-remove remove-image" style="font-size:24px; position:absolute; cursor:pointer;" data-image-id="{{ $image->id }}" onclick="removeImage(this,'{{ $image->id }}')"></i>
                                                        <!-- </button> -->
                                                        
                                                    </div>
                                                    @endforeach
                                                </div>
                                          
                                        </div>
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description (EN)</label>
                                            @php $description = old('description', $product->description) @endphp
                                            <x-forms.tinymce-editor :name="'description'" :data="$description" />
                                        </div>
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description (AR)<span class="star">*</span></label>
                                            @php $description = old('description_ar', $product->description_ar) @endphp
                                            <x-forms.tinymce-editor :name="'description_ar'" :data="$description"/>
                                            @if($errors->has('description_ar'))
                                                <div class="error">{{$errors->first('description_ar')}}</div>
                                                @endif
                                        </div>
                                        <div class="button-row d-flex">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Update Product Auction</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-head.tinymce-config />
<script>
function removeImage(button,id) {
    $.ajax({
        url: "{{ url('admin/products/remove')}}"+'/'+id,
        type: 'GET',
        success: function(response) {
            // $('.image-container[data-image-id='+id+']').remove();
            $(".productImage"+id).remove();
            // alert("Removed");
        },
        error: function(xhr) {
            alert('An error occurred while deleting the image.');
        }
    });
}

</script>
    <script>
    function previewImages() {
        var preview = document.getElementById('image-preview');
        preview.innerHTML = '';

        var files = document.getElementById('gallery').files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                var image = document.createElement('img');
                image.src = e.target.result;
                preview.appendChild(image);
            };

            reader.readAsDataURL(file);
        }
    }
</script>



    <script>
    window.addEventListener('DOMContentLoaded', (event) => {
        // Get the elements and initial deposit value
        var depositField = document.getElementById('deposit_field');
        var depositOptionWith = document.getElementById('with_deposit');
        var depositOptionWithout = document.getElementById('without_deposit');
        var depositAmountInput = document.getElementById('deposit_amount');
        var initialDepositValue = {{ $product->deposit }};
        
        // Function to toggle deposit field visibility
        function toggleDepositField() {
            if (depositOptionWith.checked) {
                depositField.style.display = 'block';
            } else {
                depositField.style.display = 'none';
                depositAmountInput.value = '';
            }
        }

        // Add change event listener to radio buttons
        depositOptionWith.addEventListener('change', toggleDepositField);
        depositOptionWithout.addEventListener('change', toggleDepositField);

        // Initial visibility based on the initial deposit value
        if (initialDepositValue === 1) {
            depositOptionWith.checked = true;
            toggleDepositField();
        } else {
            depositOptionWithout.checked = true;
            toggleDepositField();
        }
    });
</script>
</x-admin-layout>

<script>
   $('#brand').on('change', function () {
    var auctionType = $(this).val();
    if (auctionType) {
        $.ajax({
            type: 'GET',
            url: 'get-project/' + auctionType,
            success: function (data) {
                $('#project').empty();
                $('#project').append($('<option value="">Select Project</option>'));
                $.each(data, function (key, value) {
                    $('#project').append($('<option value="' + value.id + '">' + value.name + '</option>'));
                });
            }
        });
    } else {
        $('#project').empty();
        $('#project').append($('<option value="">Select Project</option>'));
    }
});

</script>
<script>
$(document).ready(function() {
    $("#brand").on("change", function() {
        var selectedValue = $(this).val();
        if (selectedValue === "2") {
            $("#end-date-container").hide();
            $("#minsellingprice").show();
        } else {
            $("#end-date-container").show();
            $("#minsellingprice").hide();
        }
    });

    $("#brand").trigger("change");
});
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    flatpickr("#end_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "{{ date('Y-m-d') }}",
    });
</script>

<style>
.image-preview {
    display: flex;
    flex-wrap: wrap;
    margin: 15px;
}

.image-preview img {
    max-width: 140px;
    max-height: 100px;
    margin: 10px;
}

.remove-field {
    margin-top: 30px;
}
.test {
    margin-top: 3rem !important;
}
.star {
    color:#c97f7f;
}
</style>
