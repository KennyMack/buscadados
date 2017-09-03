'use strict';
(function (window) {
    $(document).ready( function() {
        var imgLogo = $('#img-upload');
        var txtLogoData = $('#imgdata');
        var imgFile = $('#image');
        var txtCnpjCpf = $('#cnpjcpf');
        //var txtIE = $('#ie');

        imgFile.change(function () {
            window.imageField.readURL(this, imgLogo, txtLogoData);
        });

        txtCnpjCpf.mask('99.999.999/9999-99');

        /*txtIE.on('keypress', function (event) {
            if(!window.validate.isInArray(event.key,
                ['0','1','2','3','4','5','6','7','8','9','/', '-', '.'])){
                event.returnValue = false;
                return false;
            }
        });

        txtCnpjCpf.on('keypress', function (event) {
            if(window.validate.isInteger(event)){
                event.returnValue = false;
                return false;
            }
            return window.format.formatField(this, '00.000.000/0000-00', event);
        });

        txtCnpjCpf.on('blur', function() {
            if (window.validate.isCNPJ(txtCnpjCpf.val()))
                console.log('valido');
            else
                console.log('invalido');
        });*/
    });

}(window));