<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Countries', 'link' => 'admin.countries.index', 'page' => 'Edit
        Country'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.countries.update', $country)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Edit Country</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Name</label>
                                                <input class="multisteps-form__input form-control" type="text" name="name"
                                                    placeholder="eg. Michael" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('name', $country->name)}}">
                                                @if($errors->has('name'))
                                                <div class="error">{{$errors->first('name')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Phonecode</label>
                                                <input class="multisteps-form__input form-control" name="phonecode" type="text"
                                                    placeholder="eg. Prior" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('phonecode', $country->phonecode)}}">
                                                @if($errors->has('phonecode'))
                                                <div class="error">{{$errors->first('phonecode')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>status</label>
                                                <select class="choices__list choices__list--single form-control"
                                                    name="status" id="choices-gender" tabindex="-1">
                                                    <option {{old('status', $country->status) == 0 ? "selected" : ""}}
                                                        value="0">
                                                        Inactive</option>
                                                    <option {{old('status', $country->status) == 1 ? "selected" : ""}}
                                                        value="1">
                                                        Active
                                                    </option>
                                                </select>
                                                @if($errors->has('status'))
                                                <div class="error">{{$errors->first('status')}}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="button-row d-flex">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Update Country</button>
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
</x-admin-layout>