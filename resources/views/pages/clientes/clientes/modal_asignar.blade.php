<x-modal.modal id="ModalAsignar" size="modal-xs" nombretitulo="tituloAsignar">
    <x-slot name="titulo"> ASIGNAR:  </x-slot>
    <x-slot name="body">
        <h4 class="warn text-black"></h4>
        <form class="js-validate needs-validation" novalidate="" data-name="asignarUsuarios" id="asignarUsuarios" method="POST" action="{{ url('cliente_asignarP') }}" data-js="success_asignar">
            <input type="hidden" id="{{ $inputs['asignar']->id_cliente }}" name="{{ $inputs['asignar']->id_cliente }}" value="">

            <x-form.select id="{{ $inputs['asignar']->id_asesor }}" titulo="Asesor" required="true" multiple='true' class=''/>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')
        $("table").on("click","[data-bs-target='#ModalAsignar']",function(){
            $('.warn').html('')
            let url = $(this).data('url')
            let uuid = $(this).data('uuid')
            clear($($(this).data('bs-target')),tom_select)
            $('#ModalAsignar #{{ $inputs['asignar']->id_cliente }}').val(uuid)
            HSCallGet.init(url,get_asesor)
        })

        const get_asesor = (data) =>{
            if(data.respuesta){
                let texto = 'Este cliente tiene los siguientes asesores asignados: <br>';
                $('#tituloAsignar').text('ASIGNAR ASESOR A: ' + data.nombre);
                $('.warn').html('');

                const asesor = ((data.asesor) ? data.asesor.id_asesor.split(",") : []);
                const resultado = asesores.filter(id => asesor.includes(id));

                const select = tom_select.find(element => element.inputId == '{{ $inputs['asignar']->id_asesor }}');
                select.setValue(asesor)

                if(data.cantidad > 0){
                    $.each(resultado, function(index, value) {
                        texto += value.name + ' ' + value.apellidos
                    })
                    texto += '<br>'
                    $('.warn').html(texto)
                }
            }
        }

        const success_asignar = (data) => {
            if(data.respuesta) {
                $('#ModalAsignar').modal('hide');
            }
        }
    @endpush
</x-modal.modal>