<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Pages', 'link' => 'admin.pages.index', 'page' => 'Create Page'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.pages.store')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Add Page</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Title <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" type="text"
                                                    name="title" placeholder="eg. Michael" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('title')}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Slug <span class="star">*</span></label>
                                                <input class="multisteps-form__input form-control" name="slug"
                                                    type="text" placeholder="eg. Prior" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('slug')}}">
                                                @if($errors->has('slug'))
                                                <div class="error">{{$errors->first('slug')}}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                               <div class="col-12 col-sm-6 mb-3">
                                                <label>Image</label>
                                                <input class="form-control" type="file" placeholder="Image"
                                                    onfocus="focused(this)" name="image"
                                                    accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)">
                                                @if($errors->has('image'))
                                                <div class="error">{{$errors->first('image')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-12 mb-3">
                                                <label>Content</label>
                                                @php $description = old('description') @endphp
                                                <x-forms.tinymce-editor :name="'content'" :data="$description" />
                                            </div>
                                      
                                        </div>
                                        <div class="button-row d-flex">
                                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit"
                                                title="Submit">Add Page</button>
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