<?php

use Weborama\Routing\RouteCollection;

/*
|-------------------------------------------------------
| Routes
|-------------------------------------------------------
|
| Matching a bunch of URL to their controller method.
| Using '@' formating to match controller with action
| or calling a closure to directly implement a function inside a route
|
*/

routes()->add('/auth/login', 'UserController@login');
routes()->get('/auth/register', 'UserController@login');
routes()->get('/auth/logout', 'UserController@login');
routes()->get('/auth/account', 'UserController@login');
routes()->get('/', 'PageController@home');
routes()->get('/test', function(){
    echo 'hello';
});
