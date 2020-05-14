<?php
	error_reporting(0);
	require './Database.php';
	$db = new MongodbDatabase();
	foreach($db->getSetting() as $stt){
		$cch = iterator_to_array($stt['cCat_Header']);
		$ccf = iterator_to_array($stt['cCat_Filter']);
		$pch = iterator_to_array($stt['pCat_Header']);
		$pcf = iterator_to_array($stt['pCat_Filter']);
		$ch = iterator_to_array($stt['cart_Header']);
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/overhang.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Neko Neko Nyaa</title>
</head>

<body class="bg">
	<?php
		include "NavBar.php";
	?>
	<div class="page-container mt-3">
		<div class="row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-12 py-3">
				<form>
					<h3 class="mb-3 text-center">Upload Latest Product List:</h3>
					<div class="container">
						<div class="custom-file mb-3">
							<input type="file" class="custom-file-input" id="fileUpload" name="filename" style="">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<div class="mt-3 text-center">
							<button type="button" value="Upload" id="upload" class="button allBtn">Upload</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row py-3" id="setPrimary" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white; display:none">
			<div class="col-12 py-4">
				<div class="card border-warning filter">
					<h4 class="card-header" style="background:#ffff99">Primary Key: <small class="text-danger">Select the Product Code/ID for the products.</small></h4>
					<div class="card-body">
						<form method="GET" action="">
							<div class="list-group mb-3">
								<div style="overflow-y: auto; overflow-x: hidden;">
									<div id="headerlist" class="list-group-item radiobutton ">
									</div>
								</div>
							</div>
						</form>
						<button class="button allBtn my-3 text-center" id="btnConfirm">Save</button>
					</div>
				</div>
			</div>
		</div>
		<div id="setHeaders" class="row py-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col">
				<div class="card border-warning filter">
					<h4 class="card-header" style="background:#ffff99">Catalogue (Customers)</h4>
					<div class="card-body">
						<form id="catalogueCustomerForm" method="GET" action="">
							<div class="list-group mb-3">
								<h5>Headers:</h5>
								<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
										<?php
											foreach($db->fetchProduct() as $header){
												for($i = 0; $i < sizeof($header['header']); $i++){
										?>
										<label><input type="checkbox" class="common_selector cCatheader" value="<?php echo $header['header'][$i]; ?>" <?php if (in_array($header['header'][$i],$cch)) echo "checked";?>> <?php echo $header['header'][$i]; ?></label><br>
										<?php	
									}}
								?>
									</div>
								</div>
							</div>
							<div class="list-group mb-3">
								<h5>Filters:</h5>
								<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
										<?php
											foreach($db->fetchProduct() as $header){
												for($i = 0; $i < sizeof($header['header']); $i++){
										?>
										<label><input type="checkbox" class="common_selector cCatfilter" value="<?php echo $header['header'][$i]; ?>" <?php if (in_array($header['header'][$i],$ccf)) echo "checked";?>> <?php echo $header['header'][$i]; ?></label><br>
										<?php	
									}}
						?>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
			<div class="col">
				<div class="card border-warning filter">
					<h4 class="card-header" style="background:#ffff99">Catalogue (Partners)</h4>
					<div class="card-body">
						<form id="cataloguePartnerForm" method="GET" action="">
							<div class="list-group mb-3">
								<h5>Headers:</h5>
								<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
										<?php
											foreach($db->fetchProduct() as $header){
												for($i = 0; $i < sizeof($header['header']); $i++){
										?>
										<label><input type="checkbox" class="common_selector pCatheader" value="<?php echo $header['header'][$i]; ?>" <?php if (in_array($header['header'][$i],$pch)) echo "checked";?>> <?php echo $header['header'][$i]; ?></label><br>
										<?php	
									}}
						?>
									</div>
								</div>
							</div>
							<div class="list-group mb-3">
								<h5>Filters:</h5>
								<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
										<?php
											foreach($db->fetchProduct() as $header){
												for($i = 0; $i < sizeof($header['header']); $i++){
										?>
										<label><input type="checkbox" class="common_selector pCatfilter" value="<?php echo $header['header'][$i]; ?>" <?php if (in_array($header['header'][$i],$pcf)) echo "checked";?>> <?php echo $header['header'][$i]; ?></label><br>
										<?php	
									}}
						?>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
			<div class="col">
				<div class="card border-warning filter">
					<h4 class="card-header" style="background:#ffff99">Cart</h4>
					<div class="card-body">
						<form id="cartForm" method="GET" action="">
							<div class="list-group mb-3">
								<h5>Headers:</h5>
								<div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
									<div class="list-group-item checkbox ">
										<?php
											foreach($db->fetchProduct() as $header){
												for($i = 0; $i < sizeof($header['header']); $i++){
										?>
										<label><input type="checkbox" class="common_selector cartHeader" value="<?php echo $header['header'][$i]; ?>" <?php if (in_array($header['header'][$i],$ch)) echo "checked";?>> <?php echo $header['header'][$i]; ?></label><br>
										<?php	
									}
								}
						?>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
	<?php include './Footer.php' ?>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/overhang.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/xlsx.full.min.js"></script>
<script src="js/jszip.js"></script>
<script>
	// Add the following code if you want the name of the file appear on select
	$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});

