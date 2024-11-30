<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar', ['module' => 'News', 'link' => 'admin.news.index', 'page' => ''])
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
        if ($.fn.dataTable.isDataTable('#news-table')) {
            var data = $('#news-table').DataTable();
        } else {
            var data = $('#news-table').DataTable({
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $(document).on('click','.news', function() {
        var userId = $(this).data('id');
        var datas = $('#news-table').DataTable();
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this Enquiry. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.news.destroy', ':id') }}".replace(':id', userId),
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
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush
</x-admin-layout>