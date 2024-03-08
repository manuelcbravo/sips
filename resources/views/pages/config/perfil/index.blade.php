<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Perfil</x-slot>
        <x-slot name="cuerpo">
            <x-layout.card>
                <x-slot name="header"> Información básica</x-slot>
                <x-slot name="body">
                    <!-- Form -->
                    <form class="js-validate needs-validation" novalidate="" data-name="FormUsuarios" id="FormUsuarios" method="POST" action="{{ route('usuarios.store') }}">
                        <input type="hidden" id="id" name="id" value="{{ Auth::user()->id }}">
                        <input type="hidden" id="rol" name="rol" value="{{ Auth::user()->rol }}">
                        <!-- Form -->
                        <div class="row mb-4">
                            <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Nombre completo </label>

                            <div class="col-sm-9">
                                <div class="input-group input-group-sm-vertical">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}" required="true">
                                    <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{ Auth::user()->apellidos }}" required="true">
                                </div>
                            </div>
                        </div>
                        <!-- End Form -->

                        <!-- Form -->
                        <div class="row mb-4">
                            <label for="emailLabel" class="col-sm-3 col-form-label form-label">Celular</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="celular" id="celular" aria-label="Celular" value="{{ Auth::user()->celular }}" required="true">
                            </div>
                        </div>
                        <!-- End Form -->

                        <!-- Form -->
                        <div class="row mb-4">
                            <label for="emailLabel" class="col-sm-3 col-form-label form-label">Email</label>

                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" id="email" aria-label="Email" value="{{ Auth::user()->email }}" readonly="">
                            </div>
                        </div>
                        <!-- End Form -->

                        <!-- Form -->
                        <div class="row mb-4">
                            <label for="organizationLabel" class="col-sm-3 col-form-label form-label">Contraseña</label>

                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password_plain" id="password_plain" placeholder="" aria-label="Contraseña" value="{{ Auth::user()->password_plain }}" required="true" minlength="8">
                                <span class="invalid-feedback">Campo obligatorio, el campo debe de tener al menos 8 caracteres. Asegúrate de ingresar una combinación de caracteres que consista en dígitos hexadecimales (0-9 y a-z). Por ejemplo, 1a2b3c4d </span>
                            </div>
                        </div>
                        <!-- End Form -->

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                    <!-- End Form -->
                </x-slot>
            </x-layout.card>
            <!-- Card -->
            <div class="card mt-4">
              <div class="card-header">
                <h4 class="card-title">Dispositivos recientes</h4>
              </div>

              <!-- Body -->
              <div class="card-body">
                <p class="card-text">View and manage devices where you're currently logged in.</p>
              </div>
              <!-- End Body -->

              <!-- Table -->
              <div class="table-responsive">
                <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                  <thead class="thead-light">
                    <tr>
                      <th>Browser</th>
                      <th>Device</th>
                      <th>Location</th>
                      <th>Most recent activity</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach($sessions as $session)
                    <tr>
                      <td class="align-items-center">
                        <img class="avatar avatar-xss me-2" src="assets/svg/brands/chrome-icon.svg" alt="Image Description"> {{ $session->agent['browser']}} on {{ $session->agent['platform'] }}
                      </td>
                      <td><i class="bi-display fs-3 me-2"></i> Dell XPS 15 @if($session->is_current_device)<span class="badge bg-soft-success text-success ms-1">Actual</span> @endif</td>
                      <td>{{ $session->ip_address }}</td>
                      <td>{{ $session->last_active  }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- End Table -->
            </div>
            <!-- End Card -->
        </x-slot>
    </x-layout.page>
    @push('js')
        <script>
            (function() {
                new HSSideNav('.js-navbar-vertical-aside').init()

                window.onload = function () {
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
                            tata.success('Éxito', data.mensaje)
                        }
                    }
                }
            })()
        </script>
    @endpush
</x-app-layout>
