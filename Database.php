<?php
	require_once './vendor/autoload.php';
	
	class MongodbDatabase{		
		//Constructor
		public function __construct(){
			try {
				$this->client = new MongoDB\Client('mongodb://admin:admin123@ds239009.mlab.com:39009/heroku_0g0g5g6c');
			}catch (MongoConnectionException $e) {
				die('Error connecting to MongoDB server');
			}
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
		
		/*********************************/
		/*Upload Data -- Stock & Deletion*/
		/*********************************/
		public function checkExists(){
			return $this->collect->countDocuments(['date' => date("Y-m-d")]);
		}
		
		public function replaceStock($date, $product, $header){
			$this->collect->replaceOne(['date' => $date],
										['date' => $date, 'products' => $product, 'header' => $header]);
		}
		
		public function replaceDeletion($date, $deletion){
			$this->deletion->replaceOne(['date' => $date],
										['date' => $date, 'deletions' => $deletion]);
		}
		
		public function insertStock($date, $product, $header){
			$this->collect->insertOne(['date' => $date, 'products' =>$product, 'header' => $header]);
		}
		
		public function insertDeletion($date, $deletion){
			$this->deletion->insertOne(['date' => $date, 'deletions' =>$deletion]);
		}
		
		public function getHeaders(){
			foreach($this->fetchProduct() as $i){
				return iterator_to_array($i['header']);
			}
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
		public function insertCart($oid, $date, $cart, $uid){
			$this->cart->insertOne(['oid' => $oid, 'date' => $date, 'carts' => $cart, 'uid' => $uid,'remarks' => "", 'status' => "active"]);
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
									['$set' => ['remarks' => $remarks, 'status' => "pending"]]);
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
	}
	
?>
