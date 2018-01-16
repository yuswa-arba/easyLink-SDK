<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tb_template extends Model
{
    protected $table = "tb_template";

    protected $fillable = [
        'pin', 'finger_idx', 'alg_ver', 'template'
    ];

    public $timestamps = false;
}
