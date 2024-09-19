<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Auctiontype', 'link' => 'admin.auctiontypes.index', 'page' => 'Create
        Blog'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.auctiontypes.store')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Add Auctiontype</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Name</label>
                                                <input class="multisteps-form__input form-control" type="text" name="name"
                                                    placeholder="eg. Name" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('name')}}">
                                                @if($errors->has('name'))
                                                <div class="error">{{$errors->first('name')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>status</label>
                                                <select class="choices__list choices__list--single form-control"
                                                    name="status" id="choices-gender" tabindex="-1" data-choice="active">
                                                    <option value="0">Inactve</option>
                                                    <option selected value="1">Active</option>
                                                </select>
                                                @if($errors->has('status'))
                                                <div class="error">{{$errors->first('status')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-12 mb-3">
                                                <label>Description</label>
                                                @php $description = old('description') @endphp
                                                <x-forms.tinymce-editor :name="'description'" :data="$description" />
                                            </div>
                                            <div class="button-row d-flex">
                                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                    title="Submit">Add Auctiontype</button>
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