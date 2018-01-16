<?php

namespace App\Http\Controllers\FingerSpot;

use App\model\tb_device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    public function setting(Request $request)
    {
        return view('setting');
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

    /** ================================================================================
     * Fungsi controller yang digunakan untuk melakukan pengaturan pada mesin fingerspot
     * =============================================================================== */
    public function prosesSetting(Request $request)
    {
        $get_url = $request->get('url_setting');
        if ($data = tb_device::all()) {// mengambil data tb_device sebagai url, por, dan parameter yang menghubungkan software dengan mesin

            $sn = $data[0]['device_sn'];// mengambil parameter yang sesuai dengan nomor seri mesin fingerspot
            $port = $data[0]['server_port'];// mengambil port yang di gunakan untuk konek dengan mesin sesuai dengan port yang ada di EasyLink SDK vl.2

            /** ====================================================
             * jika nilai value yang dikirim memiliki nilai 1
             * maka akan menjalankan perintah pengaturan waktu mesin
             * ===================================================== */
            if ($get_url == '1') {
                $url = $data[0]['server_IP'] . "/dev/settime";
            }

            /** ===================================================================
             * jika nilai value yang dikirim memiliki nilai 2
             * maka perintah yang dijalankan adalah menghapus data admin pada mesin
             * ================================================================== */
            elseif ($get_url == '2') {
                $url = $data[0]['server_IP'] . "/dev/deladmin";
            }

            /** ====================================================================
             * jika nilai value yang dikirim memiliki nilai 3
             * maka perintah yang akan dijalankan adalah menghapus data log di mesin
             * =================================================================== */
            elseif ($get_url == '3') {
                $url = $data[0]['server_IP'] . "/log/del";
            }

            /** ==============================================================================
             * jika nilai value yang dikirim memiliki nilai 4
             * maka perintah yang akan dijalakan adalah menghapus semua data yang ada di mesin
             * ============================================================================= */
            elseif ($get_url == '4') {
                $url = $data[0]['server_IP'] . "/dev/init";
            }

            /** ========================================================================
             * jika tidak ada nilai apa-apa maka tidak akan menjalankan perintah apa-apa
             * ======================================================================= */
            else {
                $url = "";
            }

            $parameter = "sn=" . $sn;// menambil value dari variable $sn untuk menjadi parameter
            $server_output = $this->webservice($port, $url, $parameter);// untuk koneksi dari software ke mesin fingerspot

            echo json_encode($server_output);// mengembalikan data berupa json untuk ditampilkan

        } else {
            if ($get_url == '1' or $get_url == '2' or $get_url == '3' or $get_url == '4') {
                return view('setting');
            }
        }
    }

}
