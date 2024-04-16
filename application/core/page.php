<?php
	
namespace application\core;

use application\core\types\Type_Header;

class Page
{
	protected $layout;
	protected $pageTitle;
	protected $view;
	protected $data;
	protected $header; // Myst be class of the <Type_Header>

	protected $style;	//filename with current page style
	protected $script;	//filename with current page JavaScript

	public function __construct($view = 'main_view', $title = 'DEFAULT TITLE', $layout = 'main', $data = null)
	{
		$this->layout = $layout;
		$this->pageTitle  = $title;
		$this->view   = $view;
		$this->data   = $data;
		$this->header = new Type_Header();

		$this->script = '';
		$this->style = '';
	}
	
	public function getLayout()
	{
		return $this->layout;
	}

	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	public function getPageTitle()
	{
		return $this->pageTitle;
	}

	public function setPageTitle($title)
	{
		$this->pageTitle = $title;
	}

	public function getView()
	{
		return $this->view;
	}

	public function setView($view)
	{
		$this->view = $view;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getHeader()
	{
		return $this->header;
	}

	public function setHeader($header)
	{
		$this->header = $header;
	}

	public function setStyle($stylefile)
	{
		if (file_exists(ROOT . "/css/" . $stylefile)) {
			$this->style = "css/" . $stylefile;
		}
	}

	public function getStyle() 
	{
		return $this->style;
	}

	public function setScript($scriptfile)
	{
		if (file_exists(ROOT . "/js/" . $scriptfile)) {
			$this->script = "js/" . $scriptfile;
		}
	}

	public function getScript() 
	{
		return $this->script;
	}

}
