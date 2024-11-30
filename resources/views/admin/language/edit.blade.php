<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'language', 'link' => 'admin.language.index', 'page' => 'Edit
        language'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12"> 
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.language.update', $language)}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Edit Language</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Name</label>
                                                <input class="multisteps-form__input form-control" type="text" name="name"
                                                    placeholder="eg. Name" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('name', $language->name)}}">
                                                @if($errors->has('name'))
                                                <div class="error">{{$errors->first('name')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Short Name</label>
                                                <input class="multisteps-form__input form-control" type="text" name="short_name"
                                                    placeholder="eg. short_name" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('short_name', $language->short_name)}}">
                                                @if($errors->has('short_name'))
                                                <div class="error">{{$errors->first('short_name')}}</div>
                                                @endif
                                            </div>
                                        
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Country Image</label>
                                                <input class="form-control" type="file" placeholder="Language Image"
                                                    onfocus="focused(this)" name="image_path"
                                                    accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)">
                                                @if($errors->has('image_path'))
                                                <div class="error">{{$errors->first('image_path')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>status</label>
                                                <select class="choices__list choices__list--single form-control"
                                                    name="status" id="choices-gender" tabindex="-1">
                                                    <option {{old('status', $language->status) == 0 ? "selected" : ""}}
                                                        value="0">
                                                        Draft</option>
                                                    <option {{old('status', $language->status) == 1 ? "selected" : ""}}
                                                        value="1">
                                                        Published
                                                    </option>
                                                </select>
                                                @if($errors->has('status'))
                                                <div class="error">{{$errors->first('status')}}</div>
                                                @endif
                                            </div>
                                        </div>
                                      
                                        <div class="button-row d-flex">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Update Language</button>
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