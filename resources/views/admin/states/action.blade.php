<div class="d-flex">
    <a class="btn btn-link text-dark px-3 mb-0" href="{{route('admin.states.edit', $id)}}"><i
            class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
    <form method="post" action="{{route('admin.states.destroy', $id)}}">
        @csrf
        @method('DELETE')
        <button class="btn btn-link text-danger text-gradient px-3 mb-0" type="submit"><i class="far fa-trash-alt me-2"
                aria-hidden="true"></i>Delete</button>
    </form>
</div>