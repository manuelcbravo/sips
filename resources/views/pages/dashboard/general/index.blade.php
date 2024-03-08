<x-app-layout :active="$active">
    <x-layout.page>
        <x-slot name="titulo"> Dashboard de ingresos </x-slot>
        <x-slot name="boton"> </x-slot>

        <x-slot name="indicadores"> </x-slot>
        <x-slot name="cuerpo">
            <div class="card mb-3 mb-lg-5">
                <div class="card-header card-header-content-sm-between">
                    <h4 class="card-header-title mb-2 mb-sm-0">Rango de fechas </h4>
                    <div class="d-grid d-sm-flex gap-2">
                        <div class="tom-select-custom">
                            <select class="js-select form-select form-select-sm" autocomplete="off" data-hs-tom-select-options='{
                                      "searchInDropdown": false,
                                      "hideSearch": true,
                                      "dropdownWidth": "10rem"
                                    }' id="concurrencia">
                              <option value="1">Día</option>
                              <option value="2" selected>Semana</option>
                              <option value="3">Mes</option>
                            </select>
                          </div>
                        <button id="js-daterangepicker-predefined" class="btn btn-white btn-sm dropdown-toggle">
                            <i class="bi-calendar-week"></i>
                            <span class="js-daterangepicker-predefined-preview ms-1">Sep 8 - Sep 8, 2023</span>
                        </button>
                        <button  class="btn btn-primary btn-sm btn-search">
                            <i class="bi-search"></i>
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
            <div class="card card-body mb-3 mb-lg-5">
                <div class="row col-lg-divider gx-lg-6">
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="card-subtitle mb-3">Núm. de ingresos</h6>
                                <h3 class="card-title egr_sol">16</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="card-subtitle mb-3">Cantidad de salida</h6>
                                <h3 class="card-title egr_act">10</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="card-subtitle mb-3">Núm. de ingresos realizados</h6>
                                <h3 class="card-title egr_ter">1</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="card-subtitle mb-3">Núm. de ingresos cancelados</h6>
                                <h3 class="card-title egr_can">5</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Bar Chart -->
                                <div class="mt-4" id="chart-total2" style="height: 18rem;"></div>
                                <!-- End Bar Chart -->
                            </div>
                            <!-- End Body -->

                            <div class="d-lg-none">
                                <hr>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Bar Chart -->
                                <div class="mt-4" id="chart-pie" style="height: 18rem;"></div>
                                <!-- End Bar Chart -->
                            </div>
                            <!-- End Body -->

                        </div>
                    </div>
                    <!-- End Row -->
                </div>
            </div>
        </x-slot>
        <x-slot name="modals">

        </x-slot>

    </x-layout.page>
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            window.addEventListener("load",function(event) {
                HSCore.components.HSTomSelect.init('.js-select')

                @stack('js_modulo')
            });
        </script>
    @endpush
</x-app-layout>
