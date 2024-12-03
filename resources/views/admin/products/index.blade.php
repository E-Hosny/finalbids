
@php
    $langId =\App\Models\Language::where('status',1)->get();

@endphp
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
{{-- 
<script>
    $(document).on('click', '.approve-btn', function() {
        var productId = $(this).data('id');
        $.ajax({
            url: '/admin/products/' + productId + '/approve',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#product-table').DataTable().ajax.reload(null, false);
                alert(response.message);
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });
    
    $(document).on('click', '.reject-btn', function() {
        var productId = $(this).data('id');
        Swal.fire({
            title: 'Enter Rejection Reason',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Reject',
            showLoaderOnConfirm: true,
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage('Reason is required');
                } else {
                    return $.ajax({
                        url: '/admin/products/' + productId + '/reject',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            rejection_reason: reason
                        }
                    });
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                // $('#product-table').DataTable().ajax.reload(null, false);
                var table = $('#product-table').DataTable();
                table.row($(this).parents('tr')).data(response.updatedProduct).draw(false);

                Swal.fire(
                    'Rejected!',
                    'Product has been rejected.',
                    'success'
                );
            }
        });
    });
    </script> --}}
    <script>
        $(document).on('click', '.approve-btn', function() {
            var productId = $(this).data('id');
            $.ajax({
                url: '/admin/products/' + productId + '/approve',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#product-table').DataTable().ajax.reload(null, false);
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
        
        $(document).on('click', '.reject-btn', function() {
            var productId = $(this).data('id');
            var $button = $(this); // حفظ مرجع للزر
            Swal.fire({
                title: 'Enter Rejection Reason',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Reject',
                showLoaderOnConfirm: true,
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Reason is required');
                    } else {
                        return $.ajax({
                            url: '/admin/products/' + productId + '/reject',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                rejection_reason: reason
                            }
                        }).then(function(response) {
                            return response;
                        }).catch(function(error) {
                            Swal.showValidationMessage('An error occurred: ' + error.responseText);
                        });
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    var table = $('#product-table').DataTable();
                    var row = $button.closest('tr'); // استخدام مرجع الزر لتحديد الصف
                    var rowData = table.row(row).data();
    
                    // الحصول على البيانات المحدثة من الاستجابة
                    var updatedProduct = result.value.updatedProduct;
    
                    // تحديث البيانات في الصف
                    rowData.approval_status = updatedProduct.approval_status; // يجب أن تحتوي على HTML للبادج
                    rowData.rejection_reason = updatedProduct.rejection_reason; // يجب أن تحتوي على HTML للبادج
                    rowData.action = updatedProduct.action; // يجب أن تحتوي على HTML للأزرار
    
                    // تحديث الصف في DataTable
                    table.row(row).data(rowData).draw(false);
    
                    Swal.fire(
                        'Rejected!',
                        result.value.message,
                        'success'
                    );
                }
            });
        });
    </script>
    
@endpush
</x-admin-layout>