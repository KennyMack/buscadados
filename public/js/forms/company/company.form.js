'use strict';
(function (window) {
    $(document).ready( function() {
        var imgLogo = $('#img-upload');
        var txtLogoData = $('#imgdata');
        var imgFile = $('#image');
        var txtCnpjCpf = $('#cnpjcpf');
        var txthistory = $('#history');
        var totcharhistory = $('#totcharhistory');
        var divTxtCnpj = $('#divTxtCnpj');
        var helpTxtCnpj = $('#helpTxtCnpj');
        var divTxtCnpjInput = $('#divTxtCnpjInput');

        imgFile.change(function () {
            window.imageField.readURL(this, imgLogo, txtLogoData);
        });

        txtCnpjCpf.mask('99.999.999/9999-99');
        txtCnpjCpf.on('keypress', function (evt) {
            console.log('musoud');
            validateCNPJ(txtCnpjCpf.val());
            /*
            if (window.validate.isCNPJ(txtCnpjCpf.val())) {
                helpTxtCnpj.css({'display': 'none'});
                helpTxtCnpj.classList.add('has-error');
            }
            else {
                helpTxtCnpj.css({'display': 'block'});
            }

            console.log(evt);*/
        });

        txtCnpjCpf.focusout(function (evt) {
            validateCNPJ(txtCnpjCpf.val());
            /*if (window.validate.isCNPJ(txtCnpjCpf.val()))
                helpTxtCnpj.css({ 'display': 'none'});
            else
                helpTxtCnpj.css({ 'display': 'block'});*/
            console.log(evt);
        });

        function validateCNPJ(text) {
            if (window.validate.isCNPJ(text)) {
                helpTxtCnpj.css({'display': 'none'}).animate(2000);
                divTxtCnpj.removeClass('has-error');
                divTxtCnpjInput.removeClass('has-error');

                return true;
            }
            else {
                helpTxtCnpj.css({'display': 'block'}).animate(2000);
                divTxtCnpj.addClass('has-error');
                divTxtCnpjInput.addClass('has-error');
            }
            return false;
        }

        txthistory.on('keypress', function (event) {
            totcharhistory.empty().append((txthistory.val().length));
        });

        totcharhistory.empty().append((txthistory.val().length));


    });

}(window));