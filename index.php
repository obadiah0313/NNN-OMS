<!DOCTYPE html>
<html lang="en">

<head>
	<title>Neko Neko Nyaa</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="fontawesome/css/all.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg">
	
	<?php include './NavBar.php'; ?>
	<div class="container">
		<br>
		<div class="row">
			<div class="center" style="width:100%;">
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img src="img/ahsha.png" alt="ahsha" class="center" style="width:100%;">
						</div>

						<div class="item">
							<img src="img/ahsha%202.png" alt="asha2" class="center" style="width:100%;">
						</div>

						<div class="item">
							<img src="img/ahsha%203.png" alt="asha3" class="center" style="width:100%;">
						</div>
					</div>

					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>

		<br>
		<h1 style="font-weight: bold;" align="center"> AVAILABLE PRODUCTS</h1>

		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="row"><img src="img/digi.JPG" alt="digi" style="width: 100%; height: 100%; padding:10px "></div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="row"><img src="img/magic.jpg" alt="magic" style="width: 100%; height: 100%; padding:10px "></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="row"><img src="img/magic%202.jpg" alt="magic2" style="width: 100%; height: 100%; padding:10px "></div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="row"><img src="img/digi%202.jpg" alt="digi2" style="width: 100%; height: 100%; padding:10px "></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="row"><img src="img/poke.jpg" alt="poke" style="width: 100%; height: 100%; padding:10px "></div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="row"><img src="img/eldraine.jpg" alt="eldraine" style="width: 100%; height: 100%; padding:10px "></div>
			</div>
		</div>


		<br>

		<div class="jumbotron bg-dark text-warning">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<h2 align="center" style="font-weight: bold;">JOIN US NOW</h2>
				</div>

			</div>
			<div class="row">
				<div class="col-md-4 col-xs-12">
					<img src="img/neko%202.jpg" alt="neko2" class="center" style="width: 100%; padding:20px ">
				</div>
				<div class="col-md-4 col-xs-12" class="center">
					<img src="img/neko%203.jpg" alt="neko3" class="center" style="width: 100%; padding:20px ">
				</div>
				<div class="col-md-4 col-xs-12" class="center">
					<img src="img/neko%206.jpg" alt="neko4" class="center" style="width: 100%; padding:20px ">
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-xs-12">
					<img src="img/neko%204.jpg" alt="neko4" class="center" style="width: 100%; padding:20px ">
				</div>
				<div class="col-md-4 col-xs-12" class="center">
					<img src="img/neko%205.jpg" alt="neko5" class="center" style="width: 100%; padding:20px ">
				</div>
				<div class="col-md-4 col-xs-12" class="center">
					<img src="img/neko%207.jpg" alt="neko6" class="center" style="width: 100%; padding:20px ">
				</div>

			</div>
		</div>
		<br>
	</div>
	<?php
		include './Footer.php';
	?>

</body>

</html>
