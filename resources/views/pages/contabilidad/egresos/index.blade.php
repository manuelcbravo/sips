<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Gestión de egresos </x-slot>
        <x-slot name="boton">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalEgreso">
                <i class="bi-plus mr-1"></i> Agregar nueva egreso
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
                            <th>Quien registro</th>
                            <th>Método de pago</th>
                            <th>concepto</th>
                            <th>cantidad</th>
                            <th>fechas</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
            @include('konfido.contabilidad.egresos.modal_add')
        </x-slot>

    </x-layout.page>
    @push('js')
        <script>
            window.addEventListener("load",function(event) {

                $.each(catalogos().metodo_pago, function(index, value) {
                    $('#ModalEgreso #{{ $inputs['egresos']->id_pago_metodo }}').append(`<option value="${value.id}">${value.nombre}</option>`);
                })
                
                $.each(catalogos().egresos, function(index, value) {
                    $('#ModalEgreso #{{ $inputs['egresos']->id_pago_concepto }}').append(`<option value="${value.id}">${value.nombre}</option>`);
                })
                
                $.each(catalogos().bancos, function(index, value) {
                    $('#ModalEgreso #{{ $inputs['egresos']->id_banco }}').append(`<option value="${value.id}">${value.institucion + ' - ' + value.cuenta}</option>`);
                })
                
                $.each(catalogos().administradores, function(index, value) {
                    $('#ModalEgreso #{{ $inputs['egresos']->id_usuario_firma }}').append(`<option value="${value.id}">${value.name + ' ' + value.apellidos}</option>`);
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
                    ajax: '{{ url('egresosL') }}',
                    columns: [{
                        render: function (data, type, row) {
                            return ` <div class="d-flex align-items-center" href="user-profile.html">
                                    <div class="avatar avatar-soft-primary avatar-circle">
                                      <span class="avatar-initials">${row.registro[0]}</span>
                                    </div>
                                    <div class="ms-3">
                                      <span class="d-block h5 text-inherit mb-0">${row.registro}</span>
                                    </div>
                                </div>`
                        }},{render: function (data, type, row) {
                            let btn_imagen = '';
                            if(row.img_comprobantes){
                                btn_imagen = '<button class="btn btn-primary btn-xs verdoc" data-arc="{{url('documentos')}}/'+ row.img_comprobantes +'"><i class="bi bi-file-earmark-post"></i> </button>'
                            }
                            let btn_recibo = '';
                            if(row.img_recibo){
                                btn_recibo = '<button class="btn btn-primary btn-xs verdoc" data-arc="{{url('documentos')}}/'+ row.img_recibo +'"><i class="bi bi-image"></i> </button>'
                            }
                            return `<span class="d-block h5 mb-0">${btn_recibo} ${btn_imagen} ${row.metodo}</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${ row.concepto }</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">$${ dinero_dash(row.cantidad) }</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">Aplicación: ${ fecha(row.fecha) }<span class="d-block fs-6 text-body">Registro: ${ fecha(row.created_at) }</span></span>`
                        }},{render: function (data, type, row) {
                            let icono;
                            if(!row.deleted_at) {
                                icono = '<span class="badge bg-success">ACTIVO</span>';
                            }else{
                                icono = '<span class="badge bg-danger">CANCELADO</span>';
                            }
                            return icono
                        }},{render: function (data, type, row) {
                            return `<button class="btn btn-lg btn-white dropdown-toggle" type="button" id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                        Opciones
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalEgreso" data-url="{{ url('egresos') }}/${row.id}/edit"><i class="bi bi-pencil-fill" style="margin-right: 5px;"></i>  Editar</a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger rmv" data-id="${row.id}" data-url="{{ url('egresos') }}/${row.id}"><i class="bi bi-trash3 text-danger" style="margin-right: 5px;"></i>  Eliminar</button>
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
                        if(fun == 'success_pago_seguimientos' || fun == 'success_terminar'){
                            HSCallStore.image(data,eval(fun))
                        }else{
                            HSCallStore.init(data,eval(fun))
                        }
                        
                    }
                })

                $("button[data-bs-target]").on('click', function(event){
                    clear($($(this).data('bs-target')), tom_select);
                    $('.hibrido').hide()
                });

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
