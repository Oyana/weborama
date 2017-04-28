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

    public function __construct(){
        //Set Flash Session
        if(!empty($_SESSION['msgSuccess'])){
            $this->msgSuccess = $_SESSION['msgSuccess'];
            unset($_SESSION['msgSuccess']);
        }
        if(!empty($_SESSION['msgInfo'])){
            $this->msgInfo = $_SESSION['msgInfo'];
            unset($_SESSION['msgInfo']);
        }
        if(!empty($_SESSION['msgWarning'])){
            $this->msgWarning = $_SESSION['msgWarning'];
            unset($_SESSION['msgWarning']);
        }
        if(!empty($_SESSION['msgError'])){
            $this->msgError = $_SESSION['msgError'];
            unset($_SESSION['msgError']);
        }
        return true;
    }

    public function successMessage($message = null){
        if($message){
              $this->msgSuccess[] = $message;
              $_SESSION['msgSuccess'] = $this->msgSuccess;
              return true;
        }else {
            return $this->msgSuccess;
        }
    }

    public function infoMessage($message = null){
        if($message){
              $this->msgInfo[] = $message;
              $_SESSION['msgInfo'] = $this->msgInfo;
              return true;
        }else {
            return $this->msgInfo;
        }
    }

    public function warningMessage($message = null){
        if($message){
              $this->msgWarning[] = $message;
              $_SESSION['msgWarning'] = $this->msgWarning;
              return true;
        }else {
            return $this->msgWarning;
        }
    }

    public function errorMessage($message = null){
        if($message){
              $this->msgError[] = $message;
              $_SESSION['msgError'] = $this->msgError;
              return true;
        }else {
            return $this->msgError;
        }
    }
}
