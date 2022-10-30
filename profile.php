<?php
session_start();

if (!isset($_SESSION["_user"]["login"]))
	header("Location: /login.php?redir=profile.php");

require_once "config.php";

$db = new PDO("sqlite:" . Config::DATABASE);
?>
<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
	<?php include "templates/navbar.template.php"; ?>

	<div class="py-5 container">
		<h1 class="mb-4">
			<?php echo $_SESSION["_user"]["displayName"]; ?>
		</h1>

		<h2 class="mb-4">My works</h2>
		<?php
		$works = $db->query("SELECT * FROM user_works
							  WHERE uid='" . $_SESSION["_user"]["_"]["uid"] . "'");

		foreach ($works as $work) : ?>

			<div class="card mb-2">
				<div class="card-body">
					<h5 class="card-title"><?php echo $work["title"]; ?></h5>
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