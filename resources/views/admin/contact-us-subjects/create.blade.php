<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Contact Us Subject', 'link' => 'admin.contact-us-subjects.index',
        'page' => 'Create Contact Us Subject'])
        <div class="container-fluid py-4">
            <div class="row mt-4">
                <div class="card">
                    <div class="col-12 col-lg-8 m-auto">
                        <form class="mb-8" action="{{route('admin.contact-us-subjects.store')}}" method="POST"
                            style="height: 408px;">
                            @csrf
                            <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                <h5 class="font-weight-bolder mb-0">Add Contact Us Subject</h5>
                                <p class="mb-0 text-sm">Mandatory informations</p>
                                <div class="multisteps-form__content">
                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-6">
                                            <label>Name</label>
                                            <input class="multisteps-form__input form-control" type="text" name="name"
                                                placeholder="eg. Subject" onfocus="focused(this)"
                                                onfocusout="defocused(this)" value="{{old('name')}}">
                                            @if($errors->has('name'))
                                            <div class="error">{{$errors->first('name')}}</div>
                                            @endif
                                        </div>
                                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                            <label>Short Description</label>
                                            <input class="multisteps-form__input form-control" name="sort_desc"
                                                type="text" placeholder="eg. Description" onfocus="focused(this)"
                                                onfocusout="defocused(this)" value="{{old('sort_desc')}}">
                                            @if($errors->has('sort_desc'))
                                            <div class="error">{{$errors->first('sort_desc')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="button-row d-flex mt-4">
                                        <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                            title="Submit">Add Subject</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>