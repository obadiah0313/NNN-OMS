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
            
//$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$manager = new MongoDB\Driver\Manager('mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c?replicaSet=rs-ds239009&retryWrites=false');
$query = new MongoDB\Driver\Query([]);
$queryActive = new MongoDB\Driver\Query(['status'=>true]);
$queryNotActive = new MongoDB\Driver\Query(['status'=>false]);
//$rowsActive = $manager->executeQuery("NNNdb.user",$queryActive);
//$rowsNotActive = $manager->executeQuery("NNNdb.user",$queryNotActive);
$rowsActive = $manager->executeQuery("heroku_0g0g5g6c.user",$queryActive);
$rowsNotActive = $manager->executeQuery("heroku_0g0g5g6c.user",$queryNotActive);
?>
    <div class="col-md-3" style="text-align:center; padding: 20px">        
    <input type="checkbox" id="active" name="active" value="active">
    <label for="active"> Show Deactivated </label></div>
            
  <div class="col-md-6" style="text-align:center; padding: 20px">  
  <input type="radio" id="staffs" name="type" value="staffs">
  <label for="staffs">Staffs</label>
     
            
  <input type="radio" id="customers" name="type" value="customers">
  <label for="customers">Customers</label> </div> 
           
<?php
echo "<table class='table table-light'>
<thead><tr>
<th> Full Name </th>
<th> Phone Number </th>
<th> Email </th>
<th> Type </th>
<th> Action </th>
</tr>
</thead>";

foreach ($rowsNotActive as $row){
    echo"<tbody>".
        "<tr>".
        "<td>".$row->fullname."</td>".
        "<td>".$row->phone."</td>".
        "<td>".$row->email."</td>".
        "<td>".$row->type."</td>".
        "<td><a id='btnDeactivate' class='button allBtn justify-content-between' href ='./delete.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'> Dectivate </a><td>".
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



