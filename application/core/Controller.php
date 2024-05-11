<?php

namespace application\core;

use application\core\types\Type_Header;

abstract class Controller
{
    protected $views;
    protected $page;

    protected $classname;

    public function __construct()
    {
        $this->header = new Type_Header();
        $this->classname = get_class($this);
	    $this->page = new Page();
        $this->views = new View();
    }

    abstract public function action_index();

    public function getClassName()
    {
        return $this->classname;
    }

    public function setView($view)
    {
        $this->page->setView($view);
    }

    public function getView()
    {
        return $this->page->getView();
    }

    // $views must be instance of the <Views> type
    public function setViews($views)
    {
        $this->views = $views;
    }

    public function getViews()
    {
        return $this->views;
    }

    // $header must be instance of the <Type_Header> type
    public function setHeader($header)
    {
        $this->page->setHeader($header);
    }

    public function getHeader()
    {
        return $this->page->getHeader();
    }

    public function setLayout($layout)
    {
        $this->page->setLayout($layout);
    }

    public function getLayout()
    {
        return $this->page->getLayout();
    }

    public function setPageTitle($pageTitle)
    {
        $this->page->setPageTitle($pageTitle);
    }

    public function getPageTitle()
    {
        return $this->page->getPageTitle();
    }

    public function setData($data)
    {
        $this->page->setData($data);
    }

    public function getData()
    {
        return $this->page->getData();
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setStyle($classname)
    {
        $style = strtolower(substr($classname,strpos($classname, '_')+1)) . ".css";
        $this->page->setStyle($style);
    }

    public function getStyle()
    {
        return $this->page->getStyle();
    }

    public function setScript($classname)
    {
        $script = strtolower(substr($classname,strpos($classname, '_')+1)) . ".js";
        $this->page->setScript($script);
    }

    public function getScript()
    {
        return $this->page->getScript();
    }
}


