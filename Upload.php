<?php
	error_reporting(0);
	require './Database.php';	
	$db = new MongodbDatabase();
	if (isset($_POST['data'])) {	
		if ($db->checkExists() != null) {
			$db->replaceStock(date("Y-m-d"),$_POST['data']);
		}
		else{
			$db->insertStock(date("Y-m-d"),$_POST['data']);
			$db->insertDeletion(date("Y-m-d"),$_POST['data2']);
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
		include "NavBar.php";
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
		var SheetList = workbook.SheetNames;
		for (var i = 0; i < SheetList.length; i++) {
			if (SheetList[i] == "GBD_Asia") var worksheet = SheetList[i];
			if (SheetList[i] == "Deletions") var worksheet2 = SheetList[i];
		}

		//Read all rows from First Sheet into an JSON array.
		var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[worksheet]);
		var newObj = [];
		$.each(excelRows, function(index, value) {
			if (value.hasOwnProperty("Product Code")) {
				newObj.push(value);
			}
		})
		
		var excelRows2 = XLSX.utils.sheet_to_json(workbook.Sheets[worksheet2],{range:3});
		var newObj2 = [];
		$.each(excelRows2, function(index, value) {
			if (value.hasOwnProperty("Code")) {
				newObj2.push(value);
			}
		})

		console.log('-----');
		console.log(newObj);
		console.log(newObj2);

		$.ajax({
			method: 'POST',
			data: {
				data: newObj,
				data2: newObj2
			},
			url: './Upload.php',
			success: function(response) {
				console.log('success');
				console.log(response);
			}
		})
		console.log('-----');
	};

</script>

</html>
