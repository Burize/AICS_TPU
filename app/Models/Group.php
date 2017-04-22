<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
     public static function Get()
    {
        return Group::distinct()->select('id','title')->orderBy('title')->get();
    }
}
