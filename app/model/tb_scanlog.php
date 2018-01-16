<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tb_scanlog extends Model
{
    protected $table = "tb_scanlog";

    protected $fillable = [
        'sn', 'scan_date', 'pin', 'verifymode', 'iomode', 'workcode'
    ];

    public $timestamps = false;
}
