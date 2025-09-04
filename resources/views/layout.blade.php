<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ AppCore::getOpenGraphTitle() }}</title>
    <meta name="description" content="{{ AppCore::getOpenGraphDescription() }}">

    <meta property='og:title' content="{{ AppCore::getOpenGraphTitle() }}">
    <meta property='og:description' content="{{ AppCore::getOpenGraphDescription() }}">
    <meta property='og:image' content="{{ AppCore::getOpenGraphImage() }}">

    <meta name="twitter:card" content="photo" />
    <meta name="twitter:title" content="{{ AppCore::getOpenGraphTitle() }}" />
    <meta name="twitter:description" content="{{ AppCore::getOpenGraphDescription() }}" />
    <meta name="twitter:image" content="{{ AppCore::getOpenGraphImage() }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link href="/vendor/bootstrap@5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="/vendor/bootstrap@5.3.2/js/bootstrap.bundle.min.js"></script> -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <script src='/vendor/jquery@3.3.1/js/jquery.min.js'></script>

    <link rel="stylesheet" type="text/css" href="/vendor/fontawesome@6.5.1/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="/vendor/open-color@1.9.1/css/open-color.min.css">

    <script src="/vendor/toastr@2.1.3/js/toastr.min.js"></script>
    <link href="/vendor/toastr@2.1.3/css/toastr.min.css" rel="stylesheet">

    <script src="/vendor/autosize@3.0.20/js/autosize.min.js"></script>

    @yield('head')
    @stack('styles')
</head>

<body>

    @include('navbar')

    @yield('content')

    @include('footer')

    <script>
        $(document).ready(function() {
            @if (session('status.success'))
                toastr.success('{{ session('status.success') }}');
            @endif

            @if (session('status.info'))
                toastr.info('{{ session('status.info') }}');
            @endif

            @if (session('status.warning'))
                toastr.warning('{{ session('status.warning') }}');
            @endif

            @if (session('status.error'))
                toastr.error('{{ session('status.error') }}');
            @endif

            autosize(document.querySelectorAll('.autosize'));

            $('form').submit(function(e) {
                const form = $(this);

                // 如果表單有 'ajax-form' 類別，跳過防重複提交邏輯
                if (form.hasClass('ajax-form')) {
                    return;
                }

                const submitButtons = form.find('input[type=submit], button[type=submit]');

                if (submitButtons.length > 0) {
                    submitButtons.prop('disabled', true);
                    submitButtons.each(function() {
                        const button = $(this);
                        const originalWidth = button.outerWidth();
                        button.css('width', originalWidth);

                        if (button.is('input')) {
                            button.val('送出中...');
                        } else {
                            button.text('送出中...');
                        }
                    });
                }
            });
        });
    </script>

    <div id="loading" style="display: none;">
        <span id="loading-icon" class="fa-10x">
            <i class="fas fa-spinner fa-spin"></i>
        </span>
    </div>

    <style>
        #loading {
            position: fixed;
            /* Sit on top of the page content */
            width: 100%;
            /* Full width (cover the whole page) */
            height: 100%;
            /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            /* Black background with opacity */
            z-index: 2;
            /* Specify a stack order in case you're using a different order for other elements */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #loading-icon {
            color: white;
        }
    </style>

    <style>
        .btn.btn-default {
            color: #292b2c;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn.btn-default:hover {
            color: #292b2c;
            background-color: #e6e6e6;
            border-color: #adadad;
        }

        .btn.btn-default:active {
            color: #292b2c;
            background-color: #d4d4d4;
            background-image: none;
            border-color: #8c8c8c;
        }
    </style>

    @stack('scripts')
</body>

</html>
