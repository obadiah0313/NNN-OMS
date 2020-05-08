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
				<div class="text-center">
					<h2>Manage User</h2>
				</div>
			</div>
        </div>
        <div class = "row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
<?php
            
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$query = new MongoDB\Driver\Query([]);
$rows = $manager->executeQuery("NNNdb.user",$query);

echo "<table class='table table-light'>
<thead><tr>
<th> Full Name </th>
<th> Phone Number </th>
<th> Email </th>
<th> Action </th>
</tr>
</thead>";

foreach ($rows as $row){
    echo"<tbody>".
        "<tr>".
        "<td>".$row->fullname."</td>".
        "<td>".$row->phone."</td>".
        "<td>".$row->email."</td>".
        "<td><a class='btn btn-danger' href ='delete.php?id=".$row->_id. "' >Delete </a><td>".
        "</tr>".
        "</tbody>";
}

echo "</table>"
?>
        </div></div>
<?php include './Footer.php'?>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	</body></html>



