'use strict';
(function (window) {
    $(document).ready( function() {
        var txtpostalnumber = $('#postalnumber');
        var txtphone = $('#phone');

        txtphone.on('keypress', function (event) {
            if(!window.validate.isInteger(event)){
                event.returnValue = false;
                return false;
            }
            return window.format.formatField(this, '(19) 0000#-0000', event);
        });


        txtpostalnumber.on('keypress', function (event) {
            if(!window.validate.isInteger(event)){
                event.returnValue = false;
                return false;
            }
            return window.format.formatField(this, '00000-000', event);
        });

        txtpostalnumber.on('blur', function () {
            if (window.validate.isCEP(txtpostalnumber.val()))
                console.log('valido');
            else
                console.log('invalido');
        })
    });

}(window));
