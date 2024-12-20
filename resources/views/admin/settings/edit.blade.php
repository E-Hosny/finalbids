<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Pages', 'link' => 'admin.settings.index', 'setting' => 'Edit Page'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.settings.update', $setting)}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Edit Page</h5>
                                    <!-- <p class="mb-0 text-sm">Mandatory informations</p> -->
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Title (EN) <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" type="text"
                                                    name="title" placeholder="eg. Michael" onfocus="focused(this)"
                                                    onfocusout="defocused(this)"
                                                    value="{{old('title', $setting->title)}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Title (AR) <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" type="text"
                                                    name="title_ar" placeholder="eg. Michael" onfocus="focused(this)"
                                                    onfocusout="defocused(this)"
                                                    value="{{old('title_ar', $setting->title_ar)}}">
                                                @if($errors->has('title_ar'))
                                                <div class="error">{{$errors->first('title_ar')}}</div>
                                                @endif
                                            </div>
                                            <!-- <div class="col-12 col-sm-6 mb-3">
                                                <label>Slug <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" name="slug"
                                                    type="text" placeholder="eg. Prior" onfocus="focused(this)"
                                                    onfocusout="defocused(this)"
                                                    value="{{old('slug', $setting->slug)}}">
                                                @if($errors->has('slug'))
                                                <div class="error">{{$errors->first('slug')}}</div>
                                                @endif
                                            </div> -->
                                        </div>
                                       
                                        <div class="row">
                                            
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label>Value (EN) <span class="star">*</span></label>
                                                    <input class="multisteps-form__input form-control" type="text"
                                                        name="value" placeholder="eg. Michael" onfocus="focused(this)"
                                                        onfocusout="defocused(this)"
                                                        value="{{old('value', $setting->value)}}">
                                                    @if($errors->has('value'))
                                                    <div class="error">{{$errors->first('value')}}</div>
                                                    @endif
                                                </div>
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label>Value (AR) <span class="star">*</span></label>
                                                    <input class="multisteps-form__input form-control" type="text"
                                                        name="value_ar" placeholder="eg. Michael" onfocus="focused(this)"
                                                        onfocusout="defocused(this)"
                                                        value="{{old('value_ar', $setting->value_ar)}}">
                                                    @if($errors->has('value_ar'))
                                                    <div class="error">{{$errors->first('value_ar')}}</div>
                                                    @endif
                                                </div>
                                             
                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label>Setting Image <span class="star">*</span></label>
                                                    <input class="form-control" type="file" placeholder="Blog Image"
                                                        onfocus="focused(this)" name="image"
                                                        accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)">
                                                    @if($errors->has('image'))
                                                    <div class="error">{{$errors->first('image')}}</div>
                                                    @endif
                                                </div>

                                                <div class="col-12 col-sm-6 mb-3">
                                                    <label>Setting Image (AR) <span class="star">*</span></label>
                                                    <input class="form-control" type="file" placeholder="Blog Image"
                                                        onfocus="focused(this)" name="image_ar"
                                                        accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)">
                                                    @if($errors->has('image_ar'))
                                                    <div class="error">{{$errors->first('image_ar')}}</div>
                                                    @endif
                                                </div>
                                               
                                        </div>
                                        
                                        <div class="button-row d-flex">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Update Setting</button>
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

<style>

.star {
    color:#c97f7f;
}
</style>