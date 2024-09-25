<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'BidRequest', 'link' => 'admin.bidrequests.index', 'page' => ''])
        <div class="container-fluid">
        @include('flash-message')
        <div class="row">
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
        if ($.fn.dataTable.isDataTable('#bid_requests-table')) {
            var data = $('#bid_requests-table').DataTable();
        } else {
            var data = $('#bid_requests-table').DataTable({
                paging: false
            });
        }

        $('#filters').on('click', function() {
            var name = $('#name').val();
            var created_at = $('#created_at').val(); 

            // Apply filters
            data.column(2).search(name).draw();
            if (created_at) {
                data.column(4).search(created_at).draw();
            }
        });

        $('#clearBtns').on('click', function() {
            $('#name').val('');
            $('#created_at').val(''); 
            data.column(2).search('').draw();
            data.column(4).search('').draw(); 
            console.log('Filters Cleared');
        });
    });
</script>
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '.change-status', function() {
        var button = $(this);
        var status = button.data('status');
        var bidRequestId = button.data('id');

        $.ajax({
            method: 'POST',
            url: 'update-status', 
            data: {
                status: status,
                bid_request_id: bidRequestId
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    // Update the button appearance and manage button states
                    if (status === 0) { // Decline
                        button.removeClass('btn-success').addClass('btn-danger').text('Declined').data('status', 1).prop('disabled', true);
                        // Hide the approve button
                        button.closest('.d-flex').find('.change-status[data-status="1"]').hide().prop('disabled', true);
                    } else { // Approve
                        button.removeClass('btn-danger').addClass('btn-success').text('Approved').data('status', 0).prop('disabled', true);
                        // Hide the decline button
                        button.closest('.d-flex').find('.change-status[data-status="0"]').hide().prop('disabled', true);
                    }
                    Swal.fire('Success!', 'Status updated successfully.', 'success');
                } else {
                    Swal.fire('Error!', 'Failed to update status.', 'error');
                }
            },
            error: function(error) {
                console.error('Status update failed:', error);
                Swal.fire('Error!', 'Failed to update status.', 'error');
            }
        });
    });
</script>






@endpush
</x-admin-layout>