<?php

namespace Weborama\Models;

use Weborama\Database\Database;

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $rows;
    protected $data;

    public function __construct($id = null, array $data = [])
    {
        $this->db = new Database();

        if (empty($data) && isset($id)) {
            $this->data = $this->get($id);
        } else {
            $this->data = $data;
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->rows)) {
            return $this->data[$name];
        }        
    }

    public function db()
    {
        return $this->db;
    }

    public function all()
    {
        $models = [];
        foreach ($this->db->from($this->table)->fetchAll() as $key => $value) {
            $models[] = new $this($value[$this->primaryKey], $value);
        }
        return $models;
    }

    public function hydrate($datas)
    {
        foreach (array_keys($this->rows) as $value) {
            if (isset($datas[$value])) {
                $this->data[$value] = $datas[$value];
            }
        }
        return $this;
    }

    public function persist()
    {
        if (null !== $this->{$this->primaryKey}) {
            $this->update();
        } else {
            $id = $this->insert();
            $this->{$this->primaryKey} = $id;
        }
        return $this;
    }

    /**
     * Call query builder to insert new datas in the database
     */
    private function insert()
    {
        return $this->db->insert($this->table, $this->data)->execute();
    }

    /**
     * Call query builder to update datas in the database
     */
    private function update()
    {
        return $this->db->update($this->table, $this->data, $this->{$this->primaryKey}, $this->primaryKey)->execute();
    }

    /**
     * Call query builder to delete an entry in the database
     */
    public function delete()
    {
        return $this->db->delete($this->table, $this->{$this->primaryKey}, $this->primaryKey)->execute();
    }

    /**
     * Retrieve a single entry in the database.
     * If the id is not specified in the function, 
     * it'll try to use the primary key of the model
     */
    public function get($id = null)
    {
        if (isset($id)) {
            $id = $this->{$this->primaryKey};
            if (isset($id)) {
                throw new \Exception("No primary key in function parameter or in the model to get() on", 1);
            } 
        }

        $result = $this->db->from($this->table, $id, $this->primaryKey)->fetch();

        if (!$result) {
            throw new \Exception("Nothing found with the " . $this->primaryKey . " " . $id, 1);
        }
        
        return $result;
    }
}
