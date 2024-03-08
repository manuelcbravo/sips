<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Clientes </x-slot>
        <x-slot name="boton">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalClientes">
                <i class="bi-plus mr-1"></i> Agregar cliente
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
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
            @include('pages.clientes.clientes.modal_add')
            @include('pages.modal_generico.modal_archivo', ['table' => "tbl_cliente", 'carpeta' => 'archivos'])
            @include('pages.modal_generico.modal_seguimiento', ['table' => "tbl_clientes"])
        </x-slot>

    </x-layout.page>
    @push('js')

        <script>
            HSCore.components.HSMask.init('.js-input-mask')

            window.addEventListener("load",function(event) {
                let lat_geo;
                let long_geo;
                let lat_org = '20.122400152964854';
                let long_org = '-98.73567825342464';

                $.each(catalogos().medio_contactos, function(index, value) {
                    $('#id_cat_medio_contactos').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().regimen_fiscal, function(index, value) {
                    $('#id_regimen_fiscal').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().cliente_tipos, function(index, value) {
                    $('#id_cliente_tipo').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().clasificacion_chalin, function(index, value) {
                    $('#clasificacion_chalin').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().estados, function(index, value) {
                    $('#id_estado').append(`<option value="${value.id}" >${value.estado}</option>`);
                })

                $.each(catalogos().uso_cfdi, function(index, value) {
                    $('#id_uso_cfdi').append(`<option value="${value.id_cat}" >${value.nombre}</option>`);
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
                    ajax: '{{ url('clientesL') }}',
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
                                            <span class="d-block fs-6">${ fecha(row.created_at)}</span>
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
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalClientes" data-url="{{ url('clientes') }}/${row.id}/edit"><i class="bi bi-pencil-fill" style="margin-right: 5px;"></i>  Editar</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalSeguimiento" data-url="{{ url('seguimientoL') }}/${row.id}/tbl_cliente" data-uuid="${row.id}"><i class="bi bi-arrow-bar-up" style="margin-right: 5px;"></i>  Seguimiento</a>
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
                        $('#ModalClientes').modal('hide');
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
                    $('#tituloCliente').text('CLIENTES');
                    $('#ModalClientes #edo_mun').text('');
                });


                $("table").on("click","[data-bs-target='#ModalClientes']",function(){
                    $('.col-in').hide().attr('required',false)
                    select_colonias.clearOptions();
                    select_colonias.addOption({value: 0, text: 'Otra'})
                    let url = $(this).data('url')
                    clear($($(this).data('bs-target')),tom_select)
                    HSCallGet.init(url,get)
                })

                $("table").on("click","button.rmv",function(){
                    HSCallDelete.init($(this),del)
                })


                const del = (data) =>{
                    datatable.ajax.reload();
                    tata.success('Éxito', "Eliminado correctamente");
                }

                // function obtenerCoordenadas(codigoPostal) {
                //     // URL de la API de OpenCage Data
                //     let apiUrl = `https://api.opencagedata.com/geocode/v1/json?q=${codigoPostal}&key=c42b7e0594d240b2bb2ccb41bd2da7b2`;

                //     // Realiza la solicitud Ajax a la API
                //     $.ajax({
                //         url: apiUrl,
                //         method: 'GET',
                //         dataType: 'json',
                //         success: function(data) {
                //             let cod = 'ISO_3166-1_alpha-2';
                //             $.each(data.results, function(index, value) {
                //                 if(value.components['ISO_3166-1_alpha-2'] == 'MX'){
                //                     let lat_geo = data.results[index].geometry.lat;
                //                     let long_geo = data.results[index].geometry.lng;

                //                 }
                //             })
                //         },
                //         error: function(error) {
                //             console.error("Error en la solicitud:", error);
                //         }
                //     });
                // }

                // obtenerCoordenadas(42300);

//############################################################################################################ APP MODAL


                @stack('js_modulo')
            });

            const get_client_app = (data) =>{
                if(data.respuesta){
                    $('#tituloApp').text('CLIENTE: ' + data.nombre);
                    let id_client = data.user.id;
                    let email = data.user.email;
                    let password = data.user.password_plain;

                    if(data.user.status_app === 0){
                        $('#ModalApp .content_modal_app').empty().append(`
                            <div class="alert alert-warning" role="alert">
                                Aun no se ha realizado el proceso de activación de la aplicación del cliente, favor de dar clic en el botón activar app para continuar con el proceso.
                            </div>

                            <button type="button" class="btn btn-primary w-100" data-bs-target="#ActiveApp" onclick="ActiveApp('${id_client}')">
                                <i class="bi-phone me-1"></i>
                                Activar app
                            </button>
                            `);
                    } else {
                        $('#ModalApp .content_modal_app').empty().append(`
                            <div class="alert alert-success" role="alert">
                                La aplicación del usuario se encuentra activa, a continuación, se muestran los datos de acceso.
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext" value="${email}" readonly>
                                </div>

                                <label class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control-plaintext" value="${password}" readonly>
                                </div>
                            </div>
                        `);
                    }
                }
            }

            function ActiveApp($id){
                let url = '{{ url('activeApp') }}'+'/'+$id;
                HSCallGet.init(url,get_client_app);
                tata.success('Éxito', 'Activación correcta');
            }

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

                if($type === 1){
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
                        <div class="col-sm-4">
                            <x-form.select id="genero" titulo="Género" required="true" multiple='' class='genero'/>
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
                    `);
                }
            }
        </script>
    @endpush
</x-app-layout>
