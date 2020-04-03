<?php 
class DataRetain
{
	private $menuitem;
	private $ctrl;
	private $modulesonpage = array();
	static $instance;
	
	function __construct(){
		if(self::$instance) return;
		else {self::$instance=$this; return;}
	}
	
	static public function getDataRetain(){
		return self::$instance;
	}
	
	public function setMenuItem(array $masfitch){
		$this->menuitem = $masfitch;
	}
	
	public function getMenuItem(){
		return $this->menuitem;
	}
	
	public function setControlObj($ctrl){
		$this->ctrl = $ctrl;
	}
	
	public function getControlObj(){
		return $this->ctrl;
	}
	
	public function setModelesOnPage($module, $totalmas=false){
		if(!$totalmas) array_push($this->modulesonpage, $module);
		else $this->modulesonpage=$module;
	}
	
	public function getModelesOnPage(){
		return $this->modulesonpage;
	}
}

interface Controller
{
	//private function getMetaTags();
	public function getMetatitle();
	public function getMetaDescription();
	public function getMetaKeyWords();
	public function getTemplate();
	public function addScript();
	public function addCss();	
}


class router
{
	private $segments; 
	private $tmplctrl;
	protected $db;
	
	function __construct(){
		$db = new Database();
		$this->db = $db->getDbConnect();
		$this->getSegments();
		$this->getTmplCtrl();
		$this->loader();
	}
	
	private function getSegments(){
		$uri=$_SERVER['REQUEST_URI'];
		$mas = explode('/', trim($uri, '/'));
		$this->segments['aliace']= (!empty($mas[0])) ? $mas[0] : '/';
		return $this->segments;
	}
	
	private function getTmplCtrl(){
		$sql="SELECT * FROM `menu` WHERE `aliace` = '".$this->segments['aliace']."' LIMIT 1";
		$fitch = $this->db->prepare($sql);
		$fitch->execute();		
		$masfitch = $fitch->fetchAll(PDO::FETCH_ASSOC);		

		var_dump($sql);exit;
		if(!empty($masfitch))
		{
			$this->tmplctrl['template'] = $masfitch[0]['template'];
			$this->tmplctrl['control'] = $masfitch[0]['control'];
		}
		//404
		else{
			header("location: http://itvideos.loc/404");			
		}
		//храним информацию по данной странице в статике
		new DataRetain();
		$dsave = DataRetain::getDataRetain();
		$dsave->setMenuItem($masfitch);
		//var_dump($this->tmplctrl);
		return $this->tmplctrl;
	}
	
	private function loader(){
		$this->loadControl();
		
		new DataRetain();
		$dsave = DataRetain::getDataRetain();
		$ctrl = $dsave->getControlObj();
		
		$ctrl->parceTemplate($this->tmplctrl['template']);		
		$this->loadModelesName($this->tmplctrl['template']);		
		$this->loadTemplate();			
	}
	
	private function loadControl(){
		if(!file_exists(JURL.'/'.'controls/ctrl_'.$this->tmplctrl['control'].'.php')) {
			echo 'Controller not find.';
			exit;
		}
		require_once(JURL.'/'.'controls/ctrl_'.$this->tmplctrl['control'].'.php');
		$contrl_name= $this->tmplctrl['control']."Control";		
		$ctrl=new $contrl_name;	
		
		new DataRetain();
		$dsave = DataRetain::getDataRetain();
		$dsave->setControlObj($ctrl);
	}
	
	private function loadTemplate(){
	 require_once(JURL.'/'.'temp/templates/'.'/tmpl_'.$this->tmplctrl['template'].'.php');
	}
	
	private function loadModelesName($template){
		$s = file_get_contents(JURL.'/'.'temp/templates/'.'/tmpl_'.$template.'_mod.inc');
		$modules = unserialize($s);
		
		new DataRetain();
		$dsave = DataRetain::getDataRetain();
		$dsave->setModelesOnPage($modules, true);
	}
	
	
}
$rout= new router();
?>