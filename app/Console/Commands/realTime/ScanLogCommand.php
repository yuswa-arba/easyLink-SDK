<?php

namespace App\Console\Commands\realTime;

use App\model\tb_device;
use App\Model\tb_scanlog;
use Illuminate\Console\Command;

class ScanLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Scan Log Success';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($datadev = tb_device::all()) {// mengambil data tb_device sebagai url, por, dan parameter yang menghubungkan software dengan mesin
            $parameter = "sn=" . $datadev[0]['device_sn'];// mengambil parameter yang sesuai dengan nomor seri mesin fingerspot
            $port = $datadev[0]['server_port'];// mengambil port yang di gunakan untuk konek dengan mesin sesuai dengan port yang ada di EasyLink SDK vl.2
            $url = $datadev[0]['server_IP'] . "/scanlog/new";// url yang digunakan untuk mengambil scan log atau data absen yang masih baru

            $server_output = $this->webservice($port, $url, $parameter);// untuk koneksi dari software ke mesin fingerspot

            if ($server_output) {

                /** ==================================================================================
                 * Untuk mengambil data scan log yang ada di mesin dan mengubahnya kedalam bentuk json
                 * ================================================================================= */
                $content = json_decode($server_output);
                foreach ($content->Data as $entry) {
                    $Jsn = $entry->SN;
                    $Jsd = $entry->ScanDate;
                    $Jpin = $entry->PIN;
                    $Jvm = $entry->VerifyMode;
                    $Jim = $entry->IOMode;
                    $Jwc = $entry->WorkCode;

                    /** ==============================================================================
                     * scan log yang telah diambil dari mesin akan langsung disimpan ke dalam database
                     * ============================================================================= */
                    $sqlinsertscan = new tb_scanlog();
                    $sqlinsertscan->sn = $Jsn;
                    $sqlinsertscan->scan_date = $Jsd;
                    $sqlinsertscan->pin = $Jpin;
                    $sqlinsertscan->verifymode = $Jvm;
                    $sqlinsertscan->iomode = $Jim;
                    $sqlinsertscan->workcode = $Jwc;
                    if ($sqlinsertscan->save()) {
                    } else {
                        echo '<script>alert ("Failed !")</script>';
                    }
                }
                $this->info($server_output);// untuk memberitahukan apakah input telah berhasil atau tidak melalui command
            }
        }
    }


    /** =======================================================================================================
     * fungsi yang digunakan untuk melakukan koneksi yang menghubungkan antara software dengan mesin fingerspot
     * ====================================================================================================== */
    private function webservice($port, $url, $parameter)
    {
        $curl = curl_init();
        set_time_limit(0);
        curl_setopt_array($curl, array(
                CURLOPT_PORT => $port,
                CURLOPT_URL => "http://" . $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $parameter,
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                ),
            )
        );
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $response = ("Error #:" . $err);
        } else {
            $response;
        }
        return $response;
    }

}
