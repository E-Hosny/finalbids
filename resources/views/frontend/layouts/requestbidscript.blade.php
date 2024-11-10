<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function bidNow() {

    }

    function requestBid() {
        if (!isLoggedIn()) {
            showLoginPrompt();
        } else {
            showBidConfirmation();
        }
    }

    function isLoggedIn() {
        var isLoggedIn = "{{ auth()->check() }}";
        return isLoggedIn === "1";
    }

    function showLoginPrompt() {
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
    }

    function requestBid(projectName, projectId, auctionTypeId, depositAmount) {
        if (!isLoggedIn()) {
            showLoginPrompt();
        } else {
            showBidConfirmation(projectName, projectId, auctionTypeId, depositAmount);
        }
    }


    function showBidConfirmation(projectName, projectId, auctionTypeId, depositAmount) {
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to participate in ${projectName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, bid!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: 'POST',
                    url: '{{ route("store.bid.request") }}',
                    data: {
                        user_id: '{{ auth()->id() }}',
                        project_id: projectId,
                        auction_type_id: auctionTypeId,
                        deposit_amount: depositAmount
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    // success: function(response) {
                    //     Swal.fire('Success!', 'Your request is under process, we will notify you once you have been approved.', 'success');
                    //     window.location.reload();
                    // },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your request is under process, we will notify you once you have been approved.',
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr, status, error) {

                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'Failed to submit bid.', 'error');
                    }
                });
            }
        });
    }
</script>