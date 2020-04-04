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
				<form name="testfrm" method="GET" action="filter.php">
					<div class="list-group mb-3">
						<input type="hidden" id="hidden_minimum_price" value="0" />
						<input type="hidden" id="hidden_maximum_price" value="1300" />
						<p>
							<label for="amount"><h5>Price range:</h5></label>
							<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
						</p>
						<div id="slider-range"></div>
					</div>
					<div class="list-group">
						<h5>System</h5>
						<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
							<div class="list-group-item checkbox">
								<?php
							foreach($db->getSystem() as $sys){?>
								<label><input type="checkbox" class="common_selector system" value="<?php echo $sys; ?>"> <?php echo $sys; ?></label><br>
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
							foreach($db->getType() as $type){?>
							<label><input type="checkbox" class="common_selector type" value="<?php echo $type; ?>"> <?php echo $type; ?></label><br>
							<?php	
							}
						?>
						</div>
					</div>

					<div class="list-group">
						<h5>Country of Origin</h5>
						<div class="list-group-item checkbox">
							<?php
							foreach($db->getCountry() as $cty){?>
							<label><input type="checkbox" class="common_selector country" value="<?php echo $cty; ?>"> <?php if($cty == "CN") echo "China"; else echo "United Kingdom" ; ?></label><br>
							<?php	
							}
						?>
						</div>
					</div>
				</form>
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
	<script src="js/jquery-ui.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="Table-Sortable/table-sortable.js"></script>

	<script>
		$(document).ready(function() {
			function mytable(response) {
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
			
			function filter_data() {
				var action = 'fetch_data';
				var minimum_price = $('#hidden_minimum_price').val();
				var maximum_price = $('#hidden_maximum_price').val();
				var system = get_filter('system');
				var type = get_filter('type');
				var country = get_filter('country');
				$.ajax({
					url: "ProcessingData.php?init=false",
					method: "POST",
					data: {
						action: action,
						minimum_price: minimum_price,
						maximum_price: maximum_price,
						system: system,
						type: type,
						country: country
					},
					success: function(data) {
						mytable(data);
					}
				});
			}
			
			var columns = {
				desp: 'Description',
				mrp: 'Retail Price',
			}

			$.ajax({
				method: 'GET',
				url: 'ProcessingData.php?stock=yes&init=true',
				data: {},
				success: function(response) {
					mytable(response);
				}
			});
			
			$(function() {
				$("#slider-range").slider({
					range: true,
					min: 0,
					max: 1300,
					values: [10, 800],
					slide: function(event, ui) {
						$("#amount").val("RM" + ui.values[0] + " - RM" + ui.values[1]);
						$('#hidden_minimum_price').val(ui.values[0]);
						$('#hidden_maximum_price').val(ui.values[1]);
					filter_data();
					}
				});
				$("#amount").val("RM" + $("#slider-range").slider("values", 0) +
					" - RM" + $("#slider-range").slider("values", 1));
			});
			
			function get_filter(class_name) {
				var filter = [];
				$('.' + class_name + ':checked').each(function() {
					filter.push($(this).val());
				});
				return filter;
			}

			$('.common_selector').click(function() {
				filter_data();
			});

			
		});

	</script>
</body>


</html>
