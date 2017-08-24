'use strict';

(function (window) {
    function _get(url, callback) {
        return $.get(window.BASE_URL + url, callback);
    }

    window.request = {
      _get: _get
    };
}(window));
