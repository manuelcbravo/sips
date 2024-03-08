<x-modal.modal id="ModalInventario" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Inventarios </x-slot>
    <x-slot name="body">
        <div class="row align-items-center mb-3 art_nu">
            <div class="col-sm">
            </div>
            <div class="col-sm-auto">
                <button class="btn btn-primary mr-3" data-bs-toggle="modal" data-bs-target="#ModalArticuloRemision">
                    <i class="bi-plus mr-1"></i> Articulo existente
                </button>
            </div>
        </div>
        <div class="alert alert-warning mb-3 mb-lg-4 al-prin" role="alert" style="display: none">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img class="avatar avatar-xl" src="{{ asset('assets/svg/illustrations') }}/oc-megaphone.svg" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="avatar avatar-xl" src="{{ asset('assets/svg/illustrations-light') }} /oc-megaphone.svg" alt="Image Description" data-hs-theme-appearance="dark">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3 class="alert-heading mb-1">Es necesario revisar los articulo nuevos primero, para poder guardar el detalle</h3>
                    <p class="mb-0 al-cuer"></p>
                </div>
            </div>
        </div>
        <div class="lista">

        </div>

        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
        </div>
    </x-slot>
    @push('js_modulo')

    let id_compra = 0;

    $("table").on("click","[data-bs-target='#ModalInventario']",function(){
        let url = $(this).data('url')
        {{-- clear($($(this).data('bs-target')),tom_select) --}}

        $(".art_nu").hide()

        id_compra = 0
        if($(this).data('tipo') == 2){
            $(".art_nu").show()
            id_compra = $(this).data('id')
        }

        $('.al-prin').hide()
        HSCallGet.init(url,get_detalle)
    })

    const get_detalle = (data) => {
        let i = 0;
        let table = '';
        $('#ModalInventario .lista').empty()
        
        if(data.nuevos > 0){
            $('.al-prin').show()
            $('.alert-heading').html('Tienes <b>'+data.nuevos+' articulo sin registrar</b>. Es necesario revisar los articulo nuevos primero para poder guardar el detalle');
        }

        table +=`<table class="table table-borderless table-thead-bordered">
            <thead class="thead-light">
                <tr>
                  <th scope="col">Cantidad</th>
                  <th scope="col">articulo</th>
                  <th scope="col">Descripción</th>
                  <th scope="col">Valor unitario</th>
                  <th scope="col">Importe</th>
                  <th scope="col">Impuestos</th>
                  <th scope="col"></th>
                </tr>
              </thead>
            <tbody>`
            if(data.detalle.length > 0){
                $.each(data.detalle, function(index, value) {
                    table += `<tr>
                        <td>
                            ${ ((value.id_estatus == 0)? '<span class="badge bg-success rounded-pill h6">New</span>' : '')} ${value.cantidad}
                        </td>
                        <td>
                            ${value.no_identificacion}
                        </td>
                        <td>
                            ${ value.descripcion } 
                        </td>
                        <td>
                            $${ dinero(value.valor_unitario) } 
                        </td>
                        <td>
                            $${ dinero(value.importe) } 
                        </td>
                        <td>
                            $${ dinero(value.impuestos) }
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                ${ ((value.id_estatus == 0)? `<button class="btn btn-xs btn-success btn-add" data-url="{{ url('detalle_compras') }}/${value.id}/edit"> <i class="bi bi-bag-plus-fill"></i></button>` : ``)} <button class="btn btn-xs btn-info btn-change" data-url="{{ url('detalle_compras') }}/${value.id}/edit"> <i class="bi bi-pen"></i></button>
                            </div>
                        </td>
                    </tr>`
                })
            }else{
                table += `<tr class="text-center"><td colspan="6"> Sin productos registrados</td></tr>`
            }
        {{-- $.each(data.detalle, function(index, value) {
            $('#ModalInventario .lista').append(`<div class="row">
                <div class="col-2">
                    <x-form.input tipo="text" id="cantidad[${i}]" titulo="Cantidad" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-2">
                    <x-form.input tipo="text" id="no_identificacion[${i}]" titulo="Articulo" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-2">
                    <x-form.input tipo="text" id="clave_prod_serv[${i}]" titulo="Cve servicio" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-2">
                    <x-form.input tipo="text" id="descripcion[${i}]" titulo="Descripción" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-2">
                    <x-form.input tipo="text" id="valor_unitario[${i}]" titulo="Valor unitario" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-2">
                    <x-form.input tipo="text" id="importe[${i}]" titulo="Monto total" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>

            </div>`)

            $.each(value, function(index2, value2) {
                console.log('#ModalInventario #'+index2+'['+ i + ']' , value2)
                $('#ModalInventario #'+index2+'\\['+ i + '\\]').val(value2)
            })
            i++;
        }) --}}
        table +=`</tbody>
                            </table>`

        $('.lista').append(table)
    }
    
    const success_inventario = (data) => {
        if(data.respuesta){
            $('#ModalInventario').modal('hide');
            datatable.ajax.reload();
        }else{
            warningSwal('Advertencia', 'No se ha ha ingresado ningun documento.')
        }
    }

    @endpush
</x-modal.modal>
