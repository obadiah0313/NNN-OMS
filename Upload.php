<?php
	require 'Database.php';
	
	if (isset($_POST['data'])) {
		$existsData = $collection->findOne(['date' => date('Y-m-d')]);
		if ($existsData != null) {
			$updateStock = $collection->replaceOne(['date' => date('Y-m-d')],
												   ['date' => date('Y-m-d'), 'products' => $_POST['data']]);
		}
		else{
			$insertOneResult = $collection->insertOne(['date' => date("Y-m-d"), 'products' => $_POST['data']]);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>Neko Neko Nyaa</title>
</head>

<body>
	<?php
		include("NavBar.php");
	?>
	<div class="container mt-5">
		<form>
			<div class="custom-file mb-3">
				<input type="file" class="custom-file-input" id="fileUpload" name="filename">
				<label class="custom-file-label" for="customFile">Choose file</label>
			</div>
			<div class="mt-3">
				<button type="button" value="Upload" id="upload" class="btn btn-primary">Upload</button>
			</div>
		</form>
	</div>
	<!--	<div id="dvExcel"></div>-->
</body>
<script src="js/jquery.min.js"></script>
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
	$("body").on("click", "#upload", function() {
		//Reference the FileUpload element.
		var fileUpload = $("#fileUpload")[0];

		//Validate whether File is valid Excel file.
		var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx|.xlsm)$/;
		if (regex.test(fileUpload.value.toLowerCase())) {
			if (typeof(FileReader) != "undefined") {
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
			} else {
				alert("This browser does not support HTML5.");
			}
		} else {
			alert("Please upload a valid Excel file.");
		}
	});

	function ProcessExcel(data) {
		//Read the Excel File data.
		var workbook = XLSX.read(data, {
			type: 'binary'
		});

		//Fetch the name of First Sheet.
		var firstSheet = workbook.SheetNames[2];

		//Read all rows from First Sheet into an JSON array.
		var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

		console.log('-----');
		console.log(excelRows);

		$.ajax({
			method: 'POST',
			data: {
				data: excelRows
			},
			url: './Upload.php',
			success: function(response) {
				console.log('success');
				console.log(response);
			}
		})
		console.log('-----');

		//Create a HTML Table element.
		var table = $("<table />");
		table[0].border = "1";

		//Add the header row.
		var row = $(table[0].insertRow(-1));

		//Add the header cells.
		var headerCell = $("<th />");
		headerCell.html("Product Code");
		row.append(headerCell);

		var headerCell = $("<th />");
		headerCell.html("Description");
		row.append(headerCell);

		var headerCell = $("<th />");
		headerCell.html("RSL");
		row.append(headerCell);
		var ObjHeader = [];
		var Obj = [];

		//Add the data rows from Excel file.
		for (var i = 0; i < excelRows.length; i++) {

			Obj.push({
				"product_code": excelRows[i]["Product Code"],
				"description": excelRows[i]["Description"],
				"country": excelRows[i]["RSL"]
			});
			//Add the data row.
			var row = $(table[0].insertRow(-1));

			//Add the data cells.
			var cell = $("<td />");
			cell.html(excelRows[i]["Product Code"]);
			row.append(cell);

			cell = $("<td />");
			cell.html(excelRows[i].Description);
			row.append(cell);

			cell = $("<td />");
			cell.html(excelRows[i].Country);
			row.append(cell);
		}

		//console.log(Obj);

		var dvExcel = $("#dvExcel");
		dvExcel.html("");
		dvExcel.append(table);
	};

</script>

</html>
