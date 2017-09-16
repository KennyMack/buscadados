'use strict';
(function (window) {
    $(document).ready( function() {
        var imgLogo = $('#img-upload');
        var txtLogoData = $('#imgdata');
        var imgFile = $('#image');
        var txtCnpjCpf = $('#cnpjcpf');
        var txthistory = $('#history');
        var totcharhistory = $('#totcharhistory');

        imgFile.change(function () {
            window.imageField.readURL(this, imgLogo, txtLogoData);
        });

        txtCnpjCpf.mask('99.999.999/9999-99');
        txthistory.on('keypress', function (event) {
            totcharhistory.empty().append((txthistory.val().length));
        });

        totcharhistory.empty().append((txthistory.val().length));


    });

}(window));