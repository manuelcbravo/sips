<x-modal.modal id="ModalAfTodo" size="modal-xs" nombretitulo="tituloAf">
    <x-slot name="titulo"> A.F. </x-slot>
    <x-slot name="body">
        <p class="mensaje">Mensaje pendiente</p>
        <div class="list-group list-group-flush list-group-no-gutters">
            <div class="list-group-item crear">
              <div class="row align-items-center">
                <div class="col">
                  <p>Crear Application Form </p>
                </div>
                <div class="col-auto">
                  <button class="btn btn-primary btn-af crear" data-url="" data-fun="get_new_af">Crear</button>
                </div>
              </div>
            </div>
            <div class="list-group-item enviar">
              <div class="row align-items-center">
                <div class="col">
                  <p>Enviar url del A.F. por correo electrónico </p>
                </div>
                <div class="col-auto">
                  <button class="btn btn-primary btn-af enviar" data-url="" data-fun="send_af">Enviar</button>
                </div>
              </div>
            </div>
            <div class="list-group-item url">
              <div class="row align-items-center">
                <div class="col">
                  <p>Copiar url para envio por mensaje o whatadpp</p>
                </div>
                <div class="col-auto">
                    <div class="url">
                        <div class="input-group input-group-merge">
                            <input type="text" id="modalaf" class="form-control url" value="" readonly>
                  
                            <a class="js-clipboard input-group-append input-group-text" href="javascript:;" data-bs-toggle="tooltip" title="Copy to clipboard!"
                               data-hs-clipboard-options='{
                                 "type": "tooltip",
                                 "successText": "Copiado!",
                                 "contentTarget": "#modalaf",
                                 "container": "#ModalGenerar"
                               }'>
                              <i class="bi-clipboard"></i>
                            </a>
                          </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="list-group-item ver">
                <div class="row align-items-center">
                  <div class="col">
                    <p>Ver Application Form </p>
                  </div>
                  <div class="col-auto">
                    <button class="btn btn-primary btn-af ver" data-url="" data-fun="see_af">Ver</button>
                  </div>
                </div>
              </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
        </div>
    </x-slot>
    @push('js_modulo')
        
    $("table").on("click","[data-bs-target='#ModalAfTodo']",function(){
        let modal = $(this).data('bs-target')
        $('#ModalTratamientos').modal('hide')
        $(modal).modal('show')
        let url = $(this).data('url')
        HSCallGet.init(url,get_af)
        delete HSCore.components.HSClipboard.getItems()[0]
        HSCore.components.HSClipboard.init('.js-clipboard')
    })

    const get_af = (data) => {
        if(data.respuesta) {
            fill_data(data.tratamiento, data.aplicacion);
        }else{
            errorSwal('Error',data.mensaje)
        }
    }
    $("body").on("click",".btn-af",function(){
        let url = $(this).data('url')
        let func = $(this).data('fun')
        HSCallGet.init(url,eval(func))
    })
    
    const get_new_af = (data) => {
        if(data.respuesta) {
            tata.success('Éxito', "A.F. generado correctamente");
            fill_data(data.tratamiento, data.aplicacion);
        }else{
            errorSwal('Error',data.mensaje)
        }
    }

    const send_af = (data) => {
        //funcion para enviar correo
    }
    
    const see_af = (data) => {
        //funcion para ver el af

    }

    const opciones_af = (data) => {
        if(!data){
          console.log('aqui2')
            $('.url, .enviar, .ver').hide();
        }else{
            if(data.id_cat_estatus_aforms == 1){
                $('.crear, .ver').hide();
                $('.enviar, .url').show();
            }
            if(data.id_cat_estatus_aforms > 3){
                $('.url, .enviar, .crear').hide();
                $('.ver').show();
            }
        }
    }

    const fill_data = (data, aplicacion) => {
        delete HSCore.components.HSClipboard.getItems()[0]
        $('.crear').data('url',`{{ url('af_new') }}/${data.id_lead}/${data.id_oportunidad ??0 }/${data.id_tbl_tratamientos}`);
        $('#modalaf').val(`{{env('APP_PACIENTE')}}tratamiento/af/${aplicacion.api_token}`);
        $('.enviar').data('url',`{{ url('send_af') }}/${data.id_tbl_application_forms}`);
        $('.ver').data('url',`{{ url('look_af') }}/${data.id_tbl_application_forms}`);
        HSCore.components.HSClipboard.init('.js-clipboard')
        opciones_af(aplicacion)
    }
    @endpush
</x-modal.modal>