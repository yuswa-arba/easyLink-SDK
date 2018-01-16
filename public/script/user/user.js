/** =========================================================================================
 * Script untuk mengeksekusi perintah yang berhubungan dengan user
 * seperti (get all user from mesin, delete all user in mesin, delete user with pin in mesin,
 * upload all user to mesin, upload user with pin to mesin, delete user in database)
 * ======================================================================================== */

(function ($) {

    'use strict';

    $(document).ready(function () {

        /** =================================================================
         * variable yang digunakan untuk data yang akan dikerim ke controller
         * ================================================================ */
        var url = $('#url_user').val('');
        var i_setUser = "";
        var i_delUser = "";
        var get_url = "";

        /** ====================================================================================
         * Fungsi ajax yang digunakan untuk mengirim perintah ke controller ketika button diklik
         * =================================================================================== */
        function url_setting() {
            $.ajax({
                type: "GET",
                url: "user_proses",
                data: {url_user: get_url, setUser: i_setUser, delUser: i_delUser},
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    var result_body_user = $('#result_body_user');

                    result_body_user.html("");// Mengosongkan table sebelum menampilkan hasil eksekusi dari controller

                    /** =============================================================
                     * Untuk menampilkan data yang telah dikembalikan dari controller
                     * ============================================================ */
                    for (var i = 0; i < data.length; i++) {
                        result_body_user.append(
                            '<tr>' +
                            '<td>' + data[i].pin + '</td>' +
                            '<td>' + data[i].nama + '</td>' +
                            '<td>' + data[i].pwd + '</td>' +
                            '<td>' + data[i].rfid + '</td>' +
                            '<td>' + data[i].privilege + '</td>' +
                            '</tr>'
                        );
                    }
                },

                /** =================================================================================
                 * Untuk menampilkan pemberitahuan bahwa pengambilan data dari mesin gagal atau error
                 * ================================================================================ */
                error: function (sasasdf, sdfdsf, sdfsfd) {
                    console.log('telah terjadi error')
                }
            });
        }


        /** ==================================================
         * Script untuk mengeksekusi setiap tombol yang diklik
         * ================================================= */

        /** ===========================================================================
         * Tombol untuk mengambil semua data user dari mesin ke software (Get all user)
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 1
         * ========================================================================== */
        $('#b_GetUser').click(function () {
            url.val('1');// value dari element input (url_user) akan berubah menjadi 1
            get_url = url.val();
            url_setting();// mengambil fungsi url_setting untuk menjalankan perintah mengambil semua user dari mesin
        });

        /** ====================================================================
         * Tombol untuk menghapus semua user yang ada di dalam mesin
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 2
         * =================================================================== */
        $('#b_DelUser').click(function () {
            url.val('2');// value dari element input (url_user) akan berubah menjadi 2
            get_url = url.val();
            url_setting();// mengambil fungsi url_setting untuk menjalankan perintah menghapus semua data di mesin
        });

        /** ====================================================================
         * Tombol untuk mengupload semua data user ke dalam mesin
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 3
         * =================================================================== */
        $('#b_SetAllUser').click(function () {
            url.val('3');// value dari element input (url_user) akan berubah menjadi 3
            get_url = url.val();
            url_setting();// mengambil fungsi url_setting untuk menjalankan perintah upload semua data ke mesin
        });

        /** ====================================================================
         * Tombol untuk menghapus semua data user yang ada di dalam database
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 3
         * =================================================================== */
        $('#b_delUserDB').click(function () {
            url.val('4');// value dari element input (url_user) akan berubah menjadi 4
            get_url = url.val();
            url_setting();// mengambil fungsi url_setting untuk menjalankan perintah menghapus data di database
        });

        /** ===============================================================================
         * Tombol untuk mengupload data user ke mesin sesuai dari pin yang telah di masukan
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 5
         * ============================================================================== */
        $('#b_SetUser').click(function () {
            url.val('5');// value dari element input (url_user) akan berubah menjadi 5
            i_setUser = $('#i_setUser').val();
            get_url = url.val();
            url_setting();// mengambil fungsi url_setting untuk menjalankan perintah upload data sesuai pin ke mesin
        });

        /** =========================================================================
         * Tombol untuk menghapus data user di mesin sesuai dengan pin yang dimasukan
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 6
         * ======================================================================== */
        $('#b_delUserPIN').click(function () {
            url.val('6');// value dari element input (url_user) akan berubah menjadi 6
            i_delUser = $('#i_delUser').val();
            get_url = url.val();
            url_setting();// mengambil fungsi url_setting untuk menjalankan perintah menghapus data di mesin sesuai pin
        });

    });
})(window.jQuery);