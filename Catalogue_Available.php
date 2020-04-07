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
	<title>Neko Neko Nyaa</title>
</head>

<div class="modal fade" id="productDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Product Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<label class="font-weight-bold">Release Date:</label>
				<p id="release"></p>
				<label class="font-weight-bold">Module:</label>
				<p id="module"></p>
				<label class="font-weight-bold">Product Code:</label>
				<p id="code"></p>
				<label class="font-weight-bold">Price:</label>
				<p id="price"></p>
				<label class="font-weight-bold">System:</label>
				<p id="system"></p>
				<label class="font-weight-bold">Race:</label>
				<p id="race"></p>
				<label class="font-weight-bold">Product Type:</label>
				<p id="type"></p>
				<label class="font-weight-bold">Quantity in pack:</label>
				<p id="qtyPack"></p>
				<label class="font-weight-bold">Country of Origin:</label>
				<p id="country"></p>
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
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-12 py-3">
				<div class="text-center">
					<h1>Available Stock</h1>
					<p class="lead">Latest updated on <?php echo $db->getDate()?></p>
				</div>
			</div>
		</div>

		<div class="row py-5" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-md-12 col-lg-3">
				<div class="card border-warning filter">
					<h4 class="card-header" style="background:#ffff99">Filter:</h4>
					<div class="card-body">
						<form id="filterForm" method="GET" action="">
							<div class="list-group">
								<h5>Module</h5>
								<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
										<?php
							foreach($db->getModule() as $mod){?>
										<label><input type="checkbox" class="common_selector module" value="<?php echo $mod; ?>"> <?php echo $mod; ?></label><br>
										<?php	
							}
						?>
									</div>
								</div>
							</div>

							<div class="list-group mb-3">
								<input type="hidden" id="hidden_minimum_price" value="0" />
								<input type="hidden" id="hidden_maximum_price" value="1300" />
								<h5 class="card-title">Price range</h5>
								<p>
									<input type="text" id="amount" class="text-warning" readonly size="12" style="border:0; font-weight:bold;">
								</p>
								<div id="slider-range"></div>
							</div>

							<div class="list-group">
								<h5>System</h5>
								<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
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
						<div class="mt-3">
							<button class="btn btn-warning reset-btn" type="button">Clear All Filter</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 col-lg-9">
				<div class="row mb-3 align-item-center">
					<div class="col-md-5">
						<input type="text" class="form-control" placeholder="Search in table..." id="searchField">
					</div>
					<div class="col-md-2 ml-auto text-right">
						<span class="pr-3">Rows Per Page:</span>
					</div>
					<div class="col-md-2">
						<div class="d-flex justify-content-end">
							<select class="custom-select" name="rowsPerPage" id="changeRows">
								<option value="10">10</option>
								<option value="15" selected>15</option>
								<option value="20">20</option>
								<option value="25">25</option>
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
			load_data();

			function showTable(response) {
				var table = $('#root').tableSortable({
					data: JSON.parse(response),
					columns,
					searchField: '#searchField',
					rowsPerPage: 15,
					pagination: true
				});
				$('#changeRows').on('change', function() {
					table.updateRowsPerPage(parseInt($(this).val(), 10));
				});
			}

			function filter_data() {
				var action = 'fetch_data';
				var minimum_price = $('#hidden_minimum_price').val();
				var maximum_price = $('#hidden_maximum_price').val();
				var module = get_filter('module');
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
						module: module,
						system: system,
						type: type,
						country: country
					},
					success: function(data) {
						showTable(data);
						$("th:last-child, td:last-child").css({
							display: "none"
						});
						$(document).on('click', 'tr', function() {
							var arr = $(this).text().split(' ');
							var id = arr[arr.length - 1];

							$.each(JSON.parse(response), function(index, value) {
								if (value.id === id) {
									$('#productDetail').modal('show');
									$('#release').text(value.release);
									$('#module').text(value.module);
									$('#code').text(value.id);
									$('#description').text(value.mrp);
									$('#system').text(value.system);
									$('#race').text(value.race);
									$('#type').text(value.type);
									$('#qtyPack').text(value.qtyPack);
									$('#country').text(value.country);
								}
									
							});

						});

					}
				});
			}

			var columns = {
				module: 'Module',
				desp: 'Description',
				mrp: 'Retail Price',
				qty: 'Quantity Order',
				id: 'id'
			}

			function load_data() {
				$.ajax({
					method: 'GET',
					url: 'ProcessingData.php?stock=yes&init=true',
					data: {},
					success: function(response) {
						showTable(response);
						$("th:last-child, td:last-child").css({
							display: "none"
						});
						$(document).on('click', 'tr', function() {
							var arr = $(this).text().split(' ');
							var id = arr[arr.length - 1];

							$.each(JSON.parse(response), function(index, value) {
								if (value.id === id) {
									$('#productDetail').modal('show');
									$('#release').text(value.release);
									$('#module').text(value.module);
									$('#code').text(value.id);
									$('#description').text(value.mrp);
									$('#system').text(value.system);
									$('#race').text(value.race);
									$('#type').text(value.type);
									$('#qtyPack').text(value.qtyPack);
									$('#country').text(value.country);
								}
									
							});

						});

					}
				});
			}
			
			function showModal() {
				
			}

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

			$(".reset-btn").click(function() {
				$("#filterForm").trigger("reset");
				load_data();
				$("#amount").val("RM" + $("#slider-range").slider("values", 0) +
					" - RM" + $("#slider-range").slider("values", 1));
			});

			$(function() {
				$('[data-toggle="tooltip"]').tooltip()
			})
		});

	</script>
</body>

</html>
