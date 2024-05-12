<?php

namespace application\core;

use application\core\types\Type_Header;

class Page
{
    public string $hideButtons;
    public string $title;
    public string $headerTitle;
    protected $layout;
	protected $pageTitle;
	public string $view;
	public $data;
	protected Type_Header $header; // Must be class of the <Type_Header>

	protected string $style;	//filename with current page style
	protected string $script;	//filename with current page JavaScript

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

	public function setLayout($layout): Page
    {
		$this->layout = $layout;

        return $this;
	}

	public function getPageTitle()
	{
		return $this->pageTitle;
	}

	public function setPageTitle($title): Page
    {
		$this->pageTitle = $title;

        return $this;
	}

	public function getView()
	{
		return $this->view;
	}

	public function setView($view): Page
	{
		$this->view = $view;

        return $this;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data): Page
	{
		$this->data = $data;

        return $this;
	}

	public function getHeader(): Type_Header
    {
		return $this->header;
	}

	public function setHeader($header): Page
	{
		$this->header = $header;

        return $this;
	}

	public function setStyle($stylefile): Page
	{
		if (file_exists(ROOT . "/css/" . $stylefile)) {
			$this->style = "css/" . $stylefile;
		}

        return $this;
	}

	public function getStyle(): string
    {
		return $this->style;
	}

	public function setScript($scriptfile): Page
	{
		if (file_exists(ROOT . "/js/" . $scriptfile)) {
			$this->script = "js/" . $scriptfile;
		}

        return $this;
	}

	public function getScript(): string
    {
		return $this->script;
	}
}
