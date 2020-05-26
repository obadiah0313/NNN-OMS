<?php
session_start();
if(!isset($_SESSION['_id']) || $_SESSION['type']!='staff'||$_SESSION['type']!='admin')
		header('Location:./index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/overhang.min.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Neko Neko Nyaa</title>
		<link rel="icon" href="img/neko.png">
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
          <form action="userlist.php" id="search" method="post"> 

          <label for="fname" style="margin-right:10px;">Enter name:</label>
          <input type="text" id="fname" name="fname" style="margin-right:100px;">

          <input type="radio" id="active" name="status" value="active" checked="checked">
          <label for="staffs" style="margin-right:10px;">Active</label>            
          <input type="radio" id="deactive" name="status" value="deactive">
          <label for="customers" style="margin-right:100px;">Deactived</label> 

          <input type="radio" id="staffs" name="type" value="staffs">
          <label for="staffs" style="margin-right:10px;">Staffs</label>            
          <input type="radio" id="customers" name="type" value="customers">
          <label for="customers" style="margin-right:20px;">Customers</label>            
          <input type="radio" id="customers" name="type" value="partners">
          <label for="partners" style="margin-right:20px;">Partners</label> 

        <button type="submit" style="margin-right:20px;" form="search" value="Submit" class="button allBtn tx-tfm">Search</button>
              
        </form>
</div>
        <div class = "row my-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
<?php
            
//$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$manager = new MongoDB\Driver\Manager('mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c?replicaSet=rs-ds239009&retryWrites=false');
if(isset($_POST['status'])){
    $fname = $_POST['fname'];
}
else{
    $fname = "";
}
        $regex = new MongoDB\BSON\Regex($fname, 'i');
    
$queryActive = new MongoDB\Driver\Query(['status'=>true]);
$queryActiveSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'status'=>true]);
$queryNotActive = new MongoDB\Driver\Query(['status'=>false]);
$queryNotActiveSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'status'=>false]);
			
$queryStaffAc= new MongoDB\Driver\Query(['type'=>'staff','status'=>true]);
$queryStaffAcSearch= new MongoDB\Driver\Query(['fullname'=>$regex,'type'=>'staff','status'=>true]);
$queryStaffDe = new MongoDB\Driver\Query(['type'=>'staff','status'=>false]);
$queryStaffDeSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'type'=>'staff','status'=>false]);
				
$queryCustomerAc= new MongoDB\Driver\Query(['type'=>'customer','status'=>true]);		
$queryCustomerAcSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'type'=>'customer','status'=>true]);
$queryCustomerDe = new MongoDB\Driver\Query(['type'=>'customer','status'=>false]);
$queryCustomerDeSearch = new MongoDB\Driver\Query(['fullname'=>$regex,'type'=>'customer','status'=>false]);		
				
$queryPartnerAc= new MongoDB\Driver\Query(['type'=>'partner','status'=>true]);		
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
        if(isset($_POST['type']) && $_POST['type'] == 'staffs'){
            if(isset($_POST['fname'])){
                //$rows = $manager->executeQuery("NNNdb.user",$queryStaffDeSearch);
                $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryStaffDeSearch);
            }
            else{
                //$rows = $manager->executeQuery("NNNdb.user",$queryStaffDe);
                $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryStaffDe);
                }
           }
        else if(isset($_POST['type']) && $_POST['type'] == 'customers'){
            if(isset($_POST['fname'])){
                //$rows = $manager->executeQuery("NNNdb.user",$queryCustomerDeSearch);
                $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerDeSearch);
            }
            else{
				//$rows = $manager->executeQuery("NNNdb.user",$queryCustomerDe);
				$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerDe);
                }
        }
        else if(isset($_POST['type']) && $_POST['type'] == 'partners'){
            if(isset($_POST['fname'])){
                //$rows = $manager->executeQuery("NNNdb.user",$queryCustomerDeSearch);
                $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerDeSearch);
            }
            else{
				//$rows = $manager->executeQuery("NNNdb.user",$queryCustomerDe);
				$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerDe);
                }
        }
        else{
            if(isset($_POST['fname'])){
                //$rows = $manager->executeQuery("NNNdb.user",$queryNotActiveSearch);
                $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryNotActiveSearch);
            }
            else{
				//$rows = $manager->executeQuery("NNNdb.user",$queryNotActive);
				$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryNotActive);
                }
            }
    foreach ($rows as $row){
                echo"<tbody>".
                    "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td>".$row->type."</td>".
                    "<td><a id='btnActivate' class='button allBtn justify-content-between' href ='./activate.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>".
                    "</tbody>";}
}else {
     $action = "Deactivate";
        if(isset($_POST['type']) && $_POST['type'] == 'staffs'){
            if(isset($_POST['fname'])){
            //$rows = $manager->executeQuery("NNNdb.user",$queryStaffAcSearch);
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryStaffAcSearch);
            }
            else{
            //$rows = $manager->executeQuery("NNNdb.user",$queryStaffAc);  
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryStaffAc);  
            }
        }
        else if(isset($_POST['type']) && $_POST['type'] == 'customers'){
            if(isset($_POST['fname'])){
            //$rows = $manager->executeQuery("NNNdb.user",$queryCustomerAcSearch);  
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerAcSearch);  
            }
            else{
            //$rows = $manager->executeQuery("NNNdb.user",$queryCustomerAc);
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerAc);
            }
        }
        else if(isset($_POST['type']) && $_POST['type'] == 'customers'){
            if(isset($_POST['fname'])){
            //$rows = $manager->executeQuery("NNNdb.user",$queryCustomerAcSearch);  
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerAcSearch);  
            }
            else{
            //$rows = $manager->executeQuery("NNNdb.user",$queryCustomerAc);
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerAc);
            }
        }
        else{if(isset($_POST['fname'])){
            //$rows = $manager->executeQuery("NNNdb.user",$queryActiveSearch); 
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryActiveSearch); 
            }
            else{
            //$rows = $manager->executeQuery("NNNdb.user",$queryActive);
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryActive);
            }
        }
    foreach ($rows as $row){
                echo"<tbody>".
                    "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td>".$row->type."</td>".
                    "<td><a id='btnDeactivate' class='button allBtn justify-content-between' href ='./delete.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>".
                    "</tbody>";}
        }

            
            
           


echo "</table>"
?>
        </div></div>
<?php include './Footer.php'?>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	</body></html>



