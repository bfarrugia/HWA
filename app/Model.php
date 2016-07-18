<?php

/**
* Class Model
* Generic data class to pull and process information from the database
*/
class Model
{
    // Specific table this model should interact with
    protected $_dataTable;

    // Stored database connection interface
    protected $_connection;

    // Data pulled into generic array
    protected $_data;

    // Class that group loads should instantiate into
    protected $_childClass;

    /**
     *  Load class if id is provided
     */
    public function __construct($class, $dataTable, $data = false){
        $this->_childClass = $class;
        $this->_dataTable = $dataTable;

        if($data && isset($data['id']) && !empty($data['id'])){
            $this->load([ "id" => $data['id'] ]);
        }
    }

    /**
     *  Load instance of model given the data available and conditions
     */
    public function load($data){
        if(!$this->_dataTable || !$data)
            return false;

        if(!$this->_connection)
            $this->_connection = Database::getConnection();

        $sql = "SELECT * FROM {TABLE} WHERE {VALUES}";
        $sql = $this->_replaceValues($sql, $data);
        $sql = str_replace('{TABLE}', $this->_dataTable, $sql);

        $result = $this->_connection->select($sql);
        if(isset($result[0])){
            $this->_data = $result[0];
        }

        return $this;
    }

    /**
     *  Load group of models from the conditions available
     */
    public function loadGroup($data = '*', $condition = false){
        if(!$this->_dataTable || !$data)
            return false;

        if(!$this->_connection)
            $this->_connection = Database::getConnection();

        $sql = "SELECT {SELECTION} FROM {TABLE}";
        if($condition){
            $sql .= "WHERE {VALUES}";
            $sql = $this->_replaceValues($sql, $$condition);
        }
        $sql .= " ORDER BY created DESC";
        $sql = str_replace('{TABLE}', $this->_dataTable, $sql);
        $sql = str_replace('{SELECTION}', $data, $sql);

        $result = $this->_connection->select($sql);
        if(isset($result[0])){
            if($result && count($result)){
                $group = [];
                foreach($result as $obj){
                    $group[] = new $this->_childClass($obj);
                }

                return $group;
            }
        }

        return false;
    }

    /**
     *  Build query to insert data into database
     */
    public function save(){
        if(!$this->_dataTable)
            return false;

        if(!$this->_connection)
            $this->_connection = Database::getConnection();

        $sql = "INSERT INTO {TABLE} ({VALUES}) VALUES ({VALUES_LITERAL})";

        $insertValues = $this->_sanitizeData($this->_data);
        $sql = str_replace('{VALUES_LITERAL}', implode(',', $insertValues), $sql);

        $newValues = $insertValues;
        unset($newValues["created"]);
        $keys = implode(',', array_keys($newValues));
        $sql = str_replace('{VALUES}', $keys, $sql);
        $sql = str_replace('{TABLE}', $this->_dataTable, $sql);

        $result = $this->_connection->query($sql);

        if($result){
            $sql = "SELECT id from {TABLE} WHERE {VALUES}";
            $sql = $this->_replaceValues($sql, $insertValues);
            $sql = str_replace('{TABLE}', $this->_dataTable, $sql);

            $result = $this->_connection->select($sql);
            if(isset($result[0]))
                $this->_data['id'] = $result[0]['id'];
        }

        return $result;
    }

    /**
     *  Insert values into INSERT SQL query string
     */
    protected function _replaceValues($sql, $values){
        $valString = "";
        foreach($values as $key => $value){
            $valString .= $key . "=" . $value . ' AND ';
        }
        $valString = substr($valString, 0, strlen($valString)-5);

        $sql = str_replace('{VALUES}', $valString, $sql);
        return $sql;
    }

    /**
     *  Safe-quote data before insertion into database
     */
    protected function _sanitizeData($values){
        $sanitized = [];
        foreach($values as $key => $value){
            $sanitized[$key] = $this->_connection->quote($value);
        }
        return $sanitized;
    }

    /**
     *  Get data from object by key value
     */
    public function getData($key = false){
        if(!$key)
            return $this->_data;
        if(isset($this->_data[$key]))
            return $this->_data[$key];
        return false;
    }
}