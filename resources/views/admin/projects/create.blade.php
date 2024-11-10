
    

<x-admin-layout>

    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Projects', 'link' => 'admin.projects.index', 'page' => 'Create
        Project'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.projects.store')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Add Project</h5>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Name (EN) <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" type="text" name="name"
                                                    placeholder="Eg. Name" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('name')}}">
                                                @if($errors->has('name'))
                                                <div class="error">{{$errors->first('name')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Name (AR) <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" type="text" name="name_ar"
                                                    placeholder="مثل. اسم" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('name_ar')}}">
                                                @if($errors->has('name_ar'))
                                                <div class="error">{{$errors->first('name_ar')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Project Image<span class="star">*</span></label>
                                                <input class="form-control" type="file" placeholder="Project Image"
                                                    onfocus="focused(this)" name="image_path"
                                                    accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)">
                                                @if($errors->has('image_path'))
                                                <div class="error">{{$errors->first('image_path')}}</div>
                                                @endif
                                            </div>
                                            
                                           
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Start Date & Time <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__inputs form-control" type="text" id="start_date" name="start_date_time"
                                                    value="{{ old('start_date_time') }}" data-input
                                                    data-enable-time data-date-format="Y-m-d H:i" data-min-date="{{ date('Y-m-d') }}">
                                                @if($errors->has('start_date_time'))
                                                <div class="error">{{ $errors->first('start_date_time') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>End Date & Time <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__inputs form-control" type="text" id="start_date" name="end_date_time"
                                                    value="{{ old('end_date_time') }}" data-input
                                                    data-enable-time data-date-format="Y-m-d H:i" data-min-date="{{ date('Y-m-d') }}">
                                                @if($errors->has('end_date_time'))
                                                <div class="error">{{ $errors->first('end_date_time') }}</div>
                                                @endif
                                            </div>

                                          
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Buyers_Premium <span class="star">*</span></strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="buyers_premium"
                                                    placeholder="Eg. Buyer's Premium in Percentage" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('buyers_premium') }}">
                                                @if($errors->has('buyers_premium'))
                                                <div class="error">{{ $errors->first('buyers_premium') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Status</label>
                                                <select class="choices__list choices__list--single form-control"
                                                    name="status" id="choices-gender" tabindex="-1" data-choice="active">
                                                    <option value="0">Draft</option>
                                                    <option selected value="1">Published</option>
                                                </select>
                                                @if($errors->has('status'))
                                                <div class="error">{{$errors->first('status')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose AuctionType <span class="star">*</span></strong></label>
                                                <select name="auction_type_id"
                                                    class="choices__list choices__list--single form-control" id="brand"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Choose AuctionType</option>
                                                    @foreach ($auctiontype as $at)
                                                    <option value="{{ $at->id }}">{{ $at->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('auction_type_id'))
                                                <div class="error">{{$errors->first('auction_type_id')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose a Category <span class="star">*</span></strong></label>
                                                <select name="category_id"
                                                    class="choices__list choices__list--single form-control"
                                                    id="category" tabindex="-1" data-choice="active">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $cat)

                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('category_id'))
                                                <div class="error">{{$errors->first('category_id')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6" id="end-date-container">
                                                <label><strong>Deposit Amount (Private & Live) </strong></label>
                                                <input class="multisteps-form__input form-control" type="text"  name="deposit_amount"
                                                    value="{{ old('deposit_amount') }}">
                                                 @if($errors->has('deposit_amount'))
                                                <div class="error">{{$errors->first('deposit_amount')}}</div>
                                                @endif
                                            </div>

                                            <div class="col-12 col-sm-6 mb-2">
                                                <label><strong>Is Trending:</strong></label>
                                                <input type="checkbox" name="is_trending" value="1">
                                            </div>
                                            <div class="button-row d-flex">
                                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                    title="Submit">Add Project</button>
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
</x-admin-layout>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    flatpickr("#start_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "{{ date('Y-m-d') }}",
    });
</script>
<script>
$(document).ready(function() {
    $("#brand").on("change", function() {
        // Get the selected value
        var selectedValue = $(this).val();
        if (selectedValue === "3") {
            $("#end-date-container").hide();
        } else {
            $("#end-date-container").show();
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
<script>
    
flatpickr(".multisteps-form__inputs", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today", 
  
    onReady: function(selectedDates, dateStr, instance) {
        const today = instance.days.querySelector('.today');
        if (today) {
            today.classList.remove('today');
        }
    }
   
});

</script>

<style>
.test {
    margin-top: 2rem !important;
}
.star {
    color:#c97f7f;
}
</style>