</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#setPrimary').hide();
		var excelfile = "";
		$("body").on("click", "#upload", function() {
			//Reference the FileUpload element.
			var fileUpload = $("#fileUpload")[0];

			//Validate whether File is valid Excel file.
			var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx|.xlsm)$/;
			if (regex.test(fileUpload.value.toLowerCase())) {
				if (typeof(FileReader) != "undefined") {
					var form_data = new FormData();
					form_data.append("file", fileUpload.files[0]);
					$.ajax({
						url: 'saveExcel.php',
						method: 'POST',
						data: form_data,
						contentType: false,
						cache: false,
						processData: false,
						success: function(data) {
							data = JSON.parse(data);
							excelfile = data.filename;

							var reader = new FileReader();
							//For Browsers other than IE.
							if (reader.readAsBinaryString) {
								reader.onload = function(e) {
									ProcessExcel(e.target.result);
								};
								reader.readAsBinaryString(fileUpload.files[0]);

							} else {
								//For IE Browser.
								reader.onload = function(e) {
									var data = "";
									var bytes = new Uint8Array(e.target.result);
									for (var i = 0; i < bytes.byteLength; i++) {
										data += String.fromCharCode(bytes[i]);
									}
									ProcessExcel(data);
								};
								reader.readAsArrayBuffer(fileUpload.files[0]);
							}
						}
					});

				} else {
					alert("This browser does not support HTML5.");
				}
			} else {
				alert("Please upload a valid Excel file.");
			}

		});
		var product, deletion, head;

		function ProcessExcel(data) {
			//Read the Excel File data.
			var workbook = XLSX.read(data, {
				type: 'binary'
			});

			//Fetch the name of First Sheet.
			var SheetList = workbook.SheetNames;
			for (var i = 0; i < SheetList.length; i++) {
				if (SheetList[i] == "GBD_Asia") var worksheet = SheetList[i];
				if (SheetList[i] == "Deletions") var worksheet2 = SheetList[i];
			}

			//Read all rows from First Sheet into an JSON array.
			var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[worksheet], {
				raw: false
			});
			var newObj = [];
			$.each(excelRows, function(index, value) {
				if (value.hasOwnProperty("Product Code")) {
					newObj.push(value);
				}
			})

			var excelRows2 = XLSX.utils.sheet_to_json(workbook.Sheets[worksheet2], {
				range: 3
			});
			var newObj2 = [];
			$.each(excelRows2, function(index, value) {
				if (value.hasOwnProperty("Code")) {
					newObj2.push(value);
				}
			})


			var headers = [];
			var range = XLSX.utils.decode_range(workbook.Sheets[worksheet]['!ref']);
			var C, R = range.s.r; /* start in the first row */
			/* walk every column in the range */
			for (C = range.s.c; C <= range.e.c; ++C) {
				var cell = workbook.Sheets[worksheet][XLSX.utils.encode_cell({
					c: C,
					r: R
				})] /* find the cell in the first row */

				var hdr = "UNKNOWN " + C; // <-- replace with your desired default 
				if (cell && cell.t) hdr = XLSX.utils.format_cell(cell);

				headers.push(hdr);
			}

			$.ajax({
				url: 'upload.php',
				method: 'POST',
				data: {
					data: newObj,
					data3: headers,
				},
				success: function(response) {
					response = JSON.parse(response);
					for (var i = 0; i < response.header.length; i++) {
						var li = $('<label><input type="radio" name="key" value="' + response.header[i] + '"/>' + response.header[i] + '</label><br>');
						$('#headerlist').append(li);
						$('#setPrimary').css("display", "block");
						$('#setHeaders').css("display", "none");;
					};
					product = response.product;
					deletion = newObj2,
						head = headers;
					console.log(head);
					console.log(product);
					console.log(deletion);
				}
			})
		};

		function save_setting() {
			var action = 'save_setting';
			var cCatheader = get_setting('cCatheader');
			var cCatfilter = get_setting('cCatfilter');
			var pCatheader = get_setting('pCatheader');
			var pCatfilter = get_setting('pCatfilter');
			var cartHeader = get_setting('cartHeader');
			$.ajax({
				url: "./SaveSetting.php",
				method: "POST",
				data: {
					action: action,
					cCatheader: cCatheader,
					cCatfilter: cCatfilter,
					pCatheader: pCatheader,
					pCatfilter: pCatfilter,
					cartHeader: cartHeader,
				}
			});
		}

		function get_setting(class_name) {
			var setting = [];
			$('.' + class_name + ':checked').each(function() {
				setting.push($(this).val());
			});
			return setting;
		}

		$('.common_selector').click(function() {
			save_setting();
		});

		$(document).on("click", "#btnConfirm", function() {
			var pk = $("input[name='key']:checked").val();
			alert(pk);
			console.log(head);
			console.log(product);;
			alert(excelfile);
			$.ajax({
				method: 'POST',
				data: {
					product: product,
					header: head,
					filename: excelfile,
					primarykey: pk,
				},
				url: 'ubackend.php?doc=stock',
				success: function(response) {
					response = JSON.parse(response);
					$.ajax({
						method: 'POST',
						data: {
							process: response.stock,
							deletion: deletion
						},
						url: 'ubackend.php?doc=deletion',
						success: function(data) {
							data = JSON.parse(data);
							$("body").overhang({
								type: data.type,
								message: data.msg,
								callback: function() {
									document.location.reload();
								}
							});
						}
					});
				}
			});
		});
	});

</script>

</html>
