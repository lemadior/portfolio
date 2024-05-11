<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Model_404;

class Controller_404 extends Controller
{
    private Model_404 $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_404();
    }

    public function action_index(): void
    {
    	$this->page->data = $this->model->getData();
        $this->page->hideButtons = 'hide';
        $this->page->title = 'ERROR: 404';
        $this->page->headerTitle = 'Page not found';
	    $this->page->view = '404_view';

	    $this->views->render($this->page);
    }
}
