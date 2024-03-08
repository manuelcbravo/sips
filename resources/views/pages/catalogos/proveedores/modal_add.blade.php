<x-modal.modal id="ModalProveedores" size="modal-xl" nombretitulo="tituloProveedor">
    <x-slot name="titulo"> Proveedores </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" >
            <input type="hidden" id="id" name="id" value="">
            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="id_cliente_tipo" titulo="Tipo de proveedor" required="true" multiple='' class='genero'/>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="proveedor" titulo="CLAVE Proveedor" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <!--<div class="col-sm-4">
                    <x-form.input tipo="text" id="externo" titulo="Definir externo" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>-->
            </div>
            <div id="content_type_client" class="row"></div>
            <hr>
            <div class=" mb-3">
                <span class="h3">Datos de facturación</span>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="id_regimen_fiscal" titulo="Regimen fiscal del proveedor" required="true" multiple='' class='genero'/>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="email" id="email" titulo="Correo" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="email" id="correo2" titulo="2do correo de contacto (opcional)" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label class="form-label" for="rfc">RFC</label>
                        <input type="text" class="form-control form-control-lg" name="rfc" id="rfc" placeholder="" required="" maxlength="13" pattern='.{13}'>
                        <span class="invalid-feedback">Campo obligatorio. </span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="celular" titulo="Teléfono" holder="" required="true" options='' validationclass=''  error='' pattern='.{10}'></x-form.input>
                </div>
            </div>
            <hr>
            <div class=" mb-3">
                <span class="h3">Domicilio de facturación</span>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="id_estado" titulo="Estado" required="true" multiple='' class='est'/>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="id_municipio" titulo="Municipio" required="true" multiple='' class='mun'/>
                </div>
                <div class="col-sm-4">
                    <label class="form-label" for="rfc" id="edo_mun" style="color: gray;"></label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="cp" titulo="Código postal" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-2">
                    <div class="mb-3">
                        <a class="btn btn-xs btn-primary mt-6 cp-b"><i class="bi bi-search me-2"></i>Buscar</a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="id_colonia" titulo="Colonia" required="true" multiple='' class='col'/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-in">
                    <x-form.input tipo="text" id="colonia" titulo="Colonia no registrada" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="calle" titulo="Calle" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                    </div>
                <div class="col-sm-2">
                    <x-form.input tipo="text" id="exterior" titulo="No. Exterior" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-2">
                    <x-form.input tipo="text" id="interior" titulo="No. Interior" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <hr>
            <div class=" mb-3">
                <span class="h3">Información para pagos</span>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="cuenta_principal" titulo="Cuenta principal" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-6">
                    <x-form.input tipo="text" id="cuenta_secundaria" titulo="Cuenta secundaria" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>

            <x-form.text-area id="comentario" titulo="Comentario" holder="Escribe el comentario" required=""/>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')
        const select_estado = tom_select.find(element => element.inputId == 'id_estado');
        const select_municipio = tom_select.find(element => element.inputId == 'id_municipio');


        $("#id_estado").on('change', function(event){
            const id_estado = $(this).val()
            estado(id_estado);
        });


        const get = (data) =>{
            select_colonias.clearOptions();
            select_colonias.addOption({value: 0, text: 'Otra'})

            $.each(data.colonias, function(index, value) {
                select_colonias.addOption({value: value.id, text: value.nombre})
            })

        $('#tituloProveedor').text('PROVEEDOR: ' + data.nombre);

            let $data_fields = [];
            let edo_mun = '';
            $.each($data_fields = data.posts, function(index, value) {
                if (index === 'id_cliente_tipo') {
                    $.when( create_inputs_type_client(Number(value)))
                        .then(function() {
                            fill_fields(Number(value), $data_fields);
                        });
                }
                if (index === 'id_cliente_tipo' ||
                    index === 'id_regimen_fiscal' ||
                    index === 'id_estado') {
                    const select = tom_select.find(element => element.inputId == index);
                    select.setValue([value])
                }
                if(index === 'otro_estado' || index === 'otro_municipio'){
                    if(value){edo_mun += value + ', ';}
                }
            });

            if(edo_mun == 'null, null,'){
                $('#ModalProveedores #edo_mun').text('');
            }else{
                $('#ModalProveedores #edo_mun').text(edo_mun);
            }

            function fill_fields($type, $data) {
                $.each($data, function(index, value) {
                    if(index === 'id_estado'){
                        estado(value)
                        select_municipio.setValue([data.posts.id_municipio])
                        select_colonias.setValue([data.posts.id_colonia])
                    }
                    $('#ModalProveedores #'+index).val(value);
                });
            }

        }

        const estado = (id_estado) =>{
            select_municipio.clearOptions();
            const municipio_find = municipio.filter(element => element.id_estado == id_estado)
            $.each(municipio_find, function(index, value) {
                select_municipio.addOption({value: value.id, text: value.municipio})
            })
        }

        $("body").on('click', '.cp-b', function(e) {
            let cp_id = $('#ModalProveedores #cp').val()
            if(cp_id.length == 5){
                HSCallGet.init('{{ url('cp')}}/'+cp_id,get_cp)
            }else{
                warningSwal('Revise el campo','Revise el campo de C.P., debe de estar compuesto por 5 caracteres numericos');
            }
        });

        const get_cp = (data) =>{

            if(data.respuesta){

                select_colonias.clearOptions();
                select_colonias.addOption({value: 0, text: 'Otra'})

                if(data.colonias.length > 0){

                    $.each(data.colonias, function(index, value) {
                        select_colonias.addOption({value: value.id, text: value.nombre})
                    })

                }else{
                    warningSwal('No existen colonias','Consulta con el administrador para agregar o modificar la colonia');
                }
            }else{
                warningSwal('Error','Algo salio mal, intente mas tarde y contacte con su administrador');
            }

        }

        $("#id_colonia").on('change', function(event){
            const id = $(this).val()
            $('.col-in').hide()
            if(id == 0){
                $('.col-in').show()
                $('#colonia').attr('required', true)
            }else{
                $('#colonia').attr('required', false)
            }
        });

    @endpush
</x-modal.modal>
