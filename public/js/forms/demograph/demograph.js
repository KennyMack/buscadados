'use strict';

(function (window) {
    function clearCities(input) {
        input.empty();
        input.append(new Option('Cidade *', '-1'));
    }

    function setCityById(input, value) {
        input.val(value).change();
    }

    function loadCities(cbeCity, idCountry, idState, idCity) {
        var uri = '/api/country/' + idCountry + '/state/' + idState + '/cities';

        if (idState > -1) {
            window.request._get(uri, function (data) {
                try {
                    var citiesJson = data;
                    cbeCity.empty();
                    cbeCity.append(new Option('Cidade *', '-1'));
                    for (var i = 0, items = citiesJson.length; i < items; i++) {
                        cbeCity.append(new Option(citiesJson[i].name, citiesJson[i].id));

                    }

                    setCityById(cbeCity, idCity);
                }
                catch (e) {
                    console.log(e);
                }
            });
        }
        else
            clearCities(cbeCity);

    }
    
    window.demograph = {
        clearCities: clearCities,
        setCityById: setCityById,
        loadCities: loadCities
    };
}(window));