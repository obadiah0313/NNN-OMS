<link rel="stylesheet" href="css/nav.css">
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark" role="navigation">
	<div class="container">
		<a class="navbar-brand text-warning" href="index.php">Neko Neko Nyaa</a>
		<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
			&#9776;
		</button>
		<div class="collapse navbar-collapse" id="exCollapsingNavbar">
			<ul class="nav navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Catalogue
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="Catalogue_Available.php">Available</a>
						<a class="dropdown-item" href="Catalogue_Unavailable.php">Unavailable</a>
					</div>
				</li>
				<li class="nav-item"><a href="#" class="nav-link">Cart</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Management
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="#">Customer</a>
						<a class="dropdown-item" href="#">Order</a>
						<a class="dropdown-item" href="./Upload.php">Stock</a>
					</div>
				</li>
			</ul>
			<button id="btnLogin" class="btn btn-warning justify-content-between ml-auto" onclick="document.location.href = 'Login.php';">Login</button>
		</div>
	</div>

</nav>