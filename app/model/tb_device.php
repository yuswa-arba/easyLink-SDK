<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class tb_device extends Model
{
    protected $primaryKey = "No";

    protected $table = "tb_device";

    protected $fillable = [
        'server_IP', 'server_port', 'device_sn'
    ];

    public $timestamps = false;
}
