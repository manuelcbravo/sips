<x-modal.modal id="ModalEgreso" size="modal-xl" nombretitulo="tituloPagos">
    <x-slot name="titulo"> EGRESOS </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormPago" id="FormPago" method="POST" action="{{ route('egresos.store') }}" data-js="success_pago_seguimientos">
            <input type="hidden" id="{{ $inputs['egresos']->id }}" name="{{ $inputs['egresos']->id }}" value="">
            <div class="row">
                <div class="col-sm-6">
                    <x-form.select id="{{ $inputs['egresos']->id_pago_metodo }}" titulo="Método de pago" required="true" multiple='' class='metodo_pago'/>
                </div>
                <div class="col-sm-6">
                    <x-form.select id="{{ $inputs['egresos']->id_pago_concepto }}" titulo="Concepto de pago" required="true" multiple='' class='metodo_pago'/>
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
                       }' id="{{ $inputs['egresos']->fecha }}" name="{{ $inputs['egresos']->fecha }}">                
                    </div>
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="{{ $inputs['egresos']->cantidad }}" titulo="Cantidad" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>

            <div class="row hibrido">
                <div class="col-sm-6 hib">
                    <x-form.input tipo="number" id="{{ $inputs['egresos']->efectivo }}" titulo="Cantidad efectivo" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-6 hib">
                    <x-form.input tipo="number" id="{{ $inputs['egresos']->banco }}" titulo="Cantidad banco" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-6">
                    <x-form.select id="{{ $inputs['egresos']->id_banco }}" titulo="Banco" required="" multiple='' class=''/>
                </div>
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="{{ $inputs['egresos']->clave_rastreo }}" titulo="Clave de rastreo" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-6">
                    <x-form.select id="{{ $inputs['egresos']->id_usuario_firma }}" titulo="Quien acepta la salida" required="true" multiple='' class=''/>
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
                <x-form.text-area id="{{ $inputs['egresos']->comentario }}" titulo="Comentario" holder="Escribe el comentario" required="true"/>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')
        HSCore.components.HSFlatpickr.init('.js-flatpickr')
        
        $('#ModalEgreso #{{ $inputs['egresos']->efectivo }}').hide().attr('required',false);
        $('#ModalEgreso #{{ $inputs['egresos']->banco }}').hide().attr('required',false);
        $('#ModalEgreso #{{ $inputs['egresos']->id_banco }}').hide().attr('required',false);

        $("table").on("click","[data-bs-target='#ModalEgreso']",function(){
            let url = $(this).data('url')
            clear($($(this).data('bs-target')),tom_select)
            HSCallGet.init(url,get)
        })

        const get = (data) => {
            $.each(data.posts, function(index, value) {
                if(index === '{{ $inputs["egresos"]->id_pago_concepto }}' || 
                index === '{{ $inputs["egresos"]->id_banco }}' || 
                index === '{{ $inputs["egresos"]->id_pago_metodo }}' || 
                index === '{{ $inputs["egresos"]->id_usuario_firma }}' ) {
                    const select = tom_select.find(element => element.inputId == index);
                    select.setValue([value])
                }else{
                    $('#ModalEgreso #'+index).val(value);
                }
            });
        }

        const get_seg_venta = (data) => {
            if(data.respuesta) {
                $('#tituloPagos').text('PAGOS DE: ' + data.nombre);
            }
        }

        const success_pago_seguimientos = (data) => {
            if(data.respuesta) {
                $('#ModalEgreso').modal('hide')
                tata.success('Éxito', data.mensaje);
                datatable.ajax.reload();

                if(data.swal){
                    warningSwal('Existe un sobrante',data.swal);
                }
            }
        }

        $('#ModalEgreso #{{ $inputs['egresos']->id_pago_metodo }}').change(function() {
            const id = $(this).val();
            $('.hibrido').hide()
            $('#ModalEgreso #{{ $inputs['egresos']->efectivo }}').hide().attr('required',false);
            $('#ModalEgreso #{{ $inputs['egresos']->banco }}').hide().attr('required',false);
            $('#ModalEgreso #{{ $inputs['egresos']->id_banco }}').hide().attr('required',false);
            
            if(id == 8 || id == 7 || id == 2 || id == 3  || id == 4 ){
                $('.hibrido').show()
                $('.hib').hide()
                if(id == 8 || id == 7){
                    $('.hib').show()
                    $('#ModalEgreso #{{ $inputs['egresos']->efectivo }}').show().attr('required',true);
                    $('#ModalEgreso #{{ $inputs['egresos']->banco }}').show().attr('required',true);
                    $('#ModalEgreso #{{ $inputs['egresos']->id_banco }}').show().attr('required',true);
                }
                if(id == 2){
                    $('#ModalPagosSeg #{{ $inputs['egresos']->id_banco }}').show().attr('required',true);
                }
            }
        })

    @endpush
</x-modal.modal>
