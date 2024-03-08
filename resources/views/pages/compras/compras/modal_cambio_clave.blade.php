<x-modal.modal id="ModalCambio" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Articulos </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormCambioArticulo" id="FormCambioArticulo" method="POST" action="{{ url('compras_cambio') }}" data-js="success_cambio_articulo">
            <input type="hidden" id="id" name="id" value="">

            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="articulo" titulo="Articulo Cve." holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-8">
                    <x-form.input tipo="text" id="descripcion" titulo="Descripción" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="cantidad" titulo="Cantidad" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="valor_unitario" titulo="Precio unitario" holder="" required="" options='step=0.01' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="importe" titulo="Importe" holder="" required="" options='step=0.01' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="impuestos" titulo="Impuesto" holder="" required="" options='step=0.01' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')

    
    $("body").on("click",".btn-change",function(){
        let url = $(this).data('url')
        clear($('#ModalCambio'),tom_select)
        $('#ModalCambio').modal('show')
        $('#ModalNuevosArticulos').modal('hide')
        $('#ModalInventario').modal('hide')
        HSCallGet.init(url,get_articulo_cambio)
    })

    const get_articulo_cambio = (data) =>{

        $.each(data.posts, function(index, value) {
            if(index == 'no_identificacion'){
                $('#ModalCambio #articulo').val(value);
            }else if(index == 'clave_prod_serv'){
                $('#ModalCambio #clave_prodserv').val(value);
            }else if(index == 'valor_unitario'){
                $('#ModalCambio #precio').val(value);
            }
                $('#ModalCambio #'+index).val(value);
            
        });
    }

    const success_cambio_articulo = (data) => {
        if(data.respuesta) {
            $('#ModalCambio').modal('hide');
            tata.success('Éxito', data.mensaje);
        }
    }

    @endpush
</x-modal.modal>
