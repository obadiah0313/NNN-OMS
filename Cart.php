<?php
	require 'Database.php';
	$db = new MongodbDatabase();
	$pk = $db->getPrimaryKey();
	$uid="001";
	$count = 0;
	$total = 0;
	$empty = true;
	foreach($db->fetchProduct() as $cl) {
		foreach($cl['products'] as $k=>$v){
			foreach($v as $ke=>$val){
				$aa = substr($val, -3);
				if($aa === ".00"){
					$columnname = $ke;
					break;
				}
			}
			foreach($db->loadCart($uid) as $citem){
				if ($citem['carts'] != null) $empty = false;
				$remarks = $citem['remarks'];
				foreach($citem['carts'] as $key => $value){
					if($v[$pk] == $key){
						$count += $value;
						$total += (int)substr($v[$columnname],4,-3) * $value;
					}	
				}				
			}
		}
	}
	foreach($db->getSetting() as $stt){
		$ch = iterator_to_array($stt['cart_Header']);
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Neko Neko Nyaa</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/cart.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/overhang.min.css">
</head>

<body class="bg" style="height:100%">
	<?php
		include './NavBar.php';
	?>
	<div class="page-container">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="text-center col-12 py-3">
				<h2>Your Cart</h2>
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
							<h3 class="card-header" style="background:#ffff99">Cart Summary</h3>
							<div id="wrapper">
								<div id="summary" class="card-body">
									<div class="row mx-3">
										<div class="col-6 pt-3 bg-dark text-white text-center" style="border-radius: 8px 0px 0px 0px">
											<h5>Number of Item(s)</h5>
										</div>
										<div class="col-6 pt-3 bg-secondary text-white text-center" style="border-radius: 0px 30px 0px 0px">
											<h5>Total</h5>
										</div>
									</div>
									<div class="row mx-3">
										<div class="col-6 pb-3 bg-dark text-white text-center" style="border-radius: 0px 0px 0px 30px">
											<h6><?php echo $count; ?></h6>
										</div>
										<div class="col-6 pb-3 bg-secondary text-white text-center" style="border-radius:0px 0px 8px 0px">
											<h6>MYR <?php echo number_format($total,2); ?></h6>
										</div>
									</div>
									<div class="row mx-auto my-2">
										<div class="col-12">
											<h5>Remarks:</h5>
											<textarea id="remarks" class="w-100"><?php if(isset($remarks))echo $remarks; ?></textarea>
										</div>
									</div>
									<div class="mt-3 text-center">
										<button class="button allBtn chkout-btn" type="button">Checkout <i class="fas fa-angle-double-right"></i></button>
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
	<script src="js/overhang.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="Table-Sortable/table-sortable.js"></script>
	<script>
		$(document).ready(function() {
			load_cart();

			function showTable(response) {
				var table = $('#root').tableSortable({
					data: JSON.parse(response),
					columns: columns,
					sorting: false,
					pagination: false
				});
			}

			var columns = {
				<?php
				foreach($ch as $h)
					echo "'".$h."' : '".$h."',";
				?>
				count: 'Order Quantity',
				price: 'Sub-total',
				remove: ''
			}

			function load_cart() {
				$.ajax({
					method: 'GET',
					url: './showCart.php',
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
						load_cart();
					}
				});
				$('#wrapper').load('Cart.php' + ' #summary');
			});

			function incrementValue(e) {
				e.preventDefault();
				var fieldName = $(e.target).data('field');
				var parent = $(e.target).closest('div');
				var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

				if (!isNaN(currentVal)) {
					parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
				} else {
					parent.find('input[name=' + fieldName + ']').val(1);
				}
				var id = parent.find('input[name=' + fieldName + ']').attr("id");
				var increase = 'increase';
				$.ajax({
					url: './showCart.php?update=increase',
					method: "POST",
					data: {
						action: increase,
						id: id,
					},
					success: function(response) {
						load_cart();
					}
				});
				$('#wrapper').load('Cart.php' + ' #summary');
			}

			function decrementValue(e) {
				e.preventDefault();
				var fieldName = $(e.target).data('field');
				var parent = $(e.target).closest('div');
				var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

				if (!isNaN(currentVal) && currentVal > 1) {
					parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
				} else {
					parent.find('input[name=' + fieldName + ']').val(1);
				}
				var id = parent.find('input[name=' + fieldName + ']').attr("id");
				var count = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
				var decrease = 'decrease';
				$.ajax({
					url: './showCart.php?update=decrease',
					method: "POST",
					data: {
						action: decrease,
						id: id,
						count: count
					},
					success: function(response) {
						load_cart();
					}
				});
				$('#wrapper').load('Cart.php' + ' #summary');		
			}

			$(document).on('click', '.button-plus', function(e) {
				incrementValue(e);
			});

			$(document).on('click', '#button-minus', function(e) {
				decrementValue(e);
			});
			
			$(document).on('click', '.chkout-btn', function() {
				var remarks = $('#remarks').val();
				var action = 'checkout';
				var oid = "o-<?php echo $uid; ?>-<?php echo $db->countOrder($uid)?>";
				$.ajax({
					url: './checkout.php',
					method: "POST",
					data: {
						action: action,
						remark: remarks,
						oid : oid
					},
					success: function(data) {
						data = JSON.parse(data);
						$("body").overhang({
							type: data.type,
							message: data.msg
						});
						load_cart();
						if(data.type == "success")$('#remarks').val('');
						$('#wrapper').load('Cart.php' + ' #summary');
					}
				});
			});
		});

	</script>
</body>

</html>
