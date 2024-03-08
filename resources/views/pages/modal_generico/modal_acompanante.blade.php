<x-modal.modal id="ModalAcompanante" size="modal-lg" nombretitulo="tituloAcompanante">
    <x-slot name="titulo"> Acompáñantes </x-slot>
    <x-slot name="body">

        <h4>Para agregar un acompañante, puede hacerlo desde lead en la opción agrengar acompañante</h4>

        <table class="table table-borderless table-thead-bordered mt-3">
            <thead class="thead-light">
            <tr>
                <th scope="col">Acompañante</th>
                <th scope="col">Grupo</th>
                <th scope="col">Tipo de acompañante</th>
                <th scope="col">Comentario</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody id="table_acompanante">
            </tbody>
        </table>
       
        <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
    </x-slot>
    @push('js_modulo')

    $("table").on("click","[data-bs-target='#ModalAcompanante']",function(){
        let url = $(this).data('url')
        let id = $(this).data('id')
        let opor = $(this).data('opor')
        let grupo = $(this).data('grupo') ?? 0
        HSCallGet.init(url+id+'/'+opor+'/'+grupo,get_acompanante)
    })

    const get_acompanante = (data) => {
        if(data.respuesta) {
            console.log(data)
            acompanante_lead(data.acompanante);
        }
    }

    const acompanante_lead = (data) => {
        $('#table_acompanante').empty();
        if(data.length == 0){
            $('#table_acompanante').append(`<tr><th scope="row" colspan="5" style="text-align:center;"> No hay acompañantes </th></tr>`);
        }else{
            $.each(data, function (index, value) {
                $('#table_acompanante').append(`<tr>
                    <td class="text-dark font-weight-bold"></td>
                    <td>${value.usuario}</td>
                    <td>${none(value.contacto)}</td>
                    <td>${none(value.comentario)}</td>
                    <td>${none(value.comentario)}</td>
                </tr>`);
            })
        }
    }
    @endpush
</x-modal.modal>