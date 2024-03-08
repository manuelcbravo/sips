<x-modal.modal id="ModalAjustes" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Ajustes </x-slot>
    <x-slot name="body">
        <label class="d-block h5">Articulo: <span class="h6 mb-0 articulo"></span></label>
        <label class="d-block h5">Cantidad actual: <span class="h6 mb-0 existencia"></span></label>
        <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" action="{{ url('ajuste_inventario') }}" data-js="success_ajuste">
            <input type="hidden" id="id" name="id" value="">

            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="id_movimiento" titulo="Tipo Ajuste" required="true" multiple='' class='col'/>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="cantidad" titulo="Cantidad" holder="" required="true" options='' validationclass='' error=''></x-form.input>
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

    $("table").on("click","[data-bs-target='#ModalAjustes']",function(){
        let url = $(this).data('url')
        let id = $(this).data('id')
        clear($($(this).data('bs-target')))
        $("#ModalAjustes #id").val(id)
        HSCallGet.init(url,get_ajutes)
    })

    const get_ajutes = (data) =>{

        $.each(data.posts, function(index, value) {
            if(index == 'existencia' || index == 'articulo'){
                $('.'+index).html(value);
            }
        });

    }
    
    const success_ajuste = (data) => {
        if(data.respuesta) {
            $('#ModalAjustes').modal('hide');
            tata.success('Éxito', data.mensaje);
            datatable.ajax.reload();
            catalogos();
        }
    }

    @endpush
</x-modal.modal>
