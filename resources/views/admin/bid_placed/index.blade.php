
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
    .toast-success {
        background-color: #28a745 !important; /* لون الأخضر */
        color: #fff !important; /* النص أبيض */
    }

    .toast-error {
        background-color: #dc3545 !important; /* لون الأحمر */
        color: #fff !important;
    }

    .toast-info {
        background-color: #17a2b8 !important; /* لون الأزرق */
        color: #fff !important;
    }

    .toast-warning {
        background-color: #ffc107 !important; /* لون الأصفر */
        color: #000 !important;
    }
</style>

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
        


        {{-- <script>
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
        </script> --}}
        
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
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": "3000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr.success(response.message, 'Success');
                            $('#bid_placed-table').DataTable().ajax.reload(); // إعادة تحميل الجدول
                        } else {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": "3000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr.error('Error: ' + response.message, 'Failed');
                        }
                    },
                    error: function () {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "3000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.error('Failed to update status.', 'Error');
                    }
                });
            });
        </script>
        
        


        
    @endpush
</x-admin-layout>
       
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
