<?php

namespace application\models;

use application\core\Database;
use application\core\Model;
use application\core\Settings;

use application\exceptions\Exception_Model;
use application\exceptions\Exception_Database;

class Model_Add extends Model
{
    /**
     * @throws Exception_Model
     */
    public function getData(): void
    {
        try {
            Database::closeConnection();
        } catch (Exception_Database $err) {
            throw new Exception_Model($err->getMessage(),1);
        }
    }

    public function getProductTypes(): array
    {
        $data = [];

        $query = "SELECT types.name FROM types";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new Exception_Model($err->getMessage(),1);
            return [];
        }

        $allowed_types = Settings::getAllowedTypes();

        foreach ($result as $value) {
            if (in_array($value['name'], $allowed_types)) {
                $data[] = $value['name'];
            }
        }

        return $data;
    }

    public function getDescriptionByType($type)
    {
        $query = "SELECT prod_descr FROM types WHERE name='{$type}'";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new Exception_Model($err->getMessage(),1);
            return '';
        }

        return $result[0]['prod_descr'];
    }

    public function getFieldsDataByType($type)
    {
        $query="SELECT fields.id, fields.name, fields.units 
                FROM fields, type_fields, types 
                WHERE types.name = '{$type}' 
                AND type_fields.type_id = types.id 
                AND type_fields.field_id = fields.id";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new Exception_Model($err->getMessage(),1);
            return [];
        }

        return $result;
    }

    public function getSkuList()
    {
        $query="SELECT sku FROM products";
        $sku = [];

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::getQuery($query);
        } catch (Exception_Database $err) {
            throw new Exception_Model($err->getMessage(),1);
            return [];
        }

        foreach ($result as $value) {
            $sku[] = $value['sku'];
        }

        return $sku;
    }

    public function addProduct($sku, $name, $price, $attrs)
    {
        $query = "INSERT INTO products (sku, name, price) VALUES ('{$sku}', '{$name}', {$price})";

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::doQuery($query);
        } catch (Exception_Database $err) {
            throw new \Exception($err->getMessage());
            return false;
        }

        $id = Database::getDbLink()->insert_id;

        $query = "INSERT INTO attributes (prod_id, fields_id, value) VALUES ";

        foreach ($attrs as $_id => $attr) {
            $query .= "({$id}, {$_id}, {$attr}),";
        }

        $query = rtrim($query, ',');

        try {
            // Returned array of arrays aka. [ ['name' => 'Name1'], ['name' => 'Name2'], ... ]
            $result = Database::doQuery($query);
        } catch (Exception_Database $err) {
            throw new \Exception($err->getMessage());
            return false;
        }

        return true;
    }
}
