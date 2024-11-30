<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Countries', 'link' => 'admin.countries.index', 'page' => 'list'])
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{ $dataTable->table(['class' => 'table-responsive']) }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    @push('script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush

</x-admin-layout>