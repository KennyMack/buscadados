'use strict';

(function (window) {
    $(document).ready( function() {
        var btnConfirm = $('#confirmOk');
        var btnCancel = $('#confirmCancel');
        var txtMessage = $('#confirmMessage');
        var formModal = $('#confirmModal');
        var btnRemove = $('button[name="remove_levels"]');

        function confirmDialog(message, callback) {
            var fClose = function () {
                formModal.modal('hide');
            };

            formModal.modal('show');
            txtMessage.empty().append(message);
            btnConfirm.on('click', callback);
            btnConfirm.on('click', fClose);
            btnCancel.one('click', fClose);
        }

        btnRemove.on('click', function (e) {
            var form = $(this).closest('form');
            e.preventDefault();
            confirmDialog('Confirma a exclusão ?', function () {
                form.trigger('submit');
            });

        });



    });
}(window));
