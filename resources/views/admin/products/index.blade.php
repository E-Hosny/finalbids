
@php
    $langId =\App\Models\Language::where('status',1)->get();

@endphp

<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'ProductAuction', 'link' => 'admin.products.index', 'page' => ''])
        <div class="container-fluid">
        @include('flash-message')
        <div class="row">
             <!-- <div class="col-lg-2 col-md-6">
                <label class="tests" for="langId"><strong>Select Language:</strong></label>
                <select name="lang_id" class="choices__list choices__list--single form-control" id="langId" tabindex="-1" data-choice="active">
                @foreach ($langId as $at)
                    <option value="{{ $at->short_name }}">{{ $at->name }}</option>
                @endforeach
                </select>
              </div>
            
                <div class="col-lg-4 col-md-12 col1 mt-4">
                    <button id="filters" class="btn btn-primary btn-fw">Apply Filters</button>
                    <button class="btn btn-primary btn-fw" id="clearBtns">Reset Filters</button>
                </div>
            </div> -->
            <div class="row">
                <div class="col-lg-12">
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
    if ($.fn.dataTable.isDataTable('#product-table')) {
        var data = $('#product-table').DataTable();
    } else {
        var data = $('#product-table').DataTable({
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


<script>
   $(document).on('click', '.close-auction', function () {
    if (confirm('Are you sure you want to close this auction?')) {
        let productId = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.products.close-auction') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    $('#product-table').DataTable().ajax.reload();
                } else {
                    alert('Failed to close auction!');
                }
            },
            error: function () {
                alert('Error occurred!');
            }
        });
    }
});

</script>
@endpush
</x-admin-layout>