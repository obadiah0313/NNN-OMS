<?php
	require_once './vendor/autoload.php';
	
	class MongodbDatabase{		
		//Constructor
		public function __construct(){
			try {
				$this->client = new MongoDB\Client();
			}catch (MongoConnectionException $e) {
				die('Error connecting to MongoDB server');
			}
			$this->db = $this->client->NNNdb;
			$this->collect = $this->db->selectCollection('stock');
			$this->deletion = $this->db->selectCollection('deletion');
			$this->user = $this->db->selectCollection('user');
			$this->cart = $this->db->selectCollection('cart');
		}
		
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
		
		/*********************************/
		/*Upload Data -- Stock & Deletion*/
		/*********************************/
		public function checkExists(){
			return $this->collect->countDocuments(['date' => date("Y-m-d")]);
		}
		
		public function replaceStock($date, $product){
			$this->collect->replaceOne(['date' => $date],
										['date' => $date, 'products' => $product]);
		}
		
		public function replaceDeletion($date, $deletion){
			$this->deletion->replaceOne(['date' => $date],
										['date' => $date, 'deletions' => $deletion]);
		}
		
		public function insertStock($date, $product){
			$this->collect->insertOne(['date' => $date, 'products' =>$product]);
		}
		
		public function insertDeletion($date, $deletion){
			$this->deletion->insertOne(['date' => $date, 'deletions' =>$deletion]);
		}
		
		/*****************/
		/*Cart Management*/
		/*****************/
		public function insertCart($oid, $date, $cart, $uid){
			$this->cart->insertOne(['oid' => $oid, 'date' => $date, 'carts' => $cart, 'uid' => $uid, 'status' => "pending"]);
		}
		
		public function checkCartExists($oid){
			return $this->cart->countDocuments(['oid' => $oid, 'status' => "pending"]);
		}
		
		public function updateCart($oid, $cart){
			$this->cart->updateOne(['oid' => $oid],
									['$set' => ['carts' => $cart]]);
		}
		
		public function countOrder($uid){
			if($this->cart->countDocuments(['uid' => $uid, 'status' => "pending"]) == null)
				return 0;
			else
				return $this->cart->countDocuments(['uid' => $uid, 'status' => "completed"]);
		}
		
		public function loadCart($uid){
			return $this->cart->find(['uid' => $uid, 'status' => "pending"]);
		}
		
		/******************/
		/*Get Filter value*/
		/******************/
		
		public function getSystem(){
			return $this->collect->distinct('products.System');
		}
		
		public function getType(){
			return $this->collect->distinct('products.Product Type');
		}
		
		public function getCountry(){
			return $this->collect->distinct('products.Country of Origin');
		}
	
		public function getModule(){
			return $this->collect->distinct('products.Module');
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
