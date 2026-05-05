@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" type="text/css" rel="stylesheet">
@stop

<style>
    :root {
        --cert-primary: #1a56db;
        --cert-primary-hover: #1e429f;
        --cert-primary-light: #ebf5ff;
        --cert-surface: #ffffff;
        --cert-bg: #f4f6fb;
        --cert-border: #e2e8f0;
        --cert-border-focus: #93c5fd;
        --cert-text: #1e293b;
        --cert-text-muted: #64748b;
        --cert-text-label: #374151;
        --cert-radius: 10px;
        --cert-radius-sm: 6px;
        --cert-shadow: 0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
        --cert-shadow-md: 0 4px 16px rgba(0,0,0,.08);
    }

    /* Layout base */
    #divcontenedor {
        background: var(--cert-bg);
        min-height: 100vh;
        padding: 0;
    }

    /* Header */
    .cert-header {
        background: var(--cert-surface);
        border-bottom: 1px solid var(--cert-border);
        padding: 18px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: var(--cert-shadow);
    }

    .cert-header-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cert-header-title .cert-icon-badge {
        width: 38px;
        height: 38px;
        background: var(--cert-primary-light);
        border-radius: var(--cert-radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--cert-primary);
        font-size: 17px;
    }

    .cert-header-title h1 {
        font-size: 17px;
        font-weight: 600;
        color: var(--cert-text);
        margin: 0;
        line-height: 1.2;
    }

    .cert-header-title p {
        font-size: 12px;
        color: var(--cert-text-muted);
        margin: 0;
    }

    /* Breadcrumb */
    .cert-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--cert-text-muted);
    }

    .cert-breadcrumb span.sep {
        opacity: 0.5;
    }

    .cert-breadcrumb span.active {
        color: var(--cert-primary);
        font-weight: 500;
    }

    /* Contenido principal */
    .cert-main {
        padding: 28px;
        max-width: 780px;
        margin: 0 auto;
    }

    /* Botón primario */
    .btn-cert-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--cert-primary);
        color: #ffffff !important;
        font-size: 13.5px;
        font-weight: 500;
        padding: 9px 18px;
        border: none;
        border-radius: var(--cert-radius-sm);
        cursor: pointer;
        transition: background .18s, transform .12s, box-shadow .18s;
        text-decoration: none;
        box-shadow: 0 1px 4px rgba(26,86,219,.25);
    }

    .btn-cert-primary:hover {
        background: var(--cert-primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26,86,219,.25);
        color: #ffffff !important;
    }

    .btn-cert-primary:active {
        transform: translateY(0);
    }

    /* Card del formulario */
    .cert-card {
        background: var(--cert-surface);
        border: 1px solid var(--cert-border);
        border-radius: var(--cert-radius);
        box-shadow: var(--cert-shadow-md);
        overflow: hidden;
    }

    .cert-card-header {
        background: var(--cert-primary-light);
        border-bottom: 1px solid var(--cert-border);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cert-card-header i {
        color: var(--cert-primary);
        font-size: 16px;
    }

    .cert-card-header span {
        font-size: 14px;
        font-weight: 600;
        color: var(--cert-primary);
    }

    .cert-card-body {
        padding: 28px 24px;
    }

    /* Grupos de formulario */
    .cert-form-group {
        margin-bottom: 22px;
    }

    .cert-form-group:last-child {
        margin-bottom: 0;
    }

    .cert-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--cert-text-label);
        margin-bottom: 7px;
        letter-spacing: .01em;
    }

    .cert-label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .cert-input,
    .cert-select {
        display: block;
        width: 100%;
        font-size: 14px;
        color: var(--cert-text);
        background: #fafbfd;
        border: 1px solid var(--cert-border);
        border-radius: var(--cert-radius-sm);
        padding: 10px 14px;
        transition: border-color .18s, box-shadow .18s, background .18s;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
    }

    .cert-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px;
        padding-right: 38px;
        cursor: pointer;
    }

    .cert-input:focus,
    .cert-select:focus {
        border-color: var(--cert-border-focus);
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(147,197,253,.25);
    }

    .cert-input::placeholder {
        color: #a0aec0;
    }

    /* Separador de sección */
    .cert-divider {
        border: none;
        border-top: 1px solid var(--cert-border);
        margin: 24px 0;
    }

    /* Hint debajo de un campo */
    .cert-hint {
        font-size: 11.5px;
        color: var(--cert-text-muted);
        margin-top: 5px;
    }

    /* Botón submit */
    .cert-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 20px;
        border-top: 1px solid var(--cert-border);
        margin-top: 24px;
    }

    .btn-cert-secondary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        color: var(--cert-text-muted);
        font-size: 13.5px;
        font-weight: 500;
        padding: 9px 18px;
        border: 1px solid var(--cert-border);
        border-radius: var(--cert-radius-sm);
        cursor: pointer;
        transition: background .15s, color .15s;
    }

    .btn-cert-secondary:hover {
        background: #f1f5f9;
        color: var(--cert-text);
    }

    .btn-cert-success {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #16a34a;
        color: #ffffff !important;
        font-size: 13.5px;
        font-weight: 500;
        padding: 9px 20px;
        border: none;
        border-radius: var(--cert-radius-sm);
        cursor: pointer;
        transition: background .18s, transform .12s;
        box-shadow: 0 1px 4px rgba(22,163,74,.2);
    }

    .btn-cert-success:hover {
        background: #15803d;
        transform: translateY(-1px);
    }

    /* Tabla */
    .cert-table-wrapper {
        margin-top: 28px;
    }

    .cert-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .cert-table-header h2 {
        font-size: 14px;
        font-weight: 600;
        color: var(--cert-text);
        margin: 0;
    }

    #tablaDatatable {
        background: var(--cert-surface);
        border: 1px solid var(--cert-border);
        border-radius: var(--cert-radius);
        overflow: hidden;
        box-shadow: var(--cert-shadow);
    }

    /* Animate entrance */
    @keyframes certFadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .cert-animate {
        animation: certFadeUp .32s ease both;
    }

    .cert-animate-delay {
        animation: certFadeUp .32s ease .12s both;
    }
