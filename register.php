<?
	session_start();

	$invalidUsername = false;
	$invalidEmail = false;

	require_once "classes/main.class.php";
	$Main = new Main;

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$username = $_POST["username"];
		$password = $_POST["password"];
		$email = $_POST["email"];
	
		$spassword = hash("sha512", $password) . hash("md5", strrev($password));
	
		$data1 = array($username, $spassword, 1);
		$data2 = array($email, $spassword, 2);
	
		$check1 = $Main->getDataKey($email);
		$check2 = $Main->getDataKey($username);
		$error = false;
	
		if (!empty($check1))
		{
			$invalidEmail = true;
			$error = true;
		}

		if (!empty($check2))
		{
			$invalidUsername = true;
			$error = true;
		}

		if (!$error)
		{
			$Main->insertKey($email, $data1);
			$Main->insertKey($username, $data2);

			header('Location: /login.php');
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
                            <h3 class="mb-4 pb-2 px-md-2">Create an account</h3>
							
                            <form class="px-md-2 needs-validation" action="/register.php" method="post" novalidate>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" name="username" <? echo 'class="form-control'; if ($invalidUsername) echo ' is-invalid'; echo '"' ?> required>
									<div class="invalid-feedback">
      									<? echo ($invalidUsername ? 'This username has been taken.' : 'Please fill out this field.') ?>
								    </div>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" <? echo 'class="form-control'; if ($invalidEmail) echo ' is-invalid'; echo '"' ?> required>
									<div class="invalid-feedback">
      									<? echo ($invalidEmail ? 'This email is already being used by another account.' : 'Please fill out this field.') ?>
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
                                <input type="submit" class="btn btn-success">
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
			function checkIfPasswordsMatch()
			{
				if ($('#confirmPassword').val() !== $('#password').val())
					$('#confirmPassword').addClass('is-invalid')
				else
					$('#confirmPassword').removeClass('is-invalid')
			}
		</script>
    </body>
</html>
