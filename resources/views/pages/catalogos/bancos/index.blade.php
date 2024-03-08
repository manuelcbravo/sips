<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Lista de cuentas bancarias </x-slot>
        <x-slot name="boton">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalAdd">
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
                            <th>Nombre titular</th>
                            <th>Banco</th>
                            <th>Cuenta</th>
                            <th>Cve interbancaria</th>
                            <th>Acciones</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
            @include('pages.catalogos.bancos.modal_add')
           
        </x-slot>

    </x-layout.page>
    @push('js')
        <script>
            window.addEventListener("load",function(event) {
                $('.mon').append('<option value="mxn"> Pesos mexicanos</option><option value="dlls"> Dolares</option>');
                
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
                    ajax: '{{ url('bancosL') }}',
                    columns: [{
                        render: function (data, type, row) {
                            return ` <div class="d-flex align-items-center" href="user-profile.html">
                                    <div class="avatar avatar-soft-primary avatar-circle">
                                      <span class="avatar-initials">${row.nombre_titular[0]}</span>
                                    </div>
                                    <div class="ms-3">
                                      <span class="d-block h5 text-inherit mb-0">${row.nombre_titular }</span>
                                    </div>
                                </div>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${row.institucion}</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${row.cuenta ?? 'Sin seguimiento'}</span>`
                        }},{render: function (data, type, row) {
                            return `<span class="d-block h5 mb-0">${row.clve_interbancaria}</span>`
                        }},{render: function (data, type, row) {
                            return `<button class="btn btn-lg btn-white dropdown-toggle" type="button" id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                        Opciones
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalAdd" data-url="{{ url('bancos') }}/${row.id}/edit"><i class="bi bi-pencil-fill" style="margin-right: 5px;"></i>  Editar</a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger rmv" data-id="${row.id}" data-url="{{ url('bancos') }}/${row.id}"><i class="bi bi-trash3 text-danger" style="margin-right: 5px;"></i>  Eliminar</button>
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
                        localStorage.clear();
                        $('#ModalAdd').modal('hide');
                        tata.success('Éxito', data.mensaje);
                        catalogos();  
                        datatable.ajax.reload();
                        localStorage.clear();
                        catalogos();
                    }
                }

                $("button[data-bs-target]").on('click', function(event){
                    $.each(tom_select, function(index, value){
                        if(value.inputId != 'datatableEntries'){
                            tom_select[index].clear()
                        }
                    })
                    clear($($(this).data('bs-target')));
                  
                });

                $("table").on("click","button.rmv",function(){
                    HSCallDelete.init($(this),del)
                })

                const del = (data) =>{
                    datatable.ajax.reload();
                    tata.success('Éxito', "Eliminado correctamente");
                    localStorage.clear();
                    catalogos();
                }

                $("table").on("click",'[data-bs-target="#ModalAdd"]',function(){
                    let url = $(this).data('url')
                    clear($($(this).data('bs-target')))
                    HSCallGet.init(url,get)
                })

                @stack('js_modulo')
            });
        </script>
    @endpush
</x-app-layout>
