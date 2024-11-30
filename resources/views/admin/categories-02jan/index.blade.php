
@php
    $langId =\App\Models\Language::where('status',1)->get();

@endphp
<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Categories', 'link' => 'admin.categories.index', 'page' => ''])
        <div class="container-fluid">
       @include('flash-message')
        <div class="row">
         <div class="col-lg-2 col-md-6">
                <label class="tests" for="langId"><strong>Select Language:</strong></label>
                <select name="lang_id" class="choices__list choices__list--single form-control" id="langId" tabindex="-1" data-choice="active">
                @foreach ($langId as $at)
                    <option value="{{ $at->short_name }}">{{ $at->name }}</option>
                @endforeach
                </select>
              </div>
              <div class="col-lg-2 col-md-6">
                    <label class="tests" for="created_at">Created At</label>
                    <input type="date" id="created_at" name="created_at" class="form-control">
                </div>

                <div class="col-lg-4 col-md-12 col1 mt-4">
                    <button id="filters" class="btn btn-primary btn-fw">Apply Filters</button>
                    <button class="btn btn-primary btn-fw" id="clearBtns">Reset Filters</button>
                </div>
            </div>
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
    
    <script type="module">
        $(document).ready(function() {
        if ($.fn.dataTable.isDataTable('#category-table')) {
            var data = $('#category-table').DataTable();
        } else {
            var data = $('#category-table').DataTable({
                paging: false
            });
        }

        $('#filters').on('click', function() {
            var created_at = $('#created_at').val(); 

            if (created_at) {
                data.column(4).search(created_at).draw();
            }
        });

        $('#clearBtns').on('click', function() {
            $('#created_at').val(''); 
            data.column(4).search('').draw(); 
            console.log('Filters Cleared');
        });
    });
    $(document).ready(function() {
    if ($.fn.dataTable.isDataTable('#category-table')) {
        var data = $('#category-table').DataTable();
    } else {
        var data = $('#category-table').DataTable({
            paging: false
        });
    }
    $('#filters').click(function() {
        var langId = $('#langId').val(); 
        data.column(2).search(langId).draw();
    });

    $('#clearBtns').click(function() {
        data.column(2).search('en').draw();
    });
});
</script>
@endpush
</x-admin-layout>



