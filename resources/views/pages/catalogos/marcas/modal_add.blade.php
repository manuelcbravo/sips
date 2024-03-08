<x-modal.modal id="ModalMarcas" size="modal-sm" nombretitulo="">
    <x-slot name="titulo"> Marca </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" >
            <input type="hidden" id="id" name="id" value="">

            <div class="row">
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="marca" titulo="Marca" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="nombre" titulo="Descripción" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')
        $("table").on("click","[data-bs-target='#ModalMarcas']",function(){
            let url = $(this).data('url')
            clear($($(this).data('bs-target')),tom_select)
            HSCallGet.init(url,get)
        })

        const get = (data) =>{

            $.each(data.posts, function(index, value) {

                if(index === 'id_sucursal') {
                    const select = tom_select.find(element => element.inputId == index);
                    select.setValue([value])
                }else{
                    $('#ModalMarcas #'+index).val(value);
                }

            });

        }


    @endpush
</x-modal.modal>
