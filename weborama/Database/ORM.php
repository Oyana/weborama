<?php

namespace Weborama\Database;

use Weborama\Database\Connector;

class ORM
{
    protected $connection;
    protected $primaryKey;
    protected $rows;
    protected $table;
    protected $lastQuery;
    protected $lastInsertId;
    protected $orderBy;
    protected $select = '*';

    public function __construct($table, $primaryKey = 'id')
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->connection = (new Connector)->connect();
    }


    /**
     * addByArray
     *
     * @author Golga
     * @since 0.2
     * @param array
     * @return boolean
    */
    public function addByArray($array)
    {
        $query = "INSERT INTO " . $this->connection->db['prefix'] . $this->table . " ";
        $format = "(";
        $value = "VALUES (";
        foreach ($array as $k => $v) {
            $format .= "`" . $k . "`, ";
            $value .= $this->connection->pdo->quote($v) . ", ";
        }
        $query .= rtrim($format, ", ") . ") ". rtrim($value, ", ") . ");";
        $this->connection->pdo->exec($query);
        $this->lastQuery = $query;

        $this->lastInsertId = $this->connection->pdo->lastInsertId();
        return true;
    }

    /**
     * updateByArray
     *
     * @author Golga
     * @since 0.2
     * @param integer       $id
     * @param array     $array
     * @return boolean
    */
    public function updateByArray($id, $array)
    {
        $query = "UPDATE " . $this->connection->db['prefix'] . $this->table . " SET ";
        $format = '';
        foreach ($array as $k => $v) {
            $format .= "`" . $k . "` = " . $this->connection->pdo->quote($v) . ", ";
        }
        $query .= rtrim($format, ", ") . " WHERE id = " . $id;
        $this->connection->pdo->exec($query);
        $this->lastQuery = $query;
        return true;
    }

    /**
     * delete
     *
     * @author Jiedara
     * @since 0.3
     * @param integer $id
     * @return boolean
    */
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->connection->db['prefix'] . $this->table . " WHERE id = " . $id;
        $this->connection->pdo->exec($query);
        $this->lastQuery = $query;
        return true;
    }


    /**
     * getLastInsertId
     *
     * @author Golga
     * @since 0.2
     * @param array
     * @return boolean
    */
    public function lastInsertId()
    {
        if (!empty($this->lastInsertId)) {
            return $this->lastInsertId;
        }
        return $this->connection->pdo->lastInsertId();
    }

    /**
     * getLastInsertQuery
     *
     * @author Golga
     * @since 0.2
     * @param array
     * @return boolean
    */
    public function lastQuery()
    {
        if (!empty($this->lastQuery)) {
            return $this->lastQuery;
        }
        return $this->connection->pdo->debugDumpParams();
    }

    /**
     * setOrderBy
     *
     * @author Jiedara
     * @since 0.3
     * @param string
     * @return Object
    */
    public function orderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * setSelect
     *
     * @author Jiedara
     * @since 0.3
     * @param string
     * @return Object
    */
    public function select($select)
    {
        $this->select = $select;
        return $this;
    }

    public function getAll()
    {
        if (isset($this->orderBy)) {
            $statement = $this->connection->pdo->prepare("SELECT ". $this->select ." FROM " . $this->connection->db['prefix'] . $this->table . " ORDER BY ". $this->orderBy .";");
        } else {
            $statement = $this->connection->pdo->prepare("SELECT ". $this->select ." FROM " . $this->connection->db['prefix'] . $this->table . ";");
        }
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $statement = $this->connection->pdo->prepare("SELECT ". $this->select ." FROM " . $this->connection->db['prefix'] . $this->table . "  WHERE `" . $this->primaryKey . "` = '" . $id . "';");
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function getByWhere($where = false)
    {
        if (!$where) {
            return $this->getAll();
        } elseif (!is_array($where)) {
            $whereData = $where . ";";
        } else {
            $whereData = " 1";
            foreach ($where as $key => $value) {
                $whereData = $whereData . " AND " . $key . " = '" . $value . "'";
            }
            $whereData = $whereData . " ; ";
        }
        $statement = $this->connection->pdo->prepare("SELECT ". $this->select ." FROM " . $this->connection->db['prefix'] . $this->table . "  WHERE " . $whereData);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

}
