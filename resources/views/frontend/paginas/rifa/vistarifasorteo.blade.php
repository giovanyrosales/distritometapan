{{-- resources/views/frontend/rifa.blade.php --}}

@include('frontend.menu.indexsuperior')
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />

<!-- Reemplaza el CSS existente en tu archivo Blade -->
<style>
    :root{
        --brand:#1e349c;
        --ink:#0f172a;
        --muted:#64748b;
        --bg:#f8fafc;
        --card:#ffffff;
        --radius:18px;
    }

    /* =====================
       BASE
    ===================== */
    body{
        min-height:100vh;
        background:url('{{ asset("images/imgrifa.png") }}') center / cover no-repeat fixed;
        font-family:system-ui,-apple-system,"Segoe UI",Roboto,Ubuntu,Arial,sans-serif;
    }

    /* =====================
       LAYOUT PRINCIPAL - MODIFICADO
    ===================== */
    .rifa-layout{
        width:100%;
        max-width:100%;
        margin:120px auto 60px;
        padding:0 20px;
        display:block; /* Cambiado de grid a block */
    }

    /* =====================
       FORMULARIO - OCULTO O COMENTADO
    ===================== */
    .rifa-left{
        display:none; /* Ocultar el formulario si no lo necesitas */
    }

    .rifa-card{
        width:100%;
        max-width:520px;
        background:var(--card);
        border-radius:var(--radius);
        padding:32px;
        box-shadow:0 20px 45px -25px rgba(0,0,0,.2);
        border:1px solid #e5e7eb;
    }

    .rifa-title{
        font-weight:800;
        font-size:2.1rem;
        margin-bottom:8px;
        text-align:center;
    }

    .rifa-subtitle{
        text-align:center;
        color:var(--muted);
        font-size:1.15rem;
        margin-bottom:28px;
        line-height:1.5;
    }

    /* =====================
       FORM CONTROLS
    ===================== */
    label{
        font-size:1.05rem;
        font-weight:700;
        margin-bottom:6px;
    }

    .form-group{
        margin-bottom:16px;
    }

    .form-control{
        border-radius:12px;
        height:50px;
        font-size:1.05rem;
        background:#f9fafb;
        border:1px solid #d1d5db;
        transition:.15s;
    }

    .form-control:focus{
        border-color:var(--brand);
        box-shadow:0 0 0 1px rgba(30,52,156,.25);
        background:#ffffff;
    }

    textarea.form-control{
        min-height:120px;
        resize:none;
    }

    /* =====================
       BOTÓN
    ===================== */
    .btn-rifa{
        width:100%;
        margin-top:20px;
        padding:14px;
        border-radius:999px;
        background:var(--brand);
        color:#ffffff;
        font-weight:800;
        font-size:1.15rem;
        border:none;
        cursor:pointer;
        transition:.15s;
    }

    .btn-rifa:hover{
        background:#0339ec;
        transform:translateY(-1px);
    }

    .nota{
        text-align:center;
        font-size:.95rem;
        color:var(--muted);
        margin-top:14px;
    }

    /* =====================
       TABLA PARTICIPANTES - ANCHO COMPLETO
    ===================== */
    .rifa-right{
        width:100%; /* Ancho completo */
        margin-bottom:40px; /* Espacio inferior */
    }

    .tabla-card{
        width:100%;
        background:#ffffff;
        border-radius:18px;
        padding:24px;
        box-shadow:0 20px 45px -25px rgba(0,0,0,.25);
        border:1px solid #e5e7eb;
    }

    .tabla-title{
        font-size:1.6rem;
        font-weight:800;
        margin-bottom:16px;
        color:#0f172a;
    }

    /* DataTable */
    .tabla-card table{
        width:100% !important;
        border-collapse:collapse;
        background:#ffffff;
    }

    .tabla-card thead th{
        background:#1e349c;
        color:#ffffff;
        font-weight:700;
        padding:12px;
        border:none;
    }

    .tabla-card tbody td{
        padding:12px;
        border-bottom:1px solid #e5e7eb;
        font-size:.95rem;
    }

    .tabla-card tbody tr:hover{
        background:#f1f5f9;
    }

    /* Paginación */
    .dataTables_wrapper .dataTables_paginate .paginate_button{
        background:#e5e7eb !important;
        border-radius:8px;
        margin:0 3px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current{
        background:#1e349c !important;
        color:#ffffff !important;
    }

    /* =====================
       TOASTR
    ===================== */
    #toast-container > div{
        font-size:1.05rem !important;
        padding:18px 22px 18px 55px !important;
        width:360px !important;
        opacity:1 !important;
        box-shadow:0 15px 35px rgba(0,0,0,.25) !important;
        background-position:15px center !important;
    }

    #toast-container .toast-title{
        font-size:1.15rem !important;
        font-weight:700 !important;
    }

    #toast-container .toast-message{
        font-size:1.05rem !important;
        line-height:1.45 !important;
    }

    /* =====================
       SWEETALERT2
    ===================== */
    .swal2-popup{
        zoom:1.25 !important;
        font-size:1.1rem !important;
        padding:25px !important;
    }

    .swal2-title{
        font-size:1.8rem !important;
        font-weight:700 !important;
    }

    .swal2-confirm,
    .swal2-cancel{
        font-size:1.1rem !important;
        padding:10px 24px !important;
    }

    /* =====================
       RESPONSIVE
    ===================== */
    @media (max-width:992px){
        .rifa-layout{
            margin:90px auto 40px;
            padding:0 14px;
        }

        .rifa-card,
        .tabla-card{
            padding:20px;
            border-radius:16px;
        }
    }

    @media (max-width:576px){
        #toast-container > div{
            width:90% !important;
        }

        .tabla-card{
            padding:16px;
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


    /* =========================
       📱 OPTIMIZACIÓN MÓVIL
    ========================= */
    @media (max-width: 992px) {

        /* Layout pasa a una sola columna */
        .rifa-layout{
            grid-template-columns: 1fr;
            margin: 90px auto 40px;
            padding: 0 14px;
            gap: 24px;
        }

        .rifa-left,
        .rifa-right{
            width: 100%;
            max-width: 100%;
        }

        /* Cards ocupan todo el ancho */
        .rifa-card,
        .tabla-card{
            border-radius: 16px;
            padding: 20px;
        }
    }

</style>


<body>
@include('frontend.menu.navbar')

<div class="rifa-layout">
    <!-- IZQUIERDA: FORMULARIO -->


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
            <label>Seleccionar Premio</label>
            <select id="select-premio" class="form-control">
                @foreach($arrayPremios as $rifa)
                    <option value="{{ $rifa->id }}">{{ $rifa->nombre }}</option>
                @endforeach
            </select>
        </div>


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

        <div class="d-flex flex-wrap align-items-end mb-3 gap-2">
            <!-- Premio -->
            <div style="flex: 0 0 auto; width: 250px;">
                <label>Seleccionar Premio</label>
                <select id="select-premio-pdf" class="form-control" style="height: auto;">
                    @foreach($arrayPremios as $rifa)
                        <option value="{{ $rifa->id }}">{{ $rifa->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botón PDF -->
            <div style="flex: 0 0 auto; width: 100px;">
                <button class="btn btn-success w-100" onclick="generarPDF()">
                    📄 PDF
                </button>
            </div>

            <!-- Columnas vacías para futuros filtros -->
            <div style="flex: 0 0 auto; width: 150px;"></div>
            <div style="flex: 0 0 auto; width: 150px;"></div>
        </div>

        <div id="tablaDatatable2"></div>
    </div>
</div>


<!-- MODAL GANADORES -->
<div class="modal fade" id="modalGanadores" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-ganadores-xl" role="document">
        <div class="modal-content" style="border-radius:18px;">

            <div class="modal-header">
                <h5 class="modal-title">🏆 Ganadores de la rifa</h5>
                <button class="btn btn-primary" style="margin-left: 15px" onclick="guardarGanadores()">
                    💾 Guardar
                </button>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Mostrar el premio seleccionado -->
                <p id="modalPremio" style="font-weight:700; font-size:13px; margin-bottom:12px;">
                    PREMIO: -
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead style="background:#1e349c;color:#fff">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>DUI</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
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


    function generarGanadores(){
        let cantidad = document.getElementById('cantidadGanadores').value;

        if(!cantidad || cantidad <= 0){
            toastr.error('Ingresa una cantidad válida');
            return;
        }

        openLoading()

        axios.post('/rifa/generar', {
            cantidad: cantidad,
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
            <tr data-id="${g.id}">
                <td>${index + 1}</td>
                <td style="font-size: 13px">${g.nombre}</td>
                <td style="font-size: 13px">${g.dui}</td>
                <td style="font-size: 13px">${g.telefono ?? ''}</td>
                <td style="font-size: 13px">${g.direccion ?? ''}</td>
            </tr>
        `;
        });

        // Obtener el texto del premio seleccionado
        let selectPremio = document.getElementById('select-premio');
        let premioTexto = selectPremio.options[selectPremio.selectedIndex].text;
        document.getElementById('modalPremio').textContent = `PREMIO: ${premioTexto}`;

        $('#modalGanadores').addClass('show');
    }

    function guardarGanadores(){
        let tbody = document.getElementById('tablaGanadoresBody');
        let filas = tbody.querySelectorAll('tr');

        if(filas.length === 0){
            toastr.error('No hay ganadores para guardar');
            return;
        }

        // Crear arreglo de ganadores
        let ganadores = [];
        filas.forEach(fila => {
            let celdas = fila.querySelectorAll('td');
            ganadores.push({
                nombre: celdas[1].textContent,
                dui: celdas[2].textContent,
                telefono: celdas[3].textContent,
                direccion: celdas[4].textContent,
                // Si necesitas enviar también el id del participante, asegúrate de agregarlo como data-id en el tr
                id: fila.dataset.id ?? null
            });
        });

        openLoading();

        axios.post('/rifa/registrar/ganadores', {
            ganadores: ganadores,
            premio: document.getElementById('select-premio').value
        })
            .then(res => {
                closeLoading();

                if(res.data.success === 1){
                    tbody.innerHTML = '';
                    $('#modalGanadores').modal('hide');
                    toastr.success('Ganadores registrados correctamente');
                    cargarTablaGanadores();
                } else {
                    toastr.error(res.data.message || 'No se pudo registrar');
                }
            })
            .catch(() => {
                closeLoading();
                toastr.error('Error al enviar datos');
            });
    }


    function generarPDF(){
        let premio = document.getElementById('select-premio-pdf').value;

        window.open("{{ URL::to('rifa/reportes') }}/" + premio);
    }



</script>
</body>
</html>
