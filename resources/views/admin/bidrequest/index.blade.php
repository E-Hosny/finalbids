<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'BidRequest', 'link' => 'admin.bidrequests.index', 'page' => ''])
        <div class="container-fluid">
        @include('flash-message')
        <div class="row">
                <!-- <div class="col-lg-2 col-md-6">
                    <label class="tests" for="created_at">Created At</label>
                    <input type="date" id="created_at" name="created_at" class="form-control">
                </div>


                <div class="col-lg-4 col-md-12 col1 mt-4">
                    <button id="filters" class="btn btn-primary btn-fw">Apply Filters</button>
                    <button class="btn btn-primary btn-fw" id="clearBtns">Reset Filters</button>
                </div> -->
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
                if (status === 0) {
                    button.removeClass('btn-success').addClass('btn-danger').text('Decline').data('status', 1);
                } else {
                    button.removeClass('btn-danger').addClass('btn-success').text('Approved').data('status', 0);
                }
                location.reload();
            }
        },
        error: function(error) {
            console.error('Status update failed:', error);
        }
    });
});
</script>
@endpush
</x-admin-layout>