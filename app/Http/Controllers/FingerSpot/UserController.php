<?php

namespace App\Http\Controllers\FingerSpot;

use App\model\tb_device;
use App\Model\tb_template;
use App\Model\tb_user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function user()
    {
        return view('user');
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


    /** =========================================================================================
     * Mengambil data sidik jari dan wajah sesuai dengan pin yang telah di request untuk diupload
     * ======================================================================================== */
    private function getTemplate($pinT)
    {
        $header = "[";
        $footer = "]";
        $content = "";

        $dataGetTemps = tb_template::all()->where('pin', '=', $pinT);// mengambil data template sidik jari dan wajah

        foreach ($dataGetTemps as $dataGetTemp) {
            if ($content != "") {
                $content = $content . ',';
            }

            // Content atau parameter yang akan dikirim untuk upload data ke mesin
            $content = $content . '{"pin":"' . $dataGetTemp["pin"] . '","idx":"' . $dataGetTemp["finger_idx"] .
                '","alg_ver":"' . $dataGetTemp["alg_ver"] . '","template":"' . $dataGetTemp["template"] . '"}';
        }
        return ($header . $content . $footer);// Mengembalikan data yang telah diambil untuk diupload
    }


    /** ======================================================
     * Mengambil semua data user untuk diupload ke dalam mesin
     * ===================================================== */
    private function CreateUserJSON()
    {
        $header = '{"Result":true,"Data":[';
        $footer = "]}";
        $content = "";

        $dataSetAlls = tb_user::all();// mengambil semua data user yang ada di dalam database

        foreach ($dataSetAlls as $dataSetAll) {
            if ($content != "") {
                $content = $content . ',';
            }

            // Content atau parameter yang akan dikirim untuk upload data user ke mesin
            $content = $content . '{"PIN":"' . $dataSetAll['pin'] . '","Name":"' . $dataSetAll['nama'] . '","RFID":"' . $dataSetAll['rfid'] .
                '","Password":"' . $dataSetAll['pwd'] . '","Privilege":' . $dataSetAll['privilege'] .
                ',' . $this->getTemplateAll($dataSetAll['pin']) . '}';
        }
        return ($header . $content . $footer);// Mengembalikan data yang telah diambil untuk diupload
    }

    /** ============================================================================================================
     * Mengambil semua data sidik jari dan wajah sesuai jumalah user yang ada dan yang diminta dari (CreateUserJSON)
     * =========================================================================================================== */
    function getTemplateAll($pinT)
    {
        $header = '"Template":[';
        $footer = "]";
        $content = "";

        $dataGetTempAlls = tb_template::all()->where('pin', '=', $pinT);// mengambil data template sidik jari dan wajah

        foreach ($dataGetTempAlls as $dataGetTempAll) {
            if ($content != "") {
                $content = $content . ',';
            }

            // Content data sidik jari dan wajah yang diminta dari (CreateUserJSON) untuk diupload ke mesin
            $content = str_replace('+', '%2B', $content . '{"pin":"' . $dataGetTempAll['pin'] . '","idx":"' . $dataGetTempAll['finger_idx'] .
                '","alg_ver":"' . $dataGetTempAll['alg_ver'] . '","template":"' . $dataGetTempAll['template'] . '"}');
        }
        return ($header . $content . $footer);// Mengembalikan data dari template ke dalam function (CreateUserJSON)
    }


    /** ======================================================================
     * Fungsi controller yang digunakan aktifitas yang berhubungan dengan user
     * serperti (get all, upload all, delete all, dan lain-lain).
     * ===================================================================== */
    public function userProses(Request $request)
    {

        $get_all_user = "";
        $server_output = "";

        /** ==========================================================================
         * Jika nilai value request adalah 4 maka perintah yang akan dijalankan adalah
         * menghapus data user yang telah tersimpan di dalam database
         * ========================================================================= */
        if ($request->get('url_user') == '4') {
            $querydeluser = tb_user::truncate();// menghapus semua data user yang ada di database
            $querydeltemp = tb_template::truncate();// menghapus sidik jari dan wajah yang telah tersimpan dalam database
            if ($querydeluser && $querydeltemp) {
            } else {
                echo '<script>alert ("Failed !")</script>';
            }
        }

        if ($datadev = tb_device::all()) {// mengambil data tb_device sebagai url, por, dan parameter yang menghubungkan software dengan mesin

            $sn = $datadev[0]['device_sn'];// mengambil parameter yang sesuai dengan nomor seri mesin fingerspot
            $port = $datadev[0]['server_port'];// mengambil port yang di gunakan untuk konek dengan mesin sesuai dengan port yang ada di EasyLink SDK vl.2

            /** ===============================================================================================
             * jika nilai value yang dikirim memiliki nilai 1
             * maka akan menjalankan perintah untuk mengambil semua data user yang ada didalam mesin fingerspot
             * ============================================================================================== */
            if ($request->get('url_user') == '1') {
                $parameter = "sn=" . $sn;
                $url = $datadev[0]['server_IP'] . "/user/all";
                $server_output = $this->webservice($port, $url, $parameter);
            }

            /** ============================================================================
             * jika nilai value yang dikirim memiliki nilai 3
             * maka akan menjalankan upload semua data user yang tersimpan di dalam database
             * =========================================================================== */
            elseif ($request->get('url_user') == '3') {
                $parameter = "sn=" . $sn . "&data=" . $this->CreateUserJSON();// mengambil parameter dari function (CreateUserJSON)
                $url = $datadev[0]['server_IP'] . "/user/set-all";
                $server_output = $this->webservice($port, $url, $parameter);
                if ($server_output) {
                    $get_all_user = tb_user::all();// jika telah berhasil diupload maka akan menampilkan data yang telah diupload
                }
            }

            /** ==========================================================================================
             * jika nilai value yang dikirim memiliki nilai 2
             * maka perintah yang akan dijalankan adalah menghapus semua data user yang ada di dalam mesin
             * ========================================================================================= */
            elseif ($request->get('url_user') == '2') {
                $parameter = "sn=" . $sn;
                $url = $datadev[0]['server_IP'] . "/user/delall";
                $server_output = $this->webservice($port, $url, $parameter);
            }

            /** =================================================================================================
             * jika nilai value yang dikirim memiliki nilai 6
             * maka perintah yang akan dijalankan adalah menghapus user di mesin sesuai dengan pin yang dimasukan
             * ================================================================================================ */
            elseif ($request->get('url_user') == '6') {
                $pinDel = $request->get('delUser');
                $parameter = "sn=" . $sn . "&pin=" . $pinDel;
                $url = $datadev[0]['server_IP'] . "/user/del";
                $server_output = $this->webservice($port, $url, $parameter);
            }

            /** ========================================================================================================
             * jika nilai value yang dikirim memiliki nilai 5
             * maka perintah yang dijalankan adalah mengupload data user ke mesin sesuai dengan pin yang telah dimasukan
             * ======================================================================================================= */
            elseif ($request->get('url_user') == '5') {
                $pinSet = $request->get('setUser');
                if ($pinSet == null) {
                    $sqluserUp = "";
                    echo '<script>alert ("Please Insert User PIN")</script>';
                } else {
                    $sqluserUp = tb_user::all()->where('pin', '=', $pinSet)->first();// Mengambil nilai yang ada di dalam database sesuai dengan pin
                }

                /** ================================================
                 * Mengambil data user yang tersimpan dalam database
                 * =============================================== */
                $upPin = $sqluserUp['pin'];
                $upNama = $sqluserUp['nama'];
                $upPwd = $sqluserUp['pwd'];
                $upRfid = $sqluserUp['rfid'];
                $upPriv = $sqluserUp['privilege'];

                /** ===========================================================
                 * Mengambil sidik jari dan wajah yang tersimpan dalam database
                 * ========================================================== */
                $upTemp = $this->getTemplate($upPin);
                $upTemp = str_replace("+", "%2B", $upTemp);

                //  Parameter yang digunakan untuk menyimpan data user ke dalam database
                $parameter = "sn=" . $sn . "&PIN=" . $upPin . "&Name=" . $upNama . "&Password=" . $upPwd . "&RFID=" . $upRfid . "&priv=" . $upPriv . "&tmp=" . $upTemp;

                $url = $datadev[0]['server_IP'] . "/user/set";// url yang digunakan untuk upload data user ke dalam mesin
                $server_output = $this->webservice($port, $url, $parameter);// untuk koneksi dari software ke mesin fingerspot

                if ($server_output) {
                    /** ===============================================================================
                     * jika telah berhasil upload ke dalam mesin maka akan langsung mengambil data user
                     * dari database sesuai dengan pin user yang telah diupload
                     * ============================================================================== */
                    $get_all_user = tb_user::all()->where('pin', '=', $upPin);
                }

            }

            /** ==========================================================================================
             * Jika nilai value yang dikirim bernilai 1 maka dia akan mengambil semua data user dari mesin
             * dan setelah itu langsung menyimpannya ke dalam database
             * ========================================================================================= */
            if ($request->get('url_user') == '1') {
                $content = json_decode($server_output);
                foreach ($content as $key => $value) {
                    if ((!is_array($value)) and ($value == 1)) {

                        /** ======================================================================
                         * Sebelum data dari mesin di download maka terlebih dahulu akan menghapus
                         * semua data user yang telah ada di dalam database
                         * ===================================================================== */
                        $querydeluser = tb_user::truncate();// menghapus semua data user
                        $querydeltemp = tb_template::truncate();// menghapus semua data sidik jari dan wajah yang tersimpan

                        if ($querydeluser && $querydeltemp) {
                        } else {
                            echo '<script>alert ("Failed !")</script>';
                        }

                        foreach ($content->Data as $entry) {

                            /** =============================
                             * Mengambil data user dari mesin
                             * ============================ */
                            $Jpin = $entry->PIN;
                            $Jname = $entry->Name;
                            $Jrfid = $entry->RFID;
                            $Jpass = $entry->Password;
                            $Jpriv = $entry->Privilege;
                            $JTemp = $entry->Template;

                            /** =============================================================
                             * Menyimpan data yang telah diambil dari mesin ke dalam database
                             * ============================================================ */
                            $queryinsertuser = new tb_user();
                            $queryinsertuser->pin = $Jpin;
                            $queryinsertuser->nama = $Jname;
                            $queryinsertuser->pwd = $Jpass;
                            $queryinsertuser->rfid = $Jrfid;
                            $queryinsertuser->privilege = $Jpriv;

                            if ($queryinsertuser->save()) {
                            } else {
                                echo '<script>alert ("Failed !")</script>';
                            }

                            foreach ($entry->Template as $values) {

                                /** =============================================
                                 * Mengambil data sidik jari dan wajah dari mesin
                                 * ============================================ */
                                $valPin = $values->pin;
                                $valIdx = $values->idx;
                                $valAlg_ver = $values->alg_ver;
                                $valTemp = $values->template;

                                /** =============================================================
                                 * Menyimpan data yang telah diambil dari mesin ke dalam database
                                 * ============================================================ */
                                $queryinserttemp = new tb_template();
                                $queryinserttemp->pin = $valPin;
                                $queryinserttemp->finger_idx = $valIdx;
                                $queryinserttemp->alg_ver = $valAlg_ver;
                                $queryinserttemp->template = $valTemp;

                                if ($queryinserttemp->save()) {
                                    /** =======================================================================
                                     * Jika telah berhasil menyimpan data dari mesin ke dalam database,
                                     * maka akan langsung mengambil data yang telah tersimpan untuk ditampilkan
                                     * ====================================================================== */
                                    $get_all_user = tb_user::all();
                                } else {
                                    echo '<script>alert ("Failed !")</script>';
                                }
                            }
                        }
                    } elseif ((!is_array($value)) and (!$value == 1)) {
                    }
                }
            }
        }
        echo json_encode($get_all_user);// mengembalikan data user untuk ditampilkan
    }
}
