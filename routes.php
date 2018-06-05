<?php

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

routes()->add('/auth/login', 'UserController@login')
        ->get('/auth/register', 'UserController@register')
        ->get('/auth/logout', 'UserController@logout')
        ->get('/auth/account', 'UserController@account')
        ->get('/', 'PageController@home')
        ->get('/test', function () {
            echo 'hello';
        });
