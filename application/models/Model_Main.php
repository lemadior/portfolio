<?php

namespace application\models;

use application\core\traits\SystemMethods;

use application\core\Database;
use application\core\Model;
use application\core\Settings;

use application\core\types\Type_Fields;
use application\core\types\Type_Type;
use application\core\types\Type_Product;

use application\exceptions\Exception_Model;
use application\exceptions\Exception_Database;
use Exception;
use RuntimeException;


class Model_Main extends Model
{
    use SystemMethods;


    /**
     * @throws Exception_Model
     */
    public function getData()
    {
        $result = 'NOP';
        $data = [];

        try {
            $product_id_list = $this->getProductsIdList();
        } catch (Exception $err) {
            throw new Exception_Model($err->getMessage(), 1);
        }

        // If no products in the database
        if (count($product_id_list) === 0) {
            return [];
        }

        foreach ($product_id_list as $id) {
            // Set Fields class as field for Product class
            try {
                $field = $this->getFields($id);
            } catch (Exception $err) {
                throw new Exception_Model($err->getMessage(), 1);
            }

            // Set Type class as type for Product class
            try {
                $type = $this->getType($id);
            } catch (Exception $err) {
                throw new Exception_Model($err->getMessage(), 1);
            }

            //Set Array of products from the database
            try {
                $product = $this->getProduct($id, $type, $field);
            } catch (Exception $err) {
                throw new Exception_Model($err->getMessage(), 1);
            }

            $data[] = $product;
        }

        try {
            Database::closeConnection();
        } catch (Exception_Database $err) {
            throw new Exception_Model($err->getMessage(),1);
        }

        return $data;
    }

    private function getFields($id)
    {
        $fields = [];
        $units = [];

        try {
            $_field =  $this->getFieldsDataByProductId($id);
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }

        foreach ($_field as $key => $value) {
            $fields[] = $key;
            $units[] = $value;
        }

        return new Type_Fields($id, $fields, $units);
    }

    private function getType($id): Type_Type
    {
        try {
            $type =  $this->getTypeDataByProductId($id);
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }

        return new Type_Type($id, $type['name'], $type['prod_descr'], $type['attribute']);
    }

    private function getProduct($id, $type, $field): Type_Product
    {
        try {
            $product =  $this->getProductDataByProductId($id);
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }

        return new Type_Product($id,
                           $product['name'],
                           $product['sku'],
                           $product['price'],
                           $product['value'],
                           $type,
                           $field);
    }

    /**
     * @throws Exception_Model
     */
    private function getProductTypes()
    {
        $data = [];

        $query = "SELECT types.name FROM types";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new Exception_Model($err->getMessage(),1);
        }

        $allowed_types = Settings::getAllowedTypes();

        foreach ($result as $value) {
            if (in_array($value['name'], $allowed_types, true)) {
                $data[] = $value['name'];
            }
        }

        return $data;
    }

    private function getTypeByProductId($id)
    {
        $query = "SELECT types.name 
                  FROM fields, type_fields, products, attributes, types 
                  WHERE products.id = {$id} 
                  AND attributes.prod_id = products.id 
                  AND attributes.fields_id = fields.id 
                  AND type_fields.type_id = types.id 
                  AND type_fields.field_id = fields.id";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new RuntimeException($err->getMessage());
        }

        if (!is_array($result) || empty($result[0])) {
            return '';
        }

        return $result[0]['name'];
    }

    private function getTypeDataByProductId($id)
    {
        $data = [];


        $query = "SELECT types.name, types.prod_descr, types.attribute 
                  FROM fields, type_fields, products, attributes, types 
                  WHERE products.id = {$id}
                  AND attributes.prod_id = products.id 
                  AND attributes.fields_id = fields.id 
                  AND type_fields.type_id = types.id 
                  AND type_fields.field_id = fields.id";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1', 'prod_descr' => 'description', 'attributes' => 'attr'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new RuntimeException($err->getMessage());
        }

        return $result[0];
    }

    private function getProductDataByProductId($id): array
    {
        $data = [];

        $query = "SELECT sku, name, price 
        FROM products 
        WHERE products.id = {$id}";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1', 'prod_descr' => 'description', 'attributes' => 'attr'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new RuntimeException($err->getMessage());
        }

        $data = $result[0];

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1', 'prod_descr' => 'description', 'attributes' => 'attr'], ... ]
            $result = $this->getAttrValueByProductId($id);
        } catch (Exception_Database $err) {
            throw new RuntimeException($err->getMessage());
        }

        $data['value'] = $result;

        return $data;
    }

    private function getProductsIdList(): array
    {
        $data = [];

        $query = "SELECT id FROM products";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new RuntimeException($err->getMessage());
        }

        if (!is_array($result) || empty($result[0])) {
            return [];
        }

        foreach ($result as $value) {
            $data[] = $value['id'];
        }

        return $data;
    }

    private function getAttrValueByProductId($id)
    {
        $value = '';

        $query = "SELECT attributes.value 
                  FROM fields, type_fields, products, attributes, types 
                  WHERE products.id = {$id} 
                  AND attributes.prod_id = products.id 
                  AND attributes.fields_id = fields.id 
                  AND type_fields.type_id = types.id 
                  AND type_fields.field_id = fields.id";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new RuntimeException($err->getMessage(),1);
        }

         foreach ($result as $val) {
             $value .= $val['value'] . "x";
         }

         return rtrim($value, 'x');
    }

    private function getFieldsDataByProductId($id)
    {
        $data = [];

        $query = "SELECT fields.name, fields.units 
                  FROM fields, type_fields, products, attributes, types 
                  WHERE products.id = {$id}
                  AND attributes.prod_id = products.id 
                  AND attributes.fields_id = fields.id 
                  AND type_fields.type_id = types.id 
                  AND type_fields.field_id = fields.id";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new RuntimeException($err->getMessage());
        }

        foreach ($result as $arr) {
            $data[$arr['name']] = $arr['units'];
        }

        return $data;
    }

    /**
     * @throws Exception_Database
     */
    public static function deleteProductById($id): bool
    {
        $db_link = Database::getDbLink();
        $query = "DELETE products, attributes
                  FROM products
                  LEFT JOIN attributes
                  ON products.id = attributes.prod_id
                  WHERE products.id = {$id}";

        try {
            Database::doQuery($query);
        } catch (Exception $err) {
            throw new Exception_Database($err->getMessage(),5);
        }

        if ($db_link->error) {
            throw new Exception_Database($db_link->error,5);
        }

        return true;
    }
}
