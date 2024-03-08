<x-modal.modal id="ModalTraspasos" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Traspasos </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormTraspaso" id="FormTraspaso" method="POST" action="{{ url('traspaso_inventario') }}" data-js="success_traspaso">
            <input type="hidden" id="id_art" name="id_art" value="">

            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="id_sucursal" titulo="Sucursal" required="true" multiple='' class='mun'/>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="id_almacen" titulo="Almacen" required="" multiple='' class='mun'/>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="cantidad" titulo="Cantidad" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>

            <div class="row">
                <x-form.text-area id="comentario" titulo="Comentario" holder="Escribe el comentario" required=""/>
            </div>
            <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')

        $("table").on("click","[data-bs-target='#ModalTraspasos']",function(){
            let url = $(this).data('url')
            let id = $(this).data('id')
            $("#ModalTraspasos #id_art").val(id)
        })

        const success_traspaso = (data) => {
            if(data.respuesta) {
                $('#ModalTraspasos').modal('hide');
                tata.success('Éxito', data.mensaje);
                datatable.ajax.reload();
            }
        }


    @endpush
</x-modal.modal>
