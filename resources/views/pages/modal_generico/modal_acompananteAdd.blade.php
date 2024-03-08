<x-modal.modal id="ModalAcompanamientoAdd" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Círculo </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormAcompanante" id="FormAcompanante" method="POST" action="{{ route('circulos_familia.store')}}" data-js="success_acompanado">
            <input type="hidden" id="{{ $inputs['circulo_lead']->id_lead }}" name="{{ $inputs['circulo_lead']->id_lead }}" value="">
            <div class="col-sm mb-3 aco">
                <h5 class="card-header-title">Información para unirse a un circulo</h5>
                <p class="page-header-text">Es importante que se defina bien el tipo de acompañante, si es un acompañante que va a hacerse un tratamiento, va a asignarse a una oportunidad para se acepte su tratamiento.</p>
            </div>
            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.select id="{{ $inputs['circulo_lead']->id_grupo }}" titulo="Grupo" required="true" multiple='' class='aco'/>
                    </x-slot>
                <x-slot name="segundo">
                    <x-form.select id="{{ $inputs['circulo_lead']->id_familia }}" titulo="Círculo" required="true" multiple='' class='aco'/>
                </x-slot>
            </x-form.input-double>
            
            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.select id="{{ $inputs['circulo_lead']->id_parentesco }}" titulo="Parentesco" required="true" multiple='' class='aco'/>
                    </x-slot>
                <x-slot name="segundo">
                    <x-form.select id="{{ $inputs['circulo_lead']->tipo_acompanante }}" titulo="Tipo de acompañante" required="true" multiple='' class='aco'/>
                </x-slot>
            </x-form.input-double>
            
            <x-form.text-area id="{{ $inputs['circulo_lead']->comentario }}" titulo="Comentario" holder="Escribe el comentario" required=""/>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
        <table class="table table-borderless table-thead-bordered mt-3">
            <thead class="thead-light">
            <tr>
                <th scope="col">Círculo</th>
                <th scope="col">Grupo</th>
                <th scope="col">Tipo de acompañante</th>
                <th scope="col">Parentesco</th>
                <th scope="col">Comentario</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody id="table_acompanantes">
            </tbody>
        </table>

    </x-slot>
    @push('js_modulo')
        $("table").on("click","[data-bs-target='#ModalAcompanamientoAdd']",function(){
            let url = $(this).data('url')
            let uuid = $(this).data('uuid')
            clear($($(this).data('bs-target')))
            $('#ModalAcompanamientoAdd #{{ $inputs['circulo_lead']->id_lead }}').val(uuid);
            HSCallGet.init(url+'/'+uuid,get_acompanante)
        })

        const get_acompanante = (data) =>{
            const select_padre = tom_select.find(element => element.inputId == '{{ $inputs['circulo_lead']->id_grupo }}');
            select_padre.clearOptions();
            $.each(data.grupos, function(index, value) {
                select_padre.addOption({value: value.id, text: value.nombre_{{ App::getLocale()}} })
            })

            llenar_acompanado(data.circulos);
        }

        const llenar_acompanado = (data) =>{
            $('#table_acompanantes').empty();
            if(data.length == 0){
                $('#table_acompanantes').append(`<tr><th scope="row" colspan="5" style="text-align:center;"> No hay acompañantes </th></tr>`);
            }else{
                $.each(data, function (index, value) {
                    console.log(value)
                    $('#table_acompanantes').append(`<tr>
                        <td class="text-dark font-weight-bold">${ value.nombre_familia }</td>
                        <td>${value.grupo_{{ App::getLocale()}}}</td>
                        <td>${ tipo_acompanante(value.tipo_acompanante)}</td>
                        <td>${value.nombre_{{ App::getLocale()}}}</td>
                        <td>${ none(value.comentario) }</td>
                        <td></td>
                    </tr>`);
                })
            }
        } 

        $("#{{ $inputs['circulo_lead']->id_grupo }}").on('change', function(event){
            const id_grupo = $(this).val()
            HSCallGet.init('{{ url('circulos_familiaC') }}/'+ id_grupo,get_circulo)
        });

        const get_circulo = (data) => {
            const select_lead = tom_select.find(element => element.inputId == '{{ $inputs['circulo_lead']->id_familia }}');

            select_lead.clearOptions();
            $.each(data.circulos, function(index, value) {
                select_lead.addOption({value: value.id, text: value.nombre_familia })
            })
        }

        const success_acompanado = (data) =>{
            if(data.respuesta){
                tata.success('Éxito', data.mensaje);
                llenar_acompanado(data.circulos);
            }
        }

        const tipo_acompanante = (id) =>{
            switch (id) {
                case 1:
                    return 'Tratamiento'
                case 2:
                    return 'Turista'
                case 3:
                    return 'Cuidador'
                default:
                    return "N/A"
              }
        }
        
    @endpush
</x-modal.modal>