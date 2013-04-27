<?php
class tpl
{
	private $smarty;
	private $tpl_file;
	private $nav_links = array();
	private $sub_nav_links = array();
	private $js_files = "";
	private $css_files = "";
	private $css_code;
	private $script = "";
	private $base_template = 'page.tpl';
	
	function __construct() 
	{
		require('smarty/Smarty.class.php');
		$this->smarty = new Smarty;
	}
	function add_js_file($path)
	{
		$this->js_files .= '<script language="javascript" type="text/javascript" src="'.$path.'"></script>'."\n";
	}
	function add_css_file($path)
	{
		$this->css_files .= '<link href="'.$path.'" rel="stylesheet">'."\n";
	}
	
	function add_nav_links($array)
	{
		foreach($array as $data)
		{
			$this->nav_links[] = array( 
				'name'	=> $data['name'],
				'url'	=> $data['url'],
				'class'	=> "none"
				);
		}
	}
	
	function add_sub_nav_links($array)
	{
		foreach($array as $data)
		{
			$this->sub_nav_links[] = array( 
				'name'	=> $data['name'],
				'url'	=> $data['url'],
				'class'	=> "none"
				);
		}
	}
	
	private function set_active($name, $array)
	{	
		for($i=0;$i<count($array);$i++)
		{
			if($array[$i]['name'] == $name)
				$array[$i]['class'] = 'active';
			else
				$array[$i]['class'] = '';
		}
		return $array;
	}
	
	function assign_vars($name, $value)
	{
		$this->smarty->assign($name, $value);
	}
	
	function add_script($value)
	{
		$this->script .= "<script>".$value."</script>\n";
	}
	function set_vars($array)
	{
		$this->smarty->assign("PAGE_TITLE", $array['page_title']);
		$this->smarty->assign("DESCRIPTION", $array['description']);
		$this->smarty->assign("AUTHOR", $array['author']);
		$this->smarty->assign("IMAGE", $array['image']);
		$this->smarty->assign("SUBHEADBIG", $array['subHeadBig']);
		$this->smarty->assign("SUBHEADSMALL", $array['subHeadSmall']);
		$this->tpl_file = $array['template_file'];
		
		$this->smarty->assign("NAV_LINKS", $this->set_active($array['nav_active'], $this->nav_links)); 
		$this->smarty->assign("SUB_NAV_LINKS", $this->set_active($array['sub_nav_active'], $this->sub_nav_links)); 
	}
	
	function display()
	{
		$this->smarty->assign("JS_FILES", $this->js_files); 
		$this->smarty->assign("TEMPLATEFILE", $this->tpl_file);
		$this->smarty->assign("CSS_FILES", $this->css_files);
		$this->smarty->assign("CSS_CODE", ""); //todo
		$this->smarty->assign("ENDSCRIPT", $this->script);
		$this->smarty->display( $this->base_template );
	}
}
?>
