<x-modal.modal id="ModalArchivo" size="modal-xl" nombretitulo="tituloArchivo">
    <x-slot name="titulo"> </x-slot>
    <x-slot name="body">
        <div class="row align-items-center">
            <div class="col-sm mb-5 mb-sm-0">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="col-sm-auto">
                <button class="btn btn-warning fole" data-id="0" style="display: none">
                    <i class="bi-arrow-left mr-1"></i> Regresar a home
                </button>
            </div>
            <div class="col-sm-auto">
                <button class="btn btn-primary add-n" data-action="ClienteModal">
                    <i class="bi-plus mr-1"></i> Nuevo documento
                </button>
            </div>
        </div>
        <!-- Dropzone -->
        <div id="DropZone" class="js-dropzone row dz-dropzone dz-dropzone-card mt-3" style="display: none">
            <div class="dz-message">
                <img class="avatar avatar-xl avatar-4x3 mb-3" src="{{ asset('assets') }}/svg/illustrations/oc-browse.svg" alt="Image Description">

                <h5>Arrastra y suelta tus archivos aqui</h5>

                <p class="mb-2">-- o --</p>

                <span class="btn btn-white btn-sm">Buscar archivos</span>
            </div>
        </div>
        <!-- End Dropzone -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-5 mt-5 fol">

        </div>
        <h3 class="mt-3 mb-3">Archivos</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4" id="archivos">

        </div>
    </x-slot>
    @push('js_modulo')
        let car,url, asoc,tab,pac;

        $("body").on('dblclick', 'a', function(e) {
            car = $(this).data('id')
            $('.fole').show()
            $('.fol').hide()
            $('.lis').show()
            dropzone.options.params =  {
                asoc: asoc,
                tab: tab,
                pac: pac,
                car: car
            };
            HSCallGet.init(url+'/'+car,get_archivo)
        });

        $('body').on('click', '.fole', function (event) {
            $('#DropZone').hide();
            car = 0
            $('.fol').show()
            $('.fole').hide()
            HSCallGet.init(url+'/'+car,get_archivo)
        });

        $.each(catalogos().folders, function(index, value) {
            $('.fol').append(`<div class="col mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card card-sm card-hover-shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="bi-folder fs-2 text-body me-2"></i>

                            <h5 class="text-truncate ms-2 mb-0">${value.nombre}</h5>

                            <!-- Dropdown -->
                            <div class="dropdown ms-auto">
                                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="folderDropdown${value.index}" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-three-dots-vertical"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="folderDropdown${value.index}" style="min-width: 13rem;">
                                    <span class="dropdown-header">Settings</span>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi-folder dropdown-item-icon"></i> Open
                                    </a>
                                </div>
                            </div>
                            <!-- End Dropdown -->
                        </div>
                    </div>
                    <a class="stretched-link" href="#" data-id="${value.id}"></a>
                </div>
                <!-- End Card -->
            </div>`)
        })
        $(".add-n").on('click', function(event){
            $('#DropZone').toggle();
        });

        HSCore.components.HSDropzone.init('#DropZone')
        const dropzone = HSCore.components.HSDropzone.getItem('DropZone');
        dropzone.options.url = '{{ url('archivosTr') }}'
        dropzone.options.headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        dropzone.options.errorMessage = 'El archivo es muy grande'
        dropzone.options.maxFilesize = 12
        dropzone.on("complete", function(file) {
            dropzone.removeFile(file);
            tata.success('Éxito', "Subido correctamente");
        });

        dropzone.on("success", function(file, data) {
            archivos(data.archivos)
        });

        dropzone.on("error", function(file, data) {
            errorSwal('Error', data);
        });

        $("table").on("click","[data-bs-target='#ModalArchivo']",function(){
            $('.fole').hide();
            $('.lis').show()
            $('.fol').show()
            car= 0
            asoc=  $(this).data('uuid');
            tab= '{{ $table ?? null }}';
            pac= '{{ $carpeta ?? 'archivos' }}';

            dropzone.options.params =  {
                asoc: $(this).data('uuid'),
                tab: '{{ $table ?? null }}',
                pac: '{{ $carpeta ?? 'archivos' }}',
                car: car
            };

            url = $(this).data('url')
            HSCallGet.init(url+'/'+car,get_archivo)
        })

        const get_archivo = (data) => {
            if(data.respuesta) {
                $('#tituloArchivo').text('DOCUMENTOS DE : ' + data.nombre);
                archivos(data.archivos);
            }
        }

        $(document).on('click', '.rmv-arc', function(){
            HSCallDelete.init($(this),del_archivo)
        })

        $(document).on('click', '.ren', function(){
            let uuid = $(this).data('uuid')
            $('.n-'+uuid).hide();
            $('.i-'+uuid).show();
        })

        $(document).on('click', '.ren-can', function(){
            let uuid = $(this).data('uuid')
            $('.n-'+uuid).show();
            $('.i-'+uuid).val('').hide();
        })

        $(document).on('click', '.ren-ren', function(){
            let uuid = $(this).data('uuid')
            let name = $('#rena-'+uuid).val();
            if(name){
            $.ajax({
                url: '{{ url('archivosTr/rename') }}',
                type : 'POST',
                data : { 'id' : uuid , 'name' : name},
            beforeSend: function(){
                loading()
            },
            success : function(data) {
                $('.n-'+uuid).show();
                $('.i-'+uuid).val('').hide();
                close_loading()
                if(data.respuesta) {
                    $('#tituloArchivo').text('Documentos de: ' + data.nombre);
                    archivos(data.archivos);
                }
            },
            error: function (err) {
                close_loading()
                errorSwal('Error',err);
            },
            });
            }else{
                errorSwal('Error','Ingrese un nuevo nombre');
            }
        })

        const del_archivo = (data) =>{
            tata.success('Éxito', "Eliminado correctamente");
            archivos(data.archivos);
        }

        const archivos = (data) => {
            $('#archivos').empty();
            if(data.length == 0){
                $('#archivos').append('<h5>No hay archivos para mostrar</h5>');
            }else{
                $.each(data, function (index, value) {
                let img = (value.tipo === 'pdf' || value.tipo === 'docx' || value.tipo === 'xlsx' || value.tipo === 'pptx') ? value.tipo : "img";
                $('#archivos').append(`<div class="col mb-3 mb-lg-5">
                    <div class="card card-sm card-hover-shadow card-header-borderless h-100 text-center">
                        <div class="card-header card-header-content-between border-0">
                            <span class="small">${formatBytes(value.tamano)}</span>
                            <div class="dropdown">
                                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="filesGridDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-three-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="filesGridDropdown2" style="min-width: 13rem;">
                                    <span class="dropdown-header">Opciones</span>
                                    <button class="dropdown-item ren" data-uuid="${value.id}">
                                        <i class="bi-pencil dropdown-item-icon"></i> Renombrar
                                    </button>
                                    <a class="dropdown-item" href="documentos/${ value.direccion}" download="${ value.nombre_original }">
                                        <i class="bi-download dropdown-item-icon"></i> Descargar
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <button class="dropdown-item text-danger rmv-arc" data-id="${value.id}" data-url="{{ url('archivosTr') }}/${value.id}">
                                        <i class="bi-trash dropdown-item-icon text-danger"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                            <!-- End Dropdown -->
                        </div>

                        <div class="card-body">
                            <img class="avatar avatar-4x3" src="{{ asset('assets/svg') }}/icons/${img}.svg">
                        </div>

                        <div class="card-body">
                            <h5 class="card-title n-${value.id}">${ value.nombre_original }</h5>
                            <div class="input-group mb-3 i-${value.id}" style="display: none">
                                <input type="text" class="form-control" name="rena-${value.id}" id="rena-${value.id}" placeholder="${value.nombre_original}" style="z-index: 100">

                                <div class="input-group-append">
                                    <button class="btn btn-xs btn-outline-success ren-ren" data-uuid="${value.id}"><i class="bi bi-check2"></i> </button>
                                    <button class="btn btn-xs btn-outline-danger ren-can" data-uuid="${value.id}"><i class="bi bi-x"></i> </button>
                                </div>
                            </div>
                            <p class="small">${ moment.parseZone(value.created_at).format('l LT') }</p>
                        </div>

                        <a class="stretched-link verdoc" data-arc="documentos/${ value.direccion}"></a>
                    </div>
                    <!-- End Card -->
                </div>`)
                });
            }
        }

    @endpush
</x-modal.modal>