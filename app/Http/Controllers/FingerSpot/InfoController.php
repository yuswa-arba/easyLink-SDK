<?php

namespace App\Http\Controllers\FingerSpot;

use App\model\tb_device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{

    public function info()
    {
        return view('info');
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

    /** ===============================================================================
     * Fungsi controller yang digunakan untuk mengambil informasi dari mesin fingerspot
     * ============================================================================== */
    public function prosesInfo(Request $request)
    {
        if ($data = tb_device::all()) {// mengambil data tb_device sebagai url, por, dan parameter yang menghubungkan software dengan mesin

            $sn = $data[0]['device_sn'];// mengambil parameter yang sesuai dengan nomor seri mesin fingerspot
            $port = $data[0]['server_port'];// mengambil port yang di gunakan untuk konek dengan mesin sesuai dengan port yang ada di EasyLink SDK vl.2

            if ($request->get('url_info') == "1") {// nilai satu yang dikirim pada saat tombol diklik

                $url = $data[0]['server_IP'] . "/dev/info";// url yang digunakan untuk mengambil scan log atau data absen yang masih baru
                $parameter = "sn=" . $sn;// menambil value dari variable $sn untuk menjadi parameter
                $server_output = $this->webservice($port, $url, $parameter);// untuk koneksi dari software ke mesin fingerspot

                echo json_encode($server_output);// mengembalikan data berupa json untuk ditampilkan

            }

        }
    }
}
