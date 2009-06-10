<?php
/**
 * ApiPackage test case
 *
 * PHP 5.2+
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org
 * @package       api_generator
 * @subpackage    api_generator.tests.models
 * @since         ApiGenerator 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/
App::import('Model', 'ApiGenerator.ApiPackage');
App::import('Vendor', 'ApiGenerator.ClassDocumentor');

/**
 * ApiPackageSampleClass doc block
 *
 * @package default.another.level
 */
class ApiPackageSampleClass {

}

/**
 * ApiPackage Sample Class
 *
 * @package default
 * @subpackage another.level.two
 **/
class ApiPackageSampleClassTwo {

}

/**
 * ApiPackageTestCase
 *
 * @package api_generator.tests
 **/
class ApiPackageTestCase extends CakeTestCase {
/**
 * fixtures
 *
 * @var array
 **/
	var $fixtures = array('plugin.api_generator.api_class', 'plugin.api_generator.api_package');
/**
 * startTest
 *
 * @return void
 **/
	function startTest() {
		$this->_path = APP . 'plugins' . DS . 'api_generator';
		$this->_testAppPath = dirname(dirname(dirname(__FILE__))) . DS . 'test_app' . DS;

		Configure::write('ApiGenerator.filePath', $this->_path);
		$this->ApiPackage = ClassRegistry::init('ApiPackage');
	}
/**
 * endTest
 *
 * @return void
 **/
	function endTest() {
		unset($this->ApiPackage);
		ClassRegistry::flush();
	}

/**
 * test getting the package index tree
 *
 * @return void
 **/
	function testPackageIndex() {
		$result = $this->ApiPackage->getPackageIndex();

		$this->assertFalse(isset($result[0]['ApiClass']), 'ApiClass has snuck in, big queries are happening %s');
		$this->assertTrue(isset($result[0]['children']), 'No children, might not be a tree %s');
	}
}