<?php
session_start();

require_once "classes/dbh.class.php";

$withId = false;
$db = Database::getDatabase();

if (array_key_exists("id", $_GET)) {
    $withId = true;
    $currentUid = $_SESSION["user"]["uid"];

    $stmt = $db->prepare(
        "SELECT * FROM user_works
		 WHERE rowid = :rowid;"
    );

    $stmt->execute(["rowid" => $_GET["id"]]);

    $work = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$work) {
        http_response_code(404);
        include_once "errors/404.php";
        die;
    }

    if ($work["type"] == "draft" && $work["uid"] !== $currentUid) {
        http_response_code(403);
        include_once "errors/403.php";
        die;
    }

    $stmt = $db->prepare(
        "SELECT username FROM users
		 WHERE uid = :uid;"
    );

    $stmt->execute(["uid" => $currentUid]);

    $author = $stmt->fetchColumn();
    $publishedDate = DateTime::createFromFormat("ymd his A", $work["published_date"])
        ->format("F j, Y g:i:s A");
}
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "templates/head.template.php" ?>
</head>

<body>
	<?php include "templates/navbar.template.php"; ?>

	<div class="my-5 container">
		<?php if ($withId) : ?>
			<div class="row">
				<div class="row">
					<div>
						<?php if ($work["uid"] === $currentUid) : ?>
							<div class="float-end btn-group">
								<?php include "templates/workConfig.template.php"; ?>
							</div>
						<?php endif; ?>
						<h1><?= $work["title"] ?></h1>
					</div>
					<small class="text-muted">
						Published by <?= $author ?>
						on <?= $publishedDate ?>
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