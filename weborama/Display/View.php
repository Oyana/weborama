<?php

namespace Weborama\Display;

class View
{
    public $path;
    public $datas;

    public function __construct($path, $datas = [])
    {
        $this->path = $path;
        $this->datas = $datas;
    }

    public function render()
    {
        if (null === $this->path) {
            $this->renderJson();
            return;
        }

        //add datas to view
        foreach ($this->datas as $key => $data) {
            //boom variable variable, that's how !
            ${$key} = $data;
        }

        if (file_exists(ROOT_PATH . '/' . VIEWS_PATH . $this->path . '.php')) {
            include ROOT_PATH . '/' . VIEWS_PATH . $this->path . '.php';
        } else {
            echo 'No view found at ' . VIEWS_PATH . $this->path . '.php';
        }
    }

    private function renderJson()
    {
        echo $this->datas;
    }
}
