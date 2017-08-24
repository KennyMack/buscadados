'use strict';

(function (window) {
    $(document).ready( function() {
        var imgLogo = $('#img-upload');
        var txtLogoData = $('#imgdata');
        var imgFile = $('#image');
        var txtValue = $('#value');
        var cbeCategorydetail = $('#categorydetail_id');
        var txtDetail = $('#text-detail');
        var txtDetailContent = $('#text-det-value');

        cbeCategorydetail.change(function (value) {
            var minValue = Number($(this).find(':selected').data("min-value"));
            var maxValue = Number($(this).find(':selected').data("max-value"));

            var min = window.format.formatText(minValue.toFixed(2));
            var max = window.format.formatText(maxValue.toFixed(2));

            txtDetailContent.empty().append(
                min + ' e ' +
                max);

            if (cbeCategorydetail.val() > -1){
                txtDetail.css({
                    'opacity': '0',
                    'display': 'block'
                    })
                    .show()
                    .animate({
                        opacity: 1
                    });
            }
            else
                txtDetail.hide(250);
        });

        imgFile.change(function () {
            window.imageField.readURL(this, imgLogo, txtLogoData);
        });

        txtValue.maskMoney({
            symbol:'R$', // Simbolo
            decimal:',', // Separador do decimal
            precision:2, // Precisão
            thousands:'.', // Separador para os milhares
            allowZero:false, // Permite que o digito 0 seja o primeiro caractere
            showSymbol:false // Exibe/Oculta o símbolo
        });

        txtDetail.hide(250);
    });

}(window));
