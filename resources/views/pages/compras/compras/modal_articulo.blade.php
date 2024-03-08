<x-modal.modal id="ModalArticulos" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Articulos </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormArticulos" id="FormArticulos" method="POST" action="{{ url('compras_nuevo') }}" data-js="success_nuevo_articulo">
            <input type="hidden" id="id" name="id" value="">

            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="articulo" titulo="Articulo Cve." holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-8">
                    <x-form.input tipo="text" id="descripcion" titulo="Descripción" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="clave_prodserv" titulo="Cve. producto/servicio" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-8">
                    <x-form.input tipo="text" id="observacion" titulo="Observacion" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <div class=" mb-3">
                <span class="h3">Datos general</span>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="id_linea" titulo="Línea" required="true" multiple='' class='mun'/>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="id_marca" titulo="Marca" required="true" multiple='' class='mun'/>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="id_clasificacion" titulo="Tipo producto" required="" multiple='' class='mun'/>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="id_presentacion" titulo="Presentación" required="" multiple='' class='col'/>
                    </div>
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="capacidad" titulo="Capacidad" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.select id="id_unidad_medida" titulo="Unidad medida" required="" multiple='' class='est'/>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <x-form.select id="importacion" titulo="Importación" required="" multiple='' class='col'/>
                </div>
                <!--<div class="col-sm-4">
                    <x-form.select id="ensanblado_en_linea" titulo="Ensamblado en línea" required="" multiple='' class='col'/>
                </div>-->
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="autocodigo" titulo="Auto código" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
                <div class="col-sm-4">
                    <x-form.input tipo="number" id="precio" titulo="Precio" holder="" required="" options='step=0.01' validationclass='' error=''></x-form.input>
                </div>
            </div>
            <!--<div class="row">
                <div class="col-sm-4">
                    <x-form.input tipo="text" id="precio" titulo="Precio" holder="" required="" options='' validationclass='' error=''></x-form.input>
                </div>
            </div>-->
            <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')

    
    $("body").on("click",".btn-add",function(){
        let url = $(this).data('url')
        clear($('#ModalArticulos'),tom_select)
        $('#ModalArticulos').modal('show')
        $('#ModalNuevosArticulos').modal('hide')
        HSCallGet.init(url,get_articulo_nuevo)
    })

    const get_articulo_nuevo = (data) =>{

        $.each(data.posts, function(index, value) {
            if(index == 'no_identificacion'){
                $('#ModalArticulos #articulo').val(value);
            }else if(index == 'clave_prod_serv'){
                $('#ModalArticulos #clave_prodserv').val(value);
            }else if(index == 'valor_unitario'){
                $('#ModalArticulos #precio').val(value);
            }else{
                $('#ModalArticulos #'+index).val(value);
            }
        });
    }

    const success_nuevo_articulo = (data) => {
        if(data.respuesta) {
            $('#ModalArticulos').modal('hide');
            tata.success('Éxito', data.mensaje);
        }
    }

    @endpush
</x-modal.modal>
