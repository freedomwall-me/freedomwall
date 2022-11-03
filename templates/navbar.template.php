<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-success">
	<div class="container">
		<a href="/" class="navbar-brand" style="font-family: Separat;">
			<svg width="32" height="32">
				<image xlink:href="/assets/svg/icon.svg" width="32" height="32"></image>
			</svg>
			GRSS
		</a>

		<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarCollapse">
			<div class="navbar-nav ms-auto">
				<?php if (array_key_exists("user", $_SESSION)) :
                    $name = $_SESSION["user"]["displayName"]; ?>

					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Welcome, <?= $name ?>.
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="/profile">Profile</a>
							<form action="/logout" method="post">
								<a class="dropdown-item" href="#" onclick="this.parentNode.submit()">Log out</a>
							</form>
						</div>
					</div>
				<?php else : ?>
					<a href="/login" class="nav-item nav-link active">Log in</a>
					<a href="/register" class="nav-item nav-link active">Register</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</nav>