<?php

namespace application\controllers;

use application\core\Controller;
use application\exceptions\Exception_Model;
use application\models\Model_Add;
use application\core\Settings;
use application\core\types\Type_Header;
use application\core\Error;

class Controller_Add extends Controller
{
    protected $attributes_template;
    protected $product_add_block;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Add();
        $this->attributes_template = Settings::getTemplate('attributes');
        $this->product_add_block = Settings::getTemplate('product_add');
        $this->header_buttons = [
                                    ['id' => 'save', 'name' => 'SAVE', 'action' => 'onclick="saving()"'], 
                                    ['id' => 'cancel', 'name' => 'CANCEL', 'action' => 'onclick="location.href=\'/\'"']
                                ]; 
    }

    function action_index()
    {
        $types = [];
        $data = [];

        // If $_POST is not empty it means than button "ADD" was pressed
        if (!empty($_POST)) {

          // 'UNIQUE' is flag to get array of SKUs at the page loading
          if (!empty($_POST['UNIQUE'])) {
            try {
              $skus = $this->model->getSkuList();
              echo implode(' ', $skus);
            } catch (Exception_Model $err) {
              Error::setError($err->getMessage());
              echo "FAIL";
            }

            return ;
          }

          $type = $_POST['types'];
          $sku = $_POST['sku'];
          $name = $_POST['name'];
          $price = $_POST['price'];
          $attrs = [];

          try {
            $fields = $this->model->getFieldsDataByType($type);
          } catch (Exception_Model $err) {
            Error::setError($err->getMessage());
          }

          foreach($fields as $field) {
            $attrs[$field['id']] = $_POST[strtolower($field['name'])]; 
          }

          try {
            $this->model->addProduct($sku, $name, $price, $attrs);
            echo "SUCCESS";
          } catch (Exception_Model $err) {
            Error::setError($err->getMessage());
            echo "FAIL";
          }

          return;
        }

        try {
            $types = $this->model->getProductTypes();
        } catch (Exception_Model $err) {
          Error::setError($err->getMessage());
        } 

        $str_types='';
        $str_prod_add='';
        

        foreach($types as $index => $type) {
            
            $prod_add = $this->product_add_block;
            $descr = '';
            $str_input='';

            if ($index === 0) {
              $str_types = "<option value='{$type}' selected>{$type}</option>";
            } else {
              $str_types .= "<option value='{$type}'>${type}</option>";
            }

            try {
              $inputs = $this->model->getFieldsDataByType($type);
            } catch (Exception_Model $err) {
              Error::setError($err->getMessage());
            }

            foreach ($inputs as $field) {
                  $str_input .= $this->getInputData($field); 
            }

            try {
              $descr = $this->model->getDescriptionByType($type);
            } catch (Exception_Model $err) {
              Error::setError($err->getMessage());
            }

            if ($index == 0) {
              $prod_add = str_replace("%TYPE%", strtolower($type), $prod_add);
              $prod_add = str_replace("%VISIBLE%", '', $prod_add);
            } else {
              $prod_add = str_replace("%TYPE%", strtolower($type), $prod_add);
              $prod_add = str_replace("%VISIBLE%", "hide", $prod_add);
            }
            $prod_add = str_replace("%INPUT%", $str_input, $prod_add);
            $prod_add = str_replace("%DESCR%", $descr, $prod_add);

            $str_prod_add .= $prod_add;

        }


        $data['product_types'] = $str_types;
        $data['products_add_block'] = $str_prod_add;

        $this->setData($data);

        $this->setPageTitle('Product Add');
        $this->setHeader(new Type_Header('Product Add', 'show'));
        $this->getHeader()->setButtons($this->header_buttons);
        $this->setView('add_view');
        $this->setScript($this->getClassName());
        $this->setStyle($this->getClassName());
   
        $this->getViews()->render($this->getPage());
    }

    public function getInputData($field)
    {
        $input = $this->attributes_template;

        $input = str_replace("%TYPEID%", strtolower($field['name']), $input);
        $input = str_replace("%FIELD%", $field['name'], $input);
        $input = str_replace("%UNIT%", $field['units'], $input);

        return $input;
    }

    public function getAddProductBlockData($field)
    {
        $input = $this->attributes_template;

        $input = str_replace("%TYPEID%", strtolower($field['name']), $input);
        $input = str_replace("%FIELD%", $field['name'], $input);
        $input = str_replace("%UNIT%", $field['units'], $input);

        return $input;
    }

}
