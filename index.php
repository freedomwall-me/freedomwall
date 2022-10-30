<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
	<?php include "templates/navbar.template.php"; ?>

	<div class="py-5 container">
		<h1>Welcome to the Global Repository of Short Stories</h1>

		<p class="lead">
			The GRSS is an initiative that promotes free and accessible reading material for everyone. We believe that electronic written works should never be locked behind paywalls. Users can freely read and create their own short stories for everybody else to read, free of charge.
		</p>

		<div id="imageSlides" class="carousel slide mt-4 mb-4" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img src="/assets/img/slide1.jpg" class="d-block w-100 rounded drk" alt="Open book being read by a person">
					<div class="carousel-caption">
						<h5>Access your favorite reads at your fingertips</h5>
						<p>Read your favorite pieces right here, without the hassle of going out and buying physical copies of them. Downloading is an option too, if there's a need of reading offline.</p>
					</div>
				</div>
				<div class="carousel-item">
					<img src="/assets/img/slide2.jpg" class="d-block w-100 rounded drk" alt="Seated woman reading a book">
					<div class="carousel-caption">
						<h5>Express yourself</h5>
						<p>Write your own short stories to be seen by the whole wide world. Express your imagination, your hatred, your happiness, all your emotions.</p>
					</div>
				</div>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#imageSlides" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#imageSlides" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>

		<div class="row">
			<div class="col-6 border-end">
				<h2>Start browsing works tailored specifically for you</h2>
				<a class="btn btn-success btn-lg" href="#">Browse</a>
			</div>
			<div class="col-6">
				<h2>Or, create one yourself</h2>
				<a class="btn btn-success btn-lg" href="/create.php">
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