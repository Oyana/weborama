<?php
/**
 * Controller
 *
 * @package 7agagner
 * @subpackage controllers
 */

class Controller
{
	private $msgSuccess = [];
	private $msgInfo = [];
	private $msgWarning = [];
	private $msgError = [];
	public $handleRouting = true;

	public function __construct(){
		//Set Flash Session
		if(!empty($_SESSION['msgSuccess'])){
			$this->$msgSuccess = $_SESSION['msgSuccess'];
			unset($_SESSION['msgSuccess']);
		}
		if(!empty($_SESSION['msgInfo'])){
			$this->$msgInfo = $_SESSION['msgInfo'];
			unset($_SESSION['msgInfo']);
		}
		if(!empty($_SESSION['msgWarning'])){
			$this->$msgWarning = $_SESSION['msgWarning'];
			unset($_SESSION['msgWarning']);
		}
		if(!empty($_SESSION['msgError'])){
			$this->$msgError = $_SESSION['msgError'];
			unset($_SESSION['msgError']);
		}
		return true;
	}

	public function setSuccess($message){
		$this->msgSuccess[] = $message;
		$_SESSION['msgSuccess'] = $this->msgSuccess;
		return true;
	}
	public function getSuccess(){
		return $this->msgSuccess;
	}

	public function setInfo($message){
		$this->msgInfo[] = $message;
		$_SESSION['msgInfo'] = $this->msgInfo;
		return true;
	}
	public function getInfo(){
		return $this->msgInfo;
	}

	public function setWarning($message){
		$this->msgWarning[] = $message;
		$_SESSION['msgWarning'] = $this->msgWarning;
		return true;
	}
	public function getWarning(){
		return $this->msgWarning;
	}

	public function setError($message){
		$this->msgError[] = $message;
		$_SESSION['msgError'] = $this->msgError;
		return true;
	}
	public function getError(){
		return $this->msgError;
	}
}
