<?php 
	
	class Brand
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
		
		function getId()
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
			$GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
			$this->setId($GLOBALS['DB']->lastInsertId());
		}
		
		function update($new_name)
		{
			$GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
			$this->setName($new_name);
		}
		
		function delete()
		{
			$GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE brand_id = {$this->getId()};");
		}
		
		function addStore($new_store)
		{
			$GLOBALS->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$new_store->getId()});");
		}
		
		function getStores()
		{
			$stores = array();
			$query = $GLOBALS['DB']->query("SELECT stores.* FROM 
											brands JOIN brands_stores ON (brands.id = brands_stores.brand_id)
											       JOIN stores ON (brands_stores.store_id = stores.id)
											WHERE brands.id = {$this->getId()};");
			foreach($query as $store) {
				$store_name = $store['name'];
				$store_id = $store['id'];
				$new_store = new Store($store_name, $store_id);
				array_push($store_name, $store_id);
			}
			return $stores;
		}
		
		static function getAll()
		{
			$returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
			$brands = array();
			foreach($returned_brands as $brand) {
				$brand_name = $brand['name'];
				$brand_id = $brand['id'];
				$new_brand = new Brand($brand_name, $brand_id);
				array_push($brands, $new_brand);
			}
			return $brands;
		}
		
		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM brands");
		}
		
		static function find($search_id)
		{
			$found_brand = null;
			$brands = Brand::getAll();
			foreach($brands as $brand)
			{
				$brand_id = $brand->getId();
				if($brand_id == $search_id) {
					$found_brand = $brand;
				}
			}
			return $found_brand;
		}
	}
?>