<?php
session_start();

require_once "config.php";

$db = new PDO("sqlite:" . Config::DATABASE);
$invalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$emailOrUsername = $_POST["data"];
	$password = $_POST["password"];

	$spassword = hash("sha512", $password) . hash("md5", strrev($password));

	$from = $db->query("SELECT email, username, uid, password FROM users
						 WHERE email='$emailOrUsername'
						    OR username='$emailOrUsername';")->fetch(PDO::FETCH_ASSOC);

	if ($from["password"] !== $spassword) {
		$invalid = true;
	} else {
		$_SESSION["_user"] = array(
			"displayName" => $from["username"],
			"login" => true,
			"_" => array(
				"uid" => $from["uid"]
			)
		);

		$redir = isset($_POST["redir"]) ? $_POST["redir"] : "";
		header("Location: /$redir");
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
	<?php include "templates/navbar.template.php"; ?>

	<div class="container py-5 h-100">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="col-lg-8 col-xl-6">
				<div class="card rounded-3">
					<div class="card-body p-4 p-md-5">
						<h3 class="mb-4 pb-2 px-md-2">Log in to your account</h3>

						<form class="px-md-2" action="/login" method="post">
							<div class="form-outline mb-4">
								<label class="form-label" for="data">Email or username</label>
								<input type="text" name="data" class="form-control" required>
							</div>
							<div class="form-outline mb-4">
								<label class="form-label" for="password">Password</label>
								<input type="password" name="password" class="form-control" required>
							</div>
							<div class="form-check mb-2">
								<input class="form-check-input" name="rememberMe" type="checkbox">
								<label class="form-check-label" for="rememberMe">
									Remember me for 30 days
								</label>
							</div>
							<div class="form-outline mb-4">
								<label>
									Not yet a member? <a href="/register">Register</a> now
								</label>
							</div>
							<?php if ($invalid) : ?>
								<div class="alert alert-danger alert-dismissible fade show form-outline mb-4">
									Please double-check your data. Your username or password might be incorrect.
									<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
								</div>
							<?php endif; ?>
							<?php if (isset($_GET["redir"])) : ?>
								<input type="hidden" name="redir" value=<?php echo '"' . $_GET["redir"] . '"' ?>>
							<?php endif; ?>
							<input type="submit" class="btn btn-success">
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