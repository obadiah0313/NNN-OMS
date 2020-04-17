<?php 
	session_start();
	require './Database.php';
	$db = new MongodbDatabase();
	foreach($db->getSetting() as $stt){
		$cCatHeader = iterator_to_array($stt['cCat_Header']);
		$cCatFilter = iterator_to_array($stt['cCat_Filter']);
	}
	$header = $db->getHeaders();
	$product = $db->getProduct();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="icon" href="img/neko.png">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/overhang.min.css">
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
				<?php 
					foreach($header as $v){
						echo '<label class="font-weight-bold">'.$v.'</label>';
						echo '<p id="'.substr(str_replace([' ','(',')'], '',$v), 0 ,13).'"></p>';
					}
				?>
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
					<h2>Available Stock</h2>
					<p class="lead">Latest updated on <?php echo $db->getDate()?></p>
				</div>
			</div>
		</div>

		<div class="row py-5" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
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
									<h5>Sort by Price:</h5>
									<div class="list-group-item checkbox">
										<label><input type="radio" name="price" class="common_selector price" value="asc"> Low to High</label><br>
										<label><input type="radio" name="price" class="common_selector price" value="desc"> High to Low</label>
									</div>
								</div>
								<?php foreach($cCatFilter as $f) { ?>
							<div class="list-group mb-3">
								<h5><?php echo $f; ?></h5>
								<div style="height: 150px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
										<?php foreach($db->getFilter($f) as $filter) {?>
										<label><input type="checkbox" class="common_selector <?php echo substr(str_replace([' ','(',')'], '',$f), 0 ,13) ?>" value="<?php echo $filter; ?>"> <?php echo $filter; ?></label><br>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php } ?>

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
								<h5>Sort by Price:</h5>
								<div class="list-group-item checkbox">
									<label><input type="radio" name="price" class="common_selector price" value="asc"> Low to High</label><br>
									<label><input type="radio" name="price" class="common_selector price" value="desc"> High to Low</label>
								</div>
							</div>
							<?php foreach($cCatFilter as $f) { ?>
							<div class="list-group mb-3">
								<h5><?php echo $f; ?></h5>
								<div style="height: 150px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
										<?php foreach($db->getFilter($f) as $filter) {?>
										<label><input type="checkbox" class="common_selector <?php echo substr(str_replace([' ','(',')'], '',$f), 0 ,13) ?>" value="<?php echo $filter; ?>"> <?php echo $filter; ?></label><br>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php } ?>

						</form>
						<div class="mt-3 text-right">
							<button class="button allBtn reset-btn" type="button">Clear All Filter</button>
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
	<?php include './Footer.php'; ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/overhang.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="Table-Sortable/table-sortable.js"></script>
	<!--<script type="text/javascript" src="js/loadTable.js"></script>-->

	<script>
		$(document).ready(function() {
			load_data();

			function showTable(response) {
				var table = $('#root').tableSortable({
					data: JSON.parse(response),
					columns: columns,
					searchField: '#searchField',
					rowsPerPage: 15,
					sorting: false,
					pagination: true
				});
				$('#changeRows').on('change', function() {
					table.updateRowsPerPage(parseInt($(this).val(), 10));
				});
			}

			function filter_data() {
				var action = 'fetch_data';
				var price = get_filter('price');
				<?php
					foreach($cCatFilter as $ccatfilter)
					{
						echo 'var '.substr(str_replace([' ','(',')'], '',$ccatfilter), 0 ,13).' = get_filter("'.substr(str_replace([' ','(',')'], '',$ccatfilter), 0 ,13).'");' ;
					}
				?>
				$.ajax({
					url: "./ProcessingData.php?init=false",
					method: "POST",
					data: {
						action: action,
						<?php
							foreach($cCatFilter as $ccatfilter)
							{
								echo substr(str_replace([' ','(',')'], '',$ccatfilter), 0 ,13).' : '.substr(str_replace([' ','(',')'], '',$ccatfilter), 0 ,13).',' ;
							}
						?>
						price: price
					},
					success: function(response) {
						showTable(response);
						$(document).on('dblclick', 'tr', function() {
							var arr = $(this).text().split(' ');
							var id = arr[arr.length - 1];
							$.each(JSON.parse(response), function(index, value) {
								var regex = />(.*)</;
								var rid = value.id.match(regex);
								if (rid[1] === id) {
									$('#productDetail').modal('show');
									<?php 
									foreach ($header as $head) {
										echo 'console.log(value["SS Code"]);';
										echo '$("#'.substr(str_replace([' ','(',')'], '',$head),0,13).'").text(value["'.$head.'"]);';
									}?>
								}
							});
						});
					}
				});
			}

			var columns = {
				<?php foreach($cCatHeader as $cch){
					echo "'".$cch."':'".$cch."',";
				} ?>
				btnAdd: '',
				id: ''
			}

			function load_data() {
				$.ajax({
					method: 'GET',
					url: 'ProcessingData.php?stock=yes&init=true',
					data: {},
					success: function(response) {
						showTable(response);
						$(document).on('dblclick', 'tr', function() {
							var arr = $(this).text().split(' ');
							var id = arr[arr.length - 1];
							$.each(JSON.parse(response), function(index, value) {
								var regex = />(.*)</;
								var rid = value.id.match(regex);
								if (rid[1] === id) {
									$('#productDetail').modal('show');

									<?php 
												foreach ($header as $head) {
													echo 'console.log(value["SS Code"]);';
													echo '$("#'.substr(str_replace([' ','(',')'], '',$head),0,13).'").text(value["'.$head.'"]);';
												}?>
								}

							});
						});
					}
				});
			}

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
				$("#filterForm2").trigger("reset");
				load_data();
			});

			$(document).on('click', '#btnAdd', function() {
				var item = [];
				item.push($(this).val());
				var action1 = 'add_cart';
				$.ajax({
					url: "./addCart.php",
					method: "POST",
					data: {
						action: action1,
						item: item,
					},
					success: function(data) {
						data = JSON.parse(data);
						$("body").overhang({
							type: data.type,
							message: data.msg
						});
					}
				});

			});
		});

	</script>
</body>

</html>
