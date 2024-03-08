<x-modal.modal id="ModalXML" size="modal-lg" nombretitulo="">
    <x-slot name="titulo"> Agregar compra mediante XML </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="XMLForm" id="XMLForm" method="POST" action="{{ url('compras_upload_xml')}}" data-js="success_xml">

            <x-form.select-custom id="id_proveedor" name="id_proveedor" titulo="Buscar proveedor" required="true" multiple='' class=''/>

            <input type="file" id="file" name="file" class="form-control">

            <div class="d-flex justify-content-end mt-5">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')

    const URL_search_clients = '{{ url('buscar_proveedor')}}';

    const success_xml = (data) => {
        if(data.respuesta){
            $('#ModalXML').modal('hide');
            datatable.ajax.reload();
            $('#ModalCompra').modal('show');
            HSCallGet.init(`{{ url('compras') }}/${data.id}/edit`,get)
        }else{
            warningSwal('Advertencia', 'No se ha ha ingresado ningun documento.')
        }
    }

    const T_proveedor = new TomSelect('#ModalXML #id_proveedor', {
        valueField: 'id',
        labelField: 'nombre',
        searchField: 'nombre',
        shouldLoad:function(query){
            return query.length > 2;
        },
        load: function(query, callback) {
            var url = URL_search_clients + '/' + encodeURIComponent(query);
            fetch(url)
                .then(response => response.json())
                .then(json => {
                    callback(json.items);
                }).catch(()=>{
                callback();
            });
        },
        render: {
            option: function(item, escape) {
                return `<div class="py-2 d-flex">
                    <div>
                        <div class="mb-1">
                            <span class="d-block text-muted">RFC: ${ escape(item.rfc) }</span>
                            <span class="h4">${ escape(item.nombre) }</span>
                        </div>
                    </div>
                </div>`;
            },
            item: function(item, escape) {
                return `<div class="py-2 d-flex">
                    <div>
                        <div class="mb-1">
                            <span class="d-block text-muted">rfc: ${ escape(item.rfc) }</span>
                            <span class="h4">${ escape(item.nombre) }</span>
                        </div>
                    </div>
                </div>`;
            }
        }
    });

    {{-- const T_proveedor = new TomSelect('#ModalXML #id_proveedor',{
        valueField: 'id_cl',
        labelField: 'nombre',
        searchField: 'nombre',
        // minimum query length
        shouldLoad:function(query){
            return query.length > 2;
        },
        // fetch remote data
        load: function(query, callback) {
            // Datos estáticos para prueba
                var staticData = [
                    { id: 1, nombre: 'Elemento 1' },
                    { id: 2, nombre: 'Elemento 2' },
                    // Agrega más elementos según sea necesario
                ];

                callback(staticData);

        },
        // custom rendering functions for options and items
        render: {
            option: function(item, escape) {
                return `<div class="py-2 d-flex">
                    <div>
                        <div class="mb-1">
                            <span class="d-block text-muted">Id: ${ escape(item.id) }</span>
                            <span class="h4">
                                ${ escape(item.nombre) }
                            </span>
                        </div>
                    </div>
                </div>`;
            },
            item: function(item, escape) {
                return `<div class="py-2 d-flex">
                    <div>
                        <div class="mb-1">
                            <span class="d-block text-muted">Id: ${ escape(item.id) }</span>
                            <span class="h4">
                                ${ escape(item.nombre) }
                            </span>
                        </div>
                    </div>
                </div>`;
            }
        },
    }); --}}

    @endpush
</x-modal.modal>
