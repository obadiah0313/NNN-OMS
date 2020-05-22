<?php 
	session_start(); 
	require 'Database.php';
	$db = new MongodbDatabase();
?>
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
				<label class="font-weight-bold">Order Date</label>
				<p id="date"></p>
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
	<?php include 'NavBar.php';?>
	
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-12 py-3">
				<div class="text-center">
					<h2>Order History</h2>
				</div>
			</div>
		</div>

		<div class="row py-4" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col mx-5 text-center" id="root"></div>
		</div>
	</div>
	
	<?php include 'Footer.php'; ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="Table-Sortable/table-sortable.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			load_orderHistory();
			
			function showTable(response) {
				var table = $('#root').tableSortable({
					data: JSON.parse(response),
					columns: columns,
					rowsPerPage: 15,
					sorting: true,
					pagination: true
				});
				$('#changeRows').on('change', function() {
					table.updateRowsPerPage(parseInt($(this).val(), 10));
				});
			}
			
			var columns = {
				date: 'Date',
				status: 'Status',
				view: 'Details',
			}
			
			function load_orderHistory(){
				$.ajax({
					method: 'GET',
					url: 'getHistory.php',
					data: {},
					success: function(response) {
						showTable(response);
						$(document).on('click', '#btnView', function() {
							var id = $(this).val();
							$.each(JSON.parse(response), function(index, value) {
								if (id === value.oid) {
									$('#orderDetail').modal('show');
									$("#date").text(value.date);
									$("#status").text(value.status);
									$("#products").empty();
									var content = "<table class=\"table\"><tr><th>Description</th><th>Quantity</th></tr>";
									$.each(value.test, function(index, val) {
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