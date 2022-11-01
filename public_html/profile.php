<?php
session_start();

if (!array_key_exists("user", $_SESSION))
	header("Location: /login?redir=profile");

require_once $_SERVER['DOCUMENT_ROOT'] . "/../config.php";

$db = new PDO("sqlite:" . Config::DATABASE);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$operation = $_POST["operation"];
	$id = $_POST["id"];

	$currentUid = $_SESSION["user"]["uid"];
	$creatorUid = $db->query(
		"SELECT uid FROM user_works
		 WHERE rowid='$id';"
	)->fetch(PDO::FETCH_ASSOC)["uid"];

	if ($creatorUid !== $currentUid) {
		http_response_code(403);
		include_once "errors/403.php";
		die;
	}

	switch ($operation) {
		case "delete":
			$db->exec(
				"DELETE FROM user_works
				 WHERE rowid='$id';"
			);

			break;

		case "publish":
			$db->exec(
				"UPDATE user_works
				 SET type='release'
				 WHERE rowid='$id'
				 AND type='draft';"
			);

			break;

		case "unpublish":
			$db->exec(
				"UPDATE user_works
				 SET type='draft'
				 WHERE rowid='$id'
				 AND type='release';"
			);

			break;
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
	<?php include $_SERVER['DOCUMENT_ROOT'] . "/../templates/navbar.template.php"; ?>

	<div class="my-5 container">
		<h1 class="mb-4">
			<?= $_SESSION["user"]["displayName"] ?>
		</h1>

		<div class="page-header mb-4">
			<h2 class="float-start me-3">My works</h2>
			<div class="btn-toolbar">
				<a href="/create" class="btn btn-outline-success">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
						<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
					</svg>
					Create
				</a>
			</div>
		</div>
		<?php
		$works = $db->query("SELECT rowid, * FROM user_works
							 WHERE uid='" . $_SESSION["user"]["uid"] . "';")->fetchAll(PDO::FETCH_ASSOC);

		foreach ($works as $work) : ?>

			<div class="card mb-2">
				<div class="card-body">
					<div>
						<?php if ($_SESSION["user"]["uid"] === $work["uid"]) : ?>
							<div class="float-end btn-group">
								<?php include $_SERVER['DOCUMENT_ROOT'] . "/../templates/workConfig.template.php"; ?>
							</div>
						<?php endif; ?>
						<a class="card-title text-reset text-decoration-none h5" href="/works/<?= $work["rowid"] ?>"><?= $work["title"] ?></a>
					</div>
					<?php if ($work["type"] == "draft") : ?>
						<span class="badge text-bg-warning">Draft</span>
					<?php endif; ?>

					<?php foreach (json_decode($work["tags"], true) as $obj) : ?>
						<span class="badge text-bg-secondary"><?= $obj["value"]; ?></span>
					<?php endforeach; ?>

					<p class="card-text">
						<?= $work["body"] ?>
					</p>
				</div>
			</div>

		<?php
		endforeach;
		?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>