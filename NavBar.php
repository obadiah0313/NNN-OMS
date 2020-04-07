<link rel="stylesheet" href="css/nav.css">
<div style="background:orange">
	<div class="d-none d-lg-block bg-dark">
		<div class="container">
			<div class="row text-white">
				<div class="d-inline col-auto mr-auto">
					<i class="fab fa-whatsapp"></i> WhatsApp : <a class="text-white" href="https://wa.me/60138183616">013-818 3616</a>
				</div>
				<div class="d-inline col-auto mx-auto">
					<i class="fab fa-facebook-square"></i> Facebook : <a class="text-white" href="https://www.facebook.com/nekonekonyaannn">Neko Neko Nyaa</a>
				</div>
				<div class="d-inline col-auto ml-auto">
					<i class="fa fa-envelope"></i> E-mail : <a class="center text-white" href="mailto:nekonekonyaannn@gmail.com">nekonekonyaannn@gmail.com</a>
				</div>
			</div>
		</div>
	</div>
	<div class="d-lg-none bg-dark">
		<div class="container">
			<div class="row text-white">
				<div class="d-inline col-auto mr-auto"><a class="center text-white"><i class="fab fa-whatsapp"></i> 013-818 3616</a>
				</div>
				<div class="d-inline col-auto mx-auto">
					<a class="center text-white" href="https://www.facebook.com/nekonekonyaannn"><i class="fab fa-facebook-square"></i> Neko Neko Nyaa</a>
				</div>
				<div class="d-inline col-auto ml-auto">
					<a class="center text-white" href="mailto:nekonekonyaannn@gmail.com"><i class="fa fa-envelope"></i> Email Us</a>
				</div>
			</div>
		</div>
	</div>
	<div class="d-none d-lg-block">
		<div class="container">
			<div class="row">
				<div class="col-auto mx-auto my-1">
					<a href="./index.php"><img src="img/neko.png" alt="logo" style="width:40% ;"></a>
				</div>
				<div class="col-auto mx-auto">
					<h3 class="display-4">
						<i>Neko Neko Nyaa</i><br>
						<small class="text-muted">Ordering System</small>
					</h3>
				</div>
			</div>
		</div>
	</div>
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
</div>
