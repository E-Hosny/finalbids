<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('.wishlist-heart').click(function () {
            var productId = $(this).data('product-id');
            var action = $(this).hasClass('active') ? 'remove' : 'add';
            let that = $(this);
            var isLoggedIn = "{{ auth()->check() }}"; 
            
            if (!isLoggedIn) {
                Swal.fire({
                    icon: 'info',
                    title: 'Please Login First',
                    text: 'You need to log in to perform this action.',
                    showCancelButton: true,
                    confirmButtonText: 'Login'
                }).then((result) => {
                    if (result.isConfirmed) {
  
                        localStorage.setItem('redirect_url', window.location.href);

                        window.location.href = '{{ route("signin") }}';
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.reload();
                    }
                });
                return;
            }
          

            // User is logged in, proceed with the wishlist action
            $.ajax({
                type: 'POST',
                url: action === 'add' ? '{{ route("addToWishlist") }}' : '{{ route("removeFromWishlist") }}',
                data: { product_id: productId },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (action === 'add') {
                        that.addClass('active');
                        window.location.reload();
                    } else {
                        that.removeClass('active');
                        that.parents('.productCardDiv').remove();
                        window.location.reload();
                    }
                    // alert(response.message); 
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseJSON.error); 
                }
            });
        });
    });
</script>
