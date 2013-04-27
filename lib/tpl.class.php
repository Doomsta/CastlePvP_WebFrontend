<?php
class tpl
{
	private $smarty;
	private $tpl_file;
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
	function assign_block_vars($array)
	{
		
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
		$this->smarty->assign("IMAGE", $array['image']);
		$this->smarty->assign("SUBHEADBIG", $array['subHeadBig']);
		$this->smarty->assign("SUBHEADSMALL", $array['subHeadSmall']);
		$this->tpl_file = $array['template_file'];
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
