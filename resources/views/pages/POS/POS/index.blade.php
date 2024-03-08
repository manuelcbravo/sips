<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">

        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="{{ asset('assets/css/vendor.min.css') }}">

        <!-- CSS Front Template -->
        <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css?v=1.0') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <link rel="preload" href="{{ asset('assets/css/theme.min.css') }}" data-hs-appearance="default" as="style">
        <link rel="preload" href="{{ asset('assets/css/theme-dark.min.css') }}" data-hs-appearance="dark" as="style">
        <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/fancybox.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        @stack('css')

        <style data-hs-appearance-onload-styles>
            *{
                transition: unset !important;
            }

            body {
                opacity: 0;
            }
        </style>

        <style type="text/css">
            .rounded-circle {
                
                font-size: 15px;
                text-align: center;
            }
        </style>

        <script src="{{ asset('assets/js/plugins/init.js') }}"></script>
    </head>
    <body class="scrollbar has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset" style="background-color: #f5f6fa!important">
        <script src="{{ asset('assets/js/hs.theme-appearance.js') }}"></script>
        <script src="{{ asset('assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js') }}"></script>


        <main id="content" role="main" class="m-5">
            <div class="content container-fluid">
                
                <div class="row">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <!-- Card -->
                        <div class="card mb-3 mb-lg-5">
                            <!-- Header -->
                            <div class="card-header card-header-content-between">
                                <h4 class="card-header-title">Compras
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <h5>Producto</h5>
                                    </div>
                                    <div class="col col-md-2 align-self-center">
                                        <h5>Precio</h5>
                                    </div>
                                    <div class="col col-md-2 align-self-center">
                                        <h5>Cantidad</h5>
                                    </div>
                                    <div class="col col-md-2 align-self-center text-end">
                                        <h5>Total</h5>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-grow-1 ms-3 lista_compra">
                                        <div class="row py-3 text-center" style="background-color: #f3f3f3">
                                            <label> Busque un articulo </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Card -->
                        <div class="card">
                            <div class="card-body">
                                <h5>Cuenta: {{ Auth::user()->name .' '. Auth::user()->apellidos }}</h5>
                                <!-- List Group -->
                                <ul class="list-group list-group-flush list-group-no-gutters">
                                    <li class="list-group-item">
                                        <div class="mb-3">
                                            <div class="tom-select-custom custom-empty">
                                                <select class="form-select" autocomplete="off"
                                                        data-hs-tom-select-options='{
                                                            "placeholder": "Seleccione..."
                                                        }'
                                                        id="id_cliente"
                                                        name="id_cliente">
                                                    <option value="">Busque el cliente...</option>
                                                </select>
                                                <span class="invalid-feedback">Campo obligatorio.</span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="email" id="codigo" class="form-control" placeholder="Buscar por codigo o por producto">
                                        </div>
                                        <div class="mb-3">
                                            <input type="email" id="nota" class="form-control" placeholder="Nota de la venta">
                                        </div>
                                            
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="icon icon-soft-info icon-circle">
                                                <i class="bi-basket"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="text-body text-inherit cantidad"></span>
                                            </div>
                                            <div class="flex-grow-1 text-end">
                                                <i class="bi-chevron-right text-body"></i>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row justify-content-md-end">
                                            <div class="col-12">
                                                <div class="row align-items-center mb-3">
                                                    <span class="col-6">Subtotal:</span>
                                                    <h4 class="col-6 text-end text-dark mb-0 sub-total">$0.00</h4>
                                                  </div>
                                
                                                  <hr class="my-3">
                                
                                                  <div class="row align-items-center">
                                                    <span class="col-6">Impuestos:</span>
                                                    <h4 class="col-6 text-end text-dark mb-0 impuestos">$0.00</h4>
                                                  </div>
                                
                                                  <hr class="my-3">
                                
                                                  <div class="row align-items-center">
                                                    <span class="col-6 text-dark fw-semibold">Total:</span>
                                                    <h3 class="col-6 text-end text-dark mb-0 total">$0.00</h3>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-4 p-0">
                                                        <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
                                                            <button type="button" class="btn btn-warning btn-block w-100" id="hold">Guardar</button>
                                                            <button type="button" class="btn btn-danger btn-block w-100" id="reset">Cancelar</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 p-0">
                                                        <div class="btn-group-vertical w-100" role="group" aria-label="Vertical button group">
                                                            <button type="button" class="btn btn-secondary btn-block w-100" id="print_order">Print Order</button>
                                                            <button type="button" class="btn btn-dark btn-block w-100" id="print_bill">Print Bill</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 p-0">
                                                        <button type="button" class="btn btn-success btn-block w-100" id="payment" style="height:85px;"><h2 class="text-white"><i class="bi bi-credit-card-2-front"></i> Pagar</h2></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    
                                </ul>
                                <!-- End List Group -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </main>
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

        <!-- JS Front -->
        <script src="{{ asset('assets/js/theme.min.js') }}"></script>
        <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/sweetalert.js') }}"></script>
        <script src="{{ asset('assets/js/fancybox.umd.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/tata.js') }}"></script>
        <script src="{{ asset('assets/js/moment.js') }}"></script>
        <script src="{{ asset('assets/js/locale.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/config.js') }}"></script>

        <script>
            const input_codigo = $('#codigo');
            const input_nota = $('#nota');
            const lista_compra = $('.lista_compra');
            const lista = [];
            const URL_search_clients = '{{ url('buscar_cliente')}}';
            

            window.addEventListener("load",function(event) {
                var guardado = 0;

                if(JSON.parse(localStorage.getItem('lista_guardada'))){
                    guardado = 1;
                    $('button#hold').append(`<span class="badge bg-light text-dark ms-1 dato_guar">1</span>`)
                }

                HSCore.components.HSTomSelect.init('.js-select')

                $("body").on("click","button#print_order",function(){
                    
                })
                
                $("body").on("click","button#print_bill",function(){

                })

                $("body").on("click","button#hold",function(){
                    if(guardado == 0){
                        if(lista.length > 0){
                            localStorage.removeItem('lista_guardada');
                            const listaString = JSON.stringify(lista);
                            localStorage.setItem('lista_guardada', listaString);
                            guardado = 1
                            limpiar()
                            $('button#hold').append(`<span class="badge bg-light text-dark ms-1 dato_guar">1</span>`)
                        }
                    }else{
                        lista_cargar(JSON.parse(localStorage.getItem('lista_guardada')))
                        localStorage.removeItem('lista_guardada');
                        guardado = 0
                        $(".dato_guar").remove();
                    }
                    
                })

                $("body").on("click","button#reset",function(){
                    limpiar()
                })

                $("body").on("click","button.btn-plus",function(){
                    var productId = $(this).data("id");
                    var productIndex = lista.findIndex(producto => producto.id === productId);

                    if (productIndex !== -1) {

                        lista[productIndex].cantidad += 1;
                        lista[productIndex].precio += lista[productIndex].precio_unitario;
                        lista_cargar(lista);

                    }
                })
                
                $("body").on("click","button.btn-minus",function(){
                    var productId = $(this).data("id");
                    var productIndex = lista.findIndex(producto => producto.id === productId);

                    if (productIndex !== -1) {
                        lista[productIndex].cantidad -= 1;
                        lista[productIndex].precio -= lista[productIndex].precio_unitario;

                        if(lista[productIndex].cantidad == 0){
                            lista.splice(productIndex, 1);
                        }
                        lista_cargar(lista);
                    }
                })

                $("body").on("click","i.rmv",function(){
                    var productId = $(this).data("id");
                    var productIndex = lista.findIndex(producto => producto.id === productId);

                    if (productIndex !== -1) {
                        lista.splice(productIndex, 1);
                        lista_cargar(lista);
                    }
                })

                input_codigo.on('input', function() {
                    let url = '{{ url('articulos/buscar') }}/' + $(this).val()
                    HSCallGet.init(url,get)
                
                });

                const get = (data) => {
                    if(data.respuesta){
                        if(data.productos.length === 1){

                            var productoExistente = lista.find(function(item) {
                                return item.id === data.productos[0].id;
                            });

                            if (productoExistente) {
                                productoExistente.cantidad += 1;
                                productoExistente.precio += parseFloat(data.productos[0].precio);
                            } else {
                                // Si no existe, agrega un nuevo producto al arreglo
                                lista.push({
                                    id: data.productos[0].id,
                                    nombre: data.productos[0].articulo,
                                    descripcion: data.productos[0].descripcion,
                                    precio: parseFloat(data.productos[0].precio),
                                    precio_unitario: parseFloat(data.productos[0].precio),
                                    cantidad: 1
                                });
                            }

                            lista_cargar(lista);

                        }else{

                        }

                    
                    }else{

                    }
                    console.log(lista);
                    
                }
            })

            const limpiar = () =>{
                lista_compra.empty()

                lista_compra.append(`<div class="row py-3 text-center" style="background-color: #f3f3f3">
                    <label> Busque un articulo </label>
                </div>`)

                $('.total').empty().html('$'+dinero('0'))
                $('.sub-total').empty().html('$'+dinero('0'))
                $('.impuestos').empty().html('$'+dinero('0'))
                $('.cantidad').empty().html(0 + ' productos')
                input_codigo.val('')
                input_nota.val('')
                T_cliente.setValue([]);
            }

            const lista_cargar = (data) => {
                let subtotal = 0;
                let impuestos = 0;
                let total = 0;
                let cantidad = 0;

                lista_compra.empty()
                data.forEach(function(producto) {
                    lista_compra.append(`<div class="row py-3" style="background-color: #f3f3f3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a class="h3 d-block" href="ecommerce-product-details.html">${producto.nombre}</a>
                            <label>${producto.descripcion}</label>
                        </div>
                        <div class="col col-md-2 align-self-center">
                            <h3>$${dinero(producto.precio_unitario)}</h3>
                        </div>
                        <div class="col col-md-2 align-self-center">
                            <h3>
                                <button type="button" class="btn btn-secondary rounded-circle btn-xs btn-minus" data-id="${producto.id}"><i class="bi bi-dash-lg"></i></button>
                                ${producto.cantidad}
                                <button type="button" class="btn btn-secondary rounded-circle btn-xs btn-plus" data-id="${producto.id}"><i class="bi bi-plus-lg"></i></button>
                            </h3>
                        </div>
                        <div class="col col-md-2 align-self-center text-end">
                            <h3>$${dinero(producto.precio)} <i class="bi bi-trash3-fill text-danger rmv" style="cursor: pointer" data-id="${producto.id}"></i></h3>
                        </div>
                    </div>`)
                    total += producto.precio;
                    cantidad += producto.cantidad;
                })

                $('.total').empty().html('$'+dinero(total))
                $('.sub-total').empty().html('$'+dinero(total-(total*{{ ENV('APP_IMPUESTOS_POR')}})))
                $('.impuestos').empty().html('$'+dinero(total*{{ ENV('APP_IMPUESTOS_POR')}}))
                $('.cantidad').empty().html(cantidad + ' productos')
            }

            const tom_select = HSCore.components.HSTomSelect.getItems()

            const T_cliente = new TomSelect('#id_cliente', {
                valueField: 'id',
                labelField: 'nombre',
                searchField: ['nombre','rfc'],
                shouldLoad:function(query){
                    return query.length > 2;
                },
                load: function(query, callback) {
                    var url = URL_search_clients + '/' + encodeURIComponent(query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            callback(json.items);
                        }).catch(()=>{
                        callback();
                    });
                },
                render: {
                    option: function(item, escape) {
                        return `<div class="py-2 d-flex">
                            <div>
                                <div class="mb-1">
                                    <span class="d-block text-muted">RFC: ${ escape(item.rfc) }</span>
                                    <span class="h4">${ escape(item.nombre) }</span>
                                </div>
                            </div>
                        </div>`;
                    },
                    item: function(item, escape) {
                        return `<div class="py-2 d-flex">
                            <div>
                                <div class="mb-1">
                                    <span class="d-block text-muted">rfc: ${ escape(item.rfc) }</span>
                                    <span class="h4">${ escape(item.nombre) }</span>
                                </div>
                            </div>
                        </div>`;
                    }
                }
            });

        </script>

    </body>
</html>
