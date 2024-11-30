<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Blogs', 'link' => 'admin.blogs.index', 'page' => 'Details'])
        <div class="container-fluid py-4">
            <div class="row mt-4">
                <div class="card">
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                            <h5 class="font-weight-bolder mb-0">View Blog</h5>
                            <div class="row mt-3">
                                <div class="col-12 col-sm-12">
                                    <label for="title">Title</label>
                                    <p class="mb-0">{{ $blog->title }}</p>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <label for="image">Image</label>
                                    <img src="{{ asset('img/blogs/' . $blog->image) }}" width="100px"
                                        alt="Blog Image" />
                                </div>
                                <div class="col-12 col-sm-12">
                                    <label for="description">Description</label>
                                    <p class="mb-0">{!! $blog->description !!}</p>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <label for="status">Status</label>
                                    <p class="mb-0">{{ $blog->status ? "Published" : "Draft" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>