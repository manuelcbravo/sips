<x-modal.modal id="ModalFotos" size="modal-xl" nombretitulo="tituloFoto">
    <x-slot name="titulo"> Fotos </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormFotos" id="FormFotos" method="POST" >
            <input type="hidden" id="id_articulo" name="id_articulo" value="">
            <br><br>
            <div class="row">
                <div class="col-sm-12">
                    <p style="text-align:center;">
                        <label class="avatar avatar-xxl avatar-circle avatar-circle profile-cover-avatar" for="avatarUploader">
                            <img id="avatarImg" class="avatar-img" src="{{ asset('assets') }}/img/160x160/img2.jpg" alt="Image Description">
                            <button class="avatar-status avatar-status-primary" id="btn_img" style="width: 2rem!important; height: 2rem!important; bottom: 0.2rem!important; right: 0.2rem!important">
                                <i class="bi-plus-lg"></i>
                                <input type="file" class="js-file-attach form-attachment-btn-label" id="image" name="image" accept="image/png, image/gif, image/jpeg, image/jpg">
                            </button>
                        </label>
                    </p>
                </div>
            </div>

            <div id="fotos_list" class="row gx-2 gx-lg-3"></div>

            <div class="d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')

        $("table").on("click","[data-bs-target='#ModalFotos']",function(){
            let url = $(this).data('url')
            let id = $(this).data('id')
            clear($($(this).data('bs-target')))
            HSCallGet.init(url,get_fotos)
            $("#ModalFotos #id_articulo").val(id)
        })

        const get_fotos = (data) =>{
            let titulo = '';
            $.each(data.articulo, function(index, value) {
                if(index === 'articulo' || index === 'descripcion') {
                    if(value){titulo += value + ' - ';}
                }
            });
            titulo = titulo.slice(0, -2);
            $('#tituloFoto').text('Artículo: ' + titulo);
            fotos_list(data);
        }

        $("#btn_img").change(function(){
            var fd = new FormData();
            var files = $('#image')[0].files[0];
            fd.append('file',files);
            fd.append('id_articulo', $("#ModalFotos #id_articulo").val());
            $.ajax({
                url: '{{ url('articulosFoto') }}',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                loading();
            },
                success: function(data){
                    close_loading()
                    if(data.respuesta){
                        $('#ModalFotos').modal('hide');
                        tata.success('Éxito', data.mensaje);
                    }else{
                        errorSwal('Error','Algo salio mal')
                    }
                },
                error: function(data) {
                    close_loading()
                    errorSwal('Error',data);
                }
            });
        });

        function fotos_list(data){
            $("#fotos_list").empty();
            if (data.fotos.length >0){
                var valor_anterior;
                $.each(data.fotos, function(index, value) {
                    if((index > 0 && valor_anterior != value.tipo) ||  index == 0) {
                        $('#fotos_list').append(`<div class="col-12"> ${value.tipo}</div>`);
                    }
                    $('#fotos_list').append(`
                    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                        <div class="gallery">
                            <a class="gallery-item rounded-3">
                                <img src="documentos/` + value.direccion+ `" height="200">
                            </a>
                        </div>
                    </div>`)
                    valor_anterior = value.nombre_tipo;
                });
            }else{
                    $('#fotos_list').append(
                    `<div class="col-12 text-center p-4">
                        <img class="mb-3" src="{{ asset('assets') }}/svg/illustrations-light/oc-error.svg" alt="Image Description" style="width: 7rem;">
                        <p class="mb-0">No hay fotos para mostrar</p>
                    </div>`);
            }
        }
    @endpush
</x-modal.modal>
