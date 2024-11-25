<div class="d-flex">
    @if ($status == 1)
        <button class="btn btn-sm btn-success" disabled>
            Approved
        </button>
    @elseif ($status == 2)
        <button class="btn btn-sm btn-danger" disabled>
            Rejected
        </button>
    @else
        <button class="btn btn-sm btn-success change-status" data-id="{{ $id }}" data-status="1">
            Approve
        </button>
        <button class="btn btn-sm btn-danger change-status" data-id="{{ $id }}" data-status="2">
            Reject
        </button>
    @endif
</div>
