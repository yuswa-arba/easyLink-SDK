<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tb_user extends Model
{
    protected $table = "tb_user";

    protected $fillable = [
        'pin', 'nama', 'pwd', 'rfid', 'privilege'
    ];

    public $timestamps = false;
}
