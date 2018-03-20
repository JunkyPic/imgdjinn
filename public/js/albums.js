$(document).ready( function () {
    var iId = [];
    var album_delete_btn_delete = 0;
    var route = $('#album__delete_route').val();

    $('#album__delete_btn').on('click', function () {

        $('#album__delete').toggleClass('img-d-black-border');

        if($(this).hasClass('btn-danger')) {
            album_delete_btn_delete = 1;
            $(this).html('Submit');
            $(this).removeClass('btn-danger').addClass('btn-success');
        } else {
            album_delete_btn_delete = 0;
            $(this).html('Delete');
            $(this).removeClass('btn-success').addClass('btn-danger');
            if(iId.length) {
                deleteAlbums(iId, route);
            }
        }
    });

    $('.album__select').on('click', function (e) {
        if(album_delete_btn_delete === 1) {
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

function deleteAlbums(iId, route) {
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
                    $('#' + value).parent().remove();
                });
            }
        }
    });
}