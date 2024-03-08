<x-modal.modal id="ModalLaboral" size="modal-xl" nombretitulo="tituloLaboral">
    <x-slot name="titulo"> Leads </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormLaboral" id="FormLaboral" method="POST" action="{{ route('laboral.store') }}" data-js="success_laboral">
            <input type="hidden" id="{{ $inputs['laboral']->id }}" name="{{ $inputs['laboral']->id }}" value="">
            <input type="hidden" id="{{ $inputs['laboral']->id_cliente }}" name="{{ $inputs['laboral']->id_cliente }}" value="">
            <input type="hidden" id="{{ $inputs["laboral"]->latitud}}" name="{{ $inputs["laboral"]->latitud}}" value="">
            <input type="hidden" id="{{ $inputs["laboral"]->longitud}}" name="{{ $inputs["laboral"]->longitud}}" value="">
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['laboral']->nombre }}" titulo="Nombre empresa" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="{{ $inputs['laboral']->fuente_ingreso }}" titulo="Fuente de ingreso" required="true" multiple='' class='genero'/>
                    </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['laboral']->rfc }}" titulo="R.F.C." holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class=" mb-3">
                <span class="h3">Domicilio</span>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="{{ $inputs['laboral']->cp }}" titulo="Código postal" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-2">
                    <div class="mb-3">
                        <a class="btn btn-xs btn-primary mt-6 cp-b2"><i class="bi bi-search me-2"></i>Buscar</a>
                    </div>
                 
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="{{ $inputs['laboral']->id_trabajo_estado }}" titulo="Estado" required="true" multiple='' class='est'/>
                    </div>
                <div class="col-sm-4">
                    <x-form.select id="{{ $inputs['laboral']->id_trabajo_municipio }}" titulo="Municipio" required="true" multiple='' class='mun'/>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="{{ $inputs['laboral']->id_trabajo_colonia }}" titulo="Colonia" required="true" multiple='' class='col'/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['laboral']->calle }}" titulo="Calle" holder="" required="" options='' validationclass='' error=''></x-form.input>
                    </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['laboral']->interior }}" titulo="No. Interior" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="{{ $inputs['laboral']->exterior }}" titulo="No. Exterior" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12" style="height: 15rem;">
                    <div id="map-canvas-1" style="width: 100%; height: 100%; margin: 0; padding: 0; position: relative; overflow: hidden;"></div>
                </div>
            </div>
            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.text-area id="{{ $inputs['laboral']->comentario }}" titulo="Referencia calle" holder="Escribe el comentario" required=""/>
                </x-slot>
                <x-slot name="segundo">
                    <x-form.text-area id="{{ $inputs['laboral']->comentario }}" titulo="Comentario registro" holder="Escribe el comentario" required=""/>
                </x-slot>
            </x-form.input-double>

            <div class="d-flex justify-content-end mb-3">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>

            <table class="table table-borderless table-thead-bordered">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">R.F.C</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Mapa</th>
                    <th scope="col">Comentario</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="table_laboral">
                </tbody>
            </table>
    </x-slot>
    @push('js_modulo')
    const select_colonias2 = tom_select.find(element => element.inputId == '{{ $inputs['laboral']->id_trabajo_colonia }}');
    const select_estado2 = tom_select.find(element => element.inputId == '{{ $inputs['laboral']->id_trabajo_estado }}');
    const select_municipio2 = tom_select.find(element => element.inputId == '{{ $inputs['laboral']->id_trabajo_municipio }}');
    const municipios = catalogos().municipios
    const estados = catalogos().estados
    
        $("table").on("click","[data-bs-target='#ModalLaboral']",function(){
            clear($($(this).data('bs-target')),tom_select)
            let url = $(this).data('url')
            let uuid = $(this).data('uuid')
            let opor = $(this).data('opor') 
            $('#ModalLaboral #{{ $inputs['laboral']->id_cliente }}').val(uuid)
            let nuevaPosicion = new google.maps.LatLng(lat_org, long_org);
            marker_1.setPosition(nuevaPosicion);
            map2.setCenter(nuevaPosicion);
            HSCallGet.init(url+uuid,get_laboral)
        })

        const get_laboral = (data) => {
            if(data.respuesta) {
                $('#tituloLaboral').text('REGRISTROS DE TRABAJO DE : ' + data.nombre);
                laboral_lead(data.data);
            }
        }

        const success_laboral = (data) => {
            if(data.respuesta) {
                $('#ModalLaboral').modal('hide')
                tata.success('Éxito', data.mensaje);
                laboral_lead(data.data);
                if(datatable){
                    datatable.ajax.reload();
                }
            }
        }

        const laboral_lead = (data) => {
            $('#table_laboral').empty();
            if(data.length == 0){
                $('#table_laboral').append(`<tr><th scope="row" colspan="6" style="text-align:center;"> No hay información laboral </th></tr>`);
            }else{
                $.each(data, function (index, value) {
                    let estado = estados.find(element => element.id == value.id_trabajo_estado).estado
                    let municipio = municipios.find(element => element.id_estado == value.id_trabajo_estado && element.id == value.id_trabajo_municipio).municipio
                    let dir = value.calle+ ' #' +value.interior+ ((value.exterior)? ' ext.' +value.exterior:'')+ ', ' +value.colonia+ ', ' + municipio + ', ' +estado
                    
                    $('#table_laboral').append(`<tr>
                        <td class="text-dark font-weight-bold">
                           ${ value.nombre }
                        </td>
                        <td>${value.rfc}</td>
                        <td>${ dir }</td>
                        <td><a class="btn btn-primary btn-xs" href="https://www.google.com/maps?q=${value.latitud},${value.longitud}" target="_blank">
                            <i class="bi bi-geo-fill me-2"></i>Ir
                            </a>
                        </td>
                        <td>${none(value.comentario)}</td>
                        <td><button class="btn btn-xs btn-success edt-tra"data-url="{{ url('laboral') }}/${value.id}/edit" date-uuid="${value.id}"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-xs btn-danger del-tra" data-url="{{ url('laboral')}}/${value.id}"><i class="bi bi-trash3"></i></button></td>
                    </tr>`);
                })
            }
        }

        $("table").on("click","button.edt-tra",function(){
            let url = $(this).data('url');
            clear($('#ModalLaboral'),tom_select);
            HSCallGet.init(url,get_datos)
        })

        const get_datos = (data) =>{
            select_colonias2.clearOptions();
            $.each(data.colonias, function(index, value) {
                select_colonias2.addOption({value: value.id, text: value.tipo +' '+ value.nombre})
            })
            if(data.respuesta){
                $.each(data.posts, function(index, value) {
                    if(index === '{{ $inputs["laboral"]->fuente_ingreso }}' || index === '{{ $inputs["laboral"]->id_trabajo_estado }}' ) {
                        if(index === '{{ $inputs['laboral']->id_trabajo_estado }}'){
                            estado(value)
                            select_municipio2.setValue([data.posts.{{ $inputs["laboral"]->id_trabajo_municipio }}])
                            select_colonias2.setValue([data.posts.{{ $inputs["laboral"]->id_trabajo_colonia }}])
                        }
                        const select = tom_select.find(element => element.inputId == index);
                        select.setValue([value])
                    }else{
                        $('#ModalLaboral #'+index).val(value);
                    }
                })
                datatable.ajax.reload();
                let nuevaPosicion = new google.maps.LatLng(data.posts.{{ $inputs["laboral"]->latitud}}, data.posts.{{ $inputs["laboral"]->longitud}});
                marker_1.setPosition(nuevaPosicion);
                map2.setCenter(nuevaPosicion);
            }
        }

        $("table").on("click","button.del-tra",function(){
            HSCallDelete.init($(this),del2)
        })

        const del2 = (data) =>{
            laboral_lead(data.data)
            tata.success('Éxito', "Eliminado correctamente");
        }


        $("#{{ $inputs['laboral']->id_trabajo_estado }}").on('change', function(event){
            const id_estado = $(this).val()
            estado2(id_estado);
        });

        const estado2 = (id_estado) =>{
            const select_municipio2 = tom_select.find(element => element.inputId == '{{ $inputs['laboral']->id_trabajo_municipio }}');
            select_municipio.clearOptions();
            const municipio_find = municipio.filter(element => element.id_estado == id_estado)
            $.each(municipio_find, function(index, value) {
                select_municipio2.addOption({value: value.id, text: value.municipio})
            })
        }

        $("body").on('click', '.cp-b2', function(e) {
            let cp_id = $('#ModalLaboral #{{ $inputs['laboral']->cp }}').val()
            if(cp_id.length == 5){
                HSCallGet.init('{{ url('cp')}}/'+cp_id,get_cp2)
            }else{
                warningSwal('Revise el campo','Revise el campo de C.P., debe de estar compuesto por 5 caracteres numericos');
            }
        });

        const get_cp2 = (data) =>{
            let apiUrl = `https://api.opencagedata.com/geocode/v1/json?q=${data.cp}&key=c42b7e0594d240b2bb2ccb41bd2da7b2`;

            $.ajax({
                url: apiUrl,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let cod = 'ISO_3166-1_alpha-2';
                    $.each(data.results, function(index, value) {
                        if(value.components['ISO_3166-1_alpha-2'] == 'MX'){
                            let lat_geo = data.results[index].geometry.lat;
                            let long_geo = data.results[index].geometry.lng;
                            $("#ModalClientes #{{ $inputs["laboral"]->latitud}}").val(lat_geo);
                            $("#ModalClientes #{{ $inputs["laboral"]->longitud}}").val(long_geo);
                            let nuevaPosicion = new google.maps.LatLng(lat_geo, long_geo);
                            marker_1.setPosition(nuevaPosicion);
                            map2.setCenter(nuevaPosicion);
                        }
                    })
                },
                error: function(error) {
                    console.error("Error en la solicitud:", error);
                }
            });
            if(data.respuesta){
                if(data.colonias.length > 0){
                    select_estado2.setValue([data.colonias[0].id_estado])
                    select_municipio2.setValue([data.colonias[0].id_municipio])
                    select_colonias2.clearOptions();
                    $.each(data.colonias, function(index, value) {
                        select_colonias2.addOption({value: value.id, text: value.tipo +' '+ value.nombre})
                    })
                }else{
                    warningSwal('No existen colonias','Consulta con el administrador para agregar o modificar la colonia');
                }
            }else{
                warningSwal('Error','Algo salio mal, intente mas tarde y contacte con su administrador');
            }
        }
    @endpush
</x-modal.modal>