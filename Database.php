<?php
	require_once './vendor/autoload.php';
	
	class MongodbDatabase{		
		//Constructor
		public function __construct(){
			try {
				//$this->client = new MongoDB\Client();
				$this->client = new MongoDB\Client('mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c?replicaSet=rs-ds239009&retryWrites=false');
			}catch (MongoConnectionException $e) {
				die('Error connecting to MongoDB server');
			}
			//$this->db = $this->client->NNNdb;
			$this->db = $this->client->heroku_0g0g5g6c;
			$this->collect = $this->db->selectCollection('stock');
			$this->deletion = $this->db->selectCollection('deletion');
			$this->user = $this->db->selectCollection('user');
			$this->cart = $this->db->selectCollection('cart');
			$this->setting = $this->db->selectCollection('setting');
		}

		/************/
		/*Fetch Data*/
		/************/		
		public function fetchProduct(){
			return $this->collect->find(
				[],
				[
					'limit' => 1, 
					'sort' => ['date'=> -1]
				]);
		}
		
		public function fetchDeletion(){
			return $this->deletion->find(
				[],
				[
					'limit' => 1, 
					'sort' => ['date'=> -1]
				]);
		}
		
		public function getProduct(){
			foreach($this->fetchProduct() as $i){
				return iterator_to_array($i['products']);
			}
		}
		
		public function getProductList(){
			return $this->collect->find();
		}
		
		public function getPrimaryKey(){
			foreach($this->fetchProduct() as $i){
				return $i['primaryKey'];
			}
		}
		public function getDespKey(){
			foreach($this->fetchProduct() as $i){
				return $i['desp'];
			}
		}

		public function getHeaders(){
			foreach($this->fetchProduct() as $i){
				return iterator_to_array($i['header']);
			}
		}
		
		public function getProductDetail($code) {
			$data =  $this->collect->find();
			foreach($data as $d){
				foreach ($d['products'] as $val){
					if($val[$d['primaryKey']] == $code){
						return $val[$d['desp']];
					}
				}
			}
		}
		
		/*********************************/
		/*Upload Data -- Stock & Deletion*/
		/*********************************/
		public function checkExists(){
			return $this->collect->findOne(['date' => date("Y-m-d")]);
		}
		
		public function replaceStock($date, $product, $header, $primarykey,$desp, $file){
			$this->collect->replaceOne(['date' => $date],
										['date' => $date, 'products' => $product, 'header' => $header, 'primaryKey' => $primarykey,'desp'=>$desp, 'filename' => $file]);
		}
		
		public function replaceDeletion($date, $deletion){
			$this->deletion->replaceOne(['date' => $date],
										['date' => $date, 'deletions' => $deletion]);
		}
		
		public function insertStock($date, $product, $header, $primarykey,$desp, $file){
			$this->collect->insertOne(['date' => $date, 'products' =>$product, 'header' => $header, 'primaryKey' => $primarykey, 'desp'=>$desp,'filename' => $file]);
		}
		
		public function insertDeletion($date, $deletion){
			$this->deletion->insertOne(['date' => $date, 'deletions' =>$deletion]);
		}
		
		/******************/
		/*Table Management*/
		/******************/
		public function insertSetting($cCatheader, $cCatfilter, $pCatheader, $pCatfilter, $cartHeader){
			$this->setting->insertOne(['cCat_Header' => $cCatheader, 'cCat_Filter' => $cCatfilter, 'pCat_Header' => $pCatheader, 'pCat_Filter' => $pCatfilter, 'cart_Header'=>$cartHeader,'active'=>'yes']);
		}
		
		public function updateSetting($cCatheader, $cCatfilter, $pCatheader, $pCatfilter, $cartHeader){
			$this->setting->updateOne(['active' => 'yes'],
									  ['$set' => ['cCat_Header' => $cCatheader, 'cCat_Filter' => $cCatfilter, 'pCat_Header' => $pCatheader, 'pCat_Filter' => $pCatfilter, 'cart_Header'=>$cartHeader]]);
		}
		
		public function findSetting() {
			return $this->setting->countDocuments(['active' => 'yes']);
		}
		
		public function getSetting() {
			return $this->setting->find();
		}
		
		/*****************/
		/*Cart Management*/
		/*****************/
		public function insertCart($cart, $uid){
			$this->cart->insertOne(['date' => '', 'carts' => $cart, 'uid' => $uid,'remarks' => "", 'status' => "active"]);
		}
		
		public function checkCartExists($uid){
			return $this->cart->countDocuments(['uid' => $uid, 'status' => "active"]);
		}
		
		public function updateCart($uid, $cart){
			$this->cart->updateOne(['uid' => $uid, 'status' => 'active'],
									['$set' => ['carts' => $cart]]);
		}
		
		public function updateStatus($uid, $remarks){
			$this->cart->updateOne(['uid' => $uid, 'status' => 'active'],
									['$set' => ['remarks' => $remarks, 'date'=> date("Y-m-d"),'status' => "pending"]]);
		}
				
		public function loadCart($uid){
			return $this->cart->find(['uid' => $uid, 'status' => "active"]);
		}
		
		/******************/
		/*Order Management*/
		/******************/
		public function loadOrder(){
			return $this->cart->find(['status' => [ '$ne' => "active"]]);
		}
		
		public function loadConfirmedOrder($oid) {
			return $this->cart->find(['_id' => new MongoDB\BSON\ObjectID($oid)]);
		}
		
		public function filterOrder($status){
			return $this->cart->find(['status' => $status]);
		}
				
		public function updateOrder($oid, $status){
			$this->cart->updateOne(['_id' => new MongoDB\BSON\ObjectID($oid)],
									['$set' => ['status' => $status]]);
		}
		
		public function removeOrder($oid) {
			$this->cart->deleteOne(['_id' => new MongoDB\BSON\ObjectID($oid)]);
		}
		/******************/
		/*Get Filter value*/
		/******************/
		
		public function getFilter($filter){
			return $this->collect->distinct('products.'.$filter);
		}
		
		public function getDate(){
			$data = $this->collect->find(
				[],
				[
					'limit' => 1, 
					'sort' => ['date'=> -1]
				]);
			foreach($data as $d)
				return $d['date'];
		}
		
        /*****************/
		/*User Management*/
		/*****************/
		public function checkUserExist($email){
			$userinfo = $this->user->findOne(['email' => $email]);
			return $userinfo['_id'];
		}
	
        public function insertUser($fullname, $phone, $email, $password, $type, $status){
			$this->user->insertOne(['fullname' => $fullname, 'phone' => $phone, 'email' => $email, 'password' => $password, 'type' => $type, 'status' => $status]);
		}
        
        public function updateUser($_id, $fullname, $phone, $email){
			$this->user->updateOne(['_id' => $_id], ['$set' =>['fullname' => $fullname, 'phone' => $phone, 'email' => $email]]);
		}
        
        public function updatePass($_id, $npassword){
			$this->user->updateOne(['_id' => $_id], ['$set' =>['password' => $npassword]]);
		}
        
        public function updateUserStatus($_id, $status){
			$this->user->updateOne(['_id' => $_id], ['$set' =>['status' => $status]]);
		}
		
		public function getUserName($_id) {
			$userinfo = $this->user->findOne(['_id' => new MongoDB\BSON\ObjectID($_id)]);
			return $userinfo['fullname'];
		}
		
		public function getUserEmail($_id) {
			$userinfo = $this->user->findOne(['_id' => new MongoDB\BSON\ObjectID($_id)]);
			return $userinfo['email'];
		}
		
		public function loadOrderHistory($_id)
		{
			$orderhistory = [];
			$hist = $this->cart->find(['uid' => $_id, 'status' => ['$ne' => "active"]] );
			foreach($hist as $h)
			{
				$item = new stdClass();
				foreach ($h['carts'] as $k=>$v){
					$key = $this->getProductDetail((string)$k);
					$item->$key = $v;
				}
				$temp = array(
					'test' => $item,
					'oid' => (string)$h['_id'],
					'date' => $h['date'],
					'status' => $h['status'],
					'view' => '<button class="button allBtn item mb-1" id="btnView" value="'.(string)$h['_id'].'">View <i class="fas fa-eye"></i></button>',
					
				);
				array_push($orderhistory, $temp);
			}
			return $orderhistory;
		}
	}
	
?>
