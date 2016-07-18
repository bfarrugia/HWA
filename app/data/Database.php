<?php

/**
 *  Class Database
 *  Provide connection assistance to query the database
 */
class Database
{
    // Actuial mysqli connection instance
    protected static $_connection;

    // Reference to Model that holds the database connection
    protected static $_object;

    /**
     *  Connect to the database and initialize a Database object
     */
    public static function getConnection(){
        if(!isset(self::$_object))
            self::$_object = new Database();

        self::$_object->connect();
        return self::$_object;
    }

    /**
     *  Connect to the database with config settings stored elsewhere
     */
    public function connect(){
        if(!isset(self::$_connection)){
            $config = App::getConfig();

            if(isset($config['data']))
                self::$_connection = new mysqli($config['data']['host'], $config['data']['user'], $config['data']['pass'], $config['data']['dbname']);
        }

        if(self::$_connection === false){
            throw new Exception("No database connection available");
        }

        return self::$_connection;
    }

    /**
     *  Run a query and return the result
     */
    public function query($query){
        $connection = $this->connect();
        $result = $connection->query($query);
        return $result;
    }

    /**
     *  Run a select statement query and return the result parsed into an array
     */
    public function select($query){
        $rows = array();
        $result = $this->query($query);

        if($result === false){
            return false;
        }
        
        while($row = $result->fetch_assoc()){
            $rows[] = $row;
        }

        return $rows;
    }

    /**
     *  Make a value destined for a query safe to transmit
     */
    public function quote($value){
        $connection = $this->connect();
        return "'".$connection->real_escape_string($value)."'";
    }
}