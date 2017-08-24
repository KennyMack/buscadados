'use strict';

(function (window) {
    function formatField(input, mask, event) {
        var isMask = false;

        var value = event.keyCode;
        var exp = /\-|\.|\/|\(|\)| /g;
        var onlyNumbers = input.value.toString().replace(exp, '');

        var position = 0;
        var newValue='';
        var maskLength = onlyNumbers.length;

        if (Number(value) !== 8) {
            for(var i=0; i<= maskLength; i++) {
                isMask = ((mask.charAt(i).toString() === '-') ||
                          (mask.charAt(i).toString() === '.') ||
                          (mask.charAt(i).toString() === '/'));

                isMask = isMask || ((mask.charAt(i).toString() === '(') ||
                    (mask.charAt(i).toString() === ')') ||
                    (mask.charAt(i).toString() === ' '));

                if (isMask) {
                    newValue += mask.charAt(i);
                    maskLength++;
                } else {
                    newValue += onlyNumbers.charAt(position);
                    position++;
                }
            }
            input.value = newValue;
            return true;
        }else {
            return true;
        }
    }

    function formatText(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;

    }

    window.format = {
        formatField: formatField,
        formatText: formatText
    }
}(window));