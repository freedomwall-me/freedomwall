<?php session_start(); ?>
<!DOCTYPE html>
<html class="vh-100 vw-100">

<head>
    <?php require_once "templates/head.template.php" ?>
</head>

<body class="vh-100 vw-100" style="display: flex; flex-direction: column;">
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-success">
        <div class="container align-items-center justify-content-center">
            <span class="navbar-brand">
                <a href="/" class="navbar-brand" style="font-family: Separat;">
                    <svg width="32" height="32" class="me-2">
                        <image xlink:href="/assets/svg/icon.svg" width="32" height="32"></image>
                    </svg>
                    freedomwall
                </a>

                maintenance
            </span>
        </div>
    </nav>

    <div class="d-flex flex-grow-1 align-items-center justify-content-center m-2">
        <div>
            <h1>Err... that doesn't seem to be working.</h1>

            <p>We're currently undergoing maintenance right now. Please come back later.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>