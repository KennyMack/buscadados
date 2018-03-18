'use strict';
(function (window) {
    $(document).ready( function() {
        var txtpostalnumber = $('#postalnumber');
        var txtcellphone = $('#cellphone');
        var txtphone = $('#phone');
        var modal = $('#modal-form');

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
        var changed = false;
        txtpostalnumber.change(function () {
            console.log($(this).val());
            changed = true;
        });

        txtpostalnumber.on('keypress', function () {
            console.log($(this).val());
            changed = true;
        });

        txtpostalnumber.focusout(function (ee) {
            console.log($(this).val());
            if (changed) {
                changed = false;
                modal.toggle();
                $.getJSON("https://viacep.com.br/ws/" + $(this).val().replace(/_/g, '0') + "/json", function (result) {
                    if (!("erro" in result)) {
                        console.log(result);
                        $('#address').val(result['logradouro']);
                        $('#district').val(result['bairro']);
                        var stateId = $('#state_id');

                        var states = $('#state_id option');
                        console.log(states);
                        for (var i = 0; i < states.length; i++) {
                            if (states[i].dataset.initials === result['uf']) {
                                states[i].selected = true;
                                stateId.change();
                                break;
                            }
                        }
                        if (stateId.val() !== ' ' &&
                            stateId.val() !== '-1') {

                            window.setTimeout(function () {
                                var cities = $('#city_id option');
                                console.log('cities');
                                console.log(cities);
                                console.log(result['localidade'].toString().toUpperCase());
                                for (i = 0; i < cities.length; i++) {
                                    if (cities[i].innerText.toUpperCase() === result['localidade'].toString().toUpperCase()) {
                                        cities[i].selected = true;
                                        break;
                                    }
                                }
                                modal.toggle();
                            }, 1500);
                        }
                        else
                            modal.toggle();
                        if (result['logradouro'].toString() !== '')
                            $('#number').focus();
                        else
                            $('#address').focus();
                    }
                    else
                        modal.toggle();
                });
            }
        });
    });

}(window));
