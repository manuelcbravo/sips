<x-modal.modal id="ModalAdd" size="modal-xl" nombretitulo=''>
    <x-slot name="titulo"> Bancos </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormLugares" id="FormLugares" method="POST" action="{{ route('bancos.store') }}">
            <input type="hidden" id="id" name="id" value="">

            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.input tipo="text" id="institucion" titulo="Institución bancaria" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>
                <x-slot name="segundo">
                    <x-form.input tipo="text" id="nombre_titular" titulo="Nombre del titular" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>
            </x-form.input-double>
            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.input tipo="text" id="cuenta" titulo="Cuenta bancaria" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>
                <x-slot name="segundo">
                    <x-form.select id="moneda" titulo="Moneda" required="true" multiple='' class='mon'/>
                    </x-slot>
            </x-form.input-double>
            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.input tipo="text" id="clve_interbancaria" titulo="Clave interbancaria" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>
                <x-slot name="segundo">
                    <x-form.input tipo="text" id="clve_swift" titulo="Clave SWIFT" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>
            </x-form.input-double>
            
            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.input tipo="text" id="no_tarjeta" titulo="No. de tarjeta" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>
                <x-slot name="segundo">
                </x-slot>
            </x-form.input-double>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')
    const get = (data) =>{
        if(data.respuesta){
            $.each(data.paquete, function(index, value) {
                if(index === 'moneda') {
                    const select = tom_select.find(element => element.inputId == index);
                    select.setValue([value])
                }else{
                    console.log(value)
                    $('#ModalAdd #'+index).val(value);
                }
            });
        }
    }
    @endpush
</x-modal.modal>