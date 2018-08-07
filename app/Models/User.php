<?php

namespace App\Models;

use Weborama\Models\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'name';

    protected $rows = [
                    'pseudo' => "string",
                    'email' => "email",
                    'password' => "string",
                   ];
}
