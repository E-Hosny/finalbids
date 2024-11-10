
<div class="d-flex">
@if($status)
        <button class="btn btn-link text-dark px-3 mb-0 change-status" data-id="{{ $id }}" data-status="0"><i class="fas fa-unlock-alt"></i></button>
    @else
        <button class="btn btn-link text-danger text-gradient px-3 mb-0 change-status" data-id="{{ $id }}" data-status="1"><i class="fas fa-lock"></i></button>
    @endif
    
    <button class="btn btn-link text-danger text-gradient px-3 mb-0 delete-user" data-id="{{ $id }}"><i class="far fa-trash-alt me-2" aria-hidden="true"></i></button>
</div>