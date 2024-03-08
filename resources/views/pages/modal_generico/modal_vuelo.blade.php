<x-modal.modal id="ModalVuelo" size="modal-xl" nombretitulo="tituloVuelo">
    <x-slot name="titulo"> Leads </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormVuelo" id="FormVuelo" method="POST" action="{{ route('lead_vuelos.store') }}" data-js="success_vuelo">
            <input type="hidden" id="{{ $inputs['vuelo']->id }}" name="{{ $inputs['vuelo']->id }}" value="">
            <input type="hidden" id="{{ $inputs['vuelo']->id_lead }}" name="{{ $inputs['vuelo']->id_lead }}" value="">
            <input type="hidden" id="{{ $inputs['vuelo']->id_grupo }}" name="{{ $inputs['vuelo']->id_grupo }}" value="">
   

            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['vuelo']->aerolinea }}" titulo="Aerolínea" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['vuelo']->no_vuelo }}" titulo="Número de vuelo" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['vuelo']->puerta }}" titulo="Puerta de salida" holder="" required="true" options='' validationclass='' error=''></x-form.input>

                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['vuelo']->asiento }}" titulo="Asiento" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="{{ $inputs['vuelo']->id_aeropuerto_salida }}" titulo="Aeropuerto" required="true" multiple='' class='medio_contacto'/>
                </div>
                <div class="col-sm-4">
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="{{ $inputs['vuelo']->tipo_vuelo }}" titulo="Tipo de vuelo" required="true" multiple='' class='medio_contacto'/>
                </div>
                <div class="col-sm-4">
                    <label class="form-label col-12">Fecha y hora de salida</label>
                    <input type="text" class="js-flatpickr form-control flatpickr-custom" placeholder="Seleccione..."
                           data-hs-flatpickr-options='{
                         "dateFormat": "d/m/Y H:i",
                         "enableTime": true,
                         "static": true
                       }' id="{{ $inputs['vuelo']->fecha_salida }}" name="{{ $inputs['vuelo']->fecha_salida }}">
                </div>
                <div class="col-sm-4">
                    <label class="form-label col-12">Fecha y hora de llegada</label>
                    <input type="text" class="js-flatpickr form-control flatpickr-custom" placeholder="Seleccione..."
                           data-hs-flatpickr-options='{
                         "dateFormat": "d/m/Y H:i",
                         "enableTime": true,
                         "static": true
                       }' id="{{ $inputs['vuelo']->fecha_llegada }}" name="{{ $inputs['vuelo']->fecha_llegada }}">
                </div>
            </div>

            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.input tipo="text" id="{{ $inputs['vuelo']->precio }}" titulo="Precio" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>
                <x-slot name="segundo">
                    <label for="basicFormFile" class="js-file-attach form-label"
                        data-hs-file-attach-options='{
                        "textTarget": "[for=\"customFile\"]"
                        }'>Imagen boleto</label>
                    <input class="form-control" type="file" id="{{ $inputs['vuelo']->id_boleto_imagen }}" name="{{ $inputs['vuelo']->id_boleto_imagen }}">
                </x-slot>
            </x-form.input-double>

            <div class="mt-3">
                <x-form.text-area id="{{ $inputs['vuelo']->comentario }}" titulo="Comentario" holder="Escribe el comentario" required="true"/>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
        <table class="table table-borderless table-thead-bordered">
            <thead class="thead-light">
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Aerolinea</th>
                <th scope="col">Número de vuelo</th>
                <th scope="col">Asiento</th>
                <th scope="col">Estatus</th>
                <th scope="col">Comenatario</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody id="table_vuelo">
            </tbody>
        </table>
    </x-slot>
    @push('js_modulo')
        HSCore.components.HSFlatpickr.init('.js-flatpickr')

        $("table").on("click","[data-bs-target='#ModalVuelo']",function(){
            $.each(tom_select, function(index, value){
                if(value.inputId != 'datatableEntries'){
                    tom_select[index].clear()
                }
            })
            clear($($(this).data('bs-target')))
            let url = $(this).data('url')
            let lead = $(this).data('lead')
            let grupo = $(this).data('grupo')
            $('#{{ $inputs['vuelo']->id_lead }}').val(lead);
            $('#{{ $inputs['vuelo']->id_grupo }}').val(grupo);
            HSCallGet.init(url+"/"+lead+"/"+grupo,get_vuelo)
        })

        const get_vuelo = (data) => {
            if(data.respuesta) {
                $('#tituloVuelo').text('VUELO DE: ' + data.nombre);
                vuelo_lead(data.vuelos);
            }
        }

        const success_vuelo = (data) => {
            if(data.respuesta) {
                $('#ModalVuelo').modal('hide')
                tata.success('Éxito', data.mensaje);
                vuelo_lead(data.vuelo);
            }
        }

        const vuelo_lead = (data) => {
            $('#table_vuelo').empty();
            if(data.length == 0){
                $('#table_vuelo').append(`<tr><th scope="row" colspan="6" style="text-align:center;"> No hay vuelo </th></tr>`);
            }else{
                $.each(data, function (index, value) {
                    let btn = 'Sin opciones';
                    if(value.estatus == 1){
                        btn = `<button class="btn btn-xs btn-success edt-v" data-url="{{ url('lead_vuelos') }}/${value.id}/edit"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-xs btn-warning rmv-can" data-id="${value.id}" data-url="{{ url('lead_vuelos_cancel') }}/${value.id}"><i class="bi bi-x-octagon"></i></button>
                        <button class="btn btn-xs btn-danger rmv-vuel" data-id="${value.id}" data-url="{{ url('lead_vuelos') }}/${value.id}"><i class="bi bi-trash3"></i> </button>`;
                    }
                    let btn_imagen = '';
                    if(value.id_boleto_imagen){
                        btn_imagen = '<button class="btn btn-primary btn-xs verdoc" data-arc="documentos/'+ value.id_boleto_imagen +'"><i class="bi bi-image"></i> </button>'
                    }
                    $('#table_vuelo').append(`<tr>
                        <td class="text-dark font-weight-bold"> ${btn_imagen} ${ moment(value.fecha_llegada).format("hh:mm A DD/MM/YYYY") }</td>
                        <td>${value.aerolinea}</td>
                        <td>${none(value.no_vuelo)}</td>
                        <td>${value.asiento}</td>
                        <td>${((value.estatus == 1)? 'Activo' : 'Cancelado')}</td>
                        <td>${none(value.comentario)}</td>
                        <td>
                            `+btn+`
                        </td>
                    </tr>`);
                })
            }
        }

        $("table").on("click","button.rmv-vuel",function(){
            HSCallDelete.init($(this),del_vuelo)
        })
        
        $("table").on("click","button.edt-v",function(){
            let url = $(this).data('url')
            clear($('#ModalVuelo'))
            HSCallGet.init(url,get_vuel)
        })

        const get_vuel = (data) =>{
            if(data.respuesta){
                $.each(data.vuelo, function(index, value) {
                    if(index === '{{ $inputs['vuelo']->id_aeropuerto_salida }}' || index === '{{ $inputs['vuelo']->tipo_vuelo }}' ) {
                        const select = tom_select.find(element => element.inputId == index);
                        select.setValue([value])
                    }else if(index === '{{ $inputs['vuelo']->id_boleto_imagen }}'){
                    
                    }else{
                        $('#ModalVuelo #'+index).val(value);
                    }
                });
            }
        }
        const del_vuelo = (data) =>{
            if(data.respuesta){
                tata.success('Éxito', data.mensaje);
                vuelo_lead(data.vuelos);
            }
        } 

        $("table").on("click","button.rmv-can",function(){
            let url = $(this).data('url')
            Swal.fire({
                title: '¿Desea poner este boleto cancelado?',
                text: "El registro del boleto pasara a cancelado.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    HSCallGet.init(url,del_vuelo)
                }
            })
        })
    @endpush
</x-modal.modal>