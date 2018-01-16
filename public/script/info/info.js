/** ====================================================
 * script yang digunakan untuk mengambil info dari mesin
 * dan dikirim ke dalam software yang telah di buat
 * =================================================== */

(function ($) {

    'use strict';

    $(document).ready(function () {

        /** =========================================================================
         * ketika button diklik maka akan langsung mengirimkan perintah ke controller
         * untuk mengambil informasi data dari mesin
         * ======================================================================== */
        var url = $('#b_infoDev');
        url.click(function () {

            /** ======================================================
             * value dari button akan diubah menjadi 1
             * dan akan dikirim ke controller untuk eksekusi if (jika)
             * ===================================================== */
            url.val('1');
            var get_url = url.val();

            $.ajax({
                type: "GET",
                url: "proses_info",
                data: {url_info: get_url},
                dataType: "json",
                success: function (data) {
                    /** =========================================================
                     * mengembalikan data informasi dari mesin yang telah diambil
                     * untuk ditampilkan dalam bentuk json
                     * ======================================================== */
                    $('#result_success_info').text(data);
                }
            });
        });

    });
})(window.jQuery);