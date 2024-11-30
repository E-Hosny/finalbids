<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Bidvalue', 'link' => 'admin.bidvalues.index', 'page' => 'Edit
        Bidvalue'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.bidvalues.update', $bidvalue)}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Edit BidValue</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6">
                                                <label><strong>Bid Value</strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="bidvalue"
                                                    placeholder="eg.bidvalue" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('bidvalue', $bidvalue->bidvalue) }}">
                                                @if($errors->has('bidvalue'))
                                                <div class="error">{{ $errors->first('bidvalue') }}</div>
                                                @endif
                                            </div>
                                            <!-- <div class="col-12 col-sm-6">
                                                <label><strong>Percentage Value</strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="percentage"
                                                    placeholder="eg. Percentage" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('percentage', $bidvalue->percentage) }}">
                                                @if($errors->has('percentage'))
                                                <div class="error">{{ $errors->first('percentage') }}</div>
                                                @endif
                                            </div> -->
                                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                                <label>status</label>
                                                <select class="choices__list choices__list--single form-control"
                                                    name="status" id="choices-gender" tabindex="-1">
                                                    <option {{old('status', $bidvalue->status) == 0 ? "selected" : ""}}
                                                        value="0">
                                                        Draft</option>
                                                    <option {{old('status', $bidvalue->status) == 1 ? "selected" : ""}}
                                                        value="1">
                                                        Published
                                                    </option>
                                                </select>
                                                @if($errors->has('status'))
                                                <div class="error">{{$errors->first('status')}}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="button-row d-flex mt-4">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Update BidValue</button>
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