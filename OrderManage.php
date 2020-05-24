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
				<p id="id"></p>
				<label class="font-weight-bold">Order Date</label>
				<p id="date"></p>
				<label class="font-weight-bold">Customer/Partner</label>
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
		<div class="row my-3 py-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-12 d-lg-none mb-4" id="accordion">
				<div class="card border-warning filter">
					<div class="card-header p-0">
						<a class="card-link " data-toggle="collapse" href="#collapseOne">
							<h5 class="card-header" style="background:#ffff99; color:black">Filter:<small class="text-secondary">(Click to show)</small></h5>
						</a>
					</div>
					<div id="collapseOne" class="collapse" data-parent="#accordion">
						<div class="card-body p-2">
							<form id="filterForm" method="GET" action="">
								<div class="list-group mb-3">
									<h5>Status</h5>
									<div class="list-group-item checkbox">
										<label><input type="radio" name="status" class="filter_selector status" value="any" checked> Any</label><br>
										<label><input type="radio" name="status" class="filter_selector status" value="pending"> Pending</label><br>
										<label><input type="radio" name="status" class="filter_selector status" value="confirmed"> Confirmed</label><br>
										<label><input type="radio" name="status" class="filter_selector status" value="processing"> Processing</label><br>
										<label><input type="radio" name="status" class="filter_selector status" value="ordered"> Ordered</label><br>
										<label><input type="radio" name="status" class="filter_selector status" value="completed"> Completed</label><br>
									</div>
								</div>
							</form>
							<div class="mt-3 text-right">
								<button class="button allBtn reset-btn" type="button">Clear All Filter</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="d-none d-lg-block col-lg-3">
				<div class="card border-warning filter">
					<h4 class="card-header" style="background:#ffff99">Filter:</h4>
					<div class="card-body">
						<form id="filterForm2" method="GET" action="">
							<div class="list-group mb-3">
								<h5>Status</h5>
								<div class="list-group-item checkbox">
									<label><input type="radio" name="status" class="filter_selector status" value="any" checked> Any</label><br>
									<label><input type="radio" name="status" class="filter_selector status" value="pending"> Pending</label><br>
									<label><input type="radio" name="status" class="filter_selector status" value="confirmed"> Confirmed</label><br>
									<label><input type="radio" name="status" class="filter_selector status" value="processing"> Processing</label><br>
									<label><input type="radio" name="status" class="filter_selector status" value="ordered"> Ordered</label><br>
									<label><input type="radio" name="status" class="filter_selector status" value="completed"> Completed</label><br>
								</div>
							</div>
							<div>
								<h5>Name</h5>
								<input type="text" class="form-control" placeholder="Customer name..." id="searchField">
							</div>
						</form>
						<div class="mt-3 text-right">
							<button class="button allBtn reset-btn" type="button">Clear All Filter</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col px-auto">
				<div class="row py-2">
					<div class="col-3 text-right">
						<button class="button allBtn item" id="btnComplete" value="'.$order['oid'].'">Complete <i class="far fa-check-circle"></i></button>
					</div>
					<div class="col-auto">
						<button class="button allBtn item" id="btnConfirm" value="'.$order['oid'].'">Confirm <i class="fas fa-sync-alt"></i></button>
					</div>
					<div class="col-auto">
						<button class="button allBtn item" id="btnRemove" value="'.$order['oid'].'">Remove <i class="far fa-times-circle"></i></button>
					</div>
					<div class="col-3 text-left">
						<button class="button allBtn item" id="btnNotify" type="button">Notify<i class="far fa-envelope"></i></button>
					</div>
					<!--<div class="col-3 text-right d-none">
						<button class="button allBtn export-btn" id="btnExport" type="button">Export <i class="fas fa-file-export"></i></button>
					</div>-->

				</div>
				<div class="row">
					<div class="col-12">
						<div id="root"></div>
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
					searchField: '#searchField',
					pagination: false
				});
			}

			var columns = {
				check: '<?php echo '<input type="checkbox" id="checkAll">' ?>',
				user: 'Customer/Partner',
				date: 'Order Date',
				status: 'Status',
				view: ''
			}

			function load_order() {
				$.ajax({
					method: 'GET',
					url: './getOrder.php?init=true',
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
										content += "<tr><td>" + index + "</td><td>" + val + "</td></tr>";
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
							$('#wrapper').load('OrderManage.php' + ' #summary');
						}
					});

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
							$('#wrapper').load('OrderManage.php' + ' #summary');
							$.ajax({
								url: 'smtpScript.php',
								method: 'POST',
								data: {
									action: 'notify',
									orders: order_list,
								}
							});
						}
					});
				}
			});

			$(document).on('click', '#btnNotify', function() {
				var action = 'notify';
				if (order_list.length == 0) alert("Please select at least ONE order.");
				else {
					$.ajax({
						url: 'notify.php',
						method: 'POST',
						data: {
							action: 'notify',
							orders: order_list,
						}
					});
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
							$('#wrapper').load('OrderManage.php' + ' #summary');
						}
					});
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

			function get_filter(class_name) {
				var filter = [];
				$('.' + class_name + ':checked').each(function() {
					filter.push($(this).val());
				});
				return filter;
			}

			function get_status(class_name) {
				var filter = "";
				$('.' + class_name + ':checked').each(function() {
					filter = $(this).val();
				});
				return filter;
			}

			$('.filter_selector').click(function() {
				filter_data();
			});

			$(".reset-btn").click(function() {
				$("#filterForm").trigger("reset");
				$("#filterForm2").trigger("reset");
				load_order();
			});

			function filter_data() {
				$.ajax({
					url: "./getOrder.php?init=false",
					method: "POST",
					data: {
						action: 'fetch_data',
						status: get_status('status')
					},
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
										content += "<tr><td>" + index + "</td><td>" + val + "</td></tr>";
									});
									$("#products").append(content);
								}

							});
						});
					}
				});
			}
		});

	</script>
</body>

</html>
