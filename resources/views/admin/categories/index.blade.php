
<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Categories', 'link' => 'admin.categories.index', 'page' => ''])
        <div class="container-fluid">
       @include('flash-message')
        <div class="row">
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
                        {{ $dataTable->table(['id' => 'category-table', 'class' => 'table-responsive']) }}

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
                data.column(3).search(created_at).draw();
            }
        });

        $('#clearBtns').on('click', function() {
            $('#created_at').val(''); 
            data.column(3).search('').draw(); 
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

    $('#clearBtns').click(function() {
        $('#created_at').val('');
    });
    });
</script>
@endpush
</x-admin-layout>



