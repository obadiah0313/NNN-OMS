<?php
require 'Database.php';
$db = new MongodbDatabase();
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
if(isset($_POST['action'])){
foreach($_POST['orders'] as $o)
{
	foreach($db->loadConfirmedOrder($o) as $detail)
	$count = 0;
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'testingneko123@gmail.com'; 
	$mail->Password = 'testing123~'; 
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAutoTLS = false;
	$mail->Port = 587;

	$mail->setFrom('cherng5757@gmail.com', 'Neko Neko Nyaa');
	$mail->addReplyTo('cherng5757@gmail.com', 'Neko Neko Nyaa');
	$mail->addAddress($db->getUserEmail((string)$detail['uid']), $db->getUserName((string)$detail['uid'])); 

	$mail->Subject = 'Order Has been Processed';

	$mail->isHTML(true);

	$mailContent = '<html>
	<style>
		th,td {text-align:left; padding:15px;}
		.tdright {text-align:right}
		.total {border-bottom: 2px solid #ddd;border-top: 2px solid #ddd;font-weight:bold}
	</style>
	<h1 style="text-align:center; margin-top:2px; margin-bottom:2px;">Thank You For Your Order</h1>
		<p style="text-align:center">Your Order is now processing.</p> 
		<p style="text-align:center">We will keep updating the progress with you.</p>
		<center>
		<table style="width:70%" cellspacing="0" >
			<thead>
				<tr style="background-color:WhiteSmoke;font-size:20px;">
					<th>Order Confirmation #</th>
					<th class="tdright">'.(string)$detail['_id'].'</th>
				</tr>
			</thead>
			<tbody>';
	foreach($detail['carts'] as $key=>$val){
		$count += $val;
		$desp = $db->getProductDetail((string)$key);
		$mailContent .= '<tr><td>'.$desp.'</td><td class="tdright">'.$val.'</td></tr>';
	}
	$mailContent .= '<tr >
	<td class="total">TOTAL</td><td class="total tdright">'.$count.'</td>
	</tr>
	</tbody>
	</table>
	</center>
	</html>';
	$mail->Body = $mailContent;

	if($mail->send()){
		echo 'Message has been sent';
	}else{
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
}
}
