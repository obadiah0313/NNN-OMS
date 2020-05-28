<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}?>
<link rel="stylesheet" href="css/nav.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="fontawesome/css/all.css">
<div style="background:rgba(255, 165, 0, 0.85)">
	<div class="d-none d-lg-block bg-dark">
		<div class="page-container mb-0">
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
		<div class="page-container mb-0">
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
		<div class="page-container">
			<div class="row">
				<div class="col-auto mr-auto">
					<a href="./index.php"><img src="img/neko.png" alt="logo" style="position:absolute; z-index:4;width:500%;"></a>
				</div>
				<div class="col-auto mb-0 mt-3">
					<h1>
						<i>Neko Neko Nyaa</i>
						<small class="text-muted"> Ordering System</small>
					</h1>
				</div>
			</div>
		</div>
	</div>
	<nav style="z-index:3" class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark" role="navigation">
		<div class="container-fluid" style="margin-left: 10%;
	margin-right: 10%;">
			<div class="d-none d-lg-block" style="width:100px"></div>
			<a class="navbar-brand text-warning" href="index.php">Neko Neko Nyaa</a>
			<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar">
				&#9776;
			</button>
			<div class="collapse navbar-collapse order-0" id="exCollapsingNavbar">
				<ul class="nav navbar-nav">
					<li class="nav-item"><a href="./Catalogue_Available.php" class="nav-link">Catalogue</a></li>
					<li class="nav-item"><a href="./about.php" class="nav-link">About Us</a></li>
                    <?php 
                    if (isset($_SESSION['fullname'])){
						if ($_SESSION['type']=="admin" || $_SESSION['type']=="staff"){?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Setting
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="<?php if($_SESSION['type'] == "admin") echo "./userlist.php"; else echo "./userlistStaff.php";?>">User Management</a>
							<a class="dropdown-item" href="./OrderManage.php">Order Management</a>
							<a class="dropdown-item" href="./CatalogueManage.php">Catalogue Management</a>
						</div>
					</li>
					<?php }
						if ($_SESSION['type']=="admin"){?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Admin
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="./addStaff.php">Add Staff</a>
							<a class="dropdown-item" href="./OrderSummary.php">Order Summary</a>
						</div>
					</li>
					<?php } }
					?>
				</ul>
			</div>
			<div class="collapse navbar-collapse order-1" id="exCollapsingNavbar">
				<ul class="nav navbar-nav ml-auto mr-2">
					<li class="nav-item"><a href="./Cart.php" class="nav-link">Cart <i class="fas fa-shopping-cart"></i></a></li>
					<li class="nav-item"><a href="./Profile.php" class="nav-link"></a></li>
					<?php if (isset($_SESSION['fullname'])){echo'<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Profile <i class="fas fa-user-circle"></i>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="./Profile.php">My Profile</a>
							<a class="dropdown-item" href="orderHistory.php">Order History</a>
							<a class="dropdown-item" href="./logout.php">Logout</a>
						</div>
					</li>';} 
                    else{
                    echo'<a id="btnLogin" class="button allBtn justify-content-between " href="./Login.php">Login</a>';}
                ?>
				</ul>
                <a class="text-warning nav-link">Hello,  
                    <?php 
                  if (isset($_SESSION['fullname'])){
                    echo $_SESSION['fullname'];}
                    else {echo 'Guest';} ?>
                </a>
			</div>

		</div>

	</nav>
</div>
