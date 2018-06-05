<?php

namespace App\Model

use Weborama\Models\Model;

class User extends Model
{
    protected $table = 'users';

    protected $rows = [
                    'pseudo' => "string",
                    'email' => "email",
                    'password' => "string",
                   ];
    public function __construct()
    {
        parent::__construct($this->table);
    }
}