</style>

<div id="divcontenedor" style="display: none">

    {{-- Header --}}
    <div class="cert-header cert-animate">
        <div class="cert-header-title">
            <div class="cert-icon-badge">
                <i class="fas fa-certificate"></i>
            </div>
            <div>
                <h1>Certificados</h1>
                <p>Gestión de certificados de diplomado</p>
            </div>
        </div>
        <div class="cert-breadcrumb">
            <span>Diplomado</span>
            <span class="sep">›</span>
            <span>Certificado</span>
            <span class="sep">›</span>
            <span class="active">Listado</span>
        </div>
    </div>

    {{-- Contenido principal --}}
    <div class="cert-main">



        {{-- Card del formulario --}}
        <div class="cert-card cert-animate-delay">

            <div class="cert-card-header">
                <i class="fas fa-file-alt"></i>
                <span>Datos del certificado</span>
            </div>

            <div class="cert-card-body">
                <form id="formRifa">
                    @csrf

                    {{-- Nombre alumno --}}
                    <div class="cert-form-group">
                        <label class="cert-label" for="nombre">
                            Nombre del alumno
                            <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="nombre"
                            maxlength="100"
                            autocomplete="off"
                            class="cert-input"
                            placeholder="Ej. Juan Carlos López"
                            required
                        >
                        <p class="cert-hint">Ingrese el nombre completo del alumno.</p>
                    </div>

                    <hr class="cert-divider">

                    {{-- Curso --}}
                    <div class="cert-form-group">
                        <label class="cert-label" for="select-curso">Curso</label>
                        <select class="cert-select" id="select-curso">
                            @foreach($arrayCurso as $sel)
                                <option value="{{ $sel->id }}">{{ $sel->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Certificado --}}
                    <div class="cert-form-group">
                        <label class="cert-label" for="select-certificado">Certificado</label>
                        <select class="cert-select" id="select-certificado">
                            @foreach($arrayCertificado as $sel)
                                <option value="{{ $sel->id }}">{{ $sel->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Acciones --}}
                    <div class="cert-actions">

                        <button type="button" class="btn-cert-success" onclick="nuevoRegistro()">
                            <i class="fas fa-save"></i>
                            Guardar registro
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>


@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>
    <script src="{{ asset('plugins/ckeditor5v1/build/ckeditor.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            document.getElementById("divcontenedor").style.display = "block";
            recargar();
        });
    </script>

    <script>

        $('#select-curso').select2({
            theme: "bootstrap-5",
            "language": {
                "noResults": function(){
                    return "Busqueda no encontrada";
                }
            },
        });

        $('#select-certificado').select2({
            theme: "bootstrap-5",
            "language": {
                "noResults": function(){
                    return "Busqueda no encontrada";
                }
            },
        });


        function recargar(){
            var ruta = "{{ URL::to('/admin/diplomado/certificado/tabla') }}";
            $('#tablaDatatable').load(ruta);
        }

        function modalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            $('#modalAgregar').modal('show');
        }

        function nuevoRegistro(){
            var nombre = document.getElementById('nombre').value;
            var curso = document.getElementById('select-curso').value;
            var certificado = document.getElementById('select-certificado').value;

            if(nombre === ''){
                toastr.error('El nombre del alumno es requerido');
                return;
            }

            openLoading();
            var formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('curso', curso);
            formData.append('certificado', certificado);

            axios.post('/admin/diplomado/alumno/crear', formData)
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastr.success('Registro guardado correctamente');

                        let codigo = response.data.codigo;

                        // 🔄 limpiar inputs
                        document.getElementById('nombre').value = '';
                        $('#select-curso').val(null).trigger('change');
                        $('#select-certificado').val(null).trigger('change');

                        // 🧾 mostrar QR
                        let html = `
                        <div style="margin-top:20px; text-align:center;">
                            <h5>Código de verificación</h5>
                            <p>${codigo}</p>
                            <img id="qrImg" src="/qr/${codigo}" />

                            <br><br>

                            <button onclick="descargarQR('${codigo}')" class="btn-cert-primary">
                                Descargar QR PNG
                            </button>
                        </div>
                    `;

                        document.querySelector('.cert-main').insertAdjacentHTML('beforeend', html);
                    } else {
                        toastr.error('Error al registrar');
                    }
                })
                .catch(() => {
                    toastr.error('Error al registrar');
                    closeLoading();
                });
        }

        function descargarQR(codigo){
            let img = document.getElementById('qrImg');

            fetch(img.src)
                .then(res => res.text())
                .then(svg => {
                    let canvas = document.createElement("canvas");
                    let ctx = canvas.getContext("2d");

                    let image = new Image();
                    let blob = new Blob([svg], {type: 'image/svg+xml'});
                    let url = URL.createObjectURL(blob);

                    image.onload = function(){
                        canvas.width = image.width;
                        canvas.height = image.height;
                        ctx.drawImage(image, 0, 0);

                        let png = canvas.toDataURL("image/png");

                        let a = document.createElement("a");
                        a.href = png;
                        a.download = "qr_" + codigo + ".png";
                        a.click();

                        URL.revokeObjectURL(url);
                    };

                    image.src = url;
                });
        }

    </script>

@endsection
