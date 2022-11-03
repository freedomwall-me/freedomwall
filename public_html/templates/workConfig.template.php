<?php if (!isset($work)) die ?>
<?php $id = $work["rowid"] ?>
<button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
    </svg>
</button>
<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    <form action="/profile" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <?php if ($work["type"] == "draft") : ?>
            <a class="dropdown-item" href="/create?edit=<?= $id ?>">Edit</a>
            <input type="hidden" name="operation" value="publish">
            <a class="dropdown-item text-success" href="#" onclick="this.parentNode.submit()">Publish</a>
        <?php else : ?>
            <input type="hidden" name="operation" value="unpublish">
            <a class="dropdown-item text-danger" href="#" onclick="this.parentNode.submit()">Unpublish</a>
        <?php endif; ?>
    </form>
    <form action="/profile" method="post">
        <input type="hidden" name="operation" value="delete">
        <input type="hidden" name="id" value="<?= $id ?>">
        <a class="dropdown-item text-danger" href="#" onclick="this.parentNode.submit()">Delete</a>
    </form>
</div>