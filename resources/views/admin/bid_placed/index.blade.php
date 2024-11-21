<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{ $dataTable->table(['class' => 'table table-striped table-bordered']) }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('script')
        {{ $dataTable->scripts() }}
        

{{-- 
        <script>
            $(document).on('click', '.change-status', function () {
                var button = $(this);
                var status = button.data('status');
                var bidRequestId = button.data('id');
        
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.bid-placed.update-status') }}",
                    data: {
                        status: status,
                        bid_request_id: bidRequestId
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Success!', response.message, 'success');
                            // إعادة تحميل الجدول
                            $('#bid_placed-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to update status.', 'error');
                    }
                });
            });
        </script>
         --}}
        
        
    @endpush
</x-admin-layout>
