<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Proveedores </x-slot>
        <x-slot name="boton">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalProveedores">
                <i class="bi-plus mr-1"></i> Agregar
            </button>
        </x-slot>

        <x-slot name="indicadores"> </x-slot>
        <x-slot name="cuerpo">
            <x-layout.card-table idEntries="datatableEntries" idPagination="datatablePagination">
                <x-slot name="header">
                    <x-layout.table-header id="datatableSearch"></x-layout.table-header>
                </x-slot>
                <x-slot name="header2"> </x-slot>
                <x-slot name="table">
                    <x-layout.table id="datatable" options='{
                   "order": [],
                    "info": {
                    "totalQty": "#datatableWithPaginationInfoTotalQty"
                    },
                    "search": "#datatableSearch",
                    "entries": "#datatableEntries",
                    "pageLength": 12,
                    "pagination": "datatablePagination"
                    }'>
                        <x-slot name="headers">
                            <th>Nombre</th>
                            <th>Contactos</th>
                            <th>Créditos</th>
                            <th>Saldo</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
            @include('pages.catalogos.proveedores.modal_add')
            @include('pages.modal_generico.modal_archivo', ['table' => "tbl_proveedores", 'carpeta' => 'archivos'])
            @include('pages.modal_generico.modal_seguimiento',['table' => "tbl_proveedores"])
        </x-slot>

    </x-layout.page>
    @push('js')
        <script>
            HSCore.components.HSMask.init('.js-input-mask')

            window.addEventListener("load",function(event) {

                $.each(catalogos().medio_contactos, function(index, value) {
                    $('#id_cat_medio_contactos').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().regimen_fiscal, function(index, value) {
                    $('#id_regimen_fiscal').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().cliente_tipos, function(index, value) {
                    $('#id_cliente_tipo').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                 $.each(catalogos().estados, function(index, value) {
                    $('#id_estado').append(`<option value="${value.id}" >${value.estado}</option>`);
                })

                const municipio = catalogos().municipios
                let asesores = catalogos().asesores;
                $.each(asesores, function(index, value) {
                    $('#id_asesor').append(`<option value="${value.id}" >${value.name + ' ' + value.apellidos}</option>`);
                })

                HSCore.components.HSTomSelect.init('.js-select')

                HSCore.components.HSDatatables.init($('#datatable'), {
                    language: {
                        zeroRecords: `<div class="text-center p-4">
                    <img class="mb-3" src="{{ asset('assets') }}/svg/illustrations/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                    <img class="mb-3" src="{{ asset('assets') }}/svg/illustrations-light/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
                    <p class="mb-0">No hay información para mostrar</p>
                    </div>`,
                        processing: `<div id="users-table_processing" class="dataTables_processing">
                        <div class="spinner-border text-primary spinner-datatable-processing" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="d-block">Cargando información</div>
                    </div>`,
                    },
                    processing: true,
                    ajax: '{{ url('proveedoresL') }}',
                    columns: [{
                        render: function (data, type, row) {
                            let perfil = `<div class="avatar avatar-soft-primary avatar-circle">
                                            <span class="avatar-initials">${row.nombre[0]}</span>
                                        </div>`
                            if(row.imagen_perfil){
                                perfil = `<span class="avatar avatar-circle">
                                            <img class="avatar-img" src="{{ url('documentos') }}/${row.imagen_perfil}" alt="Image Description">
                                        </span>`
                            }
                            return ` <div class="d-flex align-items-center" href="user-profile.html">
                                        ${perfil}
                                        <div class="ms-3">
                                            <span class="d-block h5 text-inherit mb-0">${row.nombre + ' ' + ((row.apellido_paterno)? row.apellido_paterno : '') + ' ' + ((row.apellido_materno)? row.apellido_materno : '')}</span>
                                            <span class="d-block fs-6">${ row.proveedor }</span>
                                            <span class="d-block fs-6">${  ((row.ultimo_contacto) ?  moment(row.ultimo_contacto).format('DD/MM/YYYY HH:mm'): 'Sin seguimiento') }</span>
                                        </div>
                                    </div>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">Correo: ${ row.email }
                                <span class="d-block fs-6 text-body">Teléfono: ${ row.celular }</span>
                                </span>`
                        }},{render: function (data, type, row) {
                            return dinero_dash(row.credito)
                        }},{render: function (data, type, row) {
                            return dinero_dash(row.saldo)
                        }},{render: function (data, type, row) {

                            let icono;
                            switch (row.id_estatus) {
                                case 1:
                                    icono = '<span class="badge bg-success">ACTIVO</span>';
                                    break;
                                case 3:
                                    icono = '<span class="badge bg-danger">LISTA NEGRA</span>';
                                    break;
                            }

                            return icono;
                        }},{render: function (data, type, row) {
                            return `<button class="btn btn-lg btn-white dropdown-toggle" type="button" id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                        Opciones
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalProveedores" data-url="{{ url('proveedores') }}/${row.id}/edit"><i class="bi bi-pencil-fill" style="margin-right: 5px;"></i>  Editar</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalSeguimiento" data-url="{{ url('seguimientoL') }}/${row.id}/tbl_proveedores" data-uuid="${row.id}"><i class="bi bi-arrow-bar-up" style="margin-right: 5px;"></i>  Seguimiento</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalArchivo" data-url="{{ url('archivosL') }}/${row.id}" data-uuid="${row.id}"><i class="bi bi-archive-fill" style="margin-right: 5px;"></i> Documentos</a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger rmv" data-id="${row.id}" data-url="{{ url('clientes') }}/${row.id}"><i class="bi bi-trash3 text-danger" style="margin-right: 5px;"></i>  Eliminar</button>
                                        </div>`
                        },
                    }]
                });
                const tom_select = HSCore.components.HSTomSelect.getItems()
                const datatable = HSCore.components.HSDatatables.getItem('datatable')

                HSBsValidation.init('.js-validate', {
                    onSubmit: data => {
                        let fun = data.form.dataset.js ?? 'success'
                        data.event.preventDefault()
                        HSCallStore.init(data,eval(fun))
                    }
                })

                const success = (data) => {
                    if(data.respuesta) {
                        $('#ModalProveedores').modal('hide');
                        tata.success('Éxito', data.mensaje);
                        datatable.ajax.reload();
                    }else{
                        warningSwal(data.titulo,data.mensaje)
                    }
                }

                const select_colonias = tom_select.find(element => element.inputId == 'id_colonia');

                $("button[data-bs-target]").on('click', function(event){
                    select_colonias.clearOptions();
                    select_colonias.addOption({value: 0, text: 'Otra'})
                    clear($($(this).data('bs-target')), tom_select);
                    $('.col-in').hide().attr('required',false)
                });


                $("table").on("click","[data-bs-target='#ModalProveedores']",function(){
                    select_colonias.clearOptions();
                    select_colonias.addOption({value: 0, text: 'Otra'})
                    $('.col-in').hide().attr('required',false)
                    $('#colonia').attr('required', false)
                    let url = $(this).data('url')
                    clear($($(this).data('bs-target')),tom_select)
                    HSCallGet.init(url,get)
                })

                $("table").on("click","button.rmv",function(){
                    HSCallDelete.init($(this),del)
                })

                /*$("table").on("click","button.lis_neg",function(){

                    let id = $(this).data('id')
                    let estatus = $(this).data('estatus')
                    let texto = '';

                    if(estatus == 1){
                        texto = ' cliente activo';
                    }else{
                        texto = ' la Lista negra';
                    }

                    let url = $(this).data('url')

                    Swal.fire({
                        title: '¿Desea cambiar de estatus?',
                        text: "Esta seguro de pasar este cliente a " +texto,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Lista negra',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.value) {
                            let token = jQuery('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                type: "post",
                                url: url,
                                dataType: "JSON",
                                data: {
                                    "id": id,
                                    "estatus": estatus,
                                    "_token": token,
                                },
                                beforeSend: function(){
                                    loading();
                                },
                                success: function(data) {
                                    close_loading()
                                    if(data.respuesta){
                                        datatable.ajax.reload();
                                    }else{
                                        errorSwal()
                                    }
                                },
                                error: function(data) {
                                    close_loading()
                                    errorSwal('Error',data);
                                }
                            });
                        }
                    })
                })*/

                const del = (data) =>{
                    datatable.ajax.reload();
                    tata.success('Éxito', "Eliminado correctamente");
                }

               @stack('js_modulo')
            });



            $('#id_cliente_tipo').on('change', function() {
                let type = $(this).val();
                $('#content_type_client').empty().append(`
                    <hr>
                    <div class="mb-3">
                        <span class="h3 title_type_client"></span>
                    </div>
                    <div id="inputs_type_client" class="row"></div>
                `);
                create_inputs_type_client(Number(type));
            });

            function create_inputs_type_client($type){
                if ($type === 0){
                    $('#inputs_type_client').empty().append(`
                        <div class="col-sm-4">
                            <x-form.input tipo="text" id="nombre" titulo="Nombre/s" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>`
                    )
                }

                if ($type === 1){
                    // Title
                    $('.title_type_client').text('Información personal')

                    // Inputs
                    $('#inputs_type_client').empty().append(`
                        <div class="col-sm-4">
                            <x-form.input tipo="text" id="nombre" titulo="Nombre/s" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input tipo="text" id="apellido_paterno" titulo="Apellido Paterno" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input tipo="text" id="apellido_materno" titulo="Apellido Materno" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input tipo="date" id="fecha_nacimiento" titulo="Fecha de nacimiento" holder="" required="" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <!--<div class="col-sm-4">
                            <x-form.select id="id_lugar_nacimiento" titulo="Lugar de nacimiento" required="true" multiple='' class='genero'/>
                        </div>
                        <div class="col-sm-4">
                            <x-form.select id="id_estado_civil" titulo="Estado civil" required="true" multiple='' class='genero'/>
                        </div>-->
                        <div class="col-sm-4">
                            <x-form.select id="genero" titulo="Género" required="true" multiple='' class='genero'/>
                        </div>
                        <!--<div class="col-sm-4">
                            <x-form.input tipo="email" id="email" titulo="Correo" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label" for="rfc">RFC</label>
                                <input type="text" class="form-control form-control-lg" name="rfc" id="rfc" placeholder="" required maxlength="13" pattern='.{13}'>
                                <span class="invalid-feedback">Campo obligatorio. </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input-mask tipo="text" id="celular" titulo="Teléfono Celular" holder="" required="" options='' validationclass='0000000000' error='' pattern='.{10}'></x-form.input>
                        </div>-->
                        <div class="col-sm-4">
                            <x-form.input-mask tipo="text" id="oficina" titulo="Teléfono Oficina" holder="" required="" options='' validationclass='0000000000' error='' pattern='.{10}'></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input-mask tipo="text" id="casa" titulo="Teléfono Casa" holder="" required="" options='' validationclass='0000000000' error='' pattern='.{10}'></x-form.input>
                        </div>
                    `);

                    // Catalogues
                    $('#genero').append('<option value="1">Hombre</option><option value="2">Mujer</option>');
                    //$.each(catalogos().estado_civil, function(index, value) {
                    //    $('#id_estado_civil').append(`<option value="${value.id}" >${value.nombre}</option>`);
                    //})
                    $.each(catalogos().estados, function(index, value) {
                        $('#id_estado').append(`<option value="${value.id}" >${value.estado}</option>`);
                        //$('#id_domicilio_estado').append(`<option value="${value.id}" >${value.estado}</option>`);
                        //$('#id_trabajo_estado').append(`<option value="${value.id}" >${value.estado}</option>`);
                        //$('#id_lugar_nacimiento').append(`<option value="${value.id}" >${value.estado}</option>`);
                    })
                } else if ($type === 2){
                    // Title
                    $('.title_type_client').text('Información de la empresa');

                    // Inputs
                    $('#inputs_type_client').empty().append(`
                        <div class="col-sm-6">
                            <x-form.input tipo="text" id="nombre" titulo="Empresa" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <!--<div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label" for="empresa_rfc">RFC</label>
                                <input type="text" class="form-control form-control-lg" name="empresa_rfc" id="empresa_rfc" placeholder="" required maxlength="13" pattern='.{13}'>
                                <span class="invalid-feedback">Campo obligatorio. </span>
                            </div>
                        </div>-->
                        <span class="h4 p-2">Representante legal</span>
                        <div class="col-sm-4">
                            <x-form.input tipo="text" id="rl_nombre" titulo="Nombre/s" holder="" required="" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input tipo="text" id="rl_apellido_paterno" titulo="Apellido Paterno" holder="" required="" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input tipo="text" id="rl_apellido_materno" titulo="Apellido Materno" holder="" required="" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input tipo="email" id="rl_email" titulo="Correo" holder="" required="" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input-mask tipo="text" id="rl_rfc" titulo="RFC" holder="" required="" options='' validationclass='0000000000000' error='' pattern='.{13}'></x-form.input-mask>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input-mask tipo="text" id="rl_celular" titulo="Teléfono Celular" holder="" required="" options='' validationclass='0000000000' error='' pattern='.{10}'></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input-mask tipo="text" id="rl_oficina" titulo="Teléfono Oficina" holder="" required="" options='' validationclass='0000000000' error='' pattern='.{10}'></x-form.input>
                        </div>
                        <div class="col-sm-4">
                            <x-form.input-mask tipo="text" id="rl_casa" titulo="Teléfono Casa" holder="" required="" options='' validationclass='0000000000' error='' pattern='.{10}'></x-form.input>
                        </div>
                    `);
                }
            }
        </script>
    @endpush
</x-app-layout>
