<x-modal.modal id="ModalTraspaso" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Traspaso </x-slot>
    <x-slot name="body">
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
        <form class="js-validate needs-validation" novalidate="" data-name="formTraspaso" id="formTraspaso" method="POST" action="{{ url('compra_traspaso')}}" data-js="success_traspaso">
            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="id_sucursal" titulo="Sucursal" required="true" multiple='' class='mun'/>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="id_almacen" titulo="Almacen" required="" multiple='' class='mun'/>
                </div>
            </div>
            <div class="lista_traspaso">

            </div>

            <div class="d-flex justify-content-end mt-5">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>

    </x-slot>
    @push('js_modulo')

    $("table").on("click","[data-bs-target='#ModalTraspaso']",function(){
        let url = $(this).data('url')
        clear($($(this).data('bs-target')),tom_select)
        $('.al-prin').hide()
        HSCallGet.init(url,get_traspaso)
    })

    const get_traspaso = (data) => {
        let i = 0;
        let table = '';
        $('#ModalTraspaso .lista_traspaso').empty()
        
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
                  <th scope="col">precio</th>
                  <th scope="col">disponible</th>
                  <th scope="col">A traspaso</th>
                </tr>
              </thead>
            <tbody>`
            if(data.detalle.length > 0){
                $.each(data.detalle, function(index, value) {
                    table += `<tr>
                        <td>
                            ${value.cantidad}
                        </td>
                        <td>
                            ${value.no_identificacion}
                        </td>
                        <td>
                            ${ value.descripcion } 
                        </td>
                        <td>
                            Precio llegada: $${dinero(value.valor_unitario)}<br>
                            precio actual: $${ dinero(value.precio_viejo) }
                        </td>
                        <td>
                            ${ value.cantidad_det } 
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-lg" name="cantidad[${ value.id }]" id="cantidad[${ value.id }]" placeholder="" required="true" min="0" max="${value.cantidad_det}">
                            <span class="invalid-feedback">Revise la disponibilidad.</span>                        
                        </td>
                    </tr>`
                })
            }else{
                table += `<tr class="text-center"><td colspan="6"> Sin productos registrados</td></tr>`
            }

        table +=`</tbody>
                            </table>`

        $('.lista_traspaso').append(table)
    }
    
    const success_traspaso = (data) => {
        if(data.respuesta){
            $('#ModalTraspaso').modal('hide');
            datatable.ajax.reload();
        }else{
            warningSwal('Advertencia', 'No se ha ha ingresado ningun documento.')
        }
    }

    $("#id_sucursal").on('change', function(event){
        const id_sucursal = $(this).val()
        id_sucursal_d = $(this).val()

        HSCallGet.init('{{ url('sucursales_h') }}/'+id_sucursal, get_sucursal2)
    });

    const get_sucursal2 = (data) => {
        select_almacen2.clearOptions();

        $.each(data.almacenes, function(index, value) {
            select_almacen2.addOption({value: value.id, text: value.nombre})
        })
    }

    @endpush
</x-modal.modal>
