/**
 * *Archivo JS de administración
 */
$ = jQuery.noConflict();

$(document).ready(function () {
    $('#enviar').on('click', function (e) {
        e.preventDefault();
        const nombre = $('#nombre').val();
        console.log(nombre);

        $.ajax({
            url: lesdata.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'les_crud_table',
                nonce: lesdata.seguridad,
                nombre: nombre,
                tipo: 'add'
            },
            success: function (res) {
                console.log('Datos insertados correctamente');

            },
            error: function (xhr, status, error) {
                // Callback que se ejecuta cuando se produce un error en la solicitud
                console.error('Ocurrió un error en la solicitud:', error);
                console.log(xhr);
                console.log(status);
            }
        })
    })
    
})