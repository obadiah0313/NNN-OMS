<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Document</title>
</head>

<body>
<?php
	include './NavBar.php';
?>
	<div class="page-container">
		<h3 class="text-center">Deletion Stock</h3>
		<h6 class="text-center text-danger">Please note that these deletions are correct for the main GW business in UK. Some local warehouses may still carry stock of these items until they have sold through</h6>
		<h6 class="text-center text-danger">Also, some items will come back into the Trade Range if the sales warrant bringing them back due to their popularity</h6>
		<h6 class="text-center text-danger">Products that are repackaged or change from hard cover to soft cover - the new stock will be sent to you once the old stock has sold through </h6>
			<div class="row mt-5 mb-3 align-items-center">
				<div class="col-md-3">
					<input type="text" class="form-control" placeholder="Search in table..." id="searchField">
				</div>
				<div class="col-md-2 text-right">
					<span class="pr-3">Rows Per Page:</span>
				</div>
				<div class="col-md-2">
					<div class="d-flex justify-content-end">
						<select class="custom-select" name="rowsPerPage" id="changeRows">
							<option value="5">5</option>
							<option value="10" selected>10</option>
							<option value="15">15</option>
							<option value="20">20</option>
						</select>
					</div>
				</div>
			</div>
			<div id="root"></div>
		</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="Table-Sortable/table-sortable.js"></script>

	<script>
		$(document).ready(function() {
			var columns = {
				desp: 'Description',
				datechange: 'Date of Change',
				comment: 'Comment (correct at time of removal)',
			}

			$.ajax({
				method: 'GET',
				url: 'ProcessingData.php?stock=no&init=true',
				data: {},
				success: function(response) {
					var table = $('#root').tableSortable({
						data: JSON.parse(response),
						columns,
						searchField: '#searchField',
						responsive: {
							1100: {
								columns: {
									desp: 'Description',
									datechange: 'Date of Change',
									comment: 'Comment (correct at time of removal)',
								},
							},
						},
						rowsPerPage: 10,
						pagination: true,
						tableWillMount: () => {
							console.log('table will mount')
						},
						tableDidMount: () => {
							console.log('table did mount')
						},
						tableWillUpdate: () => console.log('table will update'),
						tableDidUpdate: () => console.log('table did update'),
						tableWillUnmount: () => console.log('table will unmount'),
						tableDidUnmount: () => console.log('table did unmount')
					});
					$('#changeRows').on('change', function() {
						table.updateRowsPerPage(parseInt($(this).val(), 10));
					})
					$('#rerender').click(function() {
						table.refresh(true);
					})

					$('#distory').click(function() {
						table.distroy();
					})

					$('#refresh').click(function() {
						table.refresh();
					})
				}
			});
		});

	</script>
</body>


</html>
