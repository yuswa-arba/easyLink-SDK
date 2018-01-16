/** ============================================================================================================
 * Script untuk mengambil dan menghapus kegiatan scan yang telah dilakukan oleh user pada saat melakukan absensi
 * seperti (get all scan, delete scan log, delete scan log in database, get new scan log)
 * =========================================================================================================== */

(function ($) {

    'use strict';

    $(document).ready(function () {

        /** =================================================================
         * variable yang digunakan untuk data yang akan dikerim ke controller
         * ================================================================ */
        var url = $('#url_scan').val('');
        var get_url = "";

        /** ====================================================================================
         * Fungsi ajax yang digunakan untuk mengirim perintah ke controller ketika button diklik
         * =================================================================================== */
        function url_scan() {
            console.log(get_url);
            $.ajax({
                type: "GET",
                url: "proses_scan",
                data: {url_scan: get_url},
                dataType: "json",
                success: function (data) {
                    var result_body_scan = $('#result_body_scan');

                    result_body_scan.html("");// Mengosongkan table sebelum menampilkan hasil eksekusi dari controller

                    /** =============================================================
                     * Untuk menampilkan data yang telah dikembalikan dari controller
                     * ============================================================ */
                    for (var i = 0; i < data.length; i++) {
                        result_body_scan.append(
                            '<tr>' +
                            '<td>' + data[i].sn + '</td>' +
                            '<td>' + data[i].scan_date + '</td>' +
                            '<td>' + data[i].pin + '</td>' +
                            '<td>' + data[i].verifymode + '</td>' +
                            '<td>' + data[i].iomode + '</td>' +
                            '<td>' + data[i].workcode + '</td>' +
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

        /** =====================================================================================
         * Tombol untuk mengambil semua data scan log user pada saat melakukan absensi dari mesin
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 1
         * ==================================================================================== */
        $('#b_allScan').click(function () {
            url.val('1');// value dari element input (url_scan) akan berubah menjadi 1
            get_url = url.val();
            url_scan();// mengambil fungsi url_scan untuk menjalankan perintah mengambil semua scan log dari mesin
        });

        /** ====================================================================
         * Tombol untuk menghapus semua scan log yang ada di dalam masin
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 2
         * =================================================================== */
        $('#b_delScan').click(function () {
            url.val('2');// value dari element input (url_scan) akan berubah menjadi 2
            get_url = url.val();
            url_scan();// mengambil fungsi url_scan untuk menjalankan perintah menghapus semua scan log di mesin
        });

        /** ====================================================================
         * Tombol untuk menghapus semua data scan log yang berada di database
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 3
         * =================================================================== */
        $('#b_delScanDB').click(function () {
            url.val('3');// value dari element input (url_scan) akan berubah menjadi 3
            get_url = url.val();
            url_scan();// mengambil fungsi url_scan untuk menjalankan perintah menghapus semua scan log di database
        });

        /** ====================================================================
         * Tombol untuk mengambil data scan log yang masih baru dilakukan user
         * ketika tombol diklik maka value atau data yang akan dikirim menjadi 4
         * =================================================================== */
        $('#b_getNewScan').click(function () {
            url.val('4');// value dari element input (url_scan) akan berubah menjadi 4
            get_url = url.val();
            url_scan();// mengambil fungsi url_scan untuk menjalankan perintah mengambil data scan log dari mesin
        });

    });
})(window.jQuery);