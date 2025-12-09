{{-- resources/views/frontend/buzon-sugerencias.blade.php --}}

@include('frontend.menu.indexsuperior')
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />

<style>
    :root{
        --brand:#14532d;
        --brand-soft:#e0f2f1;
        --ink:#0f172a;
        --muted:#64748b;
        --bg:#f8fafc;
        --card:#ffffff;
        --ring:rgba(15,23,42,.06);
        --radius:14px;
    }

    body{
        background:linear-gradient(180deg,var(--bg),#edf2f7 60%);
        color:var(--ink);
        font-family: system-ui,-apple-system,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial,sans-serif;
    }

    /* TITULOS PRINCIPALES */
    .section-title{
        text-transform:uppercase;
        font-weight:800;
        letter-spacing:.08em;
        font-size:17px!important;
        margin-bottom: 0px;
    }

    .section-subtitle{
        color:var(--muted);
        max-width:900px;
        font-size: 17px!important;
        line-height:1.55;
    }

    /* TARJETA DEL FORMULARIO */
    .sugerencias-card{
        margin:30px auto 40px;
        background:var(--card);
        border-radius:20px;
        padding:28px 32px 26px;
        border:1px solid #e2e8f0;
        box-shadow:0 18px 40px -26px var(--ring);
        max-width:1100px;
    }

    .sugerencias-header h3{
        margin:0;
        font-size:1.35rem;
        font-weight:700;
    }

    .sugerencias-header span{
        font-size:.95rem;
        color:var(--muted);
    }

    /* CAMPOS */
    .form-sugerencias label{
        font-size:1rem;
        font-weight:600;
        color:#0f172a;
        margin-bottom:4px;
    }

    .form-sugerencias .form-control,
    .form-sugerencias textarea{
        border-radius:10px;
        border:1px solid #d4d4d8;
        font-size:1rem;
        padding:9px 14px;
        height:40px;
        background:#f9fafb;
        transition:0.12s;
    }

    .form-sugerencias textarea{
        border-radius:18px;
        min-height:130px;
        height:auto;
        resize:vertical;
    }

    .form-sugerencias .form-control:focus,
    .form-sugerencias textarea:focus{
        border-color:var(--brand);
        background:#fff;
        box-shadow:0 0 0 1px rgba(20,83,45,.15);
    }

    .help-text{
        font-size:.9rem;
        color:var(--muted);
        margin-top:4px;
    }

    /* BOTÓN ENVIAR */
    .btn-enviar{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:10px 28px;
        border-radius:999px;
        background:var(--brand);
        color:#fff;
        font-size:1rem;
        font-weight:600;
        border:none;
        box-shadow:0 14px 30px -18px rgba(20,83,45,.7);
        cursor:pointer;
        transition:0.12s;
    }

    .btn-enviar:hover{
        background:#166534;
        transform:translateY(-1px);
    }

    /* RESPONSIVE */
    @media (max-width: 767px){
        .sugerencias-card{
            padding:18px;
            border-radius:16px;
        }
    }

    /* SWEETALERT2 — POPUP MÁS GRANDE */
    .swal2-popup {
        width: 600px !important;
        padding: 3rem 2.8rem !important;
        border-radius: 22px !important;
    }

    .swal2-icon {
        transform: scale(1.8) !important;
        margin: 40px auto 20px auto !important;
    }

    .swal2-title {
        font-size: 2.2rem !important;
        font-weight: 800 !important;
        margin-top: 10px !important;
        margin-bottom: 18px !important;
    }

    .swal2-html-container {
        font-size: 1.3rem !important;
        font-weight: 500 !important;
    }

    .swal2-confirm {
        padding: 14px 40px !important;
        font-size: 1.2rem !important;
        border-radius: 999px !important;
        background: var(--brand) !important;
        color: #fff !important;
    }

    .swal2-confirm:hover {
        background: #0f5c29 !important;
    }

    /* ===== SELECT MODERNO ===== */
    .select-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #f9fafb;
        border: 1px solid #d4d4d8;
        border-radius: 10px;
        padding: 9px 40px 9px 14px; /* espacio para la flecha */
        height: 40px;
        font-size: 1rem;
        width: 100%;
        cursor: pointer;
        transition: 0.18s;
        color: var(--ink);
        background-image: url("data:image/svg+xml,%3Csvg width='14' height='10' viewBox='0 0 14 10' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L7 9L13 1' stroke='%2364748b' stroke-width='2'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
    }

    .select-control::-ms-expand {
        display: none;
    }

    .select-control:hover {
        background:#ffffff;
    }

    .select-control:focus {
        border-color:var(--brand);
        background:#ffffff;
        box-shadow:0 0 0 1px rgba(20,83,45,.18);
        outline:none;
    }

    .select-control:disabled {
        background:#f1f5f9;
        opacity:.6;
        cursor:not-allowed;
    }
</style>

<body>
<div class="colorlib-loader"></div>
<div id="page">
    {{-- Navbar --}}
    @include('frontend.menu.navbar')

    {{-- Imagen de cabecera --}}
    <aside id="colorlib-hero">
        <div class="flexslider">
            <ul class="slides">
                <li style="background-image: url({{ asset('images/Slider/portadaslider.jpg') }});">
                    <div class="overlay"></div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-md-offset-3 slider-text">
                                <div class="slider-text-inner text-center">
                                    <h1><strong>BUZÓN DE SUGERENCIAS</strong></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </aside>

    <h5>.</h5>

    {{-- Contenido --}}
    <div id="colorlib-services">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">

                    <header class="page-header">
                        <h2 class="section-title">BUZÓN DE SUGERENCIAS</h2>
                        <p class="section-subtitle">
                            Ayúdanos a construir un mejor municipio. Cualquier sugerencia que tengas será bienvenida
                            por nuestro equipo, quien se encargará de revisarla y darle seguimiento en la medida de lo posible.
                        </p>
                    </header>

                    <div class="sugerencias-card">
                        <div class="sugerencias-header">
                            <p style="font-weight:bold;font-size:14px">Envíenos su sugerencia</p>
                            <span style="font-size:12px">
                                Los campos marcados con <span style="color:#dc2626">*</span> son obligatorios.
                            </span>

                            {{-- Selects de distrito y servicio --}}
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px !important;" for="id_distrito">
                                            Distrito
                                            <span class="req" style="color: red">*</span>
                                        </label>
                                        <select id="id_distrito" name="id_distrito"
                                                class="form-control select-control">
                                            <option value="">Seleccione un distrito</option>
                                            @foreach($arrayDistrito as $item)
                                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px !important;" for="id_distritoservicios">
                                            Servicio / dependencia
                                            <span class="req" style="color: red">*</span>
                                        </label>
                                        <select id="id_distritoservicios" name="id_distritoservicios"
                                                class="form-control select-control" disabled>
                                            <option value="">Seleccione un servicio</option>
                                            {{-- se llena por AJAX según el distrito --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form style="margin-top: 15px" class="form-sugerencias">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px !important;" for="nombre">
                                            Nombre y Apellido
                                            <span class="req" style="color: red">*</span>
                                        </label>
                                        <input type="text"
                                               name="nombre"
                                               id="nombre"
                                               maxlength="100"
                                               autocomplete="off"
                                               class="form-control"
                                               value="{{ old('nombre') }}"
                                               required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="font-size: 12px !important;" for="telefono">
                                            Teléfono fijo o móvil
                                            <span class="req" style="color: red">*</span>
                                        </label>
                                        <input type="text"
                                               name="telefono"
                                               id="telefono"
                                               autocomplete="off"
                                               maxlength="25"
                                               class="form-control"
                                               value="{{ old('telefono') }}"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="font-size: 12px !important;" for="correo">
                                    Correo electrónico
                                </label>
                                <input type="email"
                                       name="correo"
                                       id="correo"
                                       autocomplete="off"
                                       maxlength="100"
                                       class="form-control"
                                       value="{{ old('correo') }}">
                            </div>

                            <div class="form-group">
                                <label style="font-size: 12px !important;" for="comentarios">
                                    Comentarios
                                    <span class="req" style="color: red">*</span>
                                </label>
                                <textarea name="comentarios"
                                          id="comentarios"
                                          class="form-control"
                                          rows="5"
                                          maxlength="2500"
                                          required>{{ old('comentarios') }}</textarea>
                                <p class="help-text" style="font-size: 11px !important;">
                                    Describe tu sugerencia con el mayor detalle posible.
                                </p>
                            </div>

                            <div class="text-right" style="margin-top:10px;">
                                <button type="button" class="btn-enviar" onclick="enviarDatos()">
                                    ENVIAR
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M4 4l16 8-16 8 4-8-4-8z"
                                              stroke="currentColor" stroke-width="1.7"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div> {{-- card --}}

                </div>
            </div>
        </div>
    </div>

    @include('frontend.menu.footer')
    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>
    <script src="{{ asset('js/frontend.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $(".ancla").click(function (e) {
                e.preventDefault();
                var codigo = "#" + $(this).data("ancla");
                $("html,body").animate({scrollTop: $(codigo).offset().top}, 300);
            });
        });
    </script>

    <script>
        document.getElementById('id_distrito').addEventListener('change', function () {
            cargarServiciosPorDistrito(this.value);
        });

        function cargarServiciosPorDistrito(idDistrito) {

            let selectServicios = document.getElementById('id_distritoservicios');
            selectServicios.innerHTML = '<option value="">Seleccione un servicio</option>';
            selectServicios.disabled = true;

            if (idDistrito === '') {
                return;
            }

            openLoading()

            let formData = new FormData();
            formData.append('id_distrito', idDistrito);

            axios.post('/buscar/distrito/servicios', formData)
                .then((response) => {

                    closeLoading()
                    if (response.data.success === 1) {
                        let lista = response.data.lista;
                        lista.forEach(function (item) {
                            let option = document.createElement('option');
                            option.value = item.id;
                            option.text = item.nombre;
                            selectServicios.appendChild(option);
                        });
                        selectServicios.disabled = false;
                    } else {
                        toastr.error('No se pudieron cargar los servicios');
                    }
                })
                .catch((error) => {
                    closeLoading()

                    toastr.error('Error al cargar servicios');
                });
        }
    </script>

    <script>
        function enviarDatos(){

            var nombre = document.getElementById('nombre').value;
            var telefono = document.getElementById('telefono').value;
            var correo = document.getElementById('correo').value;
            var comentarios = document.getElementById('comentarios').value;
            var id_distrito = document.getElementById('id_distrito').value;
            var id_distritoservicios = document.getElementById('id_distritoservicios').value;

            if(id_distrito === ''){
                toastr.error('Seleccione un distrito');
                return;
            }

            if(id_distritoservicios === ''){
                toastr.error('Seleccione un servicio');
                return;
            }

            if(nombre === ''){
                toastr.error('Nombre es requerido');
                return;
            }

            if(telefono === ''){
                toastr.error('Teléfono es requerido');
                return;
            }

            if(comentarios === ''){
                toastr.error('Comentarios es requerido');
                return;
            }

            openLoading();
            var formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('telefono', telefono);
            formData.append('correo', correo);
            formData.append('comentarios', comentarios);
            formData.append('id_distrito', id_distrito);
            formData.append('id_distritoservicios', id_distritoservicios);

            axios.post('/enviar/sugerencias', formData)
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        limpiar();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Sugerencia Enviada!',
                            text: '',
                            confirmButtonText: 'Aceptar'
                        });
                    }else{
                        toastr.error('Error al registrar');
                    }
                })
                .catch((error) => {
                    toastr.error('Error al registrar');
                    closeLoading();
                });
        }

        function limpiar(){
            document.getElementById('id_distrito').value = '';
            document.getElementById('id_distritoservicios').innerHTML = '<option value="">Seleccione un servicio</option>';
            document.getElementById('id_distritoservicios').disabled = true;

            document.getElementById('nombre').value = '';
            document.getElementById('telefono').value = '';
            document.getElementById('correo').value = '';
            document.getElementById('comentarios').value = '';
        }
    </script>

</div>
</body>
</html>
