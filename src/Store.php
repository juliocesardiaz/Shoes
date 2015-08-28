<?php 
	
	class Store 
	{
		private $name;
		private $id;
		
		function __construct($name, $id = null)
		{
			$this->name = $name;
			$this->id = $id;
		}
		
		function setName($new_name)
		{
			$this->name = $new_name;
		}
		
		function getName()
		{
			return $this->name;
		}
		
		function setId($new_id)
		{
			$this->id = $new_id;
		}
		
		function getId()
		{
			return $this->id;
		}
		
		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
			$this->setId($GLOBALS['DB']->lastInsertId());
		}
		
		function update($new_name)
		{
			$GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
			$this->setName($new_name);
		}
		
		function addBrand($new_brand)
		{
			$GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$new_brand->getId()}, {$this->getId()});");
		}
		
		function getBrands()
		{
			$brands = array();
			$query = $GLOBALS['DB']->query("SELECT brands.* FROM 
											stores JOIN brands_stores ON (stores.id = brands_stores.store_id)
											       JOIN brands ON (brands_stores.brand_id = brands.id)
											WHERE stores.id = {$this->getId()};");
			foreach($query as $brand) {
				$brand_name = $brand['name'];
				$brand_id = $brand['id'];
				$new_brand = new Brand($brand_name, $brand_id);
				array_push($brands, $new_brand);
			}
			return $brands;
		}
		
		function delete()
		{
			$GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()};");
		}
		
		static function getAll()
		{
			$returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
			$stores = array();
			foreach($returned_stores as $store) {
				$store_name = $store['name'];
				$store_id = $store['id'];
				$new_store = new Store($store_name, $store_id);
				array_push($stores, $new_store);
			}
			return $stores;
		}
		
		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM stores;");
			$GLOBALS['DB']->exec("DELETE FROM brands_stores;");
		}
		
		static function find($search_id)
		{
			$found_store = null;
			$stores = Store::getAll();
			foreach($stores as $store)
			{
				$store_id = $store->getId();
				if($store_id == $search_id) {
					$found_store = $store;
				}
			}
			return $found_store;
		}
	}
?>