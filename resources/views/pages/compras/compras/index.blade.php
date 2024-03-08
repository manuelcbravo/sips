<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Compras </x-slot>
        <x-slot name="boton">
            <button class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#ModalCompra">
                <i class="bi-plus mr-1"></i> Compra manual
            </button>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalXML">
                <i class="bi-filetype-xml mr-1"></i> Compra XML
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
                            <th>Proveedor</th>
                            <th>Tipo</th>
                            <th>articulos</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
            @include('pages.compras.compras.modal_add')
            @include('pages.compras.compras.modal_xml')
            @include('pages.compras.compras.modal_inventario')
            @include('pages.compras.compras.modal_nuevos')
            @include('pages.compras.compras.modal_articulo')
            @include('pages.compras.compras.modal_articulo_remision')
            @include('pages.compras.compras.modal_cambio_clave')
            @include('pages.compras.compras.modal_traspaso')
            @include('pages.compras.compras.modal_pagos')
            @include('pages.modal_generico.modal_archivo', ['table' => "tbl_compras", 'carpeta' => 'compras'])
        </x-slot>

    </x-layout.page>
    @push('js')

        <script>
            HSCore.components.HSMask.init('.js-input-mask')

            window.addEventListener("load",function(event) {

                let texto_select_si_no = '<option value="0" >No</option><option value="1" >Si</option>'

                $.each(catalogos().sucursales, function(index, value) {
                    $('#id_sucursales, #id_sucursal').append(`<option value="${value.id}" >${value.nombre}</option>`);
                })

                $.each(catalogos().linea, function(index, value) {
                    $('#id_linea').append(`<option value="${value.linea}" >${value.linea + ' - ' + value.nombre}</option>`);
                })

                $.each(catalogos().marca, function(index, value) {
                    $('#id_marca').append(`<option value="${value.marca}" >${value.marca + ' - ' + value.nombre}</option>`);
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

                $.each(catalogos().metodo_pago, function(index, value) {
                    $('#id_pago_metodo').append(`<option value="${value.id}">${value.nombre}</option>`);
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
                    ajax: '{{ url('comprasL') }}',
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
                                            <span class="d-block h5 text-inherit mb-0">${ row.nombre }</span>

                                        </div>
                                    </div>`
                        }},{render: function (data, type, row) {
                            let tipo = ''
                            if(row.tipo_compra == 2){
                                tipo = 'Nota de remisión';
                            }else{
                                tipo = 'Factura';
                            }
                            return tipo ;
                        }},{render: function (data, type, row) {
                            return 'Total articulos: '+row.cantidad_detalles + ' <br>Total productos: ' + row.suma_detalles
                        }},{render: function (data, type, row) {
                            return fecha(row.fecha_compra)
                        }},{render: function (data, type, row) {
                            return `$ ` + dinero(row.monto_total)
                        }},{render: function (data, type, row) {
                            return `<button class="btn btn-lg btn-white dropdown-toggle" type="button" id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                        Opciones
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalCompra" data-url="{{ url('compras') }}/${row.id}/edit" data-id-open="${row.id}"><i class="bi bi-pencil-fill" style="margin-right: 5px;"></i>  Editar</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalInventario" data-tipo="${row.tipo_compra}" data-id="${row.id}" data-url="{{ url('compras_detalle') }}/${row.id}"><i class="bi bi-shop" style="margin-right: 5px;"></i>  Detalle compra</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalTraspaso" data-url="{{ url('compra_traspaso') }}/${row.id}"><i class="bi bi-file-earmark-arrow-up" style="margin-right: 5px;"></i> Movimiento inventario</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalArchivo" data-url="{{ url('archivosL') }}/${row.id}" data-uuid="${row.id}"><i class="bi bi-archive-fill" style="margin-right: 5px;"></i> Recibos</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalPagosSeg" data-url="{{ url('pago_comprasT') }}" data-id="${row.id}"><i class="bi bi-cash-stack" style="margin-right: 5px;"></i> Gestión pagos</a>
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalPagosSeg" data-url="{{ url('pago_comprasT') }}" data-id="${row.id}"><i class="bi bi-arrow-counterclockwise" style="margin-right: 5px;"></i> Devoluciones</a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger rmv" data-id="${row.id}" data-url="{{ url('compras') }}/${row.id}"><i class="bi bi-trash3 text-danger" style="margin-right: 5px;"></i>  Eliminar</button>
                                    </div>`
                        },
                    }]
                });
                const tom_select = HSCore.components.HSTomSelect.getItems()
                const datatable = HSCore.components.HSDatatables.getItem('datatable')

                const select_almacen2 = tom_select.find(element => element.inputId == 'id_almacen');

                $("button[data-bs-target]").on('click', function(event){
                    clear($($(this).data('bs-target')), tom_select);
                    T_proveedor.clear();
                    T_proveedor.clearOptions();

                    $('.prov').show()
                    $('.prov_det').hide()
                    $('#ModalCompra #id_proveedor').attr('required',true)
                });


                HSBsValidation.init('.js-validate', {
                    onSubmit: data => {
                        let fun = data.form.dataset.js ?? 'success'
                        data.event.preventDefault()

                        if(fun == 'success_xml' || fun == 'success_pago_seguimientos'){
                            HSCallStore.image(data,eval(fun))
                        }else{
                            HSCallStore.init(data,eval(fun))
                        }
                    }
                })

                const success = (data) => {
                    if(data.respuesta) {
                        $('#ModalAlmacen').modal('hide');
                        tata.success('Éxito', data.mensaje);
                        datatable.ajax.reload();
                    }else{
                        warningSwal(data.titulo,data.mensaje)
                    }
                }

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
