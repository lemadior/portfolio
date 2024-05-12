<?php

namespace application\controllers;

use application\core\Controller;
use application\exceptions\Exception_Model;
use application\models\Model_Main;
use application\core\Error;
use application\core\Settings;

use application\core\types\Type_Header;
use Exception;

class Controller_Main extends Controller
{
    private string $product_card_template;
    protected array $header_buttons;
    private Model_Main $model;

    public function __construct()
    {
	    parent::__construct();
        $this->model = new Model_Main();
        $this->product_card_template =  Settings::getTemplate('products');
        $this->header_buttons = [
                                    ['id' => 'add', 'name' => 'ADD', 'action' => 'onclick="location.href=\'/add-product\'"'],
                                    ['id' => 'delete-product-btn', 'name' => 'DELETE', 'action' => 'onclick="delete_product()"']
                                ];
    }

    public function action_index()
    {
        $products = ''; // Array of the product types with all needed data

        // If $_POST is not emty it means than button 'DELETE' was pressed
        if (!empty($_POST)) {

            $answ = 'SUCCESS';
            foreach ($_POST as $index => $id ) {
                if (!$this->model->deleteProductById($id)) {
                    $answ = "FAIL";
                    break;
                }

            }
            echo $answ;
            return;
        }

        try {
            $_products = $this->model->getData();
        } catch (Exception_Model|Exception $err) {
            Error::setError($err->getMessage());
        }

        if (!empty($_products)) {
            foreach ($_products as $product) {
                $products .= $this->getProductCard($product);
            }
        }

        $this->setData(['products' => $products]);

        $this->setPageTitle('Product List');
        $this->setHeader(new Type_Header('Product List', 'show'));
        $this->getHeader()->setButtons($this->header_buttons);
        $this->setScript($this->getClassName());
        $this->setStyle($this->getClassName());
        $this->setView('main_view');

        $this->getViews()->render($this->getPage());
    }



    private function prepareUnits($str)
    {
        $units = ['(MB)' => ' MB', '(KG)' => 'KG', '(CM)' => ''];

        return $units[$str];
    }

    private function getProductCard($product)
    {
        $card = $this->product_card_template;

        $card = str_replace("%ID%", $product->getId(), $card);
        $card = str_replace("%SKU%", $product->getSku(), $card);
        $card = str_replace("%NAME%", $product->getName(), $card);
        $card = str_replace("%PRICE%", $product->getPrice(), $card);

        $card = str_replace("%ATTR%", $product->getType()->getAttributes(), $card);
        $card = str_replace("%VALUE%", $product->getAttributeValue() , $card);
        $card = str_replace("%UNITS%", $this->prepareUnits($product->getFields()->getUnits()[0]), $card);

        return $card;
    }
}
