<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Articulos </x-slot>
        <x-slot name="boton">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalClientes">
                <i class="bi-plus mr-1"></i> Agregar artículo
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
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Presentacion</th>
                            <th>Acciones</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
            @include('pages.inventario.articulos.modal_add')
            @include('pages.inventario.articulos.modal_barcode')
            @include('pages.inventario.articulos.modal_fotos')
        </x-slot>

    </x-layout.page>
    @push('js')
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=quarterly&region=MX&language=es&key={{ ENV('API_GOOGLE_MAPS')}}&libraries=places"></script>
    <script type="text/javascript" src="//googlearchive.github.io/js-marker-clusterer/src/markerclusterer.js"></script>

        <script>
            HSCore.components.HSMask.init('.js-input-mask')

            window.addEventListener("load",function(event) {

                let texto_select_si_no = '<option value="0" >No</option><option value="1" >Si</option>'

                $.each(catalogos().linea, function(index, value) {
                    $('#id_linea').append(`<option value="${value.id}" >${value.linea + ' - ' + value.nombre}</option>`);
                })

                $.each(catalogos().marca, function(index, value) {
                    $('#id_marca').append(`<option value="${value.id}" >${value.marca + ' - ' + value.nombre}</option>`);
                })

                $.each(catalogos().u_medida, function(index, value) {
                    $('#id_unidad_medida').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().articulo_origen, function(index, value) {
                    $('#id_clasificacion').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().presentacion, function(index, value) {
                    $('#id_presentacion').append(`<option value="${value.codigo}" >${value.codigo + ' - ' + value.nombre}</option>`);
                })

                //$('#importacion, #ensanblado_en_linea').append(texto_select_si_no)
                $('#importacion').append(texto_select_si_no)

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
                        url: "{{ url('articulosL') }}",
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
                                            <span class="d-block h5 text-inherit mb-0">${ row.articulo }</span>
                                        </div>
                                    </div>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${row.descripcion}</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${((row.precio)? row.precio : '')}</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${ row.presentacion }</span>`
                        }},{render: function (data, type, row) {
                            return `<button class="btn btn-lg btn-white dropdown-toggle" type="button" id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                        Opciones
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalClientes" data-url="{{ url("articulos") }}/${row.id}/edit"><i class="bi bi-pencil-fill" style="margin-right: 5px;"></i>  Editar</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalBarCode" data-url="{{ url("barcode") }}/${row.id}" data-id="${row.id}"><i class="bi bi-upc" style="margin-right: 5px;"></i>  Barcode</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalFotos" data-url="{{ url("fotos") }}/${row.id}/edit" data-id="${row.id}"><i class="bi bi-file-image" style="margin-right: 5px;"></i> Imagen</a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger rmv" data-id="${row.id}" data-url="{{ url("articulos") }}/${row.id}"><i class="bi bi-trash3 text-danger" style="margin-right: 5px;"></i>  Eliminar</button>
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
                        catalogos();
                    }
                }

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
