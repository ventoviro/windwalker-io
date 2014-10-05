<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2008 - 2014 Asikart.com. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\IO;

use Windwalker\Filter\InputFilter;
use Windwalker\IO\Filter\NullFilter;

/**
 * Class Input
 *
 * @property-read    Input       $get
 * @property-read    Input       $post
 * @property-read    Input       $request
 * @property-read    Input       $server
 * @property-read    FilesInput  $files
 * @property-read    Cookie      $cookie
 *
 * @method      integer  getInt()       getInt($name, $default = null)    Get a signed integer.
 * @method      integer  getUint()      getUint($name, $default = null)   Get an unsigned integer.
 * @method      float    getFloat()     getFloat($name, $default = null)  Get a floating-point number.
 * @method      boolean  getBool()      getBool($name, $default = null)   Get a boolean.
 * @method      boolean  getBoolean()   getBoolean($name, $default = null)   Get a boolean.
 * @method      string   getWord()      getWord($name, $default = null)
 * @method      string   getAlnum()     getAlnum($name, $default = null)
 * @method      string   getCmd()       getCmd($name, $default = null)
 * @method      string   getBase64()    getBase64($name, $default = null)
 * @method      string   getString()    getString($name, $default = null)
 * @method      string   getHtml()      getHtml($name, $default = null)
 * @method      string   getPath()      getPath($name, $default = null)
 * @method      string   getUsername()  getUsername($name, $default = null)
 * @method      string   getEmail()     getEmail($name, $default = null)
 * @method      string   getUrl()       getUrl($name, $default = null)
 * @method      string   getRaw()       getRaw($name, $default = null)
 *
 * @since {DEPLOY_VERSION}
 */
class Input implements \Serializable, \Countable
{
	/**
	 * Filter object to use.
	 *
	 * @var    \Windwalker\Filter\InputFilter
	 * @since  {DEPLOY_VERSION}
	 */
	protected $filter = null;

	/**
	 * Input data.
	 *
	 * @var    array
	 * @since  {DEPLOY_VERSION}
	 */
	protected $data = array();

	/**
	 * Input objects
	 *
	 * @var    array
	 * @since  {DEPLOY_VERSION}
	 */
	protected $inputs = array();

	/**
	 * Constructor.
	 *
	 * @param   array       $source  Optional source data. If omitted, a copy of the server variable '_REQUEST' is used.
	 * @param   InputFilter $filter  The input filter object.
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function __construct($source = null, InputFilter $filter = null)
	{
		if ($filter)
		{
			$this->filter = $filter;
		}
		else
		{
			$this->filter = class_exists('Windwalker\\Filter\\InputFilter') ? new InputFilter : new NullFilter;
		}

		$this->prepareSource($source);
	}

	/**
	 * Prepare source.
	 *
	 * @param   array  $source  Optional source data. If omitted, a copy of the server variable '_REQUEST' is used.
	 *
	 * @return  void
	 */
	protected function prepareSource($source = null)
	{
		if (is_null($source))
		{
			$this->data = &$_REQUEST;
		}
		else
		{
			$this->data = $source;
		}
	}

	/**
	 * Magic method to get an input object
	 *
	 * @param   mixed  $name  Name of the input object to retrieve.
	 *
	 * @return  Input  The request input object
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function __get($name)
	{
		if (isset($this->inputs[$name]))
		{
			return $this->inputs[$name];
		}

		$filter = ($this->filter instanceof NullFilter) ? null : $this->filter;

		$className = __NAMESPACE__ . '\\' . ucfirst($name) . 'Input';

		if (!class_exists($className))
		{
			$className = __NAMESPACE__ . '\\' . ucfirst($name);
		}

		if (class_exists($className))
		{
			$this->inputs[$name] = new $className(null, $filter);

			return $this->inputs[$name];
		}

		$superGlobal = '_' . strtoupper($name);

		if (isset($GLOBALS[$superGlobal]))
		{
			$this->inputs[$name] = new Input($GLOBALS[$superGlobal], $filter);

			return $this->inputs[$name];
		}

		return null;
	}

	/**
	 * Get the number of variables.
	 *
	 * @return  integer  The number of variables in the input.
	 *
	 * @since   {DEPLOY_VERSION}
	 * @see     Countable::count()
	 */
	public function count()
	{
		return count($this->data);
	}

	/**
	 * Gets a value from the input data.
	 *
	 * @param   string  $name     Name of the value to get.
	 * @param   mixed   $default  Default value to return if variable does not exist.
	 * @param   string  $filter   Filter to apply to the value.
	 *
	 * @return  mixed  The filtered input value.
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function get($name, $default = null, $filter = 'cmd')
	{
		if (isset($this->data[$name]))
		{
			return $this->filter->clean($this->data[$name], $filter);
		}

		return $default;
	}

	/**
	 * Gets an array of values from the request.
	 *
	 * @param   array  $vars        Associative array of keys and filter types to apply.
	 *                              If empty and datasource is null, all the input data will be returned
	 *                              but filtered using the default case in JFilterInput::clean.
	 * @param   mixed  $datasource  Array to retrieve data from, or null
	 *
	 * @return  mixed  The filtered input data.
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function getArray(array $vars = array(), $datasource = null)
	{
		if (empty($vars) && is_null($datasource))
		{
			$vars = $this->data;
		}

		$results = array();

		foreach ($vars as $k => $v)
		{
			if (is_array($v))
			{
				if (is_null($datasource))
				{
					$results[$k] = $this->getArray($v, $this->get($k, null, 'array'));
				}
				else
				{
					$results[$k] = $this->getArray($v, $datasource[$k]);
				}
			}
			else
			{
				if (is_null($datasource))
				{
					$results[$k] = $this->get($k, null, $v);
				}
				elseif (isset($datasource[$k]))
				{
					$results[$k] = $this->filter->clean($datasource[$k], $v);
				}
				else
				{
					$results[$k] = $this->filter->clean(null, $v);
				}
			}
		}

		return $results;
	}

	/**
	 * Sets a value
	 *
	 * @param   string  $name   Name of the value to set.
	 * @param   mixed   $value  Value to assign to the input.
	 *
	 * @return  void
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function set($name, $value)
	{
		$this->data[$name] = $value;
	}

	/**
	 * Define a value. The value will only be set if there's no value for the name or if it is null.
	 *
	 * @param   string  $name   Name of the value to define.
	 * @param   mixed   $value  Value to assign to the input.
	 *
	 * @return  void
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function def($name, $value)
	{
		if (isset($this->data[$name]))
		{
			return;
		}

		$this->data[$name] = $value;
	}

	/**
	 * Check if a value name exists.
	 *
	 * @param   string  $name  Value name
	 *
	 * @return  boolean
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function exists($name)
	{
		return isset($this->data[$name]);
	}

	/**
	 * extract
	 *
	 * @param   string $name
	 *
	 * @return  static
	 */
	public function extract($name)
	{
		return new static($this->get($name, array(), 'raw'));
	}

	/**
	 * getByPath
	 *
	 * @param   string  $paths
	 * @param   mixed   $default
	 * @param   string  $filter
	 *
	 * @return  array|null
	 */
	public function getByPath($paths, $default = null, $filter = 'cmd')
	{
		if (empty($paths))
		{
			return null;
		}

		$args = is_array($paths) ? $paths : explode('.', $paths);

		$dataTmp = $this->data;

		foreach ($args as $arg)
		{
			if (is_object($dataTmp) && !empty($dataTmp->$arg))
			{
				$dataTmp = $dataTmp->$arg;
			}
			elseif (is_array($dataTmp) && !empty($dataTmp[$arg]))
			{
				$dataTmp = $dataTmp[$arg];
			}
			else
			{
				return $default;
			}
		}

		return $this->filter->clean($dataTmp, $filter);
	}

	/**
	 * Magic method to get filtered input data.
	 *
	 * @param   string  $name       Name of the filter type prefixed with 'get'.
	 * @param   array   $arguments  [0] The name of the variable [1] The default value.
	 *
	 * @return  mixed   The filtered input value.
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function __call($name, $arguments)
	{
		if (substr($name, 0, 3) == 'get')
		{
			$filter = substr($name, 3);

			$default = null;

			if (isset($arguments[1]))
			{
				$default = $arguments[1];
			}

			return $this->get($arguments[0], $default, $filter);
		}
	}

	/**
	 * Gets the request method.
	 *
	 * @return  string   The request method.
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function getMethod()
	{
		$method = strtoupper($_SERVER['REQUEST_METHOD']);

		return $method;
	}

	/**
	 * Method to serialize the input.
	 *
	 * @return  string  The serialized input.
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function serialize()
	{
		// Load all of the inputs.
		$this->loadAllInputs();

		// Remove $_ENV and $_SERVER from the inputs.
		$inputs = $this->inputs;
		unset($inputs['env']);
		unset($inputs['server']);

		// Serialize the options, data, and inputs.
		return serialize(array($this->data, $inputs));
	}

	/**
	 * Method to unserialize the input.
	 *
	 * @param   string  $input  The serialized input.
	 *
	 * @return  Input  The input object.
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function unserialize($input)
	{
		// Unserialize the data, and inputs.
		list($this->data, $this->inputs) = unserialize($input);

		$this->filter = class_exists('Windwalker\\Filter\\InputFilter') ? new InputFilter : new NullFilter;
	}

	/**
	 * Method to load all of the global inputs.
	 *
	 * @return  void
	 *
	 * @since   {DEPLOY_VERSION}
	 */
	public function loadAllInputs()
	{
		static $loaded = false;

		if (!$loaded)
		{
			// Load up all the globals.
			foreach ($GLOBALS as $global => $data)
			{
				// Check if the global starts with an underscore.
				if (strpos($global, '_') === 0)
				{
					// Convert global name to input name.
					$global = strtolower($global);
					$global = substr($global, 1);

					// Get the input.
					$this->$global;
				}
			}

			$loaded = true;
		}
	}
}
