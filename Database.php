<?php
	require_once './vendor/autoload.php';
	
	class MongodbDatabase{		
		//Constructor
		public function __construct(){
			try {
				//$this->client = new MongoDB\Client();
				$this->client = new MongoDB\Client('mongodb://localhost:27017/?readPreference=primary&appname=MongoDB%20Compass%20Community&ssl=false');
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

		public function getHeaders(){
			foreach($this->fetchProduct() as $i){
				return iterator_to_array($i['header']);
			}
		}
		
		/*********************************/
		/*Upload Data -- Stock & Deletion*/
		/*********************************/
		public function checkExists(){
			return $this->collect->countDocuments(['date' => date("Y-m-d")]);
		}
		
		public function replaceStock($date, $product, $header, $primarykey){
			$this->collect->replaceOne(['date' => $date],
										['date' => $date, 'products' => $product, 'header' => $header, 'primaryKey' => $primarykey]);
		}
		
		public function replaceDeletion($date, $deletion){
			$this->deletion->replaceOne(['date' => $date],
										['date' => $date, 'deletions' => $deletion]);
		}
		
		public function insertStock($date, $product, $header, $primarykey){
			$this->collect->insertOne(['date' => $date, 'products' =>$product, 'header' => $header, 'primaryKey' => $primarykey]);
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
		public function insertCart($oid, $cart, $uid){
			$this->cart->insertOne(['oid' => $oid, 'date' => '', 'carts' => $cart, 'uid' => $uid,'remarks' => "", 'status' => "active"]);
		}
		
		public function checkCartExists($oid){
			return $this->cart->countDocuments(['oid' => $oid, 'status' => "active"]);
		}
		
		public function updateCart($oid, $cart){
			$this->cart->updateOne(['oid' => $oid],
									['$set' => ['carts' => $cart]]);
		}
		
		public function updateStatus($oid, $remarks){
			$this->cart->updateOne(['oid' => $oid],
									['$set' => ['remarks' => $remarks, 'date'=> date("Y-m-d"),'status' => "pending"]]);
		}
		
		public function countOrder($uid){
			if($this->cart->countDocuments(['uid' => $uid, 'status' => "active"]) == null)
				return 0;
			else
				return $this->cart->countDocuments(['uid' => $uid, 'status' => "completed"]);
		}
		
		public function loadCart($uid){
			return $this->cart->find(['uid' => $uid, 'status' => "active"]);
		}
		
		/******************/
		/*Order Management*/
		/******************/
		public function loadOrder(){
			return $this->cart->find(['status' => "pending"]);
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
        /*************/
		/*Create User*/
		/*************/
        public function insertUser($fullname, $phone, $email, $password, $type){
			$this->user->insertOne(['fullname' => $fullname, 'phone' => $phone, 'email' => $email, 'password' => $password, 'type' => $type]);
		}
        
        public function updateUser($_id, $fullname, $phone, $email){
			$this->user->updateOne(['_id' => $_id], ['$set' =>['fullname' => $fullname, 'phone' => $phone, 'email' => $email]]);
		}
        
        public function updatePass($_id, $npassword){
			$this->user->updateOne(['_id' => $_id], ['$set' =>['password' => $npassword]]);
		}
	}
	
?>
