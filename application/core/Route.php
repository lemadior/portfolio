<?php

namespace application\core;

use application\exceptions\Exception_Route;

class Route
{
    /**
     * @throws Exception_Route
     */
    public static function start(): void
    {
        // Default controller and it's method
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // Get controller's name
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        if ($controller_name === 'add-product') {
            $controller_name = 'add';
        }

        //Get name of action
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }

        //Add prefixes
        $model_name = 'Model_' . ucfirst($controller_name);
	    $controller_name = 'Controller_' . ucfirst($controller_name);
        $action_name = 'action_' . $action_name;

        //get file with model
        $model_file = strtolower($model_name) . '.php';
        $model_path = 'application/models/' . $model_file;

        if (file_exists($model_path)) {
            include $model_path;
        }

        //Get file with controller's class
//        $controller_file = strtolower($controller_name) . '.php';
        $controller_file = $controller_name . '.php';
        $controller_path = 'application/controllers/' . $controller_file;

        if (file_exists($controller_path)) {
            include $controller_path;
        } else {
            throw new Exception_Route('Controller Error : ' . $controller_path, 1);
        }

        $controller_name = "\\application\\controllers\\" . $controller_name;

        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            throw new Exception_Route('Method Error : ' . $action, 2);
        }
    }

}

