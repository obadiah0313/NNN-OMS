<?php
	require 'Database.php';
	$db = new MongodbDatabase();
	$uid="001";
	$count = 0;
	$total = 0;
	foreach($db->fetchProduct() as $cl) {
		for($i = 0; $i < sizeof($cl['products']); $i++){
			foreach($db->loadCart($uid) as $citem){
				foreach($citem['carts'] as $key => $value){
					if($cl['products'][$i]['Product Code'] == $key){
						$count += $value;
						$total += (int)$cl['products'][$i]['MRP'] * $value;
					}	
				}				
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
</head>

<body class="bg">
	<?php
		include './NavBar.php';
	?>
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="text-center col-12 py-3">
				<h2>Your Cart</h2>
			</div>
		</div>
		<div class="row" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-9 px-auto">
				<div id="root"></div>
			</div>
			<div class="col-3 my-3 ml-auto">
				<div class="row">
					<div class="col-12">
						<div class="card border-warning filter">
							<h3 class="card-header" style="background:#ffff99">Cart Summary</h3>
							<div class="card-body">
								<div class="row mx-3">
									<div class="col-6 pt-3 bg-dark text-white text-center" style="border-radius: 8px 0px 0px 0px">
										<h5>Number of Item(s)</h5>
									</div>
									<div class="col-6 pt-3 bg-secondary text-white text-center" style="border-radius: 0px 30px 0px 0px">
										<h5>Sub-total</h5>
									</div>
								</div>
								<div class="row mx-3">
									<div class="col-6 pb-3 bg-dark text-white text-center" style="border-radius: 0px 0px 0px 30px">
										<h6><?php echo $count; ?></h6>
									</div>
									<div class="col-6 pb-3 bg-secondary text-white text-center" style="border-radius:0px 0px 8px 0px">
										<h6>RM <?php echo number_format($total,2); ?></h6>
									</div>
								</div>
								<div class="mt-3 text-center">
									<button class="button allBtn reset-btn" type="button">Checkout >></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<?php include './Footer.php'; ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="Table-Sortable/table-sortable.js"></script>
	<script>
		$(document).ready(function() {
			load_cart();

			function showTable(response) {
				var table = $('#root').tableSortable({
					data: JSON.parse(response),
					columns: columns,
					sorting: false,
					pagination: false
				});
			}

			var columns = {
				desp: 'Description',
				count: 'Order Quantity',
				price: 'Price(RM)',
				remove: '',
				id: 'id'
			}

			function load_cart() {
				$.ajax({
					method: 'GET',
					url: './showCart.php?cart=show',
					data: {},
					success: function(response) {
						showTable(response);
						$("th:last-child, td:last-child").css({
							display: "none"
						});
					}
				});
			}
		});

	</script>
</body>

</html>
