<?php

namespace App\Observer;

use App\Events\RealtimeEvent;
use App\Model\tb_scanlog;

class RealtimeObserver
{
    /** =========================================================================================
     * Perintah yang akan di jalankan jika telah terjadi input ke dalam database table tb_scanlog
     * dan datanya akan tersimpan ke dalam redis broadcasting
     * ======================================================================================== */
    public function created(tb_scanlog $scanlog)
    {
        $data = [
            'sn' => $scanlog->sn,
            'date' => $scanlog->scan_date,
            'pin' => $scanlog->pin,
            'verifymode' => $scanlog->verifymode,
            'iomode' => $scanlog->iomode,
            'workcode' => $scanlog->workcode,
        ];

        broadcast(new RealtimeEvent($data));// memasukan data yang baru disimpan ke dalam redis broadcasting
    }
}