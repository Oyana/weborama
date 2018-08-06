<?php

namespace Weborama\Database;

class Connector
{
    public $db;
    public $pdo;

    function __construct()
    {
        //set database value (use constant or forced value in the model)
        if (!isset($this->db['type'])) {
            $this->db['type'] = DB_TYPE;
        }
        if (!isset($this->db['host'])) {
            $this->db['host'] = DB_HOST;
        }
        if (!isset($this->db['name'])) {
            $this->db['name'] = DB_NAME;
        }
        if (!isset($this->db['user'])) {
            $this->db['user'] = DB_USER;
        }
        if (!isset($this->db['pass'])) {
            $this->db['pass'] = DB_PASS;
        }
        if (!isset($this->db['prefix'])) {
            $this->db['prefix'] = DB_PREFIX;
        }
    }

    public function connect()
    {
        try { // PDO Connection
            $dsn = "" . $this->db['type']. ':host=' . $this->db['host']. ';dbname=' . $this->db['name']. "";
            $pdo = new \PDO($dsn, $this->db['user'], $this->db['pass']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8");
        } catch (PDOException $e) {
            if (DEBUG_LVL > 0) {
                echo '<pre>';
                echo $e->getMessage();
                echo '</pre>';
                die();
            }
        }
        $this->pdo = $pdo;
        return $this;
    }
}
