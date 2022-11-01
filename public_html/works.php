<?php
session_start();

require_once "../config.php";

$withId = false;
$db = new PDO("sqlite:" . Config::DATABASE);

if (array_key_exists("id", $_GET)) {
	$withId = true;
	$id = $_GET["id"];
	$work = $db->query(
		"SELECT rowid, * FROM user_works
		 WHERE rowid='$id';"
	)->fetch(PDO::FETCH_ASSOC);

	if (!$work || ($work["type"] == "draft" && $work["uid"] !== $_SESSION["user"]["uid"])) {
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

	<div class="my-5 container">
		<?php if ($withId) : ?>
			<div class="row">
				<div class="row">
					<div>
						<?php if ($_SESSION["user"]["uid"] === $work["uid"]) : ?>
							<div class="float-end btn-group">
								<?php include "../templates/workConfig.template.php"; ?>
							</div>
						<?php endif; ?>
						<h1><?= $work["title"] ?></h1>
					</div>
					<small class="text-muted">
						Published by <?= $author ?>
						on <?= DateTime::createFromFormat("ymd his A", $work["published_date"])->format("F j, Y g:i:s A") ?>
					</small>
					<?php if ($work["type"] == "draft") : ?>
						<strong>
							<small class="text-muted">This work is only visible to you. Publish it for other people to see this work.</small>
						</strong>
					<?php endif; ?>
					<div>
						<?php if ($work["type"] == "draft") : ?>
							<span class="badge text-bg-warning">Draft</span>
						<?php endif; ?>
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