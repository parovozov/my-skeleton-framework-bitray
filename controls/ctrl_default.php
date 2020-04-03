<?php
class defaultControl implements Controller
{
	private $menuitem;
	private $db;
	function __construct(){
		$this->getMetaTags();
	}
	
	private function getMetaTags(){
		new DataRetain();
		$dsave = DataRetain::getDataRetain();
		$this->menuitem = $dsave->getMenuItem();
	}
	
	public function getMetatitle(){
		$strmeta="<title>".$this->menuitem[0]['metatitle']."</title>\n";
		return $strmeta;
	}
	
	public function getMetaDescription(){
		$strmeta="<meta name='description' content='".$this->menuitem[0]['metadescription']."'/>\n";
		return $strmeta;
	}
	
	public function getMetaKeyWords(){
		$strmeta="<meta name='keywords' content='".$this->menuitem[0]['metakeywords']."' />\n";
		return $strmeta;
	}
	
	public function getTemplate(){
		return $this->menuitem[0]['template'];
	}
	
	public function addScript(){
		$str="";
		$filename = "templates/".$this->getTemplate()."/js/tmpl_".$this->getTemplate().".js";
		if(file_exists($filename))
			$str.="<script src='".$filename."'  type='text/javascript'></script>\n";		
		
		$str.=$this->addModuleScript();
		return $str;
	}
	
	private function addModuleScript(){
		$str='';
		new DataRetain();
		$dsave = DataRetain::getDataRetain();
		$modulesname = $dsave->getModelesOnPage();

		foreach($modulesname as $key => $val){
			$filename = "modules/mod_".$val."/js/mod_".$val.".js";
			if(file_exists($filename))
				$str.="<script src='".$filename."'  type='text/javascript'></script>\n";
		}
		return $str;
	}
	
	public function addCss(){
		$str="";
		$filename="templates/".$this->getTemplate()."/css/tmpl_".$this->getTemplate().".css";
		if(file_exists($filename))
			$str.="<link rel='stylesheet' href='".$filename."' type='text/css' />\n";	
		
		$str.=$this->addModeleCss();
		return $str;
	}
	
	 private function addModeleCss(){
		$str='';
		new DataRetain();
		$dsave = DataRetain::getDataRetain();
		$modulesname = $dsave->getModelesOnPage();
		
		foreach($modulesname as $key => $val){
			$filename = "modules/mod_".$val."/css/mod_".$val.".css";
			if(file_exists($filename))
				$str.="<link rel='stylesheet' href='".$filename."' type='text/css' />\n";
		}
		 return $str;
	 }
	
	private function parceTemplateInside($template_puth, $template_tmp, $template_txt, $filemodifytemplate, $template_modules){
		$linefilenew='';
		$linereplace='';
		$linefile=file($template_puth);
		$i=0;
		while(!empty($linefile[$i]))
		{
			$pos1=strpos($linefile[$i], '<#');
			$pos2=strpos($linefile[$i], '#>');
			if($pos1!==false && $pos2!==false)
			{
				preg_match_all('/<#(\w{3,})#>/', $linefile[$i], $matches);
				$l=count($matches);
				$linereplace = $linefile[$i];
				foreach($matches[0] as $key => $val)
				{
					$this->setModulesPage($matches[1][$key]);
					$linereplace=str_replace($val, '<?php '.__CLASS__.'::loadModule("'.$matches[1][$key].'") ?>', $linereplace);					
				}
				$linefilenew.= $linereplace;				
			}
			else {
				$linefilenew.= $linefile[$i];
			}
			$i++;
		}
		
		new DataRetain();
		$dsave = DataRetain::getDataRetain();		
		$modules = $dsave->getModelesOnPage();
		$s = serialize($modules);	
			
		file_put_contents($template_modules, $s);
		file_put_contents($template_tmp, $linefilenew);
		file_put_contents($template_txt, $filemodifytemplate);
	}
	
	public function parceTemplate(string $template){
		$template_file = 'tmpl_'.$template.'.php';
		$template_txt_file = 'tmpl_'.$template.'.txt';
		$template_modules_file = 'tmpl_'.$template.'_mod.inc';
		
		$template_puth=JURL.'/'.'templates/'.$template.'/'.$template_file;		
		$template_tmp=JURL.'/'.'temp/templates/'.$template_file;
		$template_txt=JURL.'/'.'temp/templates/'.$template_txt_file;
		$template_modules=JURL.'/'.'temp/templates/'.$template_modules_file;
		
		if(!file_exists($template_puth)) {echo 'Template not find.'; exit;}
		$filemodifytemplate = filemtime($template_puth);
		
		if(file_exists($template_txt))
		{
			$filemodifytxt = file_get_contents($template_txt);
			if($filemodifytemplate == $filemodifytxt)
				return;
			else $this->parceTemplateInside($template_puth, $template_tmp, $template_txt, $filemodifytemplate, $template_modules);
		}
		else $this->parceTemplateInside($template_puth, $template_tmp, $template_txt, $filemodifytemplate, $template_modules); 
	}
	
	private function setModulesPage(string $modulename){
		new DataRetain();
		$dsave = DataRetain::getDataRetain();		
		$dsave->setModelesOnPage($modulename);
	}
	
	static function loadModule($modul)
	{
		new DataRetain();
		$dsave = DataRetain::getDataRetain();		
		$modules = $dsave->getModelesOnPage();
		if(in_array($modul, $modules)){
			$filename = 'mod_'.$modul.'.php';
			$dirname = 'mod_'.$modul;
			$fileputh = JURL.'/modules/'.$dirname.'/'.$filename;
			//echo $fileputh;
			if(file_exists($fileputh)){
				require_once($fileputh);
			}
			else{
				echo '<strong>Модуль '.$modul.' не найден!</strong>';
			exit;
			}
		}
		else{
			echo '<strong>Модуль '.$modul.' не зарегистрирован!</strong>';
			exit;
		}
	}
	
	public function getAcssesToGroup($groupids){
		//$groupid = explode(',', $groupids);
		var_dump($groupids);
	}
}
?>