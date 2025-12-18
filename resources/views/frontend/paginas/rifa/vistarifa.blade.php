{{-- resources/views/frontend/rifa.blade.php --}}

@include('frontend.menu.indexsuperior')
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
<style>
    :root{
        --brand: #1e349c;
        --ink:#0f172a;
        --muted:#64748b;
        --bg:#f8fafc;
        --card:#ffffff;
        --radius:18px;
    }

    body{
        min-height:100vh;
        background:
            url('{{ asset("images/imgrifa.png") }}') center / cover no-repeat fixed;
        font-family: system-ui,-apple-system,"Segoe UI",Roboto,Ubuntu,Arial,sans-serif;
    }

    .rifa-card{
        max-width:520px;
        margin:120px auto 60px;
        background:var(--card);
        border-radius:var(--radius);
        padding:32px;
        box-shadow:0 20px 45px -25px rgba(0,0,0,.2);
        border:1px solid #e5e7eb;
    }

    .rifa-title{
        font-weight:800;
        font-size:2.1rem;   /* antes 1.5rem */
        margin-bottom:8px;
        text-align:center;
    }

    .rifa-subtitle{
        text-align:center;
        color:var(--muted);
        font-size:1.15rem;  /* antes .95rem */
        margin-bottom:28px;
        line-height:1.5;
    }

    label{
        font-size:1.05rem;  /* antes .9rem */
        font-weight:700;
        margin-bottom:6px;
    }

    .form-control{
        border-radius:12px;
        height:50px;        /* antes 42px */
        font-size:1.05rem;  /* antes .95rem */
        background:#f9fafb;
        border:1px solid #d1d5db;
        transition:.15s;
    }

    .form-control:focus{
        border-color:var(--brand);
        box-shadow:0 0 0 1px rgba(20,83,45,.2);
        background:#fff;
    }

    textarea.form-control{
        min-height:120px;   /* antes 90px */
        font-size:1.05rem;
        resize:none;
    }

    .btn-rifa{
        width:100%;
        margin-top:20px;
        padding:14px;
        border-radius:999px;
        background:var(--brand);
        color:#fff;
        font-weight:800;
        font-size:1.15rem;  /* antes 1rem */
        border:none;
        cursor:pointer;
        transition:.15s;
    }

    .btn-rifa:hover{
        background: #0339ec;
        transform:translateY(-1px);
    }

    .nota{
        text-align:center;
        font-size:.95rem;   /* antes .8rem */
        color:var(--muted);
        margin-top:14px;
    }

    @media (max-width: 576px){
        .rifa-card{
            margin:90px 16px 40px; /* espacio a los lados */
            padding:24px 20px;
        }
    }


    /* 🔥 Fuerza tamaño normal del SweetAlert2 */
    .swal2-popup {
        zoom: 1.25 !important;        /* Aumenta tamaño completo */
        font-size: 1.1rem !important; /* Ajuste legible */
        padding: 25px !important;
    }

    .swal2-title {
        font-size: 1.8rem !important;
        font-weight: 700 !important;
    }

    .swal2-html-container {
        font-size: 1.2rem !important;
        margin-top: 10px !important;
    }

    .swal2-confirm {
        font-size: 1.1rem !important;
        padding: 10px 24px !important;
    }

    .swal2-cancel {
        font-size: 1.1rem !important;
        padding: 10px 24px !important;
    }

    .vote-card {
        display: flex;
        flex-direction: column;
    }

    .vote-desc {
        flex-grow: 1;
    }

    /* GRID para los cards de votación */
    .grid-votacion{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;               /* separación entre cards */
    }

    /* Cards flex para que el botón quede abajo */
    .vote-card{
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .vote-desc{
        flex-grow: 1;            /* empuja el botón hacia abajo */
    }


    /* Layout principal */
    .rifa-layout{
        max-width: 1400px;
        margin: 120px auto 60px;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 520px 1fr;
        gap: 30px;
        align-items: flex-start;
    }

    /* Ajustes de columnas */
    .rifa-left{
        display: flex;
        justify-content: flex-start;
    }

    .rifa-right{
        width: 100%;
    }

    /* En desktop quita el centrado del card */
    .rifa-card{
        margin: 0;
    }


    /* Card contenedor de la tabla */
    .tabla-card{
        background: #ffffff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 20px 45px -25px rgba(0,0,0,.25);
        border: 1px solid #e5e7eb;
    }

    /* Título de la tabla */
    .tabla-title{
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 16px;
        color: #0f172a;
    }

    /* DataTable base */
    .tabla-card table{
        width: 100% !important;
        background: #ffffff;
        border-collapse: collapse;
    }

    /* Cabecera */
    .tabla-card thead th{
        background: #1e349c;
        color: #ffffff;
        font-weight: 700;
        border: none;
        padding: 12px;
    }

    /* Filas */
    .tabla-card tbody td{
        background: #ffffff;
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        font-size: .95rem;
    }

    /* Hover fila */
    .tabla-card tbody tr:hover{
        background: #f1f5f9;
    }

    /* Paginación */
    .dataTables_wrapper .dataTables_paginate .paginate_button{
        background: #e5e7eb !important;
        border-radius: 8px;
        margin: 0 3px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current{
        background: #1e349c !important;
        color: #fff !important;
    }
    .rifa-right{
        max-width: 900px;
    }









    /* ===== TOASTR FIX ICONO + TEXTO ===== */
    #toast-container > div {
        font-size: 1.05rem !important;
        padding: 18px 22px 18px 55px !important; /* deja espacio al icono */
        width: 360px !important;
        opacity: 1 !important;
        box-shadow: 0 15px 35px rgba(0,0,0,.25) !important;
        background-position: 15px center !important; /* icono alineado */
    }

    /* Título */
    #toast-container .toast-title {
        font-size: 1.15rem !important;
        font-weight: 700 !important;
        margin-bottom: 6px !important;
    }

    /* Mensaje */
    #toast-container .toast-message {
        font-size: 1.05rem !important;
        line-height: 1.45 !important;
    }

    /* Evita solapamiento */
    #toast-container .toast-message,
    #toast-container .toast-title {
        padding-left: 0 !important;
    }

    /* Móvil */
    @media (max-width: 576px) {
        #toast-container > div {
            width: 90% !important;
            padding-left: 55px !important;
        }
    }


    /* ===== FIX MODAL GANADORES ===== */

    /* Solo cuando el modal tiene clase 'show' (está abierto) */
    #modalGanadores.modal.show {
        display: block !important;
        z-index: 9999 !important;
    }

    #modalGanadores .modal-dialog {
        z-index: 10000 !important;
        position: relative;
    }

    #modalGanadores .modal-content {
        background: #ffffff !important;
        position: relative;
        z-index: 10001 !important;
    }

    /* Backdrop debajo del modal */
    .modal-backdrop.show {
        z-index: 9998 !important;
        opacity: 0.5 !important;
    }

    /* Asegurar que el contenido sea visible */
    #modalGanadores.show .modal-header,
    #modalGanadores.show .modal-body,
    #modalGanadores.show .modal-footer {
        background: #ffffff !important;
        opacity: 1 !important;
    }

    /* Tabla dentro del modal */
    #modalGanadores table {
        background: #ffffff !important;
    }

    #modalGanadores table thead th {
        background: #1e349c !important;
        color: #ffffff !important;
    }

    #modalGanadores table tbody td {
        background: #ffffff !important;
    }

    .modal-fullscreen {
        max-width: 100vw !important;
        width: 100vw !important;
        height: 100vh;
        margin: 0;
    }

    .modal-fullscreen .modal-content {
        height: 100vh;
        border-radius: 0;
    }


    .modal-ganadores-xl {
        max-width: 90vw !important;   /* casi toda la pantalla */
        width: 90vw !important;
    }

    @media (max-width: 768px) {
        .modal-ganadores-xl {
            max-width: 100vw !important;
            width: 100vw !important;
            margin: 0;
        }
    }





</style>

<body>
@include('frontend.menu.navbar')

<div class="rifa-layout">
    <!-- IZQUIERDA: FORMULARIO -->
    <div class="rifa-left">
        <div class="rifa-card">
            <h2 class="rifa-title">🎟 Participa en la Rifa</h2>
            <p class="rifa-subtitle">
                Completa tus datos para participar.
                Todos los campos son obligatorios.
            </p>

            <form id="formRifa">
                @csrf

                <div class="form-group">
                    <label>Nombre completo <span style="color: red">*</span></label>
                    <input type="text" id="nombre" maxlength="50" autocomplete="off" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>DUI <span style="color: red">*</span></label>
                    <input type="text" id="dui" maxlength="20" autocomplete="off" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" id="telefono" autocomplete="off" maxlength="20" class="form-control">
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <textarea id="direccion" autocomplete="off" maxlength="200" class="form-control"></textarea>
                </div>

                <button type="button" class="btn-rifa" onclick="enviarRifa()">
                    🎉 Participar
                </button>

                <div class="nota">
                    Tus datos serán usados únicamente para la rifa.
                </div>
            </form>
        </div>
    </div>

    <!-- DERECHA: TABLA -->
    <div class="rifa-right">
        <div class="tabla-card rifa-datatable">
            <h3 class="tabla-title">Listado de Participantes</h3>
            <div id="tablaDatatable"></div>
        </div>
    </div>
</div>



<!-- CARD GENERAR GANADORES -->
<div style="max-width: 520px; margin: 0 auto 80px;">
    <div class="rifa-card">
        <h3 class="rifa-title" style="font-size:1.6rem;">🏆 Generar ganadores</h3>
        <p class="rifa-subtitle">
            Ingresa cuántos ganadores deseas generar.
        </p>

        <div class="form-group">
            <label>Número de ganadores</label>
            <input
                type="number"
                id="cantidadGanadores"
                min="1"
                max="100"
                class="form-control"
                placeholder="Ejemplo: 3"
            >
        </div>

        <button class="btn-rifa" onclick="generarGanadores()">
            🎯 Generar ganadores
        </button>
    </div>
</div>

<div class="">
    <div class="tabla-card">
        <h3 class="tabla-title">Listado de Ganadores</h3>
        <div id="tablaDatatable2"></div>
    </div>
</div>

<!-- MODAL GANADORES -->
<div class="modal fade" id="modalGanadores" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-ganadores-xl" role="document">

    <div class="modal-content" style="border-radius:18px;">
            <div class="modal-header">
                <h5 class="modal-title">🏆 Ganadores de la rifa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead style="background:#1e349c;color:#fff">
                        <tr>
                            <th>#</th>
                            <th style="width: 8%">Fecha Ganador</th>
                            <th>Nombre</th>
                            <th>DUI</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody id="tablaGanadoresBody">
                        <!-- se llena por JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>




@include('frontend.menu.footer')
<!-- Bootstrap 4 JS (incluye Popper) -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/alertaPersonalizada.js') }}"></script>

<script type="text/javascript">
    $(function () {
        openLoading();

        cargarTablaParticipantes();
        cargarTablaGanadores();
    });
</script>

<script>

    function cargarTablaParticipantes() {
        if ($.fn.DataTable.isDataTable('#tabla')) {
            $('#tabla').DataTable().destroy();
        }

        $('#tablaDatatable').load('/rifa/tabla', function () {
            $('#tabla').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: false,
                pageLength: 10,
                responsive: true,
                "language": {
                    "search": "Buscar:",
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ entradas",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
            });
        });
    }

    function cargarTablaGanadores() {
        if ($.fn.DataTable.isDataTable('#tabla2')) {
            $('#tabla2').DataTable().destroy();
        }

        $('#tablaDatatable2').load('/rifa/tablaganador', function () {
            $('#tabla2').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                pageLength: 10,
                responsive: true,
                "language": {
                    "search": "Buscar:",
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ entradas",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
            });
        });
    }

    function recargar(){
        openLoading()

        $('#tablaDatatable').load("{{ url('/rifa/tabla') }}");
    }

    function enviarRifa(){
        let nombre = document.getElementById('nombre').value.trim();
        let dui = document.getElementById('dui').value.trim();
        let telefono = document.getElementById('telefono').value.trim();
        let direccion = document.getElementById('direccion').value.trim();

        if(!nombre || !dui){
            toastr.error('Campos con asterisco son obligatorios');
            return;
        }

        let formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('dui', dui);
        formData.append('telefono', telefono);
        formData.append('direccion', direccion);

        axios.post('/rifa/registro', formData)
            .then(res => {
                if(res.data.success === 1){

                    openLoading()
                  cargarTablaParticipantes()

                    document.getElementById('formRifa').reset();
                }else{
                    toastr.error('No se pudo registrar');
                }
            })
            .catch(() => {
                toastr.error('Error al enviar datos');
            });
    }



    function generarGanadores(){
        let cantidad = document.getElementById('cantidadGanadores').value;

        if(!cantidad || cantidad <= 0){
            toastr.error('Ingresa una cantidad válida');
            return;
        }

        openLoading()

        axios.post('/rifa/generar', {
            cantidad: cantidad
        })
            .then(res => {
                closeLoading()

                if(res.data.success === 0) {

                    toastr.error(res.data.message);

                }else if(res.data.success === 1){

                    // Forzar apertura del modal con múltiples métodos
                    $('#modalGanadores').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });

                    // Asegurar visibilidad
                    $('#modalGanadores').css({
                        'display': 'block',
                        'opacity': '1',
                        'visibility': 'visible'
                    });

                    // Agregar clase show
                   mostrarGanadores(res.data.ganadores)

                }else{
                    toastr.error('No se pudo generar');
                }
            })
            .catch(() => {
                closeLoading()
                toastr.error('Error al generar ganadores');
            });
    }

    function mostrarGanadores(ganadores) {
        let tbody = document.getElementById('tablaGanadoresBody');
        tbody.innerHTML = '';

        ganadores.forEach((g, index) => {
            tbody.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${g.fechaFormat}</td>
                <td>${g.nombre}</td>
                <td>${g.dui}</td>
                <td>${g.telefono ?? ''}</td>
                <td>${g.direccion ?? ''}</td>
                <td class="text-center">
                    <button class="btn btn-success btn-sm"
                        onclick="editarGanador(${g.id})">
                        🏆 Ganador
                    </button>
                </td>
            </tr>
        `;
        });

        $('#modalGanadores').addClass('show');
    }

    function editarGanador(id){
        if(!id){
            toastr.error('ID inválido');
            return;
        }

        openLoading()

        axios.post('/rifa/registrar/ganador', {
            id: id
        })
            .then(res => {
                closeLoading();

                if(res.data.success === 1){

                    let tbody = document.getElementById('tablaGanadoresBody');
                    tbody.innerHTML = '';
                    $('#modalGanadores').addClass('hide');
                    toastr.success('Ganador registrado correctamente');

                    $('#modalGanadores').modal('hide');

                    openLoading()
                    cargarTablaGanadores();

                }else{
                    toastr.error('No se pudo registrar');
                }
            })
            .catch(() => {
                closeLoading();
                toastr.error('Error al enviar datos');
            });
    }



</script>
</body>
</html>
