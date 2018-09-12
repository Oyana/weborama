<?php

namespace Weborama\Database;

use Weborama\Database\Connector;
use Weborama\Database\QueryBuilder\Delete;
use Weborama\Database\QueryBuilder\Insert;
use Weborama\Database\QueryBuilder\Select;
use Weborama\Database\QueryBuilder\Update;

/**
 * Inspired from FluentPDO
 *
 * For more information see http://github.com/envms/fluentpdo
 */

class Database
{
    protected $pdo;
    public $debug;

    /**
     * ORM constructor
     */
    function __construct() 
    {
        $this->pdo = (new Connector)->connect()->pdo;
    }

    /**
     * Create SELECT query from $table
     *
     * @param string  $table      - db table name
     * @param integer $primaryKey - return one row by primary key
     *
     * @return Select
     */
    public function from($table, $primaryKey = null, $primaryKeyName = 'id') 
    {
        $query = new Select($this, $table);
        if ($primaryKey !== null) {
            $tableTable = $query->getFromTable();
            $tableAlias = $query->getFromAlias();
            $query      = $query->where("$tableAlias.$primaryKeyName", $primaryKey);
        }

        return $query;
    }

    /**
     * Create INSERT INTO query
     *
     * @param string $table
     * @param array  $values - accepts one or multiple rows, @see docs
     *
     * @return Insert
     */
    public function insert($table, $values = array()) 
    {
        $query = new Insert($this, $table, $values);

        return $query;
    }

    /**
     * Create UPDATE query
     *
     * @param string       $table
     * @param array|string $set
     * @param string       $primaryKey
     *
     * @return Update
     */
    public function update($table, $set = array(), $primaryKey = null, $primaryKeyName = 'id') 
    {
        $query = new Update($this, $table);
        $query->set($set);
        if ($primaryKey) {
            $query = $query->where($primaryKeyName, $primaryKey);
        }

        return $query;
    }

    /**
     * Create DELETE query
     *
     * @param string $table
     * @param string $primaryKey delete only row by primary key
     *
     * @return Delete
     */
    public function delete($table, $primaryKey = null, $primaryKeyName = 'id') 
    {
        $query = new Delete($this, $table);
        if ($primaryKey) {
            $query = $query->where($primaryKeyName, $primaryKey);
        }

        return $query;
    }

    /**
     * Create DELETE FROM query
     *
     * @param string $table
     * @param string $primaryKey
     *
     * @return Delete
     */
    public function deleteFrom($table, $primaryKey = null, $primaryKeyName = 'id') 
    {
        $args = func_get_args();

        return call_user_func_array(array($this, 'delete'), $args);
    }

    /**
     * @return \PDO
     */
    public function getPdo() 
    {
        return $this->pdo;
    }

    /**
     * Closes the \PDO connection to the database
     *
     * @return null
     */
    public function close() 
    {
        $this->pdo = null;
    }

}
