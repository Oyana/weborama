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
        //GET routing with dynamic parameter
        ->get('/profiles', 'UserController@index')
        ->get('/{user}/profile', 'UserController@show')
        ->get('/profile/create', 'UserController@createForm')
        ->post('/profile/create', 'UserController@createUser')
        ->get('/{user}/profile/edit', 'UserController@editForm')
        ->put('/{user}/profile', 'UserController@editUser')
        ->delete('/{user}/profile', 'UserController@delete')

        //Route with simple closure
        ->get(
            '/', function () {
                view('home');
            }
        );
