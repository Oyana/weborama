<?php

/*
|-------------------------------------------------------
| DISPLAY HELPERS & HANDLER
|-------------------------------------------------------
|
| Add some helpers function for views handling
|
*/

/*
Include the wanted view, that's located inside the `/views` directory.
You can pass some datas to it.
Each row of your array will be transformed to varaible, that you can access directly in your view.
*/
function view($view_name, $formatedData = array())
{

    //add datas to view
    foreach ($formatedData as $key => $data) {
        //boom variable variable, that's how !
        ${$key} = $data;
    }

    if (file_exists(ROOT_PATH . '/views/' . $view_name . '.php')) {
        include(ROOT_PATH . '/views/' . $view_name . '.php');
    } else {
        debug('No view found at ' . ROOT_PATH . '/views/' . $view_name . '.php');
        return false;
    }
}
