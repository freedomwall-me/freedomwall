<?php
require 'vendor/autoload.php';

session_start();

require_once "classes/dbh.class.php";

$withId = false;
$db = Database::getDatabase();

if (array_key_exists("id", $_GET)) {
    $withId = true;
    $currentUid = $_SESSION["user"]["uid"];

    $stmt = $db->prepare(
        "SELECT rowid, * FROM user_works
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

    $publishedDate = DateTime::createFromFormat("Y-m-d H:i:s", $work["published_date"])
        ->format(
            "F j, Y g:i:s A"
        );
} else {
    $stmt = $db->prepare(
        "SELECT COUNT(*) FROM user_works
	 	 WHERE type <> 'draft';"
    );

    $stmt->execute();

    $worksPerPage = intval($_GET["show"] ?? "12");
    $numberOfWorks = $stmt->fetchColumn();
    $numberOfPages = intval(ceil($numberOfWorks / $worksPerPage));

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

    $pagination[] = [
        'page' => '⮜⮜',
        'ref' => 1,
        'active' => ($currentPage != 1) ? '' : 'disabled',
    ];

    $pagination[] = [
        'page' => '⮜',
        'ref' => $currentPage - 1,
        'active' => ($currentPage != 1) ? '' : 'disabled',
    ];

    for ($i = 1; $i <= $numberOfPages; $i++) {
        $pagination[] = [
            'page' => $i,
            'ref' => $i,
            'active' => '',
        ];
    }

    $pagination[] = [
        'page' => '⮞',
        'ref' => $currentPage + 1,
        'active' => ($currentPage != $numberOfPages) ? '' : 'disabled',
    ];

    $pagination[] = [
        'page' => '⮞⮞',
        'ref' => $numberOfPages,
        'active' => ($currentPage != $numberOfPages) ? '' : 'disabled',
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
		<?php if ($withId) : ?>
			<div class="row">
				<div class="row">
					<div>
						<?php if ($work["uid"] === $currentUid) : ?>
							<div class="float-end btn-group">
								<?php include "templates/workConfig.template.php"; ?>
							</div>
						<?php endif; ?>
						<h1>
							<?= $work["title"] ?>
						</h1>
					</div>
					<small class="text-muted">
						Published on <?= $publishedDate ?>
					</small>
					<?php if ($work["type"] == "draft") : ?>
						<strong>
							<small class="text-muted">This work is only visible to you. Publish it for other people to see this
								work.</small>
						</strong>
					<?php endif; ?>
					<div>
						<?php if ($work["type"] == "draft") : ?>
							<span class="badge text-bg-warning">Draft</span>
						<?php endif; ?>
						<?php foreach (json_decode($work["tags"], true) as $obj) : ?>
							<span class="badge text-bg-secondary">
								<?= $obj["value"]; ?>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
				<p>
					<?= bzdecompress($work["body"]) ?>
				</p>
			</div>
		<?php else : ?>
			<h1 class="mb-4">Walls</h1>

			<?php if ($numberOfWorks == 0) : ?>
				No walls yet. Come back later...
			<?php else : ?>
				<div>

					<?php
                    $count = count($works);
                    for ($i = 0; $i < $count; $i++) :
                        $work = $works[$i];
                    ?>
						<?php if ($i % 3 === 0) : ?>
							<div class="row">
							<?php endif; ?>
							<div class="col-4">
								<div class="card mb-3" style="height: 17.5em; text-overflow: ellipsis; overflow: hidden;">
									<div class="card-body">
										<div>
											<a class="card-title text-reset text-decoration-none h5" href="/walls/<?= $work["rowid"] ?>">
												<?= $work["title"] ?>
											</a>
										</div>

										<?php foreach (json_decode($work["tags"], true) as $obj) : ?>
											<span class="badge text-bg-secondary">
												<?= $obj["value"]; ?>
											</span>
										<?php endforeach; ?>

										<p class="card-text">
											<?= bzdecompress($work["body"]) ?>
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
							<li class="page-item <?= $pg["active"] ?>">
								<a class="page-link" href="/walls?page=<?= $pg["ref"] ?>">
									<?= $pg["page"] ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>
		<?php endif; ?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>