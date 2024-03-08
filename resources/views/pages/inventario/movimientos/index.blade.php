<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Inventario </x-slot>
        <x-slot name="boton">
            {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalClientes">
                <i class="bi-plus mr-1"></i> Agregar articulo
            </button> --}}
        </x-slot>

        <x-slot name="indicadores"> </x-slot>
        <x-slot name="cuerpo">
            <div class="card mb-2">
                <div class="card-body col-8 row">
                    <div class="col-6">
                        <x-form.select id="id_sucursales" titulo="Sucursal" required="" multiple='' class=''/>
                    </div>
                </div>
            </div>
            <x-layout.card-table idEntries="datatableEntries" idPagination="datatablePagination">
                <x-slot name="header">
                    <div class="row col-12">
                        <div class="col-6">
                            <x-layout.table-header id="datatableSearch"></x-layout.table-header>
                        </div>
                        
                    </div>
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
                            <th>Sucursal</th>
                            <th>Movimiento</th>
                            <th>Precio</th>
                            <th>Inventario</th>
                            <th>Entrada/salida</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
            @include('pages.inventario.inventarios.modal_ajustes')
            @include('pages.inventario.inventarios.modal_traspasos')
            @include('pages.inventario.inventarios.modal_maximo')
            @include('pages.inventario.inventarios.modal_add')
            @include('pages.inventario.articulos.modal_barcode')

        </x-slot>

    </x-layout.page>
    @push('js')
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=quarterly&region=MX&language=es&key={{ ENV('API_GOOGLE_MAPS')}}&libraries=places"></script>
    <script type="text/javascript" src="//googlearchive.github.io/js-marker-clusterer/src/markerclusterer.js"></script>
        <script>
            HSCore.components.HSMask.init('.js-input-mask')
            
            window.addEventListener("load",function(event) {

                let id_sucursal_d = 0;
                let id_almacen_d = 0

                $.each(catalogos().sucursales, function(index, value) {
                    $('#id_sucursales, #id_sucursal').append(`<option value="${value.id}" >${value.nombre}</option>`);
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
                    // ajax: '{{ url('productosL') }}',
                    serverSide: true,
                    ajax: {
                        url: "{{ url('inventario_movimientos') }}/"+id_sucursal_d,
                        type: "POST",
                    },
                    columns: [{
                        render: function (data, type, row) {
                            let perfil = `<div class="avatar avatar-soft-primary avatar-circle">
                                            <span class="avatar-initials">${row.articulo[0]}</span>
                                        </div>`
                            return ` <div class="d-flex align-items-center" href="#">
                                        ${perfil}
                                        <div class="ms-3">
                                            <span class="d-block h5 mb-0">${ row.articulo }</span>
                                            <span class="d-block h6 text-inherit mb-0">${ row.descripcion }</span>
                                            <span class="d-block h6 text-inherit mb-0">${ row.presentacion }</span>
                                        </div>
                                    </div>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${row.sucursal}</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${row.movimiento}</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">$${ dinero(row.precio) }</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h6 mb-0">Inv. inicial: ${ row.inv_inicial }</span>
                                    <span class="d-block h6 mb-0">Inv. salida: ${ row.inv_final }</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h6 mb-0">Entrada: ${ row.entrada ?? 0}</span>
                                    <span class="d-block h6 mb-0">Salida: ${ row.salida ?? 0 }</span>`
                        }}
                    ]
                });

                const tom_select = HSCore.components.HSTomSelect.getItems()
                const datatable = HSCore.components.HSDatatables.getItem('datatable')

                const select_sucursal = tom_select.find(element => element.inputId == 'id_sucursales');
                const select_almacen = tom_select.find(element => element.inputId == 'id_almacenes');

                $("#id_sucursales").on('change', function(event){
                    const id_sucursal = $(this).val()
                    id_sucursal_d = $(this).val()

                    datatable.ajax.url("{{ url('inventario_movimientos') }}/" + id_sucursal_d).load();

                });

                @stack('js_modulo')
            });
        </script>
    @endpush
</x-app-layout>
