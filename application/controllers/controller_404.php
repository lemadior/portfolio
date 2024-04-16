<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Model_404;

class Controller_404 extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_404();
    }

    function action_index()
    {
    	$this->page->data = $this->model->get_data();
        $this->page->hideButtons = 'hide';
    	// $this->page->data = ['etype' => "ERRORA<br>"];
        $this->page->title = 'ERROR: 404';
        $this->page->headerTitle = 'Page not found';
	    $this->page->view = '404_view';

	    $this->views->render($this->page);
    }
}
