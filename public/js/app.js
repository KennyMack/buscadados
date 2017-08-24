'use strict';


window.getUrlQryParams = function() {
    var queries = {};
    var urlParams = document.location.search.substr(1).split('&') || [];
    if (urlParams.length > 0) {

        urlParams.map(function(q){
            var i = q.split('=');
            if(q)
                queries[i[0].toString()] = i[1].toString();
        });
    }

    return queries;
};
