<div class="d-flex">
    <!-- <a class="btn btn-link text-dark px-3 mb-0" href="{{route('admin.bidvalues.edit', $id)}}"><i
            class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i></a> -->
    <form method="post" action="{{route('admin.bidrequests.destroy', $id)}}">
        @csrf
        @method('DELETE')
        <button class="btn btn-link text-danger text-gradient px-3 mb-0" type="submit"><i class="far fa-trash-alt me-2"
                aria-hidden="true"></i></button>
    </form>
</div>

<!-- admin/bidrequests/actions.blade.php -->
@if($status)
    <button class="btn btn-sm btn-success change-status" data-id="{{ $id }}" data-status="0">Approved</button>
@else
    <button class="btn btn-sm btn-danger change-status" data-id="{{ $id }}" data-status="1">Decline</button>
@endif

