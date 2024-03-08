<x-modal.modal id="ModalMaximo" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Máximos/mínimos </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormMaximos" id="FormMaximos" method="POST">
            <input type="hidden" id="id" name="id" value="">

            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="maximo" titulo="Máximo" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="minimo" titulo="Mínimo" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')

        $("table").on("click","[data-bs-target='#ModalMaximo']",function(){
            let url = $(this).data('url')
            let id = $(this).data('id')
            $("#ModalMaximo #id").val(id)
            clear($($(this).data('bs-target')))
            HSCallGet.init(url,get_maximos)
        })

        const get_maximos = (data) =>{

            $.each(data.posts, function(index, value) {
                $('#ModalMaximo #'+index).val(value);
            });

        }

        const success = (data) => {
                    if(data.respuesta) {
                        $('#ModalMaximo').modal('hide');
                        tata.success('Éxito', data.mensaje);
                        datatable.ajax.reload();
                        catalogos();
                    }
                }
    @endpush
</x-modal.modal>
