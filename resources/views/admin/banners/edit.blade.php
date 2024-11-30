<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Banner', 'link' => 'admin.banners.index', 'page' => 'Edit
        Banner'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12"> 
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.banners.update', $banner)}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Edit Banner</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Title (EN) <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" type="text" name="title"
                                                    placeholder="eg. Title" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('title', $banner->title)}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Title (AR) <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" type="text" name="title_ar"
                                                    placeholder="eg. عنوان" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('title_ar', $banner->title_ar)}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title_ar')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose Project Url <span class="star">*</span></strong></label>
                                                <select name="url"
                                                    class="choices__list choices__list--single form-control" id="brand"
                                                    tabindex="-1" data-choice="active">
                                                    @foreach ($project as $at)
                                                    <option value="{{ $at->slug }}" {{ old('url', $banner->url) == $at->slug ? 'selected' : '' }}>{{ $at->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('url'))
                                                <div class="error">{{$errors->first('url')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Banner Image </label>
                                                <input class="form-control" type="file" placeholder="Banner Image"
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
                                                    <option {{old('status', $banner->status) == 0 ? "selected" : ""}}
                                                        value="0">
                                                        Draft</option>
                                                    <option {{old('status', $banner->status) == 1 ? "selected" : ""}}
                                                        value="1">
                                                        Published
                                                    </option>
                                                </select>
                                                @if($errors->has('status'))
                                                <div class="error">{{$errors->first('status')}}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description <span class="star">*</span></label>
                                            @php $description = old('description', $banner->description) @endphp
                                            <x-forms.tinymce-editor :name="'description'" :data="$description" />
                                            @if($errors->has('description'))
                                                <div class="error">{{$errors->first('description')}}</div>
                                                @endif
                                        </div>
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description (AR) <span class="star">*</span></label>
                                            @php $description = old('description', $banner->description_ar) @endphp
                                            <x-forms.tinymce-editor :name="'description_ar'" :data="$description" />
                                            @if($errors->has('description_ar'))
                                                <div class="error">{{$errors->first('description_ar')}}</div>
                                                @endif
                                        </div>
                                        <div class="button-row d-flex">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Update Banner</button>
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