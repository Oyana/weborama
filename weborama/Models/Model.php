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

    public static function all()
    {
        $caller = get_called_class();
        $callerClass = new $caller;
        $models = [];
        foreach ((new Database)->from($callerClass->table)->fetchAll() as $key => $value) {
            $models[] = new $caller($value[$callerClass->primaryKey], $value);
        }
        return $models;
    }

    public static function hydrate($datas)
    {
        $caller = get_called_class();
        $callerClass = new $caller;
        foreach (array_keys($callerClass->rows) as $value) {
            if (isset($datas[$value])) {
                $callerClass->data[$value] = $datas[$value];
            }
        }
        return $callerClass;
    }

    public function persist()
    {
        if (null !== $this->id) {
            $this->update();
        } else {
            $id = $this->insert();
            $this->id = $id;
        }
        return $this;
    }

    private function insert()
    {
        return $this->db->insert($this->table, $this->data)->execute();
    }

    private function update()
    {
        return $this->db->update($this->table, $this->data, $this->id, $this->primaryKey)->execute();
    }
}
