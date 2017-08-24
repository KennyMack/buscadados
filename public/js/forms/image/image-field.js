'use strict';

(function (window) {
    function readURL(input, img, inputData) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                img.attr('src', e.target.result);
                inputData.val(e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    window.imageField = {
        readURL: readURL
    }
}(window));
