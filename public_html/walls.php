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
        include_once "public_html/errors/404.php";
        die;
    }

    if ($work["type"] == "draft" && $work["uid"] !== $currentUid) {
        http_response_code(403);
        include_once "public_html/errors/403.php";
        die;
    }

    $publishedDate = DateTime::createFromFormat("ymd his A", $work["published_date"])
        ->format("F j, Y g:i:s A");
} else {
    $stmt = $db->query("SELECT COUNT(*) FROM user_works;");

    $worksPerPage = intval($_GET["show"] ?? "12");
    $numberOfWorks = $stmt->fetchColumn();
    $numberOfPages = intval(round($numberOfWorks / $worksPerPage));

    if (($worksPerPage % $numberOfWorks) !== 0) {
        $numberOfPages += 1;
    }

    $currentPage = intval($_GET["page"] ?? "1");

    $stmt = $db->prepare(
        "SELECT rowid, * FROM user_works
		 ORDER BY published_date
		 DESC LIMIT :limit OFFSET :offset"
    );

    $stmt->execute(
        [
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
}
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "public_html/templates/head.template.php" ?>
</head>

<body>
	<?php include "public_html/templates/navbar.template.php"; ?>

	<div class="my-5 container">
		<?php if ($withId) : ?>
			<div class="row">
				<div class="row">
					<div>
						<?php if ($work["uid"] === $currentUid) : ?>
							<div class="float-end btn-group">
								<?php include "public_html/templates/workConfig.template.php"; ?>
							</div>
						<?php endif; ?>
						<h1><?= $work["title"] ?></h1>
					</div>
					<small class="text-muted">
						Published on <?= $publishedDate ?>
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
			<h1 class="mb-4">Walls</h1>

			<div>
				<?php for ($i = 0; $i < count($works); $i++) : $work = $works[$i]; ?>
					<?php if ($i % 3 === 0) : ?>
						<div class="row">
						<?php endif; ?>
						<div class="col-4">
							<div class="card mb-3">
								<div class="card-body">
									<div>
										<a class="card-title text-reset text-decoration-none h5" href="/walls/<?= $work["rowid"] ?>"><?= $work["title"] ?></a>
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
						</div>
						<?php if (($i + 1) % 3 === 0 || $i == count($works)) : ?>
						</div>
					<?php endif; ?>
				<?php endfor; ?>
			</div>

			<nav>
				<ul class="pagination justify-content-center mt-4">
					<?php foreach ($pagination as $pg) : ?>
						<li class="page-item <?= $pg["state"] ?>">
							<a class="page-link" href="/walls?page=<?= $pg["ref"] ?>">
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