<?php
	require 'Database.php';
	$db = new MongodbDatabase();
	$countOrder = 0;
	$countItems = 0;
	foreach($db->loadOrder() as $order){
		$countOrder++;
		foreach($order['carts'] as $key=>$value){
			$countItems += $value;
		}
	} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="icon" href="img/neko.png">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/cart.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
</head>

<body class="bg">
	<?php
		include './NavBar.php';
	?>
	<div style="display:none">
		<input type="file" id="productList">
	</div>
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="text-center col-12 py-3">
				<h2>Orders Management</h2>
			</div>
		</div>
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col px-auto">
				<div id="root"></div>
			</div>
			<div class="col-auto my-3 ml-auto">
				<div class="row">
					<div class="col-12">
						<div class="card border-warning filter">
							<h3 class="card-header" style="background:#ffff99">Export Order List</h3>
							<div id="wrapper">
								<div id="summary" class="card-body">
									<div class="row mx-3">
										<div class="col-6 pt-3 bg-dark text-white text-center" style="border-radius: 8px 0px 0px 0px">
											<h5>Number of Order(s)</h5>
										</div>
										<div class="col-6 pt-3 bg-secondary text-white text-center" style="border-radius: 0px 30px 0px 0px">
											<h5>Total Item(s) Ordered</h5>
										</div>
									</div>
									<div class="row mx-3">
										<div class="col-6 pb-3 bg-dark text-white text-center" style="border-radius: 0px 0px 0px 30px">
											<h6><?php echo $countOrder; ?></h6>
										</div>
										<div class="col-6 pb-3 bg-secondary text-white text-center" style="border-radius:0px 0px 8px 0px">
											<h6><?php echo $countItems; ?></h6>
										</div>
									</div>
									<div class="mt-3 text-center">
										<button class="button allBtn export-btn" id="btnExport" type="button">Export <i class="fas fa-file-export"></i></button>
									</div>
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
	<script src="js/xlsx.full.min.js"></script>
	<script src="js/jszip.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="Table-Sortable/table-sortable.js"></script>
	<script>
		$(document).ready(function() {
			load_order();

			function showTable(response) {
				var table = $('#root').tableSortable({
					data: JSON.parse(response),
					columns: columns,
					sorting: false,
					pagination: false
				});
			}

			var columns = {
				oid: 'Order(s)',
				user: 'Order By',
				date: 'Order Date',
				edit: ''
			}

			function load_order() {
				$.ajax({
					method: 'GET',
					url: './getOrder.php',
					data: {},
					success: function(response) {
						showTable(response);
					}
				});
			}

			$(document).on('click', '#btnRemove', function() {
				var item = $(this).val();
				var action = 'update';
				$.ajax({
					url: './showCart.php?update=remove',
					method: "POST",
					data: {
						action: action,
						item: item,
					},
					success: function(response) {
						load_order();
					}
				});
				$('#wrapper').load('Cart.php' + ' #summary');
			});

			$(document).on('click', '#btnExport', function() {
				var files = <?php $out = array();
				foreach (glob('./Product_List/*.xlsm') as $filename) {
					$p = pathinfo($filename);
					$out[] = $p['filename'];
				}
				echo json_encode($out); ?>;
				var action ="write"
				$.ajax({
					url: './writeOrder.php',
					method: "POST",
					data: {
						action: action,
						file: './Product_List/'+files[files.length-1],
					},
					success: function(response) {
					}
				});
				//window.location = './Product_List/'+files[files.length-1] + '.xlsm';
			});
		});

	</script>
</body>

</html>
