<?php require './Database.php';
		$db = new MongodbDatabase();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<title>Document</title>
</head>

<body>
	<?php
		include './NavBar.php';
	?>
	<div class="page-container">
		<h3 class="text-center">Available Stock</h3>
		<div class="row">
			<div class="col-md-3">
				<div class="list-group mb-3">
					<h5>Price(RM)</h5>
					<input type="hidden" id="hidden_minimum_price" value="0" />
					<input type="hidden" id="hidden_maximum_price" value="1300" />
					<p id="price_show">0 - 1300</p>
					<div id="price_range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
						<div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
						<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
						<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
					</div>
				</div>
				<div class="list-group">
					<h5>System</h5>
					<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
						<div class="list-group-item checkbox">
							<?php
							foreach($db->getSystem() as $sys){?>
							<label><input type="checkbox" class="common_selector" value="<?php echo $sys; ?>"> <?php echo $sys; ?></label><br>
							<?php	
							}
						?>
						</div>
					</div>
				</div>

				<div class="list-group">
					<h5>Product Type</h5>
					<div class="list-group-item checkbox">
						<?php
							foreach($db->getType() as $sys){?>
						<label><input type="checkbox" class="common_selector" value="<?php echo $sys; ?>"> <?php echo $sys; ?></label><br>
						<?php	
							}
						?>
					</div>
				</div>
				
				<div class="list-group">
					<h5>Country of Origin</h5>
					<div class="list-group-item checkbox">
						<?php
							foreach($db->getCountry() as $sys){?>
						<label><input type="checkbox" class="common_selector" value="<?php echo $sys; ?>"> <?php echo $sys; ?></label><br>
						<?php	
							}
						?>
					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="row mt-5 mb-3 align-item-center">
					<div class="col-md-5">
						<input type="text" class="form-control" placeholder="Search in table..." id="searchField">
					</div>
					<div class="col-md-2 ml-auto text-right">
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
		</div>
	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="Table-Sortable/table-sortable.js"></script>

	<script>
		$(document).ready(function() {
			var columns = {
				desp: 'Description',
				mrp: 'Retail Price',
			}

			$.ajax({
				method: 'GET',
				url: 'ProcessingData.php?stock=yes',
				data: {},
				success: function(response) {
					var table = $('#root').tableSortable({
						data: JSON.parse(response),
						columns,
						searchField: '#searchField',
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
			$('#price_range').slider({
				range: true,
				min: 0,
				max: 1300,
				values: [0, 1300],
				step: 10,
				stop: function(event, ui) {
					$('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
					$('#hidden_minimum_price').val(ui.values[0]);
					$('#hidden_maximum_price').val(ui.values[1]);
					filter_data();
				}
			});
		});

	</script>
</body>


</html>
