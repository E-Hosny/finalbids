@if ($message = Session::get('success'))
            <div id="flashMessagePopup" class=" col-lg-3 col-md-3 alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                
                $(document).ready(function () {
                    $('#flashMessagePopup').fadeIn('slow');
                    $('#flashMessagePopup').delay(2000).fadeOut('slow');
                });
            </script>
        @endif