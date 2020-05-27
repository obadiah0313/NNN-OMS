<?php
	require 'Database.php';
	$db = new MongodbDatabase();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
	<link rel="icon" href="img/neko.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="css/overhang.min.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/daterangepicker.css">
</head>

<body class="bg">
	<?php include './NavBar.php'; ?>
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="text-center col-12 py-3">
				<h2>Orders Summary</h2>
				<div class="row justify-content-center">
					<div class="col-5">
						<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
							<i class="fa fa-calendar"></i>&nbsp;
							<span></span> <i class="fa fa-caret-down"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row my-3 py-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-12 justify-content-center" id="root">

			</div>
		</div>

	</div>
	<?php include './Footer.php'; ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/overhang.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script src="js/daterangepicker.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="Table-Sortable/table-sortable.js"></script>
	<script type="text/javascript">
		function showTable(response) {
			var table = $('#root').tableSortable({
				data: JSON.parse(response),
				columns: columns,
				sorting: false,
				pagination: false
			});
		}

		var columns = {
			code: '<?php echo $db->getPrimaryKey(); ?>',
			desp: '<?php echo $db->getDespKey(); ?>',
			qty: 'Quantity Ordered'
		}
		
		$(function() {

			var start = moment().subtract(29, 'days');
			var end = moment();

			function cb(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$.ajax({
					url: './getSummary.php',
					method: "POST",
					data: {
						action: "read",
						start: start.format('YYYY-MM-DD'),
						end: end.format('YYYY-MM-DD'),
					},
					success: function(response) {
						showTable(response);
					}
				});
			}

			$('#reportrange').daterangepicker({
				startDate: start,
				endDate: end,
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				}
			}, cb);

			cb(start, end);

		});

	</script>
</body>

</html>
