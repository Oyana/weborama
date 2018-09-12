<?php

namespace Weborama\Debugger;

/*
|-------------------------------------------------------
| DEBUG HELPERS & HANDLER
|-------------------------------------------------------
|
| Display the debugging information to the page
| with helpers function or when errors are returned
|
*/

class Debugger
{
    public $debugLevel;

    public function __construct()
    {
        $this->debugLevel = DEBUG_LVL;

        error_reporting(0);
        switch (DEBUG_LVL) {
        case 0:
            error_reporting(0);
            ini_set('display_errors', false);
            break;
        case 1:
        case 2:
        default:
            error_reporting(E_ALL);
            ini_set('display_errors', true);
            break;
        }
        //Display in a tree all argument you pass to it. You can pass as many argument as you want.
        public function debug()
        {
            if (DEBUG_LVL > 0) {
                //display a nicely designed accordeon debugging
                node(func_get_args());
                die();
            } else {
                return true;
            }
        }

        private function node($datas)
        {
            echo '<ul class="debug-node">';
            foreach ($datas as $data) {
                echo "<li>";
                if (is_array($data)) {
                    echo('Array : ');
                    node($data);
                } else {
                    echo '<pre>';
                    var_dump($data);
                    echo '</pre>';
                }
                echo "</li>";
            }
            '</ul>';
        }
    }
}

