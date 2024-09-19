<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Categories', 'link' => 'admin.categories.index', 'page' => 'Create
        Category'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.categories.store')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Add Category</h5>
                                    
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
                                                <label>Banner Image <span class="star">*</span> </label>
                                                <input class="form-control" type="file" placeholder="Banner Image"
                                                    onfocus="focused(this)" name="image_path"
                                                    accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)">
                                                @if($errors->has('image_path'))
                                                <div class="error">{{$errors->first('image_path')}}</div>
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
                                         
                                            <div class="button-row d-flex">
                                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                    title="Submit">Add Category</button>
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
<style>

.star {
    color:#c97f7f;
}
</style>