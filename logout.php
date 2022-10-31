<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
	echo "Unauthorized";
	return;
}

session_start();

unset($_SESSION["_user"]);

header("Location: /index");
