<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Contact Us', 'link' => 'admin.contact-us.index', 'page' =>
        'Details'])
        <div class="container-fluid py-4">
            <div class="row mt-4">
                <div class="card">
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="card p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                            <h5 class="font-weight-bolder mb-0">View Contact Us</h5>
                            <div class="row mt-3">
                                <div class="col-12 col-sm-12">
                                    <label for="name">Name</label>
                                    <p class="mb-0">{{ $contact_us->name }}</p>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <label for="message">Message</label>
                                    <p class="mb-0">{{ $contact_us->message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>