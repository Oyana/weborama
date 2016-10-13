<?php
/**
 * Model
 *
 * @package 7agagner
 * @subpackage models
 */
class Model
{
	protected $db;
	protected $id_key;
	protected $table;
	protected $lastQuery;
	protected $lastInsertId;

	/**
	 * __construct Model
	 * @author Golga
	 * @since 0.2
	 * @param	object		$db
	 */
	public function __construct( $id_key, $table )
	{
		try // PDO Connection
		{
			$db = new PDO( DB_TYPE . ":host=" . DB_HOST ."; dbname=" . DB_NAME . ";", DB_USER, DB_PASS );
			$db->exec("set names utf8");
		}
		catch( PDOException $e )
		{
			if ( DEV_MOD )
			{
				echo $e->getMessage();
			}
		}

		$this->db = $db;
		$this->id_key = $id_key;
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
		unset($this->db);
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
	public function addByArray( $array )
	{
		$query = "INSERT INTO " . DB_PREFIX . $this->table . " ";
		$format = "(";
		$value = "VALUES (";
		foreach ($array as $k => $v)
		{
			if ( $k != $this->id_key)
			{
				$format .= "`" . $k . "`, ";
				$value .= $this->db->quote( $v ) . ", ";
			}
		}
		$query .= rtrim( $format, ", " ) . ") ". rtrim( $value, ", " ) . ");";
		$this->db->exec( $query );
		$this->lastQuery = $query;

		$this->lastInsertId = $this->db->lastInsertId();
		return true;
	}

	/**
	 * updateByArray
	 *
	 * @author Golga
	 * @since 0.2
	 * @param integer		$id
	 * @param array		$array
	 * @return boolean
	*/
	public function updateByArray( $id, $array )
	{
		$query = "UPDATE " . DB_PREFIX . $this->table . " SET ";
		$format = '';
		foreach ($array as $k => $v)
		{
			if ( $k != $this->id_key)
			{
				$format .= "`" . $k . "` = " . $this->db->quote( $v ) . ", ";
			}
		}
		$query .= rtrim( $format, ", " ) . " WHERE ". $this->id_key . " = " . $id;
		$this->db->exec( $query );
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
	public function getLastInsertId()
	{
		if ( !empty($this->lastInsertId) )
		{
			return $this->lastInsertId;
		}
		return $this->db->lastInsertId();
	}

	/**
	 * getLastInsertQuery
	 *
	 * @author Golga
	 * @since 0.2
	 * @param array
	 * @return boolean
	*/
	public function getLastQuery()
	{
		if ( !empty($this->lastQuery) )
		{
			return $this->lastQuery;
		}
		return $this->db->debugDumpParams();
	}

	public function getAll()
	{
		$statement = $this->db->prepare("SELECT * FROM " . DB_PREFIX . $this->table . ";");
		$statement->execute();
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	public function getById( $id )
	{
		$statement = $this->db->prepare("SELECT * FROM " . DB_PREFIX . $this->table . "  WHERE `" . $this->id_key . "` = " . $id . ";");
		$statement->execute();
		$data = $statement->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	public function getByWhere( $where = false )
	{
		if ( !$where )
		{
			return $this->getAll();
		}
		elseif ( !is_array( $where ) )
		{
			$whereData = $where . ";";
		}
		else
		{
			$whereData = " 1";
			foreach ($where as $key => $value)
			{
				$whereData = $whereData . " AND " . $key . "=" . $value;
			}
			$whereData = $whereData . " ; ";
		}

		$statement = $this->db->prepare("SELECT * FROM " . DB_PREFIX . $this->table . "  WHERE " . $whereData);
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
}
