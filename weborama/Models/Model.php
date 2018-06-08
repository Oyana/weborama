<?php

namespace Weborama\Models;

class Model
{
    protected $db;
    protected $pdo;
    protected $rows;
    protected $table;
    protected $lastQuery;
    protected $lastInsertId;
    protected $orderBy;
    protected $select = '*';

    /**
     * __construct Model
     * @author Golga
     * @since 0.2
     * @param   object      $db
     */
    public function __construct($table)
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
        try { // PDO Connection
            $dsn = "" . $this->db['type']. ':host=' . $this->db['host']. ';dbname=' . $this->db['name']. "";
            $pdo = new PDO($dsn, $this->db['user'], $this->db['pass']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $this->table = $table;
        return true;
    }

    /**
     * __destruct
     *
     * @author Golga
     * @since 0.2
     * @param none
     * @return boolean
    */
    public function __destruct()
    {
        unset($this->pdo);
        return true;
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
        $query = "INSERT INTO " . $this->db['prefix'] . $this->table . " ";
        $format = "(";
        $value = "VALUES (";
        foreach ($array as $k => $v) {
            $format .= "`" . $k . "`, ";
            $value .= $this->pdo->quote($v) . ", ";
        }
        $query .= rtrim($format, ", ") . ") ". rtrim($value, ", ") . ");";
        $this->pdo->exec($query);
        $this->lastQuery = $query;

        $this->lastInsertId = $this->pdo->lastInsertId();
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
        $query = "UPDATE " . $this->db['prefix'] . $this->table . " SET ";
        $format = '';
        foreach ($array as $k => $v) {
            $format .= "`" . $k . "` = " . $this->pdo->quote($v) . ", ";
        }
        $query .= rtrim($format, ", ") . " WHERE id = " . $id;
        $this->pdo->exec($query);
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
        $query = "DELETE FROM " . $this->db['prefix'] . $this->table . " WHERE id = " . $id;
        $this->pdo->exec($query);
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
        return $this->pdo->lastInsertId();
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
        return $this->pdo->debugDumpParams();
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
            $statement = $this->pdo->prepare("SELECT ". $this->select ." FROM " . $this->db['prefix'] . $this->table . " ORDER BY ". $this->orderBy .";");
        } else {
            $statement = $this->pdo->prepare("SELECT ". $this->select ." FROM " . $this->db['prefix'] . $this->table . ";");
        }
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getById($id)
    {
        $statement = $this->pdo->prepare("SELECT ". $this->select ." FROM " . $this->db['prefix'] . $this->table . "  WHERE `" . $this->id_key . "` = " . $id . ";");
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
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
        $statement = $this->pdo->prepare("SELECT ". $this->select ." FROM " . $this->db['prefix'] . $this->table . "  WHERE " . $whereData);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function slugify($string)
    {
        // Init
        $clean_string = '';

        // Clean guillemet
        $clean_string = str_replace("'", "", $string);
        $clean_string = str_replace('"', "", $clean_string);

        // Clean spaces
        $clean_string = str_replace(" ", "-", $clean_string);

        // Clean stresses
        $clean_string = $this->stripAccent($clean_string);

        // To lower
        $clean_string = strtolower($clean_string);

        // Return
        return $clean_string;
    }

    public function stripAccent($str)
    {
        $str = htmlentities($str, ENT_NOQUOTES, "UTF-8");
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        setlocale(LC_ALL, 'fr_FR');
        $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
        $str = preg_replace('#[^0-9a-z]+#i', '-', $str);
        $str = trim($str, '-');
        return $str;
    }

    public function validate($datas)
    {
        foreach ($datas as $key => $data) {
            //parse and get current data validation rule
            //$rules[0] = type of the data
            //$rules[1] = range of the data (size if one number, possible value if more), -1 mean 'nullable' and therefore, the data may be empty
            if ((!empty($data) || (string)$data === '0') && isset($this->rows[$key])) {
                $rules = explode('|', $this->rows[$key]);
                switch ($rules[0]) {
                    case 'string':
                    case 'text':
                        if (!is_string($data)) {
                            $error = "The field `" . $key . "` is not a text.";
                        }
                    break;
                    case 'date':
                        $d = DateTime::createFromFormat('Y-m-d H:i:s', $data);
                        if (empty($d) || $d->format('Y-m-d H:i:s') != $data) {
                            $error = "The field `" . $key . "` is not a valid date.";
                        }
                    break;
                    case 'int':
                        if (intval($data) != (int)$data) {
                            $error = "The field `" . $key . "` is not a number.";
                        }
                    break;
                    case 'slug':
                        if (!preg_match('/^[a-z0-9][-a-z0-9]*$/', $data)) {
                            $error = "The field `" . $key . "` must not have any special character, accent or space.";
                        }
                    break;
                    case 'array':
                        if (!is_array($data)) {
                            $error = "The field `" . $key . "` must be un tableau de valeur valid.";
                        }
                    break;
                    case 'email':
                        if (filter_var($data, FILTER_VALIDATE_EMAIL) === false) {
                            $error = "The field `" . $key . "` must be a valid email";
                        }
                    break;
                    case 'url':
                        if (filter_var($data, FILTER_VALIDATE_URL) === false) {
                            $error = "The field `" . $key . "` must be a valid URL";
                        }
                    break;
                    default:
                        $error = "The field `" . $key . "` was not understanded and wasn't validated.";
                    break;
                }
                //check if input intervalidate (input1 is mandatory only without input2 for exemple)
                if (isset($rules[1]) && in_array($rules[1], array_keys($this->rows))) {
                    if (!empty($datas[$rules[1]]) && !empty($data)) {
                        $error = "The field `" . $key . "` must be empty if the field `". $this->RowsRealName($rules[1]) ."` is filled.";
                    }
                } elseif (isset($rules[1]) && $rules[0] == 'int') {
                    if (sizeof(explode(',', $rules[1])) > 1) {
                        if (!in_array($data, explode(',', $rules[1]))) {
                            $error = "The field `" . $key . "` must be in ". $rules[1] .".";
                        }
                    } else {
                        if ($rules[1] != -1 && sizeof($data) > $rules[1] && sizeof($rules[1]) > 0) {
                            $error = "The field `" . $key . "` must be less that ". $rules[1] .".";
                        }
                    }
                } elseif (isset($rules[1]) && $rules[1] != -1 && sizeof($data) > $rules[1] && sizeof($rules[1]) > 0) {
                    $error = "The field `" . $key . "` must have less than ". $rules[1] ." character.";
                }
            } elseif (isset($rules[1]) && $rules[1] != -1 && !in_array($rules[1], array_keys($this->rows))) {
                $error = "The field `" . $key . "` is mandatory.";
            } elseif (isset($rules[1]) && in_array($rules[1], array_keys($this->rows))) {
                if (empty($datas[$rules[1]]) && empty($data)) {
                    $error = "At least one of the field `" . $key . "` or `" . $rules[1] . "` is mandatory.";
                }
            }
        }
        if (isset($error)) {
            return $error;
        } else {
            return true;
        }
    }
}
