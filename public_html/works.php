<?php
session_start();

require_once "../config.php";

$withId = false;
$db = new PDO("sqlite:" . Config::DATABASE);

if (array_key_exists("id", $_GET)) {
	$withId = true;
	$id = $_GET["id"];
	$work = $db->query(
		"SELECT * FROM user_works
		 WHERE rowid='$id';"
	)->fetch(PDO::FETCH_ASSOC);

	if (!$work || $work["type"] == "draft") {
		http_response_code(404);
		include_once "errors/404.php";
		die;
	}

	$author = $db->query(
		"SELECT username FROM users
		 WHERE uid='" . $work["uid"] . "';"
	)->fetch(PDO::FETCH_ASSOC)["username"];
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
	<?php include "../templates/navbar.template.php"; ?>

	<div class="py-5 container">
		<?php if ($withId) : ?>
			<div class="row">
				<div class="row">
					<div class="row">
						<div class="col">
							<span class="h1"><?= $work["title"] ?></span>
						</div>
						<?php if ($_SESSION["user"]["uid"] === $work["uid"]) : ?>
							<div class="col dropdown" style="text-align: right;">
								<button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
										<path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
									</svg>
								</button>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<form action="/profile" method="post">
										<input type="hidden" name="operation" value="delete">
										<input type="hidden" name="id" value="<?= $id ?>">
										<a class="dropdown-item text-danger" href="#" onclick="this.parentNode.submit()">Delete</a>
									</form>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<small class="text-muted">
						Published by <?= $author ?>
						on <?= DateTime::createFromFormat("ymd his A", $work["published_date"])->format("F j, Y g:i:s A") ?>
					</small>
					<div>
						<?php foreach (json_decode($work["tags"], true) as $obj) : ?>
							<span class="badge text-bg-secondary"><?= $obj["value"] ?></span>
						<?php endforeach; ?>
					</div>
				</div>
				<p>
					<?= $work["body"] ?>
				</p>
			</div>
		<?php else : ?>
		<?php endif; ?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>