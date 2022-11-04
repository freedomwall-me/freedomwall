<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "public_html/templates/head.template.php" ?>
	<style>
		.drk {
			filter: brightness(65%);
		}

		.carousel-caption {
			z-index: 2;
		}
	</style>
</head>

<body>
	<?php include "public_html/templates/navbar.template.php"; ?>

	<div class="my-5 container">
		<h1>Welcome to the <span style="font-family: Separat;">freedomwall</span></h1>

		<p class="lead">
			<span style="font-family: Separat;">freedomwall.me</span> is an initiative that promotes personal freedom.
			We believe that freedom should never be locked behind paywalls. Users can freely (free, as in beer and freedom)
			read and create their own freedom walls for everybody else to read, free of charge.
		</p>
		<p class="lead">
			Notice how many times we've mentioned "free" here? That's how enthusiastic we are about you and your freedom.
		</p>
		<p class="lead">
			<sup>
				There's a catch, though. You can't use this platform for perpetuating cybercrimes, such as bullying. So, use wisely ;)
			</sup>
		</p>

		<h2 class="mt-4 mb-3">Get started</h2>
		<div class="row">
			<div class="col border-end">
				<h4 class="mb-3">Start browsing walls made by other users</h4>
				<a class="btn btn-success btn-lg" href="/walls">Browse</a>
			</div>
			<div class="col">
				<h4 class="mb-3">Or, create one yourself</h4>
				<a class="btn btn-success btn-lg" href="/create">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
						<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
					</svg>
					Create
				</a>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>