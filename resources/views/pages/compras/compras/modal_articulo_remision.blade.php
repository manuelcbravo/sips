<x-modal.modal id="ModalArticuloRemision" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Articulos </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormArticuloRemision" id="FormArticuloRemision" method="POST" action="{{ url('compras_articulo') }}" data-js="success_remision_articulo">
            <input type="hidden" id="id" name="id" value="">
            <input type="hidden" id="id_compra" name="id_compra" value="">

            <div class="row">
                <div class="col-sm-12">
                    <x-form.select-custom id="id_articulo" name="id_articulo" titulo="Buscar articulo" required="true" multiple='' class=''/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="cantidad" titulo="Cantidad" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="valor_unitario" titulo="Precio unitario" holder="" required="" options='step=0.01' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="importe" titulo="Importe" holder="" required="" options='step=0.01' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="impuestos" titulo="Impuesto" holder="" required="" options='step=0.01' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')

    
    $("body").on("click","[data-bs-target='#ModalArticuloRemision']",function(){
        let url = $(this).data('url')
        clear($('#ModalArticuloRemision'),tom_select)
        $('#ModalInventario').modal('hide')
        $('#id_compra').val(id_compra);
        T_articulo.clear();
        T_articulo.clearOptions();
        {{-- HSCallGet.init(url,get_articulo_cambio) --}}
    })

    let URL_search_articulo = '{{ url('buscar_articulo') }}'

    const T_articulo = new TomSelect('#ModalArticuloRemision #id_articulo', {
        valueField: 'id', // Asegúrate de utilizar la propiedad correcta como valor único
        labelField: 'articulo', // Utiliza 'articulo' o la propiedad que deseas mostrar como etiqueta
        searchField: ['articulo', 'descripcion'], // Agrega todas las propiedades que deseas buscar
        shouldLoad: function(query) {
            return query.length > 2;
        },
        load: function(query, callback) {
            var url = URL_search_articulo + '/' + encodeURIComponent(query);
            fetch(url)
                .then(response => response.json())
                .then(json => {
                    callback(json.items);
                })
                .catch(() => {
                    callback();
                });
        },
        render: {
            option: function(item, escape) {
                return `<div class="py-2 d-flex">
                    <div>
                        <div class="mb-1">
                            <span class="d-block text-muted">#: ${escape(item.articulo)}</span>
                            <span class="h4">${escape(item.descripcion)}</span>
                        </div>
                    </div>
                </div>`;
            },
            item: function(item, escape) {
                return `<div class="py-2 d-flex">
                    <div>
                        <div class="mb-1">
                            <span class="d-block text-muted">#: ${escape(item.articulo)}</span>
                            <span class="h4">${escape(item.descripcion)}</span>
                        </div>
                    </div>
                </div>`;
            }
        }
    });
    

    {{-- const get_articulo_cambio = (data) =>{

        $.each(data.posts, function(index, value) {
            if(index == 'no_identificacion'){
                $('#ModalArticuloRemision #articulo').val(value);
            }else if(index == 'clave_prod_serv'){
                $('#ModalArticuloRemision #clave_prodserv').val(value);
            }else if(index == 'valor_unitario'){
                $('#ModalArticuloRemision #precio').val(value);
            }
                $('#ModalArticuloRemision #'+index).val(value);
            
        });
    } --}}

    const success_remision_articulo = (data) => {
        if(data.respuesta) {
            $('#ModalArticuloRemision').modal('hide');
            tata.success('Éxito', data.mensaje);
        }
    }

    @endpush
</x-modal.modal>
