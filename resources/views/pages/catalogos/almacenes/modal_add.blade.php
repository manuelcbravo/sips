<x-modal.modal id="ModalAlmacen" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Almacen </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" >
            <input type="hidden" id="id" name="id" value="">
            {{-- <input type="hidden" id="latitud" name="latitud" value="">
            <input type="hidden" id="longitud" name="longitud" value=""> --}}

            <div class=" mb-3">
                <span class="h3">General</span>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="nombre" titulo="Nombre" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.select tipo="" id="id_sucursal" titulo="Sucursal" holder="" required="" multiple="" class=""></x-form.select>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="id_encargado" titulo="Encargado" required="" multiple='' class='genero'/>
                </div>
            </div>
            <hr>
            <div class=" mb-3">
                <span class="h3">Domicilio</span>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <x-form.input tipo="text" id="direccion" titulo="Dirección" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <hr>
            {{-- <div class=" mb-3">
                <span class="h3">Ubicación</span>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12" style="height: 15rem;">
                    <div id="map-canvas-0" style="width: 100%; height: 100%; margin: 0; padding: 0; position: relative; overflow: hidden;"></div>
                </div>
            </div> --}}

            <x-form.text-area id="comentario" titulo="Comentario" holder="Escribe el comentario" required=""/>


            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')
        const select_colonias = tom_select.find(element => element.inputId == 'id_colonia');
        const select_estado = tom_select.find(element => element.inputId == 'id_domicilio_estado');
        const select_municipio = tom_select.find(element => element.inputId == 'id_domicilio_municipio');


        const get = (data) =>{

            $.each(data.posts, function(index, value) {

                if(index === 'id_sucursal') {
                    const select = tom_select.find(element => element.inputId == index);
                    select.setValue([value])
                }else{
                    $('#ModalAlmacen #'+index).val(value);
                }

            });

        }

        const estado = (id_estado) =>{
            const select_municipio = tom_select.find(element => element.inputId == 'id_domicilio_municipio');
            select_municipio.clearOptions();
            const municipio_find = municipio.filter(element => element.id_estado == id_estado)
            $.each(municipio_find, function(index, value) {
                select_municipio.addOption({value: value.id, text: value.municipio})
            })
        }

        $("body").on('click', '.cp-b', function(e) {
            let cp_id = $('#ModalAlmacen #cp').val()
            if(cp_id.length == 5){
                HSCallGet.init('{{ url('cp')}}/'+cp_id,get_cp)
            }else{
                warningSwal('Revise el campo','Revise el campo de C.P., debe de estar compuesto por 5 caracteres numericos');
            }
        });

        const get_cp = (data) =>{
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
                            $("#ModalAlmacen #latitud").val(lat_geo);
                            $("#ModalAlmacen #longitud").val(long_geo);
                            let nuevaPosicion = new google.maps.LatLng(lat_geo, long_geo);
                            marker_0.setPosition(nuevaPosicion);
                            map.setCenter(nuevaPosicion);
                        }
                    })
                },
                error: function(error) {
                    console.error("Error en la solicitud:", error);
                }
            });

            if(data.respuesta){
                if(data.colonias.length > 0){
                    select_estado.setValue([data.colonias[0].id_estado])
                    select_municipio.setValue([data.colonias[0].id_municipio])
                    select_colonias.clearOptions();
                    $.each(data.colonias, function(index, value) {
                        select_colonias.addOption({value: value.id, text: value.tipo +' '+ value.nombre})
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
