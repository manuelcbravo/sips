<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Datos empresa </x-slot>
        <x-slot name="boton">
        </x-slot>

        <x-slot name="indicadores"> </x-slot>
        <x-slot name="cuerpo">
            <div class="card card-body">
                <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" >
                    <input type="hidden" id="id" name="id" value="">
                    <h5 class="mb-4">Datos de facturación</h5>
                    <div class="row">
                        <div class="col-sm-4">
                            <x-form.input tipo="text" id="nombre" titulo="Nombre" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-2">
                            <x-form.input tipo="text" id="rfc" titulo="R.F.C." holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-3">
                            <x-form.input tipo="text" id="mail" titulo="Correo eléctronico" holder="" required="" options='' validationclass='' error=''></x-form.input>
                        </div>

                        <div class="col-sm-3">
                            <x-form.select id="regimenfiscal" titulo="Regimen fiscal" required="true" multiple='' class='genero'/>
                        </div>
                    </div>
                    <h5 class="mb-4">Dirección de facturación</h5>
                    <div class="row">
                        <div class="col-sm-3">
                            <x-form.input tipo="text" id="calle" titulo="Calle" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-1">
                            <x-form.input tipo="text" id="numeroExterior" titulo="# Exterior" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-1">
                            <x-form.input tipo="text" id="numeroInterior" titulo="# Interior" holder="" required="" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-1">
                            <x-form.input tipo="text" id="cp" titulo="C.P." holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-3">
                            <x-form.input tipo="text" id="colonia" titulo="Colonia" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-3">
                            <x-form.input tipo="text" id="localidad" titulo="Localidad" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-3">
                            <x-form.input tipo="text" id="municipio" titulo="Municipio" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                        <div class="col-sm-3">
                            <x-form.input tipo="text" id="estado" titulo="Estado" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </x-slot>
        <x-slot name="modals">

        </x-slot>
    </x-layout.page>
    @push('js')

    <script>

        window.addEventListener("load",function(event) {

            $.each(catalogos().regimen_fiscal, function(index, value) {
                $('#regimenfiscal').append(`<option value="${value.id}" >${value.nombre}</option>`);
            })
            
            HSCore.components.HSTomSelect.init('.js-select')
            
            HSBsValidation.init('.js-validate', {
                onSubmit: data => {
                    let fun = data.form.dataset.js ?? 'success'
                    data.event.preventDefault()
                    HSCallStore.init(data,eval(fun))
                }
            })

            const success = (data) => {
                if(data.respuesta) {
                    tata.success('Éxito', data.mensaje);
                }else{
                    warningSwal(data.titulo,data.mensaje)
                }
            }

            const tom_select = HSCore.components.HSTomSelect.getItems()

            const get = (data) =>{
                
                $.each(data.posts, function(index, value) {

                    if (index === 'regimenfiscal') {
                        const select = tom_select.find(element => element.inputId == index);
                        select.setValue([value])
                    }else{
                        $('#'+index).val(value);
                    }
                });
            }

           
            let url = '{{ url('empresa') }}/{{ ENV('ID_EMPRESA') }}'
            HSCallGet.init(url,get)
            
        });
    </script>
    @endpush
</x-app-layout>
