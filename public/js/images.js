$(document).ready( function () {
    var iId = [];
    var image_delete_btn_delete = 0;
    var route = $('#image__delete_route').val();


    $('#image__cancel_btn').on('click', function () {
        iId = [];

        var target = $('#image__delete_btn');
        if($('#image__delete').hasClass('img-d-black-border')) {
            $('#image__delete').removeClass('img-d-black-border')
        }

        var image_select =  $('.image__select');

        if(image_select.find('img').hasClass('img-d-black-border')) {
            image_select.find('img').removeClass('img-d-black-border');
        }

        if(target.hasClass('btn-success')) {
            image_delete_btn_delete = 0;
            target.html('Delete');
            target.removeClass('btn-success').addClass('btn-danger');
        }
    });

    $('#image__delete_btn').on('click', function () {

        $('#image__delete').toggleClass('img-d-black-border');

        if($(this).hasClass('btn-danger')) {
            image_delete_btn_delete = 1;
            $(this).html('Submit');
            $(this).removeClass('btn-danger').addClass('btn-success');
        } else {
            image_delete_btn_delete = 0;
            $(this).html('Delete');
            $(this).removeClass('btn-success').addClass('btn-danger');
            if(iId.length) {
                deleteImages(iId, route);
            }
        }
    });

    $('.image__select').on('click', function (e) {
        if(image_delete_btn_delete === 1) {
            e.preventDefault();
            var id = $(this).attr('id');

            if($(this).find('img').hasClass('img-d-black-border')) {
                iId.splice(iId.indexOf(id));
                $(this).find('img').removeClass('img-d-black-border');
            } else {
                iId.push($(this).attr('id'));
                $(this).find('img').addClass('img-d-black-border');
            }
        }
    })
});

function deleteImages(iId, route) {
    $.ajax({
        type: 'POST',
        url: route,
        data: { aliases: iId},
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
            if(data.hasOwnProperty('success') && data.success == true && data.hasOwnProperty('ids') && data.ids.length) {
                $.each(data.ids, function( index, value ) {
                    $('#' + value).parent().parent().remove();
                });
            }
        }
    });
}