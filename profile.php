<?php
session_start();

if (!array_key_exists("user", $_SESSION)) {
	header("Location: /login?redir=profile");
}

$uid = $_SESSION["user"]["uid"];

require_once "classes/dbh.class.php";

$db = Database::getDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$operation = $_POST["operation"];
	$id = $_POST["id"];

	$stmt = $db->prepare(
		"SELECT uid FROM user_works
		 WHERE rowid = :rowid;"
	);

	$stmt->execute(["rowid" => $id]);

	$currentUid = $_SESSION["user"]["uid"];
	$creatorUid = $stmt->fetchColumn();

	if ($creatorUid !== $currentUid) {
		http_response_code(403);
		include_once "errors/403.php";
		die;
	}

	switch ($operation) {
		case "delete":
			$stmt = $db->prepare(
				"DELETE FROM user_works
				 WHERE rowid = :rowid;"
			);

			break;

		case "publish":
			$stmt = $db->prepare(
				"UPDATE user_works
				 SET type = 'release'
				 WHERE rowid = :rowid;"
			);

			break;

		case "unpublish":
			$stmt = $db->prepare(
				"UPDATE user_works
				 SET type = 'draft'
				 WHERE rowid = :rowid;"
			);

			break;
		default:
			http_response_code(404);
			include_once "errors/404.php";
			die;
	}

	$stmt->execute(["rowid" => $id]);
}

$stmt = $db->prepare(
	"SELECT COUNT(*) FROM user_works
	 WHERE uid = :uid;"
);

$stmt->execute(["uid" => $uid]);

$worksPerPage = intval($_GET["show"] ?? "10");
$numberOfWorks = $stmt->fetchColumn();
$numberOfPages = intval(ceil($numberOfWorks / $worksPerPage));

$currentPage = intval($_GET["page"] ?? "1");

$stmt = $db->prepare(
	"SELECT rowid, * FROM user_works
	 WHERE uid = :uid
	 ORDER BY published_date
	 DESC LIMIT :limit OFFSET :offset"
);

$stmt->execute(
	[
		"uid" => $uid,
		"limit" => $worksPerPage,
		"offset" => ($currentPage - 1) * $worksPerPage
	]
);

$works = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pagination = [];

if ($currentPage !== 1) {
	$pagination[] = [
		'page' => 'Previous',
		'ref' => $currentPage - 1,
		'active' => "",
	];
}

for ($i = 1; $i <= $numberOfPages; $i++) {
	$pagination[] = [
		'page' => $i,
		'ref' => $i,
		'active' => ($i === $currentPage) ? "" : "disabled",
	];
}

if ($currentPage !== $numberOfPages) {
	$pagination[] = [
		'page' => 'Next',
		'ref' => $currentPage + 1,
		'active' => "disabled",
	];
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
		<div class="page-header mb-4">
			<h1 class="float-start me-3">
				My walls
			</h1>
			<div class="btn-toolbar">
				<a href="/create" class="btn btn-outline-success">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
						<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
					</svg>
					Create
				</a>
			</div>
		</div>
		<?php if ($numberOfWorks == 0) : ?>
			You have no walls yet.
		<?php else : ?>
			<?php foreach ($works as $work) : ?>
				<div class="card mb-2">
					<div class="card-body">
						<div>
							<?php if ($_SESSION["user"]["uid"] === $work["uid"]) : ?>
								<div class="float-end btn-group">
									<?php include "templates/workConfig.template.php"; ?>
								</div>
							<?php endif; ?>
							<a class="card-title text-reset text-decoration-none h5" href="/walls/<?= $work["rowid"] ?>"><?= $work["title"] ?></a>
						</div>
						<?php if ($work["type"] == "draft") : ?>
							<span class="badge text-bg-warning">Draft</span>
						<?php endif; ?>

						<?php foreach (json_decode($work["tags"], true) as $obj) : ?>
							<span class="badge text-bg-secondary"><?= $obj["value"]; ?></span>
						<?php endforeach; ?>

						<p class="card-text">
							<?= bzdecompress($work["body"]) ?>
						</p>
					</div>
				</div>
			<?php endforeach; ?>
			<nav>
				<ul class="pagination justify-content-center mt-4">
					<?php foreach ($pagination as $pg) : ?>
						<li class="page-item <?= $pg["active"] ?>">
							<a class="page-link" href="/profile?page=<?= $pg["ref"] ?>">
								<?= $pg["page"] ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		<?php endif; ?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>