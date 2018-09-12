<?php

namespace App\Models;

use Weborama\Models\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $rows = [
                    'name' => "string",
                    'email' => "email",
                    'password' => "string",
                   ];
}
