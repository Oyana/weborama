<?php

namespace Weborama\Models;

use Weborama\Database\ORM;

class Model
{
    protected $connection;
    protected $orm;
    protected $table;
    protected $data;
    protected $primaryKey = 'id';

    /**
     * __construct Model
     * @author Golga
     * @since 0.2
     */
    public function __construct($id = null)
    {
        $this->orm = new ORM($this->table, $this->primaryKey);

        if (isset($id)) {
            $this->data = $this->orm->getById($id);
        }

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
