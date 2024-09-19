<div class="d-flex">
    <!-- <form method="post" action="{{route('admin.news.destroy', $id)}}">
        @csrf
        @method('DELETE')
        <button class="btn btn-link text-danger text-gradient px-3 mb-0" type="submit"><i class="far fa-trash-alt me-2"
                aria-hidden="true"></i></button>
    </form> -->
    <button class="btn btn-link text-danger text-gradient px-3 mb-0 news" data-id="{{ $id }}"><i class="far fa-trash-alt me-2" aria-hidden="true"></i></button>

</div>