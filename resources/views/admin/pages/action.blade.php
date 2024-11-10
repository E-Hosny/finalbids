<div class="d-flex">
    <a class="btn btn-link text-dark px-3 mb-0" href="{{route('admin.pages.edit', $id)}}"><i
            class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i></a>
            {{-- Check if is_static is not equal to 1 before displaying the delete button --}}
    @if ($is_static !== 1)
        <form method="post" action="{{ route('admin.pages.destroy', $id) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-link text-danger text-gradient px-3 mb-0" type="submit">
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
            </button>
        </form>
    @endif
</div>

