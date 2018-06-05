<?php

namespace Weborama\Controllers;

class Controller
{
    protected $msgSuccess = array();
    protected $msgInfo = array();
    protected $msgWarning = array();
    protected $msgError = array();
    protected $datas = array();

    public function __construct()
    {
        //Set Flash Session
        if (!empty($_SESSION['msgSuccess'])) {
            $this->msgSuccess = $_SESSION['msgSuccess'];
            unset($_SESSION['msgSuccess']);
        }
        if (!empty($_SESSION['msgInfo'])) {
            $this->msgInfo = $_SESSION['msgInfo'];
            unset($_SESSION['msgInfo']);
        }
        if (!empty($_SESSION['msgWarning'])) {
            $this->msgWarning = $_SESSION['msgWarning'];
            unset($_SESSION['msgWarning']);
        }
        if (!empty($_SESSION['msgError'])) {
            $this->msgError = $_SESSION['msgError'];
            unset($_SESSION['msgError']);
        }
        return true;
    }

    public function successMessage($message = null)
    {
        if ($message) {
            $this->msgSuccess[] = $message;
            $_SESSION['msgSuccess'] = $this->msgSuccess;
            return true;
        } else {
            return $this->msgSuccess;
        }
    }

    public function infoMessage($message = null)
    {
        if ($message) {
            $this->msgInfo[] = $message;
            $_SESSION['msgInfo'] = $this->msgInfo;
            return true;
        } else {
            return $this->msgInfo;
        }
    }

    public function warningMessage($message = null)
    {
        if ($message) {
            $this->msgWarning[] = $message;
            $_SESSION['msgWarning'] = $this->msgWarning;
            return true;
        } else {
            return $this->msgWarning;
        }
    }

    public function errorMessage($message = null)
    {
        if ($message) {
            $this->msgError[] = $message;
            $_SESSION['msgError'] = $this->msgError;
            return true;
        } else {
            return $this->msgError;
        }
    }

    /*
    Fill the controllerDatas.
    It's forwarded by default to the view.
    You can pass an array for variable_name => value pairing or just ('foo',$bar)
    */
    public function assign()
    {
        if (func_num_args() != 1) {
            $this->datas[func_get_arg(0)] = func_get_arg(1);
        } else {
            if (!is_array(func_get_arg(0))) {
                throw new Exception("You passed 1 argument to the assign() function, it should be an array", 1);
                return false;
            }
            $this->datas = $this->datas + func_get_arg(0);
        }
        return $this->datas;
    }

    /*
    Forward the $this->datas array to the view function
    */
    public function view($view_name, $formatedData = null)
    {
        if (!isset($formatedData)) {
            $formatedData = array();
        }
        $formatedData = $formatedData + $this->datas;
        return view($view_name, $formatedData);
    }
}
