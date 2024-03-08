<x-modal.modal id="ModalUsuarios" size="modal-lg" nombretitulo="">
    <x-slot name="titulo"> Usuarios </x-slot>
    <x-slot name="body">
        <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" >
            <input type="hidden" id="id" name="id" value="">
            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.input tipo="text" id="name" titulo="Nombre/s" holder="" required="true" options='' validationclass=''  error=''></x-form.input>
                </x-slot>
                <x-slot name="segundo">
                    <x-form.input tipo="text" id="apellidos" titulo="Apellidos" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>
            </x-form.input-double>

            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.input tipo="email" id="email" titulo="Correo electrónico" holder="" required="true" options='' validationclass='' error=''></x-form.input>
                </x-slot>

                <x-slot name="segundo">
                   <div class="mb-3">
                        <label class="form-label" for="rfc">Contraseña</label>
                        <input type="password" class="form-control form-control-lg" name="password_plain" id="password_plain" placeholder="" required minlength="8">
                        <span class="invalid-feedback">Campo obligatorio, el campo debe de tener al menos 8 caracteres. Asegúrate de ingresar una combinación de caracteres que consista en dígitos hexadecimales (0-9 y a-z). Por ejemplo, 1a2b3c4d </span>
                    </div>
                </x-slot>
            </x-form.input-double>

            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.input tipo="text" id="celular" titulo="Celular" holder="" required="true" options='' validationclass=''  error=''></x-form.input>
                </x-slot>
                <x-slot name="segundo">
                    <x-form.select tipo="email" id="rol" titulo="Rol" holder="" required="true" multiple="" class=""></x-form.select>
                </x-slot>
            </x-form.input-double>

            <x-form.input-double >
                <x-slot name="primero">
                    <x-form.select tipo="email" id="id_sucursal" titulo="Sucursal a la que pertenece" holder="" required="true" multiple="" class=""></x-form.select>
                </x-slot>
            </x-form.input-double>


            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" style="margin-right: 4px"> <i class="bi-check-lg"></i> Guardar</button>
                <button type="button" class="btn btn-white text-danger" data-bs-dismiss="modal"> <i class="bi-x-lg"></i> Cancelar</button>
            </div>
        </form>
    </x-slot>
    @push('js_modulo')
        // const datatable = HSCore.components.HSDatatables.getItem('datatable')

        // INITIALIZATION OF BOOTSTRAP VALIDATION
        // =======================================================
        HSBsValidation.init('.js-validate', {
            onSubmit: data => {
                data.event.preventDefault()
                HSCallStore.init(data,success)
            }
        })

        const success = (data) => {
            if(data.respuesta) {
                $('#ModalUsuarios').modal('hide');
                tata.success('Éxito', data.mensaje)
                datatable.ajax.reload()
            }else{
                let mensajeError = '';
                for (const key in data.mensaje) {
                    // Verifica si la clave tiene mensajes de error asociados
                    if (data.mensaje.hasOwnProperty(key)) {
                      // Concatena los mensajes de error para la clave actual
                      mensajeError += `<strong>${key}:</strong> ${data.mensaje[key].join(', ')}<br>`;
                    }
                  }

                warningSwalHtml('Error',mensajeError);
            }
        }
    @endpush
</x-modal.modal>
