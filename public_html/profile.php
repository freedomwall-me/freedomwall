<?php
session_start();

if (!array_key_exists("user", $_SESSION))
	header("Location: /login?redir=profile");

require_once "../config.php";

$db = new PDO("sqlite:" . Config::DATABASE);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$operation = $_POST["operation"];

	if ($operation == "delete") {
		$id = $_POST["id"];
		$currentUid = $_SESSION["user"]["uid"];
		$creatorUid = $db->query(
			"SELECT uid FROM user_works
			 WHERE id='$id';"
		)->fetch(PDO::FETCH_ASSOC)["uid"];

		if ($creatorUid !== $currentUid) {
			http_response_code(403);
			include_once "errors/403.php";
			die;
		}
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
	<?php include "../templates/navbar.template.php"; ?>

	<div class="py-5 container">
		<h1 class="mb-4">
			<?php echo $_SESSION["user"]["displayName"]; ?>
		</h1>

		<h2 class="mb-4">My works</h2>
		<?php
		$works = $db->query("SELECT * FROM user_works
							 WHERE uid='" . $_SESSION["user"]["uid"] . "';")->fetchAll(PDO::FETCH_ASSOC);

		foreach ($works as $work) : ?>

			<div class="card mb-2">
				<div class="card-body">
					<h5 class="card-title"><?php echo $work["title"]; ?></h5>
					<?php if ($work["type"] == "draft") : ?>
						<span class="badge text-bg-warning">Draft</span>
					<?php endif; ?>

					<?php foreach (json_decode($work["tags"], true) as $obj) : ?>
						<span class="badge text-bg-secondary"><?php echo $obj["value"]; ?></span>
					<?php endforeach; ?>

					<p class="card-text">
						<?php
						$body = $work["body"];
						if (strlen($body) > 200)
							$body = substr($body, 0, 200) . "...";

						echo $body;
						?>
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