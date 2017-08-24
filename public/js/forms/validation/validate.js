'use strict';

(function (window) {
    function isInteger(e) {
        if (e.keyCode < 48 || e.keyCode > 57){
            e.returnValue = false;
            return false;
        }
        return true;
    }

    function isInArray(value, array) {
        return (array||[]).indexOf(value) > -1;
    }

    function isCNPJ(value) {
        var multplicator = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        var dig1 = 0;
        var dig2 = 0;

        var exp = /\.|\-|\//g;
        value = value.toString().replace(exp, '');
        var digit = Number(value.charAt(12)+value.charAt(13));

        for(var i = 0; i< multplicator.length; i++){
            dig1 += (i > 0 ? (value.charAt(i-1) * multplicator[i]):0);
            dig2 += value.charAt(i) * multplicator[i];
        }
        dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
        dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));

        return !(((dig1*10)+dig2) !== digit);
    }

    function isCEP(value) {
        var exp = /\d{5}\-\d{3}/;
        return exp.test(value);
    }

    window.validate = {
        isInteger: isInteger,
        isCNPJ: isCNPJ,
        isInArray: isInArray,
        isCEP: isCEP
    }
}(window));
