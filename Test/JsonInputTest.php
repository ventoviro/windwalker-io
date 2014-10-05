<?php
/**
 * Part of Windwalker project Test files.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\IO\Test;

use Windwalker\IO\JsonInput;
use Windwalker\Test\TestHelper;

/**
 * Test class of JsonInput
 *
 * @since {DEPLOY_VERSION}
 */
class JsonInputTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test instance.
	 *
	 * @var JsonInput
	 */
	protected $instance;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		$this->instance = new JsonInput;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return void
	 */
	protected function tearDown()
	{
	}

	/**
	 * Test the Windwalker\IO\Json::__construct method.
	 *
	 * @return  void
	 *
	 * @covers  Windwalker\IO\Json::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$this->assertInstanceOf(
			'Windwalker\Filter\InputFilter',
			TestHelper::getValue($this->instance, 'filter')
		);

		$this->assertEmpty(
			TestHelper::getValue($this->instance, 'data')
		);

		// Given Source & filter
		$src = array('foo' => 'bar');
		$json = new JsonInput($src);

		$this->assertEquals(
			$src,
			TestHelper::getValue($json, 'data')
		);

		// Src from GLOBAL
		$GLOBALS['HTTP_RAW_POST_DATA'] = '{"a":1,"b":2}';
		$json = new JsonInput;

		$this->assertEquals(
			array('a' => 1, 'b' => 2),
			TestHelper::getValue($json, 'data')
		);
	}

	/**
	 * Test the Windwalker\IO\Json::getRaw method.
	 *
	 * @return  void
	 *
	 * @covers  Windwalker\IO\JsonInput::getRaw
	 * @since   1.0
	 */
	public function testgetRaw()
	{
		$GLOBALS['HTTP_RAW_POST_DATA'] = '{"a":1,"b":2}';

		$json = new JsonInput;

		$this->assertEquals(
			$GLOBALS['HTTP_RAW_POST_DATA'],
			$json->getRaw()
		);
	}
}
