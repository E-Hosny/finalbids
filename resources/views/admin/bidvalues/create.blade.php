<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Bidvalue', 'link' => 'admin.bidvalues.index', 'page' => 'Create
        Bidvalue'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.bidvalues.store')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Add Bid Value</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row mt-3">
                                            <div class="col-12 col-sm-6">
                                                <label><strong>Bid Value</strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="bidvalue"
                                                    placeholder="eg.Min Price" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('bidvalue') }}">
                                                @if($errors->has('bidvalue'))
                                                <div class="error">{{ $errors->first('bidvalue') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label><strong>Increment</strong></label>
                                                <input class="multisteps-form__input form-control" type="number"
                                                    id="estimated_price" name="increment"
                                                    placeholder="eg. increment" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{ old('increment') }}">
                                                @if($errors->has('increment'))
                                                <div class="error">{{ $errors->first('increment') }}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
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
                                            <div class="button-row d-flex mt-4">
                                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                    title="Submit">Add Bidvalue</button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <x-head.tinymce-config />
</x-admin-layout>