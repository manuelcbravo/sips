<x-modal.modal id="ModalCompra" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Compras </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" data-js="success_compras">
            <input type="hidden" id="id" name="id" value="">
            <div class="row">
                <div class="prov">
                    <div class="col-sm-12">
                        <x-form.select-custom id="id_proveedor" name="id_proveedor" titulo="Buscar proveedor" required="true" multiple='' class=''/>
                    </div>
                </div>
                <div class="prov_det mb-3">
                    <label class="proveedor d-block h5 mb-0"></label>
                    <label class="rfc d-block fs-5"></label>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="folio" titulo="Folio" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="serie" titulo="Serie" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="datetime-local" id="fecha_compra" titulo="Fecha de compra" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="monto_total" titulo="Monto total" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="sub_total" titulo="Sub total" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="descuento" titulo="Descuentos" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="impuestos" titulo="Impuestos" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                
            </div>
            <x-form.text-area id="descripcion" titulo="Comentario/descripción" holder="Escribe el comentario/descripción" required=""/>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')

    const T_proveedor2 = new TomSelect('#ModalCompra #id_proveedor', {
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
                            <span class="d-block text-muted">rfc: ${ escape(item.rfc) }</span>
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

    $("table").on("click","[data-bs-target='#ModalCompra']",function(){
        let url = $(this).data('url')
        clear($($(this).data('bs-target')),tom_select)
        T_proveedor.clear();
        T_proveedor.clearOptions();
        {{-- T_proveedor2.clear();
        T_proveedor2.clearOptions(); --}}
        HSCallGet.init(url,get)
       

    })

    const get = (data) => {
        if(data.respuesta){
            $.each(data.posts, function(index, value) {

                $('#ModalCompra #'+index).val(value);
            })

            $('.prov').hide()
            $('#ModalCompra #id_proveedor').attr('required',false)
            $('.prov_det').show()
            $('.proveedor').html('Proveedor: ' + data.proveedores.nombre)
            $('.rfc').html('R.F.C.: ' + data.proveedores.rfc)
            
        }
    }
    
    const success_compras = (data) => {
        if(data.respuesta){
            $('#ModalCompra').modal('hide');
            datatable.ajax.reload();
        }else{
            warningSwal('Advertencia', 'No se ha ha ingresado ningun documento.')
        }
    }

    

    @endpush
</x-modal.modal>
