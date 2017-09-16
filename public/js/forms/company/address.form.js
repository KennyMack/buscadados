'use strict';
(function (window) {
    $(document).ready( function() {
        var txtpostalnumber = $('#postalnumber');
        var txtcellphone = $('#cellphone');
        var txtphone = $('#phone');

       /* txtphone.on('keypress', function (event) {
            if(window.validate.isInteger(event)){
                event.returnValue = false;
                return false;
            }
            return window.format.formatField(this, '(19) 0000#-0000', event);
        });*/

        txtcellphone.mask("(99) 99999-9999");
        txtphone.mask("(99) 9999-9999");
        txtpostalnumber.mask("99999-999");


        /*txtpostalnumber.on('keypress', function (event) {
            // Backspace, tab, enter, end, home, left, right
            // We don't support the del key in Opera because del == . == 46.
            var controlKeys = [8, 9, 13, 35, 36, 37, 39];
            // IE doesn't support indexOf
            var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
            // Some browsers just don't raise events for control keys. Easy.
            // e.g. Safari backspace.
            if (!event.which || // Control keys in most browsers. e.g. Firefox tab is 0
                (49 <= event.which && event.which <= 57) || // Always 1 through 9
                (48 == event.which && $(this).attr("value")) || // No 0 first digit
                isControlKey) { // Opera assigns values for control keys.
                return;
            } else {
                event.preventDefault();
            }
            return window.format.formatField(this, '00000-000', event);
        });*/

        /*txtpostalnumber.on('keyup', function (event) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        });*/

        /*txtpostalnumber.on('keypress', function (event) {
            console.log(event);
            if(window.validate.isInteger(event)){
                event.returnValue = false;
                return false;
            }
            return window.format.formatField(this, '00000-000', event);
        });*/

        /*txtpostalnumber.on('blur', function () {
            if (window.validate.isCEP(txtpostalnumber.val()))
                console.log('valido');
            else
                console.log('invalido');
        })*/
    });

}(window));
