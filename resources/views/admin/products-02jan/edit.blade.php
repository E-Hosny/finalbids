<x-admin-layout>
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
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Title</label>
                                                <input class="multisteps-form__input form-control" type="text" name="title"
                                                    placeholder="eg.Title" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('title', $product->title)}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose a Category:</strong></label>
                                                <select name="category_id"
                                                    class="choices__list choices__list--single form-control" id="category"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose a SubCategory::</strong></label>
                                                <select name="subcategory_id"
                                                    class="choices__list choices__list--single form-control" id="category"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Select SubCategory</option>
                                                    @foreach ($subcat as $scat)
                                                    <option value="{{ $scat->id }}"
                                                        {{ old('subcategory_id', $product->subcategory_id) == $scat->id ? 'selected' : '' }}>
                                                        {{ $scat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose a Brand:</strong></label>
                                                <select name="brand_id"
                                                    class="choices__list choices__list--single form-control" id="category"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Select Brand</option>
                                                    @foreach ($brands as $b)
                                                    <option value="{{ $b->id }}"
                                                        {{ old('brand_id', $product->brand_id) == $b->id ? 'selected' : '' }}>
                                                        {{ $b->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose a AuctionType::</strong></label>
                                                <select name="auction_type_id"
                                                    class="choices__list choices__list--single form-control" id="category"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Select AuctionType</option>
                                                    @foreach ($auctiontype as $at)
                                                    <option value="{{ $at->id }}"
                                                        {{ old('auction_type_id', $product->auction_type_id) == $at->id ? 'selected' : '' }}>
                                                        {{ $at->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Status</label>
                                                <select class="choices__list choices__list--single form-control"
                                                    name="status" id="choices-gender" tabindex="-1" data-choice="active">
                                                    <option value="new"
                                                        {{ old('status', $product->status) == 'new' ? 'selected' : '' }}>New
                                                    </option>
                                                    <option value="open"
                                                        {{ old('status', $product->status) == 'open' ? 'selected' : '' }}>
                                                        Open</option>
                                                    <option value="suspended"
                                                        {{ old('status', $product->status) == 'suspended' ? 'selected' : '' }}>
                                                        Suspended</option>
                                                    <option value="closed"
                                                        {{ old('status', $product->status) == 'closed' ? 'selected' : '' }}>
                                                        Closed</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                <div class="error">{{ $errors->first('status') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Auction Start Date</strong></label>
                                                <input class="multisteps-form__input form-control" type="date"
                                                    id="start_date" name="auction_start_date"
                                                    value="{{ old('auction_start_date', $product->auction_start_date) }}"
                                                    min="{{ date('Y-m-d') }}">
                                                @if($errors->has('auction_start_date'))
                                                <div class="error">{{ $errors->first('auction_start_date') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Auction End Date</strong></label>
                                                <input class="multisteps-form__input form-control" type="date" id="end_date"
                                                    name="auction_end_date"
                                                    value="{{ old('auction_end_date', $product->auction_end_date) }}"
                                                    min="{{ date('Y-m-d') }}">
                                                @if($errors->has('auction_end_date'))
                                                <div class="error">{{ $errors->first('auction_end_date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                           <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Auction Start Time</strong></label>
                                                <input class="multisteps-form__input form-control" type="time"
                                                    id="start_time" name="auction_start_time"
                                                    value="{{ old('auction_start_time', $product->auction_start_time)}}">
                                                @if($errors->has('auction_start_time'))
                                                <div class="error">{{ $errors->first('auction_start_time') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Auction End Time</strong></label>
                                                <input class="multisteps-form__input form-control" type="time" id="end_time"
                                                    name="auction_end_time" value="{{ old('auction_end_time', $product->auction_end_time)}}">
                                                @if($errors->has('auction_end_time'))
                                                <div class="error">{{ $errors->first('auction_end_time') }}</div>
                                                @endif
                                            </div>   
                                        </div>
                                        <div class="row mt-3">
                                           <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Reserved Price</strong></label>
                                                <input class="multisteps-form__input form-control" type="number" step="0.01"
                                                    id="reserved_price" name="reserved_price"
                                                    placeholder="eg. Reserved Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('reserved_price', $product->reserved_price)}}">
                                                @if($errors->has('reserved_price'))
                                                <div class="error">{{ $errors->first('reserved_price') }}</div>
                                                @endif
                                            </div>
                                            <!-- <div class="col-12 col-sm-6">
                                                <label><strong>No Of Entries</strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    name="no_of_entries" placeholder="eg. No Of Entries"
                                                    onfocus="focused(this)" onfocusout="defocused(this)"
                                                    value="{{old('no_of_entries',$product->no_of_entries)}}">
                                                @if($errors->has('no_of_entries'))
                                                <div class="error">{{$errors->first('no_of_entries')}}</div>
                                                @endif
                                            </div> -->
                                        </div>  
                                        <!-- <div class="col-12 col-sm-6">
                                            <label><strong>Deposit</strong></label>
                                            <div class="radio_listing">
                                                <div class="radio_list">
                                                    <input type="radio" id="with_deposit" name="deposit" value="1" onchange="toggleDepositField()" {{ $product->deposit == 1 ? 'checked' : '' }}>
                                                    
                                                    <label for="with_deposit"><strong>With Deposit</strong></label>
                                                </div>
                                                <div class="radio_list">
                                                    <input type="radio" id="without_deposit" name="deposit" value="0" onchange="toggleDepositField()"
                                                    {{ $product->deposit == 0 ? 'checked' : '' }}>
                                                    <label for="without_deposit">Without Deposit</label>
                                                </div>
                                            </div>
                                            <div id="deposit_field" style="display: block;">
                                              
                                                <input class="multisteps-form__input form-control" type="number" id="deposit_amount" name="deposit_amount"
                                                    placeholder="eg. Deposit Amount" onfocus="focused(this)" onfocusout="defocused(this)"
                                                    value="{{ old('deposit_amount',$product->deposit_amount) }}">
                                                @if($errors->has('deposit_amount'))
                                                <div class="error">{{ $errors->first('deposit_amount') }}</div>
                                                @endif
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-12 col-sm-6">
                                            <label><strong>Is_It_Bid_Increment</strong></label>
                                            <div class="radio_listing">
                                                <div class="radio_list">
                                                    <input type="radio" id="yes_radio" name="Is_It_Bid_Increment" value="1" onchange="toggleBidIncrementField()" {{ $product->Is_It_Bid_Increment == 1 ? 'checked' : '' }}>
                                                    <label for="yes_radio"><strong>Yes</strong></label>
                                                </div>
                                                <div class="radio_list">
                                                    <input type="radio" id="no_radio" name="Is_It_Bid_Increment" value="0" onchange="toggleBidIncrementField()" {{ $product->Is_It_Bid_Increment == 0 ? 'checked' : '' }}>
                                                    <label for="no_radio">No</label>
                                                </div>
                                            </div>
                                            <div id="bidincrement_field" style="display: {{ $product->Is_It_Bid_Increment == 1 ? 'block' : 'none' }}">
                                                <input class="multisteps-form__input form-control" type="number" id="Bid_Increment" name="Bid_Increment" placeholder="eg. Bid_Increment" onfocus="focused(this)" onfocusout="defocused(this)" value="{{ old('Bid_Increment', $product->Bid_Increment) }}">
                                                @if($errors->has('Bid_Increment'))
                                                    <div class="error">{{ $errors->first('Bid_Increment') }}</div>
                                                @endif
                                            </div>
                                        </div>    -->
                                        <!-- gallery image -->
                                        <div class="col-12 col-sm-12 mt-3 mb-3">
                                            <label><strong>Add or Update Gallery Images</strong></label>
                                            <input class="multisteps-form__input form-control" type="file" id="gallery" name="image_path[]" multiple accept="image/*" onchange="previewImages()">
                                            <div class="image-preview" id="image-preview">
                                                @foreach($galleryImages as $image)
                                                    <div class="image-container">
                                                        <img src="{{ asset($image->image_path) }}" alt="Gallery Image">
                                                        @if ($image->id)
                                                            <button class="remove-image" data-image-id="{{ $image->id }}" onclick="removeImage(this)"><i class="fa fa-remove" style="font-size:24px"></i></button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description</label>
                                            @php $description = old('description', $product->description) @endphp
                                            <x-forms.tinymce-editor :name="'description'" :data="$description" />
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

<script>
    function toggleBidIncrementField() {
        var bidincrementField = document.getElementById('bidincrement_field');
        var depositOptionWith = document.getElementById('yes_radio');

        if (depositOptionWith.checked) {
            bidincrementField.style.display = 'block';
        } else {
            bidincrementField.style.display = 'none';
            document.getElementById('Bid_Increment').value = '';
        }
    }
</script>
</x-admin-layout>

<style>
    .image-preview {
        display: flex;
        flex-wrap: wrap;
        margin-top: 16px;
    }

    .image-container {
        position: relative;
        margin: 5px;
    }

    .image-container img {
        max-width: 100px;
        max-height: 100px;
    }

    .remove-image {
        position: absolute;
        top: 0;
        right: 0;
        background-color: red;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>