/** ==============================================================================
 * Script untuk mengambil data scan log melalui redis dan laravel-echo
 * agar data yang baru di input/masuk ke database bisa secara realtime ditampilkan
 * ============================================================================= */

(function ($) {

    'use strict';

    $(document).ready(function () {

        /** =================================================================
         * variable yang digunakan untuk data yang akan dikerim ke controller
         * ================================================================ */
        var url = $('#url_finger').val('sata');
        var get_url = "";

        /** ====================================================================================
         * Fungsi ajax yang digunakan untuk mengirim perintah ke controller ketika button diklik
         * =================================================================================== */
        function url_setting() {
            $.ajax({
                type: "GET",
                url: "proses_setting",
                data: {url_setting: get_url},
                dataType: "json",
                success: function (data) {

                    $('#responses_success').text(data);// Untuk menampilkan hasil dari perintah yang telah dikirim ke controller

                },

                /** ====================================================================================
                 * Untuk menampilkan pemberitahuan bahwa perintah yang dikirim ke mesin gagal atau error
                 * =================================================================================== */
                error: function (sasasdf, sdfdsf, sdfsfd) {

                    $('#responses_error').text('Please Insert Data Device').removeClass('hide');// Menampilkan pesan error

                }
            });
        }


        /** ==================================================
         * Script untuk mengeksekusi setiap tombol yang diklik
         * ================================================= */

        /** ====================================================================
         * Tombol untuk mengatur waktu yang ada di mesin fingerspot
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 1
         * =================================================================== */
        $('#b_syncDT').click(function () {
            url.val('1');// value dari element input (url_finger) akan berubah menjadi 1
            get_url = url.val();
            url_setting();// mengambil fungsi url_scan untuk menjalankan perintah pengaturan waktu mesin
        });

        /** ====================================================================
         * Tombol untuk menghapus admin yang ada di dalam mesin fingerspot
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 2
         * =================================================================== */
        $('#b_delAdm').click(function () {
            url.val('2');// value dari element input (url_finger) akan berubah menjadi 2
            get_url = url.val();
            url_setting();// mengambil fungsi url_scan untuk menjalankan perintah mengambil semua scan log dari mesin
        });

        /** ====================================================================
         * Tombol untuk menghapus data log yang ada di mesin fingerspot
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 3
         * =================================================================== */
        $('#b_delLog').click(function () {
            url.val('3');// value dari element input (url_finger) akan berubah menjadi 3
            get_url = url.val();
            url_setting();// mengambil fungsi url_scan untuk menjalankan perintah menghapus log di mesin
        });

        /** ====================================================================
         * Tombol untuk menghapus semua data yang ada di mesin fingerspot
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 4
         * =================================================================== */
        $('#b_init').click(function () {
            url.val('4');// value dari element input (url_finger) akan berubah menjadi 4
            get_url = url.val();
            url_setting();// mengambil fungsi url_scan untuk menjalankan perintah menghapus semua data yang ada di mesin
        });

    });
})(window.jQuery);