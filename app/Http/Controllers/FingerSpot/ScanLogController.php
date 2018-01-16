<?php

namespace App\Http\Controllers\FingerSpot;

use App\model\tb_device;
use App\Model\tb_scanlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScanLogController extends Controller
{

    public function scanLog(Request $request)
    {
        $get_scans = tb_scanlog::all();

        return view('scanLog', compact('get_scans'));

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

    /** ===============================================================================================
     * Fungsi controller yang digunakan untuk melakukan aktifitas mengambil dan menghapus data scan log
     * ============================================================================================== */
    public function prosesScan(Request $request)
    {
        $server_output = "";
        $get_scan = "";

        /** ===============================================================================================
         * jika nilai value dari element yang diklik memiliki nilai 3 maka akan menjalankan perintah delete
         * dan yang didelete adalah data scan log yang telah tersimpan di dalam database
         * ============================================================================================== */
        if ($request->get('url_scan') == '3') {
            $querydel = tb_scanlog::truncate();// untuk menghapus data in database
            if ($querydel) {
            } else {
                echo '<script>alert ("Failed !")</script>';
            }
        }

        if ($datadev = tb_device::all()) {// mengambil data tb_device sebagai url, por, dan parameter yang menghubungkan software dengan mesin

            $sn = $datadev[0]['device_sn'];// mengambil parameter yang sesuai dengan nomor seri mesin fingerspot
            $port = $datadev[0]['server_port'];// mengambil port yang di gunakan untuk konek dengan mesin sesuai dengan port yang ada di EasyLink SDK vl.2
            $url = "";

            if ($request->get('url_scan')) {// jika data url_scan yang dikirim untuk tidak kosong maka akan menjalankan perintah di bawah

                /** =======================================================================================
                 * jika nilai value dari element yang diklik memiliki nilai 1
                 * maka perintah yang akan dilakukan adalah mengambil atau download data scan log dari mesin
                 * dan menyimpannya ke dalam database.
                 * ======================================================================================= */
                if ($request->get('url_scan') == '1') {
                    $url = $datadev[0]['server_IP'] . "/scanlog/all";
                }

                /** ========================================================================================
                 * jika nilai value dari element yang diklik memiliki nilai 2
                 * maka perintah yang akan diproses adalah menghapus semua data scan log di mesin fingerspot
                 * ======================================================================================= */
                elseif ($request->get('url_scan') == '2') {
                    $url = $datadev[0]['server_IP'] . "/scanlog/del";
                }

                /** ============================================================================
                 * jika nilai value dari element yang diklik memiliki nilai 3
                 * maka perintah yang akan dikerjakan adalah mengambil data scan yang masih baru
                 * dan yang masih belum tersimpan di dalam database.
                 * =========================================================================== */
                elseif ($request->get('url_scan') == '4') {
                    $url = $datadev[0]['server_IP'] . "/scanlog/new";
                }

                $parameter = "sn=" . $sn;// menambil value dari variable $sn untuk menjadi parameter
                $server_output = $this->webservice($port, $url, $parameter);// untuk koneksi dari software ke mesin fingerspot

            }

            if ($request->get('url_scan') == "1" or $request->get('url_scan') == "4") {// Jika nilai dari value yang kirim memiliki nilai 1 maka akan menjalankan perintah di bawah

                /** ==================================================================================
                 * Untuk mengambil data scan log yang ada di mesin dan mengubahnya kedalam bentuk json
                 * dan setelah itu langsung menyimpannya ke dalam database yang telah di buat di local
                 * ================================================================================= */
                $content = json_decode($server_output);
                foreach ($content as $key => $value) {

                    if ((!is_array($value)) and ($value == 1)) {

                        if ($request->get('url_scan') == "1") {// jika yang diambil adala semua maka akan menghapus semua user yang di database
                            $querydel = tb_scanlog::truncate();// digunakan untuk menghapus data scan log yang ada di database
                        }

                        foreach ($content->Data as $entry) {

                            /** ==============================================
                             * Untuk mengambil data scan dari mesin fingerspot
                             * ============================================= */
                            $Jsn = $entry->SN;
                            $Jsd = $entry->ScanDate;
                            $Jpin = $entry->PIN;
                            $Jvm = $entry->VerifyMode;
                            $Jim = $entry->IOMode;
                            $Jwc = $entry->WorkCode;

                            /** ==================================================================
                             * Untuk menyimpan data scan yang diambil dari mesin ke dalam database
                             * ================================================================= */
                            $sqlinsertscan = new tb_scanlog();
                            $sqlinsertscan->sn = $Jsn;
                            $sqlinsertscan->scan_date = $Jsd;
                            $sqlinsertscan->pin = $Jpin;
                            $sqlinsertscan->verifymode = $Jvm;
                            $sqlinsertscan->iomode = $Jim;
                            $sqlinsertscan->workcode = $Jwc;

                            if ($sqlinsertscan->save()) {
                                $get_scan = tb_scanlog::all();//mengambil data scan dari database jika telah berhasil menyimpan data ke db
                            } else {
                                echo '<script>alert ("Failed !")</script>';
                            }
                        }
                    } elseif ((!is_array($value)) and (!$value == 1)) {
                    }
                }
            }
            echo json_encode($get_scan);

        } else {
            if ($request->get('url_scan') == '1' or $request->get('url_scan') == '2' or $request->get('url_scan') == '4') {
            }
        }
    }

}
