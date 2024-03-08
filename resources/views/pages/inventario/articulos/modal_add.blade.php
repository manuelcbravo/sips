<x-modal.modal id="ModalClientes" size="modal-xl" nombretitulo="">
    <x-slot name="titulo"> Articulos </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" >
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

        const get = (data) =>{

            $.each(data.posts, function(index, value) {
                if(index === 'id_linea' ||
                    index === 'id_marca' ||
                    index === 'id_clasificacion' ||
                    index === 'id_presentacion' ||
                    index === 'id_unidad_medida' ||
                    index === 'importacion'
                    ) {
                    const select = tom_select.find(element => element.inputId == index);
                    select.setValue([value])
                }else{
                    $('#ModalClientes #'+index).val(value);
                }
            });

        }

    @endpush
</x-modal.modal>
