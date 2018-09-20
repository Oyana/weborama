<?php

namespace Weborama\Models;

use Weborama\Database\Database;

abstract class Model
{
    protected $connection;
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $rows;
    protected $data;

    public function __construct($id = null, array $data = [])
    {
        $this->db = new Database();
        $this->data = $data;

        if (isset($id) && $this->data == []) {
            if (!$this->data = $this->db->from($this->table, $id, $this->primaryKey)->fetch()) {
                throw new \Exception($id . " can't be found for model " . get_class($this), 1);
            }
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->rows)) {
            return $this->data[$name];
        }        
    }

    public function all()
    {
        $models = [];
        foreach ((new Database)->from($this->table)->fetchAll() as $key => $value) {
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

    private function insert()
    {
        return $this->db->insert($this->table, $this->data)->execute();
    }

    private function update()
    {
        return $this->db->update($this->table, $this->data, $this->{$this->primaryKey}, $this->primaryKey)->execute();
    }

    public function delete()
    {
        return $this->db->delete($this->table, $this->{$this->primaryKey}, $this->primaryKey)->execute();
    }
}
