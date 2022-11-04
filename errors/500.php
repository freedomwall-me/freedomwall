<?php session_start(); ?>
<!DOCTYPE html>
<html class="vh-100 vw-100">

<head>
    <?php require_once "templates/head.template.php" ?>
</head>

<body class="vh-100 vw-100" style="display: flex; flex-direction: column;">
    <?php include "templates/navbar.template.php"; ?>

    <div class="d-flex flex-grow-1 align-items-center justify-content-center m-2">
        <div>
            <h1>Well, this is embarrassing...</h1>

            <p>The server experienced an error. Please try submitting your request again, or try again later if that doesn't work.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>