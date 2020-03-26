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
		
		public function checkExists(){
			return $this->collect->countDocuments(['date' => date("Y-m-d")]);
		}
		
		public function replaceStock($date, $product){
			$this->collect->replaceOne(['date' => $date],
										['date' => $date, 'products' => $product]);
			var_dump("Replace product done...");
		}
		
		public function replaceDeletion($date, $deletion){
			$this->deletion->replaceOne(['date' => $date],
										['date' => $date, 'products' => $deletion]);
			var_dump("Replace deletion done...");
		}
		
		public function insertStock($date, $product){
			$this->collect->insertOne(['date' => $date, 'products' =>$product]);
			var_dump("Insert product done...");
		}
		
		public function insertDeletion($date, $deletion){
			$this->deletion->insertOne(['date' => $date, 'deletions' =>$deletion]);
			var_dump("Insert deletion done...");
		}
	}
	
?>
