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

        <script src="{{ asset('assets/js/plugins/init.js') }}"></script>
    </head>
    <body class="scrollbar has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset" style="background-color: #f5f6fa!important">
        <script src="{{ asset('assets/js/hs.theme-appearance.js') }}"></script>
        <script src="{{ asset('assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js') }}"></script>

        @include('layouts.components.header')
        @include('layouts.components.sidebar',  ['activePage' => $attributes->get('active')])


        <main id="content" role="main" class="main">
            {{ $slot }}
            @include('layouts.components.footer')
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
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- The core Firebase JS SDK is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
        <script>
            const catalogos = () =>{
                let cat = localStorage.getItem('{{ env('ENCRIPTADO_CATALOGOS') }}')
                if(cat){
                    return JSON.parse(cat)
                }else {
                    $.ajax({
                        url: "{{ url('catalogos')}}",
                        async: false,
                    }).done(function (res) {
                        localStorage.setItem('{{ env('ENCRIPTADO_CATALOGOS') }}', JSON.stringify(res))
                        return res
                    });
                }
            }

            catalogos();
            $('.dolar').html('$ '+dinero(catalogos().dollar.dato));
            $('.fecha_dolar').html(catalogos().dollar.fecha);

            $(document).on('input', 'input[type=text]', function(){
                // store current positions in variables
                var start = this.selectionStart,
                    end = this.selectionEnd;
                this.value = this.value.toUpperCase();
                // restore from variables...
                this.setSelectionRange(start, end);
            });

            $(document).on('click', '.verdoc', function(){
                Fancybox.show([
                    {
                        maxWidth: 800,
                        fitToView: false,
                        autoSize: false,
                        openEffect: 'elastic',
                        closeEffect: 'elastic',
                        autoScale: true,
                        type: 'iframe',
                        src: $(this).data('arc'),
                    },
                ])
            });

        </script>
        @if( !env('APP_DEBUG'))
            <script src="{{ asset('assets/js/plugins/req.js') }}"></script>
        @endif
        @auth()
{{--            <script src="{{ asset('assets/js/plugins/fire.js') }}" url="{{ url('') }}" cross="{{ Auth::user()->id }}"></script>--}}
        @endauth

        @stack('js')

    </body>
</html>
