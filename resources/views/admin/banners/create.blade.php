<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Banner', 'link' => 'admin.banners.index', 'page' => 'Create
        Banner'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="col-12 col-lg-8 m-auto">
                            <form action="{{route('admin.banners.store')}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                                    <h5 class="font-weight-bolder mb-0">Add Banner</h5>
                                    <p class="mb-0 text-sm">Mandatory informations</p>
                                    <div class="multisteps-form__content">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Title</label>
                                                <input class="multisteps-form__input form-control" type="text" name="title"
                                                    placeholder="eg. Title" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('title')}}">
                                                @if($errors->has('title'))
                                                <div class="error">{{$errors->first('title')}}</div>
                                                @endif
                                            </div>
                                            <!-- <div class="col-12 col-sm-6">
                                                <label>Url</label>
                                                <input class="multisteps-form__input form-control" type="text" name="url"
                                                    placeholder="eg. Url" onfocus="focused(this)"
                                                    onfocusout="defocused(this)" value="{{old('url')}}">
                                                @if($errors->has('url'))
                                                <div class="error">{{$errors->first('url')}}</div>
                                                @endif
                                            </div> -->
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label><strong>Choose Project Url:</strong></label>
                                                <select name="url"
                                                    class="choices__list choices__list--single form-control" id="brand"
                                                    tabindex="-1" data-choice="active">
                                                    <option value="">Choose Project Url</option>
                                                    @foreach ($project as $at)
                                                    <option value="{{ $at->slug }}">{{ $at->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>Banner Image</label>
                                                <input class="form-control" type="file" placeholder="Banner Image"
                                                    onfocus="focused(this)" name="image_path"
                                                    accept="image/png, image/jpeg, image/jpg" onfocusout="defocused(this)">
                                                @if($errors->has('image'))
                                                <div class="error">{{$errors->first('image_path')}}</div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-6 mb-3">
                                                <label>status</label>
                                                <select class="choices__list choices__list--single form-control"
                                                    name="status" id="choices-gender" tabindex="-1" data-choice="active">
                                                    <option value="0">Draft</option>
                                                    <option selected value="1">Published</option>
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
                                                    title="Submit">Add Blog</button>
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