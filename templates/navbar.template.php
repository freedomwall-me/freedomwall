       <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-success">
            <div class="container">
				<a href="/" class="navbar-brand">
					<svg width="32" height="32">       
     					<image xlink:href="/assets/icon.svg" width="32" height="32"></image>
					</svg>
					GRSS
				</a>
				
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
               
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                    <?  $name = $_SESSION["_user"]["displayName"];
					    if (isset($name)) : ?>
							   
						<a href="/create.php" class="btn btn-outline-light">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
							    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
							</svg>
							Create
						</a>

						<div class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    Welcome, <? echo $name ?>.
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							    <a class="dropdown-item" href="/profile.php">Profile</a>
							    <form action="/logout.php" method="post">
							        <a class="dropdown-item" href="#" onclick="this.parentNode.submit()">Log out</a>
							    </form>
							</div>
						</div>
					<? else : ?>
						<a href="/login.php" class="nav-item nav-link active">Log in</a>
						<a href="/register.php" class="nav-item nav-link active">Register</a>
					<? endif; ?>
                   </div>
                </div>
            </div>
        </nav>