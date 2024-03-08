<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Usuarios </x-slot>
        <x-slot name="boton">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalUsuarios">
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
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Activo/Activo</th>
                            <th>Acciones</th>
                        </x-slot>
                    </x-layout.table>
                </x-slot>
            </x-layout.card-table>
        </x-slot>
        <x-slot name="modals">
            @include('pages.config.users.modal_add')
        </x-slot>

    </x-layout.page>
@push('js')
    <script>
        window.addEventListener("load",function(event) {
            HSCore.components.HSMask.init('.js-input-mask')

            $.each(catalogos().rol, function(index, value) {
                $('#rol').append('<option value="'+ value.id +'">'+ value.nombre+'</option>');
            })
            
            $.each(catalogos().sucursales, function(index, value) {
                $('#id_sucursal').append('<option value="'+ value.id +'">'+ value.nombre+'</option>');
            })

            HSCore.components.HSTomSelect.init('.js-select')

            HSCore.components.HSDatatables.init($('#datatable'), {
                language: {
                    zeroRecords: `<div class="text-center p-4">
                      <img class="mb-3" src="./assets/svg/illustrations/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
                      <img class="mb-3" src="./assets/svg/illustrations-light/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
                    <p class="mb-0">No data to show</p>
                    </div>`
                },
                ajax: '{{ url('usersL') }}',
                columns: [{
                    render: function (data, type, row) {
                        return ` <div class="d-flex align-items-center" href="user-profile.html">
                                    <div class="avatar avatar-soft-primary avatar-circle">
                                      <span class="avatar-initials">${row.name[0]}</span>
                                    </div>
                                    <div class="ms-3">
                                      <span class="d-block h5 text-inherit mb-0">${row.name + ' ' + row.apellidos}</span>
                                    </div>
                                </div>`
                    }},{render: function (data, type, row) {
                        return `<span class="d-block h5 mb-0">${row.email}</span>`
                    }},{render: function (data, type, row) {
                        let rol = catalogos().rol.find(element => element.id == row.rol);
                        return `${rol.nombre}`
                    }},{render: function (data, type, row) {
                        return `<div class="form-check form-switch mb-4">
                                  <input type="checkbox" class="form-check-input" id="formSwitch${row.id}" ${(row.activado == 1) ? 'checked':''} data-id="${row.id}">
                                </div>`
                    }},{render: function (data, type, row) {
                        return `<button type="button" class="btn btn-white btn-sm" data-bs-toggle="modal" data-bs-target="#ModalUsuarios" data-url="{{ url('usuarios') }}/${row.id}/edit">
                                    <i class="bi-pencil-fill text-info"></i>
                                </button>`
                    },
                }]
            });
            const tom_select = HSCore.components.HSTomSelect.getItems()
            const datatable = HSCore.components.HSDatatables.getItem('datatable')

            $("button[data-bs-target]").on('click', function(event){
                $.each(tom_select, function(index, value){
                    if(value.inputId != 'datatableEntries'){
                        tom_select[index].clear()
                    }
                })
                clear($($(this).data('bs-target')));
            });


            $("table").on("click","[data-bs-target]",function(){
                let url = $(this).data('url')
                clear($($(this).data('bs-target')))
                HSCallGet.init(url,get)
            })

            $("table").on("click","button.rmv",function(){
                HSCallDelete.init($(this),del)
            })

            $("table").on("change",".form-check-input",function(){
                let id = $(this).attr('data-id');
                let che =  $(this).is(":checked")? 1: 0
                $.ajax({
                    url: '{{ url('usuarios/actualizar') }}',
                    type: "POST",
                    data: 'id='+id+'&activado='+che,
                    dataType: 'json',
                    beforeSend: function(){
                        loading();
                    },
                    success: function (data) {
                        close_loading();
                        if(data.respuesta) {
                            tata.success( 'Éxito',data.mensaje );
                            datatable.ajax.reload();
                            localStorage.clear();
                            catalogos();
                        }
                    },
                    error: function (data) {
                        close_loading();
                        errorSwal('Error',err);
                    }
                });
            });

            const get = (data) =>{
                $.each(data.usuario, function(index, value) {
                    if(index === 'rol' || index === 'id_sucursal') {
                        const select = tom_select.find(element => element.inputId == index);
                        select.setValue([value])
                    }else{
                        $('#'+index).val(value);
                    }
                });
            }

            const del = (data) =>{
                datatable.ajax.reload();
                tata.success('Éxito', "Eliminado correctamente");
                localStorage.clear();
                catalogos();
            }
            @stack('js_modulo')
        });
    </script>
@endpush
</x-app-layout>
