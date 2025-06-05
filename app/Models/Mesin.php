<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    protected $connection = 'mysql_machine';
    protected $table = 'ms_mesin';
}
