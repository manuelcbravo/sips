<x-modal.modal id="ModalPagosSeg" size="modal-xl" nombretitulo="tituloPagos">
    <x-slot name="titulo"> PAGOS </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormPago" id="FormPago" method="POST" action="{{ route('pago_compras.store') }}" data-js="success_pago_seguimientos">
            <input type="hidden" id="id" name="id" value="">
            <input type="hidden" id="id_compra" name="id_compra" value="">
            
            <div class="row peri">
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="folio" titulo="Folio pago" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <x-form.select id="id_pago_metodo" titulo="Método de pago" required="true" multiple='' class='metodo_pago'/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label col-12">Fecha y hora de pago</label>
                    <input type="text" class="js-flatpickr form-control flatpickr-custom" placeholder="Seleccione..."
                           data-hs-flatpickr-options='{
                         "dateFormat": "d/m/Y H:i",
                         "enableTime": true,
                         "static": true
                       }' id="fecha" name="fecha" required>                
                </div>
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="cantidad" titulo="Cantidad" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>

            <div class="row hibrido">
                <div class="col-sm-6 hib">
                    <x-form.input tipo="number" id="efectivo" titulo="Cantidad efectivo" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-6 hib">
                    <x-form.input tipo="number" id="banco" titulo="Cantidad banco" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                {{-- <div class="col-sm-6">
                    <x-form.select id="id_banco" titulo="Banco" required="" multiple='' class=''/>
                </div> --}}
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="clave_rastreo" titulo="Clave de rastreo" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>

            <x-form.input-double >
                <x-slot name="primero">
                    <label for="basicFormFile1" class="js-file-attach form-label"
                        data-hs-file-attach-options='{
                        "textTarget": "[for=\"customFile1\"]"
                        }'>Recibo de pago</label>
                    <input class="form-control" type="file" id="img_recibo" name="img_recibo">
                </x-slot>
                <x-slot name="segundo">
                    <label for="basicFormFile2" class="js-file-attach form-label"
                        data-hs-file-attach-options='{
                        "textTarget": "[for=\"customFile2\"]"
                        }'>Comprobante de pago</label>
                    <input class="form-control" type="file" id="img_comprobantes" name="img_comprobantes">
                </x-slot>
            </x-form.input-double>

            <div class="mt-3">
                <x-form.text-area id="comentario" titulo="Comentario" holder="Escribe el comentario" required=""/>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
        <table class="table table-borderless table-thead-bordered mt-4">
            <thead class="thead-light">
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Info pago</th>
                <th scope="col">Pago</th>
                <th scope="col">Comentario</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody id="table_seg_venta">
            </tbody>
        </table>
    </x-slot>
    @push('js_modulo')

    $("table").on("click","[data-bs-target='#ModalPagosSeg']",function(){
        clear($($(this).data('bs-target')), tom_select);
        let url = $(this).data('url')
        let id = $(this).data('id')

        $('#ModalPagosSeg #id_compra').val(id);
        HSCallGet.init(url+"/"+id,get_seg_venta)
    });

        HSCore.components.HSFlatpickr.init('.js-flatpickr')
        let pagos_pendientes;
        
        $('#ModalPagosSeg #efectivo').hide().attr('required',false);
        $('#ModalPagosSeg #banco').hide().attr('required',false);
        $('.hibrido').hide()

        const get_seg_venta = (data) => {
            if(data.respuesta) {
                $('#tituloPagos').text('PAGOS DE: ' + data.nombre);
                                
                pagos_lead(data.pagos);
            }
        }

        $('#ModalPagosSeg #id_periodo').change(function() {
            const id = $(this).val();
            let pago = 0;
            if(id == 'automatico'){
                if(pagos_pendientes.length > 0){
                    pago = pagos_pendientes[0].pendiente
                }
            }else{
                pago = pagos_pendientes.find((val) => val.id == id).pendiente
            }

            $('#ModalPagosSeg #cantidad').val(pago);
        })

        const success_pago_seguimientos = (data) => {
            if(data.respuesta) {
                $('#ModalPagosSeg').modal('hide')
                tata.success('Éxito', data.mensaje);
                pagos_lead(data.pagos);
                datatable.ajax.reload();
                if (typeof movimientos_pagos !== 'undefined') {
                    movimientos_pagos(data);
                }
                
                if (typeof reload !== 'undefined') {
                    reload();
                }
            }else{
                warningSwal('Advertencia', data.mensaje ?? 'Error intente mas tardes')

            }
        }

        $('#ModalPagosSeg #id_pago_metodo').change(function() {
            const id = $(this).val();
            $('.hibrido').hide()
            $('#ModalPagosSeg #efectivo').hide().attr('required',false);
            $('#ModalPagosSeg #banco').hide().attr('required',false);
            $('#ModalPagosSeg #id_banco').hide().attr('required',false);
            
            if(id == 8 || id == 7 || id == 2 || id == 3  || id == 4 ){
                $('.hibrido').show()
                $('.hib').hide()
                if(id == 8 || id == 7){
                    $('.hib').show()
                    $('#ModalPagosSeg #efectivo').show().attr('required',true);
                    $('#ModalPagosSeg #banco').show().attr('required',true);
                    $('#ModalPagosSeg #id_banco').show().attr('required',true);
                }
                if(id == 2){
                    $('#ModalPagosSeg #id_banco').show().attr('required',true);
                }
            }
        })

        const pagos_lead = (data) => {
            $('#table_seg_venta').empty();
            if(data.length == 0){
                $('#table_seg_venta').append(`<tr><th scope="row" colspan="5" style="text-align:center;"> No hay pagos </th></tr>`);
            }else{
                $.each(data, function (index, value) {
                    let btn = 'Sin opciones';
                let color = 'text-danger';
                if(value.id_pago_concepto != 7){
                    color = '';
                    btn = `<a class="btn btn-xs btn-success" href="{{ url('creditosR') }}/${value.id}" target="_blank"><i class="bi bi-ticket"></i></a>
                        @if(Auth::user()->hasAnyRoleId([0,1,2]))<button class="btn btn-xs btn-danger rmv-pago" data-id="${value.id}" data-url="{{ url('pago_compras') }}/${value.id}"><i class="bi bi-trash3"></i> </button>@endif`;
                    }
                    
                    let btn_imagen = '';
                    if(value.img_comprobantes){
                        btn_imagen = '<button class="btn btn-primary btn-xs verdoc" data-arc="{{url('documentos')}}/'+ value.img_comprobantes +'"><i class="bi bi-image"></i> </button>'
                    }

                    let btn_recibo = '';
                    if(value.img_recibo){
                    btn_recibo = '<button class="btn btn-primary btn-xs verdoc" data-arc="{{url('documentos')}}/'+ value.img_recibo +'"><i class="bi bi-image"></i> </button>'
                }
                    $('#table_seg_venta').append(`<tr>
                        <td class="text-dark font-weight-bold"> ${btn_imagen} ${ moment(value.fecha).format("hh:mm A DD/MM/YYYY") }</td>
                        <td class="${color}">Concepto: ${value.nombre_concepto}</td>
                        <td>${btn_recibo} $ ${dinero(value.cantidad)}<br>Método: ${value.metodo}</td>
                        <td>${value.comentario}</td>
                        <td>
                            ${btn}
                        </td>
                    </tr>`);
                })
            }
        }

        $("table").on("click","button.rmv-pago",function(){
            HSCallDelete.init($(this),del_seg_venta)
        })

        $("table").on("click","button.edt-v",function(){
            $("#ModalPagosSeg").modal('hide');
            let url = $(this).data('url');
            clear($('#ModalPagosEdit'));
            HSCallGet.init(url,get_pagos)
        })

        const get_pagos = (data) =>{
            if(data.respuesta){
                $('#tituloPagosEdit').text('PAGOS DE: ' + data.nombre);
            }
        }
        const del_seg_venta = (data) =>{
            if(data.respuesta){
                tata.success('Éxito', data.mensaje);
                pagos_lead(data.pagos);
                if (typeof reload !== 'undefined') {
                    reload();
                }
            }
        }

        $("table").on("click","button.rmv-can",function(){
            let url = $(this).data('url')
            Swal.fire({
                title: '¿Desea cancelar el pago?',
                text: "El registro del pago pasara a cancelado.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    HSCallGet.init(url,del_seg_venta)
                }
            })
        })

    @endpush
</x-modal.modal>
