<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Lista negra </x-slot>
        <x-slot name="boton">

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
                            <th>Ahorros</th>
                            <th>Inversiones</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
           
        </x-slot>

    </x-layout.page>
    @push('js')
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=quarterly&region=MX&language=es&key={{ ENV('API_GOOGLE_MAPS')}}&libraries=places"></script>
    <script type="text/javascript" src="//googlearchive.github.io/js-marker-clusterer/src/markerclusterer.js"></script>
        <script>
            HSCore.components.HSMask.init('.js-input-mask')

            window.addEventListener("load",function(event) {
              

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
                    ajax: '{{ url('lista_negraP') }}',
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
                                            <span class="d-block h5 text-inherit mb-0">${row.nombre + ' ' + row.apellido_paterno+ ' ' + row.apellido_materno}</span>
                                        </div>
                                    </div>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">Correo: ${ row.email }
                                <span class="d-block fs-6 text-body">Celular: ${ row.celular }</span>
                                <span class="d-block fs-6 text-body">Casa: ${ row.casa }</span>
                                <span class="d-block fs-6 text-body">Oficina: ${ row.oficina }</span>
                                </span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block fs-6 text-body">Activos: ${ row.creditos }</span>
                                <span class="d-block fs-6 text-body">Solicitudes: ${ row.solicitudes }</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block fs-6 text-body">Activos: ${ row.ahorros }</span>
                                <span class="d-block fs-6 text-body">Terminados: ${ row.ahorros_fin }</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block fs-6 text-body">Activos: ${ row.inversiones }</span>
                                <span class="d-block fs-6 text-body">Terminados: ${ row.inversiones_fin }</span>`
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
                            return `<a class="btn btn-sm btn-primary" href="{{ url('perfil_cliente') }}/${row.id}" target="_blank"> <i class="bi bi-person-circle"></i> Ver</a>
                                    <button class="btn btn-lg btn-white dropdown-toggle" type="button" id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                        Opciones
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
                                        <button class="dropdown-item text-danger lis_neg" data-id="${row.id}" data-estatus="${row.id_estatus}" data-url="{{ url('lista_negraS') }}" data-uuid="${row.id}"><i class="bi bi-x-octagon" style="margin-right: 5px;"></i> Lista Negra</button>
                                      </div>`
                        },
                    }]
                });

                const datatable = HSCore.components.HSDatatables.getItem('datatable')


                $("table").on("click","button.lis_neg",function(){
                    
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
                        text: "Esta seguro de sacar a este cliente de " +texto,
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
                })
            })
 
        </script>
    @endpush
</x-app-layout>
