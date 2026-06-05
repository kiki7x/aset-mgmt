<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    {{-- Flaticon --}}
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
    {{-- Bootstrap 4.6 --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    {{-- Bootstrap Datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- script-head --}}
    @stack('script-head')
    {{-- ./script-head --}}
    @php
        $isReadOnlyUser = auth()->check() && auth()->user()->hasRole('user');
    @endphp
</head>

{{-- <body class="hold-transition layout-top-nav layout-fixed layout-navbar-fixed text-sm"> --}}

<body class="hold-transition layout-fixed sidebar-mini {{ $isReadOnlyUser ? 'readonly-user' : '' }}">
    <div class="wrapper">
        <x-backsite.navbar></x-backsite.navbar>
        <div class="content-wrapper">
            <x-backsite.header>
                <x-slot name="welcome">
                    {{ isset($welcome) ? $welcome : '' }}
                </x-slot>
                <x-slot name="breadcrumb">
                    {!! isset($breadcrumb) ? $breadcrumb : '' !!}
                </x-slot>
            </x-backsite.header>
            <section class="content">
                <div class="container-fluid">
                    {{-- content --}}
                    @yield('content')
                    {{-- end content --}}
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <x-backsite.footer></x-backsite.footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 4.6.1-->
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    {{-- Moment.js --}}
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/locales.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.js?v=3.2.0') }}"></script>
    <!-- init bootstrap tooltip -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Datatables --}}
    {{-- <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script> --}}
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    {{-- Toastr --}}
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    {{-- Bootstrap datepicker 1.9.0 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        window.addEventListener('alert', (e) => {
            const {
                type,
                message
            } = e.detail;
            if (['success', 'error', 'info', 'warning'].includes(type)) {
                toastr[type](message); // Tampilkan toastr sesuai tipe
            }
        });
    </script>
    @if ($isReadOnlyUser)
        <script>
            // Peringatan untuk role 'user'
            const __readonlyUserWarningText = 'Fungsi ini hanya boleh dilakukan oleh role superaadmin/staf rt/staf tik';

            function _isCrudTrigger(el) {
                if (!el || el.nodeType !== 1) return false;

                const title = (el.getAttribute('title') || '').toLowerCase();
                const aria = (el.getAttribute('aria-label') || '').toLowerCase();
                const text = (el.textContent || '').toLowerCase();
                const href = (el.getAttribute('href') || '').toLowerCase();
                const onclick = (el.getAttribute('onclick') || '').toLowerCase();
                const wireClick = (el.getAttribute('wire:click') || '').toLowerCase();
                const className = (el.className || '').toLowerCase();

                if (el.closest('[data-crud="true"]')) return true;

                if (/hapus|delete|remove/.test(title) || /hapus|delete|remove/.test(aria)) return true;
                if (/tambah|create|add|edit|hapus|delete|remove|submit|simpan|save/.test(text)) return true;
                if (/(\/create|\/edit|\/delete|\/destroy)/i.test(href)) return true;
                if (/showm\(|openmodalcreate\(|dispatch\(|wire:click/.test(onclick + ' ' + wireClick)) return true;
                if (/btn-danger|btn-warning|btn-success/.test(className) && /hapus|delete|remove|edit|tambah|create|add|simpan|save|submit/.test(text + ' ' + title)) return true;

                return false;
            }

            // Capture-phase click listener: dibatasi hanya di area konten admin
            document.addEventListener('click', function(e) {
                try {
                    const contentRoot = e.target.closest('.content-wrapper');
                    if (!contentRoot) return;

                    const crudTarget = e.target.closest('[data-crud="true"]') || (e.target.closest('a,button,form') && _isCrudTrigger(e.target.closest('a,button,form')));
                    if (crudTarget) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        e.stopPropagation();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Akses Ditolak',
                            text: __readonlyUserWarningText,
                            confirmButtonText: 'Tutup'
                        });
                        return false;
                    }
                } catch (err) {
                    console.error('Readonly role interceptor error', err);
                }
            }, true); // useCapture = true

            // Capture-phase submit listener: cegah submit dari form CRUD yang ditandai atau terdeteksi di area konten
            document.addEventListener('submit', function(e) {
                try {
                    const form = e.target;
                    if (!form || form.nodeName !== 'FORM') return;

                    if (!form.closest('.content-wrapper')) return;

                    const submitter = e.submitter || null;
                    const submitterIsCrud = submitter && submitter.closest('[data-crud="true"]');
                    const formIsCrud = form.closest('[data-crud="true"]') || form.querySelector('[data-crud="true"]') || _isCrudTrigger(form);

                    if (submitterIsCrud || formIsCrud) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Akses Ditolak',
                            text: __readonlyUserWarningText,
                            confirmButtonText: 'Tutup'
                        });
                        return false;
                    }
                } catch (err) {
                    console.error('Readonly form interceptor error', err);
                }
            }, true);
        </script>
    @endif
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    {{-- script tambahan --}}
    @stack('script-foot')
    {{-- ./script tambahan --}}
</body>

</html>
