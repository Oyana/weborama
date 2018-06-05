<?php

//Return the path of your URL inside the /public/ directory (helpfull for JS or CSS loading)
function asset($url)
{
    return SITE_URL . '/public/' . $url;
}

//Return the path of your URL inside the /storage/ directory (helpfull for image loading)
function stored($url)
{
    return SITE_URL . '/storage/' . $url;
}

//Return the URL corresponding to your $routename
function routeUrl($routename)
{
    return SITE_URL . '/' . $routename;
}

//Redirect you to the wanted route. You can pass some datas that you want to keep with you.
function redirect($routename, $savedDatas = array())
{
    if (!empty($savedDatas)) {
        $_SESSION['redirect'] = $savedDatas;
    }
    header('location:'.SITE_URL . '/' . $routename);
}

//return the routeCollection object
function app()
{
    return Weborama\WeboramaApp::instance();
}

//return the request object
function request()
{
    return Weborama\Request\Request::instance();
}

//return the routeCollection object
function routes()
{
    return Weborama\Routing\RouteCollection::instance();
}

//include a view file
function view($path)
{
    include(ROOT_PATH . '/views/' . $path . '.php');
}
