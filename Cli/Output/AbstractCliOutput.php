<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2008 - 2014 Asikart.com. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\IO\Cli\Output;

/**
 * Class AbstractCliOutput
 *
 * @since {DEPLOY_VERSION}
 */
abstract class AbstractCliOutput implements CliOutputInterface
{
	/**
	 * Property outStream.
	 *
	 * @var  resource
	 */
	protected $outputStream = STDOUT;

	/**
	 * Property errorStream.
	 *
	 * @var  resource
	 */
	protected $errorStream = STDERR;

	/**
	 * getOutStream
	 *
	 * @return  resource
	 */
	public function getOutputStream()
	{
		return $this->outputStream;
	}

	/**
	 * setOutStream
	 *
	 * @param   resource $outStream
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setOutputStream($outStream)
	{
		$this->outputStream = $outStream;

		return $this;
	}

	/**
	 * Method to get property ErrorStream
	 *
	 * @return  resource
	 */
	public function getErrorStream()
	{
		return $this->errorStream;
	}

	/**
	 * Method to set property errorStream
	 *
	 * @param   resource $errorStream
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setErrorStream($errorStream)
	{
		$this->errorStream = $errorStream;

		return $this;
	}
}

