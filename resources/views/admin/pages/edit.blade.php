<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Pages', 'link' => 'admin.pages.index', 'page' => 'Edit Page'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.pages.update', $page)}}" method="POST"
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
                                                    value="{{old('title', $page->title)}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Title (AR) <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" type="text"
                                                    name="title_ar" placeholder="eg. Michael" onfocus="focused(this)"
                                                    onfocusout="defocused(this)"
                                                    value="{{old('title_ar', $page->title_ar)}}">
                                                @if($errors->has('title_ar'))
                                                <div class="error">{{$errors->first('title_ar')}}</div>
                                                @endif
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label>Pages Image</label>
                                                <input class="form-control" type="file" placeholder="Blog Image"
                                                    onfocus="focused(this)" name="image"
                                                    accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)">
                                                @if($errors->has('image'))
                                                <div class="error">{{$errors->first('image')}}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description (EN) <span class="star">*</span></label>
                                            @php $description = old('content', $page->content) @endphp
                                            <x-forms.tinymce-editor :name="'content'" :data="$description" />
                                            @if($errors->has('content'))
                                                <div class="error">{{$errors->first('content')}}</div>
                                                @endif
                                        </div>
                                        <div class="col-12 col-sm-12 mb-3">
                                            <label>Description (AR) <span class="star">*</span></label>
                                            @php $description = old('content_ar', $page->content_ar) @endphp
                                            <x-forms.tinymce-editor :name="'content_ar'" :data="$description" />
                                            @if($errors->has('content_ar'))
                                                <div class="error">{{$errors->first('content_ar')}}</div>
                                                @endif
                                        </div>
                                        
                                        <div class="button-row d-flex">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Update Page</button>
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