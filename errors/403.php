<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "templates/head.template.php" ?>
</head>

<body>
	<?php include $_SERVER['DOCUMENT_ROOT'] . "/../templates/navbar.template.php"; ?>

	<div class="my-5 container">
		<h1>Back off!</h1>

		<p>You don't have access to this resource. Try again with another account.</p>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>