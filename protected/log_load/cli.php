<?php 
class CLI
{
	private $options = array();
	private $scriptName;
	private $startTimestamp;
	
	public function __construct()
	{
		$this->startTimestamp = microtime();
		global $argv;
		$this->scriptName = array_shift($argv);
		foreach($argv as $arg)
		{
			if(strpos($arg, '--') === 0)
			{
				list($argName ,$value) = explode('=', $arg) ;
				$argName = substr($argName, 2);
				$this->options[$argName] = $value;
			}
		}
	}
	
	public function getOption($key)
	{
		if( $this->options[$key] !== null )
		{
			return $this->options[$key];
		}
		else
		{
			return false;
		}
	}
	
	public function getStartTime()
	{
		return $this->startTimestamp;
	}
	
	public function getTimeUsed()
	{
		return microtime() - $this->startTimestamp;
	}
}