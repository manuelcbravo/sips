<x-modal.modal id="ModalGenerar" size="modal-xs" nombretitulo="tituloGenerar">
    <x-slot name="titulo"> GENERAR CONTRASEÑA </x-slot>
    <x-slot name="body">
        <p class="page-header-text mb-2">Revisar que el correo sea correcto, si requiere editar, hagalo desde la opción editar.</p>
        <form class="js-validate needs-validation" novalidate="" data-name="GenerarUsuarios" id="GenerarUsuarios" method="POST" action="{{ url('lead/usuario') }}" data-js="success_usuario_generar">
            <input type="hidden" id="{{ $inputs['oportunidades']->id }}" name="{{ $inputs['oportunidades']->id }}" value="">

            <x-form.input-double >
                <x-slot name="primero">
                    <div class="mb-3">
                        <label class="form-label" for="{{ $inputs['leads']->correo }}">Correo electrónico</label>
                        <input type="text" class="form-control form-control-lg" name="{{ $inputs['leads']->correo }}" id="{{ $inputs['leads']->correo }}" readonly>
                    </div>
                </x-slot>
                <x-slot name="segundo">
                    <label class="form-label gen_cor"> </label>
                </x-slot>
            </x-form.input-double>
            <div class="url" style="display: none">
                <label class="form-label"> Copiar dirección</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="modalExample" class="form-control url" value="I am a modal exampleqwer" readonly>
          
                    <a class="js-clipboard input-group-append input-group-text" href="javascript:;" data-bs-toggle="tooltip" title="Copy to clipboard!"
                       data-hs-clipboard-options='{
                         "type": "tooltip",
                         "successText": "Copiado!",
                         "contentTarget": "#modalExample",
                         "container": "#ModalGenerar"
                       }'>
                      <i class="bi-clipboard"></i>
                    </a>
                  </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success btn-snd-g" style="margin-right: 4px"> <i class="bi-send-fill"></i> Enviar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')
        $("table").on("click","[data-bs-target='#ModalGenerar']",function(){
            delete HSCore.components.HSClipboard.getItems()[0]
            let uuid = $(this).data('uuid')
            let url = $(this).data('url')+'/'+uuid
            clear($($(this).data('bs-target')))
            $('#ModalGenerar #{{ $inputs['oportunidades']->id }}').val(uuid)
            HSCallGet.init(url,get_usuario_generar)
        })

        const get_usuario_generar = (data) => {
            if(data.respuesta) {
                if(!data.usuario){
                    $('.btn-snd-g').attr('disabled',true);
                }else{
                    generar_estatus(data.activado,data.api)
                    $('#ModalGenerar #{{ $inputs['leads']->correo }}').val(data.usuario)
                }
                $('#tituloGenerar').text('GENERAR USUARIO DE ' + data.nombre);
            }
        }

        const success_usuario_generar = (data) => {
            if(data.respuesta) {
                generar_estatus(2, data.api)
                tata.success('Éxito', "Correo enviado correctamente");
            }
        }

        const generar_estatus = (data,api) => {
            let texto;
            $('.btn-snd-g').attr('disabled',false);
            $('.url').hide();
            switch(data) {
                case 0:
                    texto = '<i class="bi-x-octagon text-danger"></i> El usuario no ha sido generado, puedes usar el boton enviar, para enviar un correo de activación';
                break;
                case 1:
                    $('.btn-snd-g').attr('disabled',true);
                    texto = '<i class="bi-check-lg text-success"></i> El usuario esta activo, puedes usar el boton enviar, para recuperar la contraseña';
                break;
                case 2:
                    $('.url').val('{{ ENV('APP_PACIENTE') }}activate/'+api).show();
                    HSCore.components.HSClipboard.init('.js-clipboard')
                    texto = '<i class="bi-exclamation-diamond text-warning"></i> Se ha enviado el correo de activación, puedes usar el boton enviar, para re-enviar un correo de activación';
                break;
            }

            $('.gen_cor').html(texto)
        }

        
    @endpush
</x-modal.modal>