/** ==============================================================================
 * Script untuk mengambil data scan log melalui redis dan laravel-echo
 * agar data yang baru di input/masuk ke database bisa secara realtime ditampilkan
 * ============================================================================= */

(function ($) {

    'use strict';

    $(document).ready(function () {

        /** =================================================================================================
         * script laravel-echo yang digunakan untuk mengambil data yang tersimpan di dalam redis
         * untuk di tampilkan pada saat data scan log telah berhasil diinput kedalam database secara realtime
         * ================================================================================================ */
        window.Echo.channel('realtime').listen('RealtimeEvent', function (e) {

            var result_body_scan = $('#result_body_scan');

            result_body_scan.html("");// Mengosongkan table sebelum menampilkan hasil eksekusi dari controller

            /** ==============================================================
             * Untuk menampilkan data baru yang telah tersimpan di dalam redis
             * ============================================================= */
            result_body_scan.append(
                '<tr>' +
                '<td>' + e.realtime.sn + '</td>' +
                '<td>' + e.realtime.date + '</td>' +
                '<td>' + e.realtime.pin + '</td>' +
                '<td>' + e.realtime.verifymode + '</td>' +
                '<td>' + e.realtime.iomode + '</td>' +
                '<td>' + e.realtime.workcode + '</td>' +
                '</tr>'
            );
        });

    });
})(window.jQuery);