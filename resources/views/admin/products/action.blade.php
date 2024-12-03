<!-- resources/views/admin/products/action.blade.php -->

<div class="d-flex">
    @if($approval_status == 'pending')
        <button data-id="{{ $id }}" class="btn btn-success btn-sm approve-btn me-2">Approve</button>
        <button data-id="{{ $id }}" class="btn btn-danger btn-sm reject-btn me-2">Reject</button>
    @endif

    <a class="btn btn-link text-dark px-3 mb-0" href="{{ route('admin.products.edit', $id) }}">
        <i class="fas fa-pencil-alt text-dark me-2"></i>
    </a>

    <form method="post" action="{{ route('admin.products.destroy', $id) }}" onsubmit="return confirm('Are you sure you want to delete this product?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-link text-danger text-gradient px-3 mb-0" type="submit">
            <i class="far fa-trash-alt me-2"></i>
        </button>
    </form>
</div>
