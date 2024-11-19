<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Product Auction', 'link' => 'admin.products.index', 'page' =>
        'Create
        Product Auction'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.products.store')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Add Product Auction</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Product Title (EN) <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__input form-control" type="text"
                                                    name="title" placeholder="Eg. Product Title" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('title')}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title')}}</div>
                                                @endif

                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Product Title (AR) <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__input form-control" type="text"
                                                    name="title_ar" placeholder="مثل. عنوان المنتج" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('title_ar')}}">
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
                                                    <option value="{{ $at->id }}">{{ $at->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('auction_type_id'))
                                                <div class="error">{{$errors->first('auction_type_id')}}</div>
                                                @endif
                                            </div>
                                          
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose Project <span class="star">*</span>:</strong></label>
                                                <select name="project_id"
                                                    class="choices__list choices__list--single form-control" id="project"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Select Project</option>
                                                    @foreach ($projects as $pr)
                                                    <option value="{{ $pr->id }}">{{ $pr->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('project_id'))
                                                <div class="error">{{$errors->first('project_id')}}</div>
                                                @endif
                                            </div>
                                          

                                            <div class="col-12 col-sm-6 mb-3" id="end-date-container">
                                                <label><strong>End Date & Time </strong></label>
                                                <input class="multisteps-form__input form-control" type="text" id="end_date" name="auction_end_date"
                                                    value="{{ old('auction_end_date') }}" data-input data-enable-time data-date-format="Y-m-d H:i"
                                                    data-min-date="{{ date('Y-m-d') }}">
                                                @if($errors->has('auction_end_date'))
                                                <div class="error">{{ $errors->first('auction_end_date') }}</div>
                                                @endif
                                            </div>
                                            
                                            <div class="col-12 col-sm-6 mb-3 test">
                                                <label><strong>Is Popular:</strong></label>
                                                <input type="checkbox" name="is_popular" value="1">
                                            </div>
                                           
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong> Price <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="reserved_price" name="reserved_price"
                                                    placeholder="Eg. Reserved Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('reserved_price') }}">
                                                @if($errors->has('reserved_price'))
                                                <div class="error">{{ $errors->first('reserved_price') }}</div>
                                                @endif
                                            </div>
                                            <h6>Estimated Price Range </h6>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Start Price <span class="star">*</span> </strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="start_price"
                                                    placeholder="Eg. Estimated Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('start_price') }}">
                                                @if($errors->has('start_price'))
                                                <div class="error">{{ $errors->first('start_price') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>End Price <span class="star">*</span> </strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="end_price"
                                                    placeholder="Eg. Estimated Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('end_price') }}">
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

                                            <div class="col-12 col-sm-12 mb-3">
                                                <label><strong>Gallery Images <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__input form-control" type="file" id="gallery" name="image_path[]" multiple accept="image/*" onchange="previewImages()">
                                                <div class="image-preview" id="image-preview"></div>

                                                @if($errors->has('image_path.0'))
                                                    <div class="error">{{ $errors->first('image_path.0') }}</div>
                                                @endif


                                            </div>

                                        </div>

                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description (EN)<span class="star">*</span></label>
                                            @php $description = old('description') @endphp
                                            <x-forms.tinymce-editor :name="'description'" :data="$description"/>
                                            @if($errors->has('description'))
                                                <div class="error">{{$errors->first('description')}}</div>
                                                @endif
                                        </div>
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description (AR)<span class="star">*</span></label>
                                            @php $description = old('description_ar') @endphp
                                            <x-forms.tinymce-editor :name="'description_ar'" :data="$description"/>
                                            @if($errors->has('description_ar'))
                                                <div class="error">{{$errors->first('description_ar')}}</div>
                                                @endif
                                        </div>
                                        <div class="button-row d-flex">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Add Product Auction</button>
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
   
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('projectForm').addEventListener('submit', function() {
        document.getElementById('submitButton').setAttribute('disabled', 'disabled');
    });
});
});
</script>

    <x-head.tinymce-config />
</x-admin-layout>
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
    margin-top: 10px;
}

.image-preview img {
    max-width: 100px;
    max-height: 100px;
    margin: 5px;
}

.remove-field {
    margin-top: 30px;
}
.test {
    margin-top: 2rem !important;
}
.star {
    color:#c97f7f;
}
</style>