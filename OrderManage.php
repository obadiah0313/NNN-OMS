<?php
	error_reporting(0);
	require './Database.php';
	$db = new MongodbDatabase();
	$countOrder = 0;
	$countItems = 0;
	$o = $db->loadOrder();
	foreach($o as $order){
		if($order['status'] == "confirmed"){
			$countOrder++;
			foreach($order['carts'] as $key=>$value){
				$countItems += $value;
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
	<link rel="icon" href="img/neko.png">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/cart.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
</head>

<div class="modal fade" id="orderDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Order Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<label class="font-weight-bold">Order ID</label>
				<p id="date"></p>
				<label class="font-weight-bold">Order Date</label>
				<p id="id"></p>
				<label class="font-weight-bold">Order By</label>
				<p id="user"></p>
				<label class="font-weight-bold">Order Product(s)</label>
				<div id="products"></div>
				<label class="font-weight-bold">Status</label>
				<p id="status"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

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
				<div class="row py-2">
					<div class="col-5 text-right">
						<button class="button allBtn item" id="btnComplete" value="'.$order['oid'].'">Complete <i class="far fa-check-circle"></i></button>
					</div>
					<div class="col-auto">
						<button class="button allBtn item" id="btnConfirm" value="'.$order['oid'].'">Confirm <i class="fas fa-sync-alt"></i></button>
					</div>
					<div class="col">
						<button class="button allBtn item" id="btnRemove" value="'.$order['oid'].'">Remove <i class="far fa-times-circle"></i></button>
					</div>

				</div>
				<div class="row">
					<div class="col-12">
						<div id="root"></div>
					</div>

				</div>
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
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="Table-Sortable/table-sortable.js"></script>
	<script>
		$(document).ready(function() {
			load_order();
			var order_list = [];

			function showTable(response) {
				var table = $('#root').tableSortable({
					data: JSON.parse(response),
					columns: columns,
					sorting: false,
					pagination: false
				});
			}

			var columns = {
				check: '<?php echo '<input type="checkbox" id="checkAll">' ?>',
				oid: 'Order(s)',
				user: 'Order By',
				date: 'Order Date',
				status: 'Status',
				view: ''
			}

			function load_order() {
				$.ajax({
					method: 'GET',
					url: './getOrder.php',
					data: {},
					success: function(response) {
						showTable(response);
						$(document).on('click', '#btnView', function() {
							var id = $(this).val();
							$.each(JSON.parse(response), function(index, value) {
								if (id === value.oid) {
									$('#orderDetail').modal('show');
									$("#date").text(value.date);
									$("#id").text(value.oid);
									$("#user").text(value.user);
									$("#status").text(value.status);
									$("#products").empty();
									var content = "<table class=\"table\"><tr><th><?php echo $db->getPrimaryKey(); ?></th><th>Quantity</th></tr>";
									$.each(value.cart, function(index, val) {
										content += "<tr><td>"+index+"</td><td>"+val+"</td></tr>";
									});
									$("#products").append(content);
								}

							});
						});
					}
				});
			}

			$(document).on('click', '#btnComplete', function() {
				var action = 'complete';
				if (order_list.length == 0) alert("Please select at least ONE order.");
				else {
					$.ajax({
						url: './updateOrders.php?action=complete',
						method: "POST",
						data: {
							action: action,
							orders: order_list,
						},
						success: function(response) {
							load_order();
						}
					});
					$('#wrapper').load('OrderManage.php' + ' #summary');
				}
			});

			$(document).on('click', '#btnConfirm', function() {
				var action = 'confirm';
				if (order_list.length == 0) alert("Please select at least ONE order.");
				else {
					$.ajax({
						url: './updateOrders.php?action=confirm',
						method: "POST",
						data: {
							action: action,
							orders: order_list,
						},
						success: function(response) {
							load_order();
						}
					});
					$('#wrapper').load('OrderManage.php' + ' #summary');
				}
			});

			$(document).on('click', '#btnRemove', function() {
				var action = 'remove';
				if (order_list.length == 0) alert("Please select at least ONE order.");
				else {
					$.ajax({
						url: './updateOrders.php?action=remove',
						method: "POST",
						data: {
							action: action,
							orders: order_list,
						},
						success: function(response) {
							load_order();
						}
					});
					$('#wrapper').load('OrderManage.php' + ' #summary');
				}
			});


			$(document).on('click', '#checkAll', function() {
				if (this.checked) {
					// Iterate each checkbox
					$(':checkbox').each(function() {
						this.checked = true;
					});
					get_orders();
				} else {
					$(':checkbox').each(function() {
						this.checked = false;
					});
					get_orders();
				}
			});

			$(document).on('click', '#btnExport', function() {
				$.ajax({
					url: './exportOrder.php',
					method: "POST",
					data: {},
					success: function(response) {
						load_order();
					}
				});

			});

			function get_orders() {
				var orders = [];
				$('.common_selector:checked').each(function() {
					orders.push($(this).val());
				});
				order_list = orders;
				console.log(order_list);
			}

			$(document).on('click', '.common_selector', function() {
				get_orders();
			});
		});

	</script>
</body>

</html>
