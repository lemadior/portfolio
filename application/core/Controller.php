<?php

namespace application\core;

use application\core\types\Type_Header;

abstract class Controller
{
    protected View $views;
    protected Page $page;

    protected string $classname;
    private Type_Header $header;

    public function __construct()
    {
        $this->header = new Type_Header();
        $this->classname = get_class($this);
        $this->page = new Page();
        $this->views = new View();
    }

    abstract public function action_index();

    public function getClassName(): string
    {
        return $this->classname;
    }

    public function setView($view): Controller
    {
        $this->page->setView($view);

        return $this;
    }

    public function getView(): string
    {
        return $this->page->getView();
    }

    // $views must be instance of the <Views> type
    public function setViews($views): Controller
    {
        $this->views = $views;

        return $this;
    }

    public function getViews(): View
    {
        return $this->views;
    }

    // $header must be instance of the <Type_Header> type
    public function setHeader($header): Controller
    {
        $this->page->setHeader($header);

        return $this;
    }

    public function getHeader(): Type_Header
    {
        return $this->page->getHeader();
    }

    public function setLayout($layout): Controller
    {
        $this->page->setLayout($layout);

        return $this;
    }

    public function getLayout()
    {
        return $this->page->getLayout();
    }

    public function setPageTitle($pageTitle): Controller
    {
        $this->page->setPageTitle($pageTitle);

        return $this;
    }

    public function getPageTitle(): string
    {
        return $this->page->getPageTitle();
    }

    public function setData($data): Controller
    {
        $this->page->setData($data);

        return $this;
    }

    public function getData()
    {
        return $this->page->getData();
    }

    public function setPage($page): Controller
    {
        $this->page = $page;

        return $this;
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function setStyle($classname): Controller
    {
        $style = strtolower(substr($classname, strpos($classname, '_') + 1)) . ".css";
        $this->page->setStyle($style);

        return $this;
    }

    public function getStyle(): string
    {
        return $this->page->getStyle();
    }

    public function setScript($classname): Controller
    {
        $script = strtolower(substr($classname, strpos($classname, '_') + 1)) . ".js";
        $this->page->setScript($script);

        return $this;
    }

    public function getScript(): string
    {
        return $this->page->getScript();
    }
}
