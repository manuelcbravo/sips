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
                    <div class="col-6">
                        <x-form.select id="id_almacenes" titulo="Almacén" required="" multiple='' class=''/>
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
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>existencia</th>
                            <th>MAx/min</th>
                            <th>Acciones</th>
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

                $.each(catalogos().movimiento_inventario, function(index, value) {
                    if(value.id != 6 || value.id != 7){
                        $('#id_movimiento').append(`<option value="${value.id}" >${value.nombre}</option>`);
                    }
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
                        url: "{{ url('inventarioL') }}/"+id_sucursal_d+'/'+id_sucursal_d,
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
                                            <span class="d-block h6 text-inherit mb-0">${ row.presentacion }</span>
                                        </div>
                                    </div>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${row.descripcion}</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">$${ dinero(row.precio) }</span>`
                        }},{render: function (data, type, row) {
                            let color = '';
                            if(row.maximo == 0 && row.minimo){
                                color = 'style="color: gray"';
                            }else if(row.existencia < row.minimo){
                                color = 'style="color: red"';
                            }else if(row.existencia >= row.minimo && row.existencia < row.maximo){
                                color = 'style="color: #F4D03F"';
                            }else if(row.existencia >= row.maximo){
                                color = 'style="color: green"';
                            }
                            return `<span ` +color+` class="d-block h5 mb-0"><strong>${ row.existencia }</strong></span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h6 mb-0">Máximo: ${ row.maximo }</span>
                                    <span class="d-block h6 mb-0">Mínimo: ${ row.minimo }</span>`
                        }},{render: function (data, type, row) {
                            return `<button class="btn btn-lg btn-white dropdown-toggle" type="button" id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                        Opciones
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalMaximo" data-url="{{ url("inventarios") }}/${row.id}/edit" data-id="${row.id}"><i class="bi bi-fullscreen" style="margin-right: 5px;"></i>  Máximos/mínimos</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalAjustes" data-url="{{ url("inventarios") }}/${row.id}/edit" data-id="${row.id}"><i class="bi bi-arrows-move" style="margin-right: 5px;"></i>  Ajustes</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalTraspasos" data-id="${row.id}"><i class="bi bi-arrow-clockwise" style="margin-right: 5px;"></i>  Traspasos</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalBarCode" data-url="{{ url("barcode") }}/${row.id}" data-id="${row.id}"><i class="bi bi-upc" style="margin-right: 5px;"></i>  Barcode</a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger rmv" data-id="${row.id}" data-url="{{ url("articulos") }}/${row.id}"><i class="bi bi-trash3 text-danger" style="margin-right: 5px;"></i>  Eliminar</button>
                                      </div>`
                        },
                    }]
                });

                const tom_select = HSCore.components.HSTomSelect.getItems()
                const datatable = HSCore.components.HSDatatables.getItem('datatable')

                const select_sucursal = tom_select.find(element => element.inputId == 'id_sucursales');
                const select_almacen = tom_select.find(element => element.inputId == 'id_almacenes');
                const select_almacen2 = tom_select.find(element => element.inputId == 'id_almacen');
                const select_movimiento = tom_select.find(element => element.inputId == 'id_movimiento');

                $("#id_sucursales").on('change', function(event){
                    const id_sucursal = $(this).val()
                    id_sucursal_d = $(this).val()

                    datatable.ajax.url("{{ url('inventarioL') }}/" + id_sucursal_d + '/' + id_almacen_d).load();

                    HSCallGet.init('{{ url('sucursales_h') }}/'+id_sucursal, get_sucursal)
                });

                $("#id_almacenes").on('change', function(event){

                    id_almacen_d = $(this).val()
                    datatable.ajax.url("{{ url('inventarioL') }}/" + id_sucursal_d + '/' + id_almacen_d).load();

                });

                $("#id_sucursal").on('change', function(event){
                    const id_sucursal = $(this).val()
                    id_sucursal_d = $(this).val()

                    HSCallGet.init('{{ url('sucursales_h') }}/'+id_sucursal, get_sucursal2)
                });


                const get_sucursal = (data) => {
                    select_almacen.clearOptions();
                    select_almacen.addOption({value: 0, text: 'Todo'})

                    $.each(data.almacenes, function(index, value) {
                        select_almacen.addOption({value: value.id, text: value.nombre})
                    })
                }

                const get_sucursal2 = (data) => {
                    select_almacen2.clearOptions();

                    $.each(data.almacenes, function(index, value) {
                        select_almacen2.addOption({value: value.id, text: value.nombre})
                    })
                }

                HSBsValidation.init('.js-validate', {
                    onSubmit: data => {
                        let fun = data.form.dataset.js ?? 'success'
                        data.event.preventDefault()
                        HSCallStore.init(data,eval(fun))
                    }
                })

                $("button[data-bs-target]").on('click', function(event){
                    clear($($(this).data('bs-target')), tom_select);
                });


                $("table").on("click","[data-bs-target='#ModalClientes']",function(){
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


                @stack('js_modulo')
            });
        </script>
    @endpush
</x-app-layout>
