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

routes()
        //basic GET & POST routing
        ->get('/auth/login', 'AuthController@loginPage')
        ->post('/auth/login', 'AuthController@login')
        ->get('/auth/register', 'AuthController@registerPage')
        ->post('/auth/register', 'AuthController@register')
        ->post('/auth/logout', 'AuthController@logout')

        //GET routing with dynamic parameter
        ->get('/{user}/profile', 'UserController@profile')

        //Route with simple closure
        ->get('/', function () {
            view('home');
        }
);
