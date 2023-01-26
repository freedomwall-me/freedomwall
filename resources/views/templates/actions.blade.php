<!-- 3 dots menu, edit, delete, publish (if draft)/unpublish (if release) -->
<div class="dropdown">
    <button type="button" class="btn btn-outline-secondary" id="dropdownMenuButton" data-bs-toggle="dropdown"
        aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
            <path
                d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
        </svg>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item no-decor" href="{{ route('wall.edit', $wall->id) }}">Edit</a>
        @if ($wall->publish_status == 'draft')
            <a class="dropdown-item no-decor link-success" href="{{ route('wall.update', $wall->id) }}"
                onclick="event.preventDefault(); document.getElementById('publish-form').submit();">
                Publish
            </a>
            <form id="publish-form" action="{{ route('wall.update', $wall->id) }}" method="POST"
                style="display: none;">
                @csrf
                @method('PUT')
                <input type="hidden" name="publish_status" value="published">
            </form>
        @else
            <a class="dropdown-item no-decor link-warning" href="{{ route('wall.update', $wall->id) }}"
                onclick="event.preventDefault(); document.getElementById('unpublish-form').submit();">
                Unpublish
            </a>
            <form id="unpublish-form" action="{{ route('wall.update', $wall->id) }}" method="POST"
                style="display: none;">
                @csrf
                @method('PUT')
                <input type="hidden" name="publish_status" value="draft">
            </form>
        @endif
        <a class="dropdown-item no-decor link-danger" href="{{ route('wall.destroy', $wall->id) }}"
            onclick="if (window.confirm('Are you sure? This action cannot be undone.')) {
                        event.preventDefault();
                        document.getElementById('delete-form').submit();
                    }">
            Delete
        </a>
        <form id="delete-form" action="{{ route('wall.destroy', $wall->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
