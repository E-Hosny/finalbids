<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'Users', 'link' => 'admin.users.index', 'page' => ''])
        <div class="container-fluid">
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
        if ($.fn.dataTable.isDataTable('#users-table')) {
            var data = $('#users-table').DataTable();
        } else {
            var data = $('#users-table').DataTable({
                paging: false,
                sorting:false,
            });
        }

        $('#filters').on('click', function() {
            var email = $('#email').val();
            var name = $('#name').val();
            var phone = $('#phone').val();
            var created_at = $('#created_at').val();

            // Apply filters
            data.column(3).search(email);
            data.column(2).search(name);
            data.column(4).search(phone);

            if (created_at) {
                data.column(6).search(created_at);
            }
            data.draw();
        });

        $('#clearBtns').on('click', function() {
            $('#email').val('');
            $('#name').val('');
            $('#phone').val('');
            $('#created_at').val('');
            data.column(3).search('');
            data.column(2).search('');
            data.column(4).search('');
            data.column(6).search('');
            console.log('Filters Cleared');
            data.draw();
        });
    });
    </script>
    <script>

$(document).on('click', '.change-status', function() {
    var button = $(this);
    var status = button.data('status');
    var userId = button.data('id');
    var datas = $('#users-table').DataTable();
    
    $.ajax({
        method: 'POST',
        url: 'updateStatususer/' + userId,
        data: {
            status: status,
            id: userId
        },
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.success) {
                var newStatus = (status === 0) ? 1 : 0;
                var buttonText = (newStatus === 0) ? '<i class="fas fa-unlock-alt"></i>' : '<i class="fas fa-lock"></i>';
                var statusText = (newStatus === 0) ? 'activated' : 'inactivated';

                if (newStatus === 0) {
                    button.html('<i class="fas fa-unlock-alt"></i>').data('status', newStatus);
                    datas.draw(false);
                } else {
                    button.html('<i class="fas fa-lock"></i>').data('status', newStatus);
                    datas.draw(false);
                }
                Swal.fire({
                    icon: 'success',
                    title: 'Status Changed!',
                    text: 'The user has been ' + statusText + ' successfully.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },
        error: function(error) {
            console.error('Status update failed:', error);
        }
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $(document).on('click','.delete-user', function() {
        var userId = $(this).data('id');
        var datas = $('#users-table').DataTable();
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this user. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.users.destroy', ':id') }}".replace(':id', userId),
                    type: 'DELETE', 
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // window.location.reload();
                        datas.draw(false);
                   },
                    error: function(xhr) {
                        console.log('Error deleting user');
                    }
                });
                //$('#deleteUserModal').modal('hide');
            }
        });
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @endpush

</x-admin-layout>
