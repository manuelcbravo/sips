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

        <link rel="preload" href="{{ asset('assets/css/theme.min.css') }}" data-hs-appearance="default" as="style">
        <link rel="preload" href="{{ asset('assets/css/theme-dark.min.css') }}" data-hs-appearance="dark" as="style">

        <style data-hs-appearance-onload-styles>
            *
            {
                transition: unset !important;
            }

            body
            {
                opacity: 0;
            }
        </style>

        <script src="{{ asset('assets/js/plugins/init.js') }}"></script>
    </head>
    <body>
        <script src="{{ asset('assets/js/hs.theme-appearance.js') }}"></script>
        <main id="content" role="main" class="main">
                {{ $slot }}
        </main>

        <!-- JS Implementing Plugins -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme.min.js') }}"></script>
        <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/sweetalert.js') }}"></script>

        <!-- JS Plugins Init. -->
        <script>
            localStorage.clear();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            (function() {
                window.onload = function () {
                    // INITIALIZATION OF BOOTSTRAP VALIDATION
                    // =======================================================
                    HSBsValidation.init('.js-validate', {
                        onSubmit: data => {
                            data.event.preventDefault()
                            $.ajax({
                                url: data.form.action,
                                type : 'POST',
                                data : $('.js-validate').serialize(),
                                dataType: 'json',
                                beforeSend: function(){
                                    $('.nono').show()
                                    $('.sisi').hide()
                                },
                                success : function(data) {
                                    close_loading()

                                    if(typeof data.login !== 'undefined'){
                                        if(!data.login) {
                                            $('.nono').hide()
                                            $('.sisi').show()
                                            errorSwal('Error', data.mensaje);
                                        }else{
                                            window.location.replace(data.url ?? '{{ url('') }}');
                                        }
                                    }
                                },
                                error: function (err) {
                                    $('.nono').hide()
                                    $('.sisi').show()
                                    errorSwal('',err);
                                },
                            });
                        }
                    })

                    // INITIALIZATION OF TOGGLE PASSWORD
                    // =======================================================
                    new HSTogglePassword('.js-toggle-password')
                }
            })()
        </script>
    </body>
</html>
