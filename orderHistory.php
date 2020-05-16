<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="icon" href="img/neko.png">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<title>Neko Neko Nyaa</title>
</head>
<body class="bg">
	<?php include 'NavBar.php';?>
	
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-12 py-3">
				<div class="text-center">
					<h2>Order History</h2>
				</div>
			</div>
		</div>

		<div class="row py-5" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
		</div>
	</div>
	
	<?php include 'Footer.php'; ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="Table-Sortable/table-sortable.js"></script>
</body>
</html>