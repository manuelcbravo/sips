<x-modal.modal id="ModalSeguimiento" size="modal-xl" nombretitulo="tituloSeguimiento">
    <x-slot name="titulo"> Leads </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormSeguimiento" id="FormSeguimiento" method="POST" action="{{ route('seguimiento.store') }}" data-js="success_seguimiento">
            <x-form.text-area id="comentario" titulo="Comentario" holder="Escribe el comentario" required="true"/>
            <input type="hidden" id="id" name="id" value="">
            <input type="hidden" id="id_lead" name="id_lead" value="">
            <input type="hidden" id="id_oportunidad" name="id_oportunidad" value="">
            <input type="hidden" id="tabla" name="tabla" value="{{ $table }}">
            <x-form.input-double >
                <x-slot name="primero">
                    <label class="form-label col-12">Fecha y hora</label>
                    <input type="text" class="js-flatpickr form-control flatpickr-custom" placeholder="Seleccione..."
                           data-hs-flatpickr-options='{
                         "dateFormat": "d/m/Y H:i",
                         "enableTime": true,
                         "static": true
                       }' id="fecha" name="fecha">
                </x-slot>
                <x-slot name="segundo">
                    <x-form.select id="id_cat_medio_contactos" titulo="Medio de contacto" required="true" multiple='' class='medio_contacto'/>
                </x-slot>
            </x-form.input-double>

            <x-form.input-double >
                <x-slot name="primero">
                    <div class="form-check form-check-switch">
                        <input class="form-check-input" type="checkbox" value="1" id="contesto" name="contesto">
                        <label class="form-check-label btn-sm" for="contesto">
                        <span class="form-check-default" style="padding: 8px">
                            <i class="bi-x-lg"></i> No contesto
                        </span>
                        <span class="form-check-active" style="padding: 8px">
                            <i class="bi-check-lg me-2"></i> Si contesto
                        </span>
                        </label>
                    </div>
                </x-slot>
                <x-slot name="segundo">
                </x-slot>
            </x-form.input-double>

            <div class="my-4">
                <h4 class="card-header-title">Próximo contacto</h4>
                <p class="card-text fs-5">Agenda una interacción con tu lead llenando los siguientes campos. Al hacerlo, se programará automáticamente en tu calendario la próxima acción.</p>
            </div>
            <x-form.input-double >
                <x-slot name="primero">
                    <label class="form-label col-12">Fecha y hora del próximo contacto</label>
                    <input type="text" class="js-flatpickr form-control flatpickr-custom" placeholder="Seleccione..."
                           data-hs-flatpickr-options='{
                         "dateFormat": "d/m/Y H:i",
                         "enableTime": true,
                         "static": true
                       }' id="fecha_seguimiento" name="fecha_seguimiento">
                </x-slot>
                <x-slot name="segundo">
                    <x-form.text-area id="acuerdo" titulo="Acuerdo para el próximo contacto" holder="Escribe el acuerdo" required=""/>
                </x-slot>
            </x-form.input-double>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
            <table class="table table-borderless table-thead-bordered mt-3">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Medio de contacto</th>
                    <th scope="col">Contesto (si/no)</th>
                    <th scope="col">Comentario</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="table_seguimiento">
                </tbody>
            </table>
        </form>
    </x-slot>
    @push('js_modulo')
        HSCore.components.HSFlatpickr.init('.js-flatpickr')

        $("table").on("click","[data-bs-target='#ModalSeguimiento']",function(){
            clear($($(this).data('bs-target')),tom_select)
            let url = $(this).data('url')
            let uuid = $(this).data('uuid')
            let opor = $(this).data('opor')
            $('#ModalSeguimiento #id_lead').val(uuid)
            $('#ModalSeguimiento #id_oportunidad').val(opor)
            HSCallGet.init(url,get_seguimiento)
        })

        const get_seguimiento = (data) => {
            if(data.respuesta) {
                $('#tituloSeguimiento').text('SEGUIMIENTO DE : ' + data.nombre);
                seguimiento_lead(data.seguimiento);
            }
        }

        const success_seguimiento = (data) => {
            if(data.respuesta) {
                $('#ModalSeguimiento').modal('hide')
                tata.success('Éxito', data.mensaje);
                seguimiento_lead(data.seguimiento);
                if(datatable){
                    datatable.ajax.reload();
                }
            }
        }

        const seguimiento_lead = (data) => {
            $('#table_seguimiento').empty();
            if(data.length == 0){
                $('#table_seguimiento').append(`<tr><th scope="row" colspan="6" style="text-align:center;"> No hay seguimiento </th></tr>`);
            }else{
                $.each(data, function (index, value) {
                    $('#table_seguimiento').append(`<tr>
                        <td class="text-dark font-weight-bold">
                           ${ moment(value.fecha).format("hh:mm A DD/MM/YYYY") }
                        </td>
                        <td>${value.usuario}</td>
                        <td>${none(value.contacto)}</td>
                        <td>${((value.contesto)? 'SI':'NO')}</td>
                        <td>${none(value.comentario)}</td>
                    </tr>`);
                })
            }
        }
    @endpush
</x-modal.modal>
