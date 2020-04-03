<?php 
class modulePosition
{
	private $position;
	private $modules;
	function __construct()
	{
		$this->position[0]='top';
		$this->position[1]='left';
		$this->position[3]='right';
		$this->position[4]='bottom';
		$this->position[5]='topright';
		
		$this->modules['topright'][0]='registration';
		$this->modules['top'][1]='menu';
	}
	public function getModulePosition()
	{
		return $this->position;
	}
	public function getModeleItems()
	{
		return $this->modules;
	}
}




?>