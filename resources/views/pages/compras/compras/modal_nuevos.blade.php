<x-modal.modal id="ModalNuevosArticulos" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Nuevos Articulos </x-slot>
    <x-slot name="body">

            <div class="lista">

            </div>

            <div class="d-flex justify-content-end mt-5">
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
    </x-slot>
    @push('js_modulo')

    $("table").on("click","[data-bs-target='#ModalNuevosArticulos']",function(){
        let url = $(this).data('url')
        HSCallGet.init(url,get_detalle_nuevo)
    })

    const get_detalle_nuevo = (data) => {
        let i = 0;
        let table = '';
        $('.lista').empty()
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
                        ${value.cantidad}
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
                            <button class="btn btn-xs btn-info btn-change" data-url="{{ url('detalle_compras') }}/${value.id}/edit"> <i class="bi bi-arrow-clockwise"></i></button>
                            <button class="btn btn-xs btn-success btn-add" data-url="{{ url('detalle_compras') }}/${value.id}/edit"> <i class="bi bi-file-earmark-plus"></i> </button>
                        </div>
                    </td>
                </tr>`
            })
        }else{
            table += `<tr class="text-center"><td colspan="6"> Sin nuevos productos</td></tr>`
        }

        table +=`</tbody>
                            </table>`

        $('.lista').append(table)
    }
    
    const success_inventario_nuevo = (data) => {
        if(data.respuesta){
            $('#ModalNuevosArticulos').modal('hide');
            datatable.ajax.reload();
        }else{
            warningSwal('Advertencia', 'No se ha ha ingresado ningun documento.')
        }
    }

    @endpush
</x-modal.modal>
