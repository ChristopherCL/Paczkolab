<?php

class DBmysql implements Database
{
    /**
     * Database Handler
     *
     * Variable which holds the current Database handler.
     *
     * @var PDO
     */
    private $dbh;

    /**
     * Error-return
     *
     * Variable which holds the latest error.
     *
     * @var string
     */
    private $error;

    /**
     * Database-statement
     *
     * Variable which holds the current database-statement
     *
     * @var string
     */
    private $stmt;

    /**
     * Constructor (No parameters)
     *
     * Generates the PDO Database-handler. Also sets the charset for communication to UTF-8
     */
    public function __construct()
    {
        $dbid = 'mysql:host=' . DB_SERVER_NAME . ';dbname=' . DB_BASE_NAME . ';charset=utf8';
        $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        try {
            $this->dbh = new PDO($dbid, DB_USERNAME, DB_PASSWORD, $options);
            $this->dbh = new PDO($dbid, DB_USERNAME, DB_PASSWORD, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * Set Query
     *
     * A modern method that replaces the old PDO method with the same name.
     * The only difference is that this method prepares the statement for you.
     *
     * @param string $query
     */
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    /**
     * Bind to statement
     *
     * Method to bind values to given keywords in the given query.
     * If $type is set to true, the type of the value will be automagically given.
     * Else the type will be null
     *
     * @param string $param
     * @param string $value
     * @param bool $type
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value) :
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value) :
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value) :
                    $type = PDO::PARAM_NULL;
                    break;
                default :
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Method executes object statement
     *
     * @return mixed
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Method returns array with rows set
     *
     * @return mixed
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Method returns single/first row as array
     *
     * @return mixed
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Method returns number of rows returned from statement
     *
     * @return mixed
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Method returns id of last inserted element from statement
     *
     * @return string
     *
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     * Method returns statement error
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}