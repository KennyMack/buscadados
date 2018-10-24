'use strict';

(function (window) {
    $(document).ready( function() {
        var imgLogo = $('#img-upload');
        var txtLogoData = $('#imgdata');
        var imgFile = $('#image');
        var txtValue = $('#value');
        var cbeCategory = $('#category_id');
        var cbeCategorydetail = $('#categorydetail_id');
        var txtDetail = $('#text-detail');
        var txtNameDetail = $('#name');
        var txtDescriptionDetail = $('#description');
        var txtDetailContent = $('#text-det-value');
        var btnAdd = $('#btnAdd');
        var btnRemove = $('#btnRemove');
        var imageBox = $('#imageBox');
        var btnImageBox = $('#btn-image-box');
        var count = Number($('#imageBox li').length) - 1;

        cbeCategory.change(function(e) {

        });


        btnAdd.click(function () {

            count = ((count + 1) + 9999);




            var field = '<li class="item-image"';
            field += 'id="btn-image-box-'+ count +'">';
            field += '<input type="hidden" name="imgdata[]" id="imgdata[]" data-index-image="' + count + '" />';
            field += '<label class="btn-image" for="image-' + count + '">';
            field += '<img src="' + window.BASE_URL +'/assets/img/category-no-image.png" alt="Image preview"';
            field += 'class="thumbnail center-thumbnail"';
            field += 'id="img-upload-'+ count +'"';
            field += 'style="max-width: 180px; max-height: 150px; min-height: 150px;">';
            field += '</label>';
            field += '<input class="inputfile" ';
            field += 'onchange="imageInputFile('+ count + ')"';
            field += ' type="file" id="image-' + count +'" name="image-' + count + '">';
            field += '<button class="btn btn-danger btn-xs"';
            field += 'id="btnRemove"';
            field += 'type="button"';
            field += 'style="margin-top: 5px"';
            field += 'onclick="removeItem('+count+'); return false;"';
            field += 'data-index-image="' + count + '">';
            field += '<span class="glyphicon glyphicon-trash"></span>';
            field += '</button>';
            field += '</li>';


            var btn = '<li class="item-image add"';
            btn += 'id="btn-add-box">';
            btn += '<div class="btn-add"';
            btn += 'id="btnAdd">';
            btn += '<i class="glyphicon glyphicon-plus"></i>';
            btn += '</div>';
            btn += '</li>';

            $(field).insertBefore('ul#imageBox>li:last');

            //imageBox.insertBefore(field);

            // btnAddBox.remove();

            //imageBox.append(btn);



        });

        btnRemove.click(function () {
            var imageIndex = $(this).data('index-image');

            if (Number(imageIndex) > 0)
                $('#btn-image-box-'+imageIndex).remove();
        });

        cbeCategorydetail.change(function (value) {
            var minValue = Number($(this).find(':selected').data("min-value"));
            var maxValue = Number($(this).find(':selected').data("max-value"));

            var max = window.format.formatText(maxValue.toFixed(2)) || 0;
            var min = window.format.formatText(minValue.toFixed(2)) || 0;

            console.log('minValue');
            txtDetailContent.empty().append(
                min + ' e ' +
                max);

            if (cbeCategorydetail.val() > -1){
                var selected = $('#category_id').find('option:selected');
                if (selected.length > 0) {
                    txtNameDetail.val($(this).find(':selected').text());
                    //txtNameDetail.attr('readonly', true);

                    txtDescriptionDetail.val($(this).find(':selected').data('description'));
                    //txtDescriptionDetail.attr('readonly', true);

                }
                txtDetail.css({
                    'opacity': '0',
                    'display': 'block'
                    })
                    .show()
                    .animate({
                        opacity: 1
                    });
            }
            else
                txtDetail.hide(250);
        });

        imgFile.change(function () {
            window.imageField.readURL(this, imgLogo, txtLogoData);
        });

        txtValue.maskMoney({
            symbol:'R$', // Simbolo
            decimal:',', // Separador do decimal
            precision:2, // Precisão
            thousands:'.', // Separador para os milhares
            allowZero:false, // Permite que o digito 0 seja o primeiro caractere
            showSymbol:false // Exibe/Oculta o símbolo
        });

        //txtDetail.hide(250);
    });

}(window));
