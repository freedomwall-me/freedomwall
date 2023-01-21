<?php
require 'vendor/autoload.php';

session_start();

$invalidUsername = false;
$invalidEmail = false;

require_once "classes/dbh.class.php";

use Ramsey\Uuid\Uuid;

$db = Database::getDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = hash("sha512", $_POST["password"]);

    $stmt = $db->prepare(
        "SELECT email, username FROM users
		 WHERE email = :email
		 OR username = :username;"
    );

    $stmt->execute(["email" => $email, "username" => $username]);

    $check1 = $stmt->fetchColumn(0);
    $check2 = $stmt->fetchColumn(1);

    $error = false;

    if (!empty($check1)) {
        $invalidEmail = true;
        $error = true;
    }

    if (!empty($check2)) {
        $invalidUsername = true;
        $error = true;
    }

    if (!$error) {
        $uid = Uuid::uuid4();

        $stmt = $db->prepare(
            "INSERT INTO users
		 	 VALUES (
				:uid,
			 	:email,
				:username,
				:password
			 );"
        );

        $stmt->execute(
            [
                "uid" => $uid->toString(),
                "email" => $email,
                "username" => $username,
                "password" => $password
            ]
        );

        header('Location: /login');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "templates/head.template.php" ?>
</head>

<body>
	<?php include "templates/navbar.template.php"; ?>

	<div class="container my-5 h-100">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="col-lg-8 col-xl-6">
				<div class="card rounded-3">
					<div class="card-body p-4 p-md-5">
						<h3 class="mb-4 pb-2 px-md-2">Create an account</h3>

						<form class="px-md-2 needs-validation" action="/register" method="post" novalidate>
							<div class="form-outline mb-4">
								<label class="form-label" for="username">Username</label>
								<input type="text" name="username" class="form-control <?php if ($invalidUsername) {
								    echo "is-invalid";
								} ?>" required>
								<div class="invalid-feedback">
									<?= $invalidUsername ? 'This username has been taken.' : 'Please fill out this field.' ?>
								</div>
							</div>
							<div class="form-outline mb-4">
								<label class="form-label" for="email">Email</label>
								<input type="email" name="email" class="form-control <?php if ($invalidEmail) {
								    echo "is-invalid";
								} ?>" required>
								<div class="invalid-feedback">
									<?= $invalidEmail ? 'This email is already being used by another account.' : 'Please fill out this field.' ?>
								</div>
							</div>
							<div class="form-outline mb-4">
								<label class="form-label" for="password">Password</label>
								<input type="password" name="password" id="password" class="form-control" pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()<>?~,.\/`\\\-=_+]).{8,}" required>
								<div class="invalid-feedback">
									Password must be at least 8 characters in length, have at least one lowercase character, one uppercase character, one digit, and one special character.
								</div>
							</div>
							<div class="form-outline mb-4">
								<label class="form-label" for="password">Confirm password</label>
								<input type="password" name="confirmPassword" id="confirmPassword" class="form-control" required oninput="checkIfPasswordsMatch()">
								<div class="invalid-feedback">
									Passwords do not match.
								</div>
							</div>
							<input type="submit" class="btn btn-success" value="Register">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
	<script src="/scripts/validateform.js"></script>
	<script>
		function checkIfPasswordsMatch() {
			if ($('#confirmPassword').val() !== $('#password').val())
				$('#confirmPassword').addClass('is-invalid')
			else
				$('#confirmPassword').removeClass('is-invalid')
		}
	</script>
</body>

</html>