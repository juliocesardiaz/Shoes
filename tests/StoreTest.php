<?php 
	/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once 'src/Brand.php';
    require_once 'src/Store.php';
    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
	
	class StoreTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Brand::deleteAll();
			Store::deleteAll();
		}
		
		function test_getId()
		{
			$test_name = "Nordstrom";
			$test_id = 1;
			$test_store = new Store($test_name, $test_id);
			
			$result = $test_store->getId();
			
			$this->assertEquals(1, $result);
		}
		
		function test_getName()
		{
			$test_name = "Nordstrom";
			$test_id = 1;
			$test_store = new Store($test_name, $test_id);
			
			$result = $test_store->getName();
			
			$this->assertEquals($test_name, $result);
		}
		
		function test_save()
		{
			$test_name = "Nordstrom";
			$test_id = 1;
			$test_store = new Store($test_name, $test_id);
			$test_store->save();
			
			$result = Store::getAll();
			
			$this->assertEquals([$test_store], $result);
		}
		
		function test_getAll()
		{
			$test_name = "Nordstrom";
			$test_id = 1;
			$test_store = new Store($test_name, $test_id);
			$test_store->save();
			
			$test_name2 = "Bloomingdales";
			$test_id2 = 2;
			$test_store2 = new Store($test_name2, $test_id2);
			$test_store2->save();
			
			$result = store::getAll();
			
			$this->assertEquals([$test_store, $test_store2], $result);
		}
		
		function test_update()
		{
			$test_name = "Nordstrom";
			$test_id = 1;
			$test_store = new Store($test_name, $test_id);
			$test_store->save();
			
			$new_name = "Bloomingdales";
			$test_store->update($new_name);
			$result = Store::getAll();
			
			$this->assertEquals($new_name, $result[0]->getName());
		}
		
		function test_delete()
		{
			$test_name = "Nordstrom";
			$test_id = 1;
			$test_store = new store($test_name, $test_id);
			$test_store->save();
			
			$test_name2 = "Bloomingdales";
			$test_id2 = 2;
			$test_store2 = new Store($test_name2, $test_id2);
			$test_store2->save();
			
			$test_store->delete();
			
			$result = Store::getAll();
			
			$this->assertEquals([$test_store2], $result);
		}
		
		function test_addBrand()
		{
			$test_name = "Nordstrom";
			$test_id = 1;
			$test_store = new Store($test_name, $test_id);
			$test_store->save();
			
			$brand_name = "Y-3";
			$test_brand = new Brand($brand_name);
			$test_brand->save();
			
			$test_store->addBrand($test_brand);
			
			$result = $test_store->getBrands();
			
			$this->assertEquals([$test_brand], $result);
		}
		
		function test_find()
		{
			$test_name = "Nordstrom";
			$test_id = 1;
			$test_store = new Store($test_name, $test_id);
			$test_store->save();
			
			$test_name2 = "Bloomingdales";
			$test_id2 = 2;
			$test_store2 = new Store($test_name2, $test_id2);
			$test_store2->save();
			
			$result = Store::find($test_store->getId());
			
			$this->assertEquals($test_store, $result);
		}
	}
?>