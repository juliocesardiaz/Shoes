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
	
	class BrandTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Brand::deleteAll();
			Store::deleteAll();
		}
		
		function test_getId()
		{
			$test_name = "Helmut Lang";
			$test_id = 1;
			$test_brand = new Brand($test_name, $test_id);
			
			$result = $test_brand->getId();
			
			$this->assertEquals(1, $result);
		}
		
		function test_getName()
		{
			$test_name = "Helmut Lang";
			$test_id = 1;
			$test_brand = new Brand($test_name, $test_id);
			
			$result = $test_brand->getName();
			
			$this->assertEquals($test_name, $result);
		}
		
		function test_save()
		{
			$test_name = "Helmut Lang";
			$test_id = 1;
			$test_brand = new Brand($test_name, $test_id);
			$test_brand->save();
			
			$result = Brand::getAll();
			
			$this->assertEquals([$test_brand], $result);
		}
		
		function test_getAll()
		{
			$test_name = "Helmut Lang";
			$test_id = 1;
			$test_brand = new Brand($test_name, $test_id);
			$test_brand->save();
			
			$test_name2 = "Y-3";
			$test_id2 = 2;
			$test_brand2 = new Brand($test_name2, $test_id2);
			$test_brand2->save();
			
			$result = Brand::getAll();
			
			$this->assertEquals([$test_brand, $test_brand2], $result);
		}
		
		function test_update()
		{
			$test_name = "Helmut Lang";
			$test_id = 1;
			$test_brand = new Brand($test_name, $test_id);
			$test_brand->save();
			
			$new_name = "Y-3";
			$test_brand->update($new_name);
			$result = Brand::getAll();
			
			$this->assertEquals($new_name, $result[0]->getName());
		}
		
		function test_delete()
		{
			$test_name = "Helmut Lang";
			$test_id = 1;
			$test_brand = new Brand($test_name, $test_id);
			$test_brand->save();
			
			$test_name2 = "Y-3";
			$test_id2 = 2;
			$test_brand2 = new Brand($test_name2, $test_id2);
			$test_brand2->save();
			
			$test_brand->delete();
			
			$result = Brand::getAll();
			
			$this->assertEquals([$test_brand2], $result);
		}
		
		function test_addStore()
		{
			$test_name = "Helmut Lang";
			$test_id = 1;
			$test_brand = new Brand($test_name, $test_id);
			$test_brand->save();
			
			$store_name = "Nordstrom";
			$test_store = new Store($store_name);
			$test_store->save();
			
			$test_brand->addStore($test_store);
			
			$result = $test_brand->getStores();
			
			$this->assertEquals([$test_store], $result);
		}
		
		function test_find()
		{
			$test_name = "Helmut Lang";
			$test_id = 1;
			$test_brand = new Brand($test_name, $test_id);
			$test_brand->save();
			
			$test_name2 = "Y-3";
			$test_id2 = 2;
			$test_brand2 = new Brand($test_name2, $test_id2);
			$test_brand2->save();
			
			$result = Brand::find($test_brand->getId());
			
			$this->assertEquals($test_brand, $result);
		}
	}
?>