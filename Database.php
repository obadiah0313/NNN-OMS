<?php
	require_once 'vendor/autoload.php';
	
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
		}
		
		public function fetchData(){
			return $this->collect->find(
			[
				'date'=> date("Y-m-d")
			]);
		}
		
		public function checkExists(){
			return $this->collect->findOne(['date' => date('Y-m-d')]);
		}
		
		public function replaceStock($date, $product){
			$this->collect->replaceOne(['date' => $date],
										['date' => $date, 'products' => $_POST['data']]);
		}
		
		public function insertStock($date, $product){
			$this->collect->insertOne(['date' => $date, 'products' => $product]);
		}
	}
	
?>
