<?php
session_start();
if(!isset($_SESSION['_id']) || $_SESSION['type']=='customer'||$_SESSION['type']=='partner')
	header('Location:./index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">	
	<link rel="stylesheet" href="css/jquery-ui.css">
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

		<div class="row py-3" style="border: 1px solid #E1E1E1;border-radius: 5px;background-color: white;">
			<div class="col-12 text-center">
				<form action="userlistStaff.php" id="search" method="post">
					<div class="row justify-content-center">
						<div class="col-auto">
							<label for="fname"><b>Name:  </b></label>
							<input type="text" id="fname" name="fname">
						</div>
						<div class="col-auto">
							<b>User Status: </b>
							<input type="radio" id="active" name="status" value="active" checked="checked">
							<label for="staffs">Active</label>
							<input type="radio" id="deactive" name="status" value="deactive">
							<label for="deactive">Deactivated</label>
						</div>
						<div class="col-auto">
							<b>User Type: </b>
							<input type="radio" id="partners" name="type" value="partners" checked="checked">
							<label for="partners">Partners</label>
							<input type="radio" id="customers" name="type" value="customers">
							<label for="customers">Customers</label>
						</div>
						<div class="col-auto">
							<button type="submit" form="search" value="Submit" class="button allBtn tx-tfm">Search</button>
						</div>
					</div>
				</form>

				<?php
if(isset($_SESSION['type']) && $_SESSION['type']=="staff"){
	/* Database Connections */
$manager = new MongoDB\Driver\Manager('mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c?replicaSet=rs-ds239009&retryWrites=false');
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


echo "<div class='table-responsive'><table class='table table-striped table-hover'>
<thead>
<tr>
<th> Full Name </th>
<th> Phone Number </th>
<th> Email </th>
<th> Type </th>
<th> Action </th>
</tr>
</thead>
<tbody>";
    
if(isset($_POST['status']) && $_POST['status'] == 'deactive'){
    $action = "Activate";
        if (isset($_POST['type']) && $_POST['type'] == 'customers'){
            if(isset($_POST['fname'])){
                $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerDeSearch);
            }
            else{
				$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerDe);
                }
                echo "<caption style='caption-side:top' class='text-center'><h5>Deactive Customer(s)<h5></caption>";
                foreach ($rows as $row){
                    echo "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td class='text-center'><a id='btnChange' class='button allBtn justify-content-between' href ='./changeType.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."&status=".$row->status."'>Customer</a></td>".
                    "<td class='text-center'><a id='btnActivate' class='button allBtn justify-content-between' href ='./activate.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>";}
                }
        else{
            if(isset($_POST['fname'])){
                $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerDeSearch);
            }
            else{
				$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerDe);
                }
                echo "<caption style='caption-side:top' class='text-center'><h5>Deactive Partner(s)<h5></caption>";
                foreach ($rows as $row){
                    echo "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td class='text-center'><a id='btnChange' class='button allBtn justify-content-between' href ='./changeType.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."&status=".$row->status."'>Partner</a></td>".
                    "<td class='text-center'><a id='btnActivate' class='button allBtn justify-content-between' href ='./activate.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>";}
                }
        }
else {
     $action = "Deactivate";
    if (isset($_POST['type']) && $_POST['type'] == 'customers') {
            if(isset($_POST['fname'])){
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerAcSearch);  
            }
            else{
            $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryCustomerAc);
            }
            echo "<caption style='caption-side:top' class='text-center'><h5>Active Customer(s)<h5></caption>";
                foreach ($rows as $row){
                    echo "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td class='text-center'><a id='btnChange' class='button allBtn justify-content-between' href ='./changeType.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."&status=".$row->status."'>Customer</a></td>".
                    "<td class='text-center'><a id='btnActivate' class='button allBtn justify-content-between' href ='./delete.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>";}
            
        }
            else{
            if(isset($_POST['fname'])){
                $rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerAcSearch);
            }
            else{
				$rows = $manager->executeQuery("heroku_0g0g5g6c.user",$queryPartnerAc);
                }
                echo "<caption style='caption-side:top' class='text-center'><h5>Active Partner(s)<h5></caption>";
                foreach ($rows as $row){
                    echo "<tr>".
                    "<td>".$row->fullname."</td>".
                    "<td>".$row->phone."</td>".
                    "<td>".$row->email."</td>".
                    "<td class='text-center'><a id='btnChange' class='button allBtn justify-content-between' href ='./changeType.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."&status=".$row->status."'>Partner</a></td>".
                    "<td class='text-center'><a id='btnActivate' class='button allBtn justify-content-between' href ='./delete.php?oid=".$row->_id."&fullname=".$row->fullname."&phone=".$row->phone."&email=".$row->email."&password=".$row->password."&type=".$row->type."'>" .$action."</a><td>".
                    "</tr>";}
                }
        }

echo "</tbody></table></div>";}
else {echo" You shouldn't be here";}
?>
			</div>
		</div>
	</div>
	<?php include './Footer.php'?>
	<script src="js/jquery.min.js"></script>	
	<script src="js/jquery-ui.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
