moment.locale('es');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const formatBytes = (bytes, decimals = 2) => {
    if (!+bytes) return '0 Bytes'

    const k = 1024
    const dm = decimals < 0 ? 0 : decimals
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

    const i = Math.floor(Math.log(bytes) / Math.log(k))

    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
}

const clear = (modal, tom_select) =>{
    form = modal.find('form');
    form[0].reset();
    form.find('input[type=hidden]').val('');
    // form.find('.js-select').val('').trigger('change');
    // $('.custom-empty .js-select .ts-control').empty();
    // $('.custom-empty .js-select .ts-control').append(`<option value="">Seleccione...</option>`);
    modal.find('.was-validated').removeClass("was-validated")
    form.find('.indeterminate-checkbox').prop("checked", false);
    if(tom_select != 0){
        $.each(tom_select, function(index, value){
            var input = value.inputId.substring(0,3);
            if(value.inputId != 'datatableEntries' && input != 'sel_'){
                tom_select[index].clear()
            }
        })
    }
}

const HSCallDelete = {
    init(t, e ) {
        Swal.fire({
            title: '¿Desea eliminar?',
            text: "Si elimina este registro no se podrá recuperar",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                let action = t.attr('data-url');
                let token = jQuery('meta[name="csrf-token"]').attr('content');
                let id = t.attr('data-id');
                $.ajax({
                    type: "delete",
                    url: action,
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    beforeSend: function(){
                        loading();
                    },
                    success: function(data) {
                        close_loading()
                        e(data);
                    },
                    error: function(data) {
                        close_loading()
                        errorSwal('Error',data);
                    }
                });
            }
        })
    }
}

const HSCallStore = {
    init(t, e,) {
        $.ajax({
            url: t.form.action,
            type : t.form.method,
            data : $('#'+t.form.dataset.name).serialize(),
            dataType: 'json',
            beforeSend: function(){
                loading()
            },
            success : function(data) {
                close_loading()
                e(data)
            },
            error: function (err) {
                close_loading()
                errorSwal('Error',err);
            },
        });
    },image(t, e,) {
        var form_data = new FormData($('#'+t.form.dataset.name)[0]);
        $.ajax({
            url: t.form.action,
            type : t.form.method,
            data : form_data,
            processData: false,
            contentType: false,
            beforeSend: function(){
                loading()
            },
            success : function(data) {
                close_loading()
                e(data)
            },
            error: function (err) {
                close_loading()
                errorSwal('Error',err);
            },
        });
    }
}

const HSCallGet = {
    init(t, e) {
        $.ajax({
            type: "get",
            url: t,
            beforeSend: function(){
                loading()
            },
            success: function(data){
                close_loading();
                e(data)
            },
            error: function (data){
                close_loading();
                errorSwal('Error',data);
            }
        });

    }
}

const none = (txt) => {
    return (txt)? txt : 'N/A' ;
}

const dinero = (txt) => {
    return (txt)? parseFloat(txt).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') : 'N/A' ;
}

const dinero_dash = (txt) => {
    return (txt)? parseFloat(txt).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') : '0.00' ;
}

const fecha = (txt) => {
    return (txt)? moment(txt).format('DD/MM/YYYY') : 'N/A' ;
}

const loading = () => {
    Swal.fire({
        title: 'Cargando...',
        willOpen () {
            Swal.showLoading()
        },
        didClose () {
            Swal.hideLoading()
        },
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
    });
}

const close_loading = () => {
    Swal.close()
}

const errorSwal = (title,texto) => {
    var texto = (texto)? ((texto.responseText)? texto.responseText : texto ) : 'Algo salio mal, intente mas tarde.'
    var title = (title)?  title : 'Oops...'

    Swal.fire({
        icon: 'error',
        title: title,
        text: texto,
        confirmButtonColor: '#0d5afd'
    })
}

const warningSwal = (title,texto) => {
    var respuesta = (texto)?  texto: 'Algo salio mal, intente mas tarde.'
    var titulo = (title)?  title : 'Oops...'

    Swal.fire({
        icon: 'warning',
        title: titulo,
        text: respuesta,
        confirmButtonColor: '#0d5afd'
    })
}

const warningSwalHtml = (title,texto) => {
    var respuesta = (texto)?  texto: 'Algo salio mal, intente mas tarde.'
    var titulo = (title)?  title : 'Oops...'

    Swal.fire({
        icon: 'warning',
        title: titulo,
        html: respuesta,
        confirmButtonColor: '#0d5afd'
    })
}

const successSwal = (title,texto) => {
    var respuesta = (texto)?  texto: 'Algo salio mal, intente mas tarde.'
    var titulo = (title)?  title : 'Oops...'

    Swal.fire({
        icon: 'success',
        title: titulo,
        text: respuesta,
        confirmButtonColor: '#0d5afd'
    })
}
