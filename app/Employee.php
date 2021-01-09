<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $primarykey = 'id';
    protected $fillable = [
        'code',
        'name',
        'first_name',
        'second_first_name',
        'email',
        'contract_type',
        'status'
    ];
}
