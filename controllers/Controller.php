<?php
/**
 * Controller
 *
 * @package 7agagner
 * @subpackage controllers
 */

class Controller
{
    protected $msgSuccess = array();
    protected $msgInfo = array();
    protected $msgWarning = array();
    protected $msgError = array();
    protected $datas = array();

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

    public function assign($datas = null){
        if(!is_array($datas)){
            $datas = compact($datas);
        }
        $this->datas = $datas;
        return $this->datas;
    }

    /* 
    Include the wanted view, that's located inside the `/views` directory.
    You can pass some datas to it.
    Each row of your array will be transformed to varaible, that you can access directly in your view.
    By default, it use the $this->datas variable
    */
    function view($view_name, $formatedData = null){

        if(!isset($formatedData)){
            $formatedData = $this->datas;
        }

        //add datas to view
        foreach($formatedData as $key => $data){
            //boom variable variable, that's how !
            ${$key} = $data;
        }

        if(file_exists(ROOT_PATH . '/views/' . $view_name . '.php')){
            include(ROOT_PATH . '/views/' . $view_name . '.php');
        }else {
            debug('No view found at ' . ROOT_PATH . '/views/' . $view_name . '.php' );
            return false;
        }

    }
}
