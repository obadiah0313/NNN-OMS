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
		<div class="row" style="text-align:center; padding: 20px"> 
          <form action="userlistStaff.php" id="search" method="post"> 

          <label for="fname" style="margin-right:10px;">Enter name:</label>
          <input type="text" id="fname" name="fname" style="margin-right:100px;">

          <input type="radio" id="active" name="status" value="active" checked="checked">
          <label for="staffs" style="margin-right:10px;">Active</label>            
          <input type="radio" id="deactive" name="status" value="deactive">
          <label for="customers" style="margin-right:100px;">Deactived</label> 
          
          <input type="radio" id="partners" name="type" value="partners" checked="checked">
          <label for="partners" style="margin-right:10px;">Partners</label> 
          <input type="radio" id="customers" name="type" value="customers">
          <label for="customers" style="margin-right:10px;">Customers</label> 

        <button type="submit" style="margin-right:20px;" form="search" value="Submit" class="button btn-outline-warning tx-tfm">Search</button>
              
        </form>
</div>
        <div class = "row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
<?php
if(isset($_SESSION['type']) && $_SESSION['type']=="staff"){            
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
//$manager = new MongoDB\Driver\Manager('mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c?replicaSet=rs-ds239009&retryWrites=false');
if(isset($_POST['status'])){
    $fname = $_POST['fname'];
}
else{
    $fname = "";
}
        $regex = new MongoDB\BSON\Regex($fname, 'i');
    
$queryCustomerAc = new MongoDB\Driver\Query(['type'=>'customer','status'=>true]);
$queryCustomerAcSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'type'=>'customer','status'=>true]);
$queryCustomerDe = new MongoDB\Driver\Query(['type'=>'customer','status'=>false]);
$queryCustomerDeSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'type'=>'customer','status'=>false]);
$queryPartnerAc = new MongoDB\Driver\Query(['type'=>'partner','status'=>true]);
$queryPartnerAcSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'type'=>'partner','status'=>true]);
$queryPartnerDe = new MongoDB\Driver\Query(['type'=>'partner','status'=>false]);
$queryPartnerDeSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'type'=>'partner','status'=>false]);

//$rowsActive = $manager->executeQuery("heroku_0g0g5g6c.user",$queryActive);
//$rowsNotActive = $manager->executeQuery("heroku_0g0g5g6c.user",$queryNotActive);

echo "<table class='table table-light'>
<thead><tr>
<th> Full Name </th>
<th> Phone Number </th>
<th> Email </th>
<th> Type </th>
<th> Action </th>
</tr>
</thead>";
    
if(isset($_POST['status']) && $_POST['status'] == 'deactive'){
    $action = "Activate";
        if (isset($_POST['type']) && $_POST['type'] == 'customers'){
            if(isset($_POST['fname'])){
                $rows = $manager->executeQuery("NNNdb.user",$queryCustomerDeSearch);
                //$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerDeSearch);
            }
            else{
				$rows = $manager->executeQuery("NNNdb.user",$queryCustomerDe);
				//$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerDe);
                }
                echo "Deactive Customer";
                foreach ($rows as $row){
                    echo"<tbody>".
                    "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td><a id='btnChange' class='button allBtn justify-content-between' href ='./changeType.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."&status=".$row->status."'>Change To Partner</a></td>".
                    "<td><a id='btnActivate' class='button allBtn justify-content-between' href ='./activate.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>".
                    "</tbody>";}
                }
        else{
            if(isset($_POST['fname'])){
                $rows = $manager->executeQuery("NNNdb.user",$queryPartnerDeSearch);
                //$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerDeSearch);
            }
            else{
				$rows = $manager->executeQuery("NNNdb.user",$queryPartnerDe);
				//$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerDe);
                }
                echo "Deactive Partner";
                foreach ($rows as $row){
                    echo"<tbody>".
                    "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td><a id='btnChange' class='button allBtn justify-content-between' href ='./changeType.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."&status=".$row->status."'>Change To Customer</a></td>".
                    "<td><a id='btnActivate' class='button allBtn justify-content-between' href ='./activate.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>".
                    "</tbody>";}
                }
        }
else {
     $action = "Deactivate";
    if (isset($_POST['type']) && $_POST['type'] == 'customers') {
            if(isset($_POST['fname'])){
            $rows = $manager->executeQuery("NNNdb.user",$queryCustomerAcSearch);  
            //$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerAcSearch);  
            }
            else{
            $rows = $manager->executeQuery("NNNdb.user",$queryCustomerAc);
            //$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerAc);
            }
            echo "Active Customer";
                foreach ($rows as $row){
                    echo"<tbody>".
                    "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td><a id='btnChange' class='button allBtn justify-content-between' href ='./changeType.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."&status=".$row->status."'>Change To Customer</a></td>".
                    "<td><a id='btnActivate' class='button allBtn justify-content-between' href ='./delete.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>".
                    "</tbody>";}
            
        }
            else{
            if(isset($_POST['fname'])){
                $rows = $manager->executeQuery("NNNdb.user",$queryPartnerAcSearch);
                //$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerAcSearch);
            }
            else{
				$rows = $manager->executeQuery("NNNdb.user",$queryPartnerAc);
				//$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerAc);
                }
                echo "Active Partner";
                foreach ($rows as $row){
                    echo"<tbody>".
                    "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td><a id='btnChange' class='button allBtn justify-content-between' href ='./changeType.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."&status=".$row->status."'>Change To Customer</a></td>".
                    "<td><a id='btnActivate' class='button allBtn justify-content-between' href ='./delete.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>".
                    "</tbody>";}
                }
        }

echo "</table>";}
else {echo" You shouldn't be here";}
?>
        </div></div>
<?php include './Footer.php'?>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	</body></html>



