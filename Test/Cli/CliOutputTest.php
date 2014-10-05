<?php
/**
 * Part of Windwalker project Test files.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\IO\Test\Cli;

use Windwalker\IO\Cli\Output\CliOutput;

/**
 * Test class of CliOutput
 *
 * @since {DEPLOY_VERSION}
 */
class CliOutputTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test instance.
	 *
	 * @var CliOutput
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
		$this->instance = new CliOutput;
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
	 * Method to test out().
	 *
	 * @return void
	 *
	 * @covers Windwalker\IO\Cli\Output\CliOutput::out
	 * @TODO   Implement testOut().
	 */
	public function testOut()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method to test err().
	 *
	 * @return void
	 *
	 * @covers Windwalker\IO\Cli\Output\CliOutput::err
	 * @TODO   Implement testErr().
	 */
	public function testErr()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method to test setProcessor().
	 *
	 * @return void
	 *
	 * @covers Windwalker\IO\Cli\Output\CliOutput::setProcessor
	 * @TODO   Implement testSetProcessor().
	 */
	public function testSetProcessor()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * Method to test getProcessor().
	 *
	 * @return void
	 *
	 * @covers Windwalker\IO\Cli\Output\CliOutput::getProcessor
	 * @TODO   Implement testGetProcessor().
	 */
	public function testGetProcessor()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}
}
