<?php
session_start();

require_once "classes/dbh.class.php";

$db = Database::getDatabase();
$invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$data = $_POST["data"];
	$password = hash("sha512", $_POST["password"]);

	$stmt = $db->prepare(
		"SELECT * FROM users
		 WHERE email = :email
		 OR username = :username;"
	);

	$stmt->execute(["email" => $data, "username" => $data]);

	$from = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($from["password"] !== $password) {
		$invalid = true;
	} else {
		$_SESSION["user"] = array(
			"displayName" => $from["username"],
			"uid" => $from["uid"]
		);

		$ref = $_POST["redir"] ?? "";

		header("Location: /$ref");
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

	<div class="container my-5 h-100">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="col-lg-8 col-xl-6">
				<div class="card rounded-3">
					<div class="card-body p-4 p-md-5">
						<h3 class="mb-4 pb-2 px-md-2">Log in to your account</h3>

						<form class="px-md-2" action="/login" method="post">
							<?php if ($invalid) : ?>
								<div class="alert alert-danger alert-dismissible fade show form-outline mb-4">
									Please double-check your data. Your username or password might be incorrect.
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								</div>
							<?php endif; ?>
							<div class="form-outline mb-4">
								<label class="form-label" for="data">Email or username</label>
								<input type="text" name="data" class="form-control" required>
							</div>
							<div class="form-outline mb-4">
								<label class="form-label" for="password">Password</label>
								<input type="password" name="password" class="form-control" required>
							</div>
							<div class="form-outline mb-4">
								<label>
									Not yet a member? <a href="/register">Register</a> now
								</label>
							</div>
							<?php if (isset($_GET["redir"])) : ?>
								<input type="hidden" name="redir" value="<?= $_GET["redir"] ?>">
							<?php endif; ?>
							<input type="submit" class="btn btn-success" value="Log in">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>