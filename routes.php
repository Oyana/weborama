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

routes()->get('/auth/login', 'AuthController@loginPage')
        ->post('/auth/login', 'AuthController@login')
        ->get('/auth/register', 'AuthController@registerPage')
        ->post('/auth/register', 'AuthController@register')
        ->post('/auth/logout', 'AuthController@logout')
        ->get('/profile', 'UserController@profile')
        ->get('/', function () {
            view('home');
        });
