@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
@stop

    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Diplomado</li>
                    <li class="breadcrumb-item active">Listado de Alumnos</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- ======================== PANEL DE FILTROS ======================== --}}
            <div class="card card-outline card-secondary mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i> Filtros
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">

                        {{-- Nombre del alumno --}}
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label class="mb-1"><i class="fas fa-user mr-1 text-muted"></i> Nombre del Alumno</label>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       id="filtro-nombre"
                                       placeholder="Escriba un nombre...">
                            </div>
                        </div>

                        {{-- Curso --}}
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label class="mb-1"><i class="fas fa-book mr-1 text-muted"></i> Curso</label>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       id="filtro-curso"
                                       placeholder="Nombre del curso...">
                            </div>
                        </div>

                        {{-- Periodo --}}
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label class="mb-1"><i class="fas fa-calendar mr-1 text-muted"></i> Periodo</label>
                                <input type="text"
                                       class="form-control form-control-sm"
                                       id="filtro-periodo"
                                       placeholder="Ej: 2024-I">
                            </div>
                        </div>

                        {{-- Fecha Desde --}}
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label class="mb-1"><i class="fas fa-calendar-alt mr-1 text-muted"></i> Fecha Desde</label>
                                <input type="date" class="form-control form-control-sm" id="filtro-fecha-desde">
                            </div>
                        </div>

                        {{-- Fecha Hasta --}}
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label class="mb-1"><i class="fas fa-calendar-check mr-1 text-muted"></i> Fecha Hasta</label>
                                <input type="date" class="form-control form-control-sm" id="filtro-fecha-hasta">
                            </div>
                        </div>

                    </div>

                    <div class="row mt-2">
                        {{-- Botones --}}
                        <div class="col-md-12 d-flex justify-content-end" style="gap: 8px;">
                            <button type="button" class="btn btn-primary btn-sm" onclick="aplicarFiltros()">
                                <i class="fas fa-search mr-1"></i> Filtrar
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="limpiarFiltros()">
                                <i class="fas fa-times mr-1"></i> Limpiar
                            </button>
                        </div>
                    </div>

                    {{-- Badge de filtros activos --}}
                    <div class="row mt-2" id="filtros-activos-row" style="display:none !important;">
                        <div class="col-12">
                            <small class="text-muted">Filtros activos: </small>
                            <span id="filtros-activos-badges"></span>
                        </div>
                    </div>

                </div>
            </div>
            {{-- ======================== FIN PANEL DE FILTROS ======================== --}}

            <div class="card card-blue">
                <div class="card-header">
                    <h3 class="card-title">Listado de Alumnos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="tablaDatatable"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>



<div class="modal fade" id="modalEditar">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fas fa-edit mr-2"></i>Editar Alumno
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">
                <form id="formulario-editar">
                    <input type="hidden" id="edit-id">

                    <div class="row">
                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="100" id="edit-nombre">
                            </div>
                        </div>

                        {{-- Fecha --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha: <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit-fecha">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Curso --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Curso: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="100" id="edit-curso">
                            </div>
                        </div>

                        {{-- Periodo --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Periodo: </label>
                                <input type="text" class="form-control" maxlength="100" id="edit-periodo">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Certificado --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Certificado:</label>
                                <input type="text" class="form-control" maxlength="100" id="edit-certificado">
                            </div>
                        </div>
                    </div>

                    {{-- QR --}}
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <label class="d-block">Código QR</label>
                            <div id="edit-qr">
                                <span class="badge badge-secondary">Sin QR</span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" class="btn btn-success" onclick="guardarEdicion()">
                    <i class="fas fa-save mr-1"></i> Actualizar
                </button>
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
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>

    <script>
        $(function () {
            const ruta = "{{ url('/admin/diplomado/listadoalumnos/tabla') }}";

            // ===================================================
            // DATATABLE
            // ===================================================
            function initDataTable() {
                if ($.fn.DataTable.isDataTable('#tabla')) {
                    $('#tabla').DataTable().destroy();
                }

                $('#tabla').DataTable({
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: true,
                    pagingType: "full_numbers",
                    lengthMenu: [[100, 150, -1], [100, 150, "Todo"]],
                    language: {
                        sProcessing:    "Procesando...",
                        sLengthMenu:    "Mostrar _MENU_ registros",
                        sZeroRecords:   "No se encontraron resultados",
                        sEmptyTable:    "Ningún dato disponible en esta tabla",
                        sInfo:          "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        sInfoEmpty:     "Mostrando 0 a 0 de 0 registros",
                        sInfoFiltered:  "(filtrado de _MAX_ registros)",
                        sSearch:        "Buscar:",
                        oPaginate: {
                            sFirst:    "Primero",
                            sLast:     "Último",
                            sNext:     "Siguiente",
                            sPrevious: "Anterior"
                        },
                        oAria: {
                            sSortAscending:  ": Orden ascendente",
                            sSortDescending: ": Orden descendente"
                        }
                    },
                    dom:
                        "<'row align-items-center'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 text-md-right'f>>" +
                        "tr" +
                        "<'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                });

                $('#tabla_length select').addClass('form-control form-control-sm');
                $('#tabla_filter input').addClass('form-control form-control-sm').css('display', 'inline-block');
            }

            // ===================================================
            // CARGAR TABLA
            // ===================================================
            window.cargarTabla = function (params = {}) {
                openLoading();
                $.get(ruta, params, function (html) {
                    $('#tablaDatatable').html(html);
                    initDataTable();
                    closeLoading();
                });
            };

            window.recargar = function () {
                aplicarFiltros();
            };

            // ===================================================
            // APLICAR FILTROS
            // ===================================================
            window.aplicarFiltros = function () {
                const params = {
                    nombre:      $('#filtro-nombre').val().trim()      || '',
                    curso:       $('#filtro-curso').val().trim()       || '',
                    periodo:     $('#filtro-periodo').val().trim()     || '',
                    fecha_desde: $('#filtro-fecha-desde').val()        || '',
                    fecha_hasta: $('#filtro-fecha-hasta').val()        || '',
                };

                mostrarBadgesFiltros(params);
                cargarTabla(params);
            };

            // ===================================================
            // LIMPIAR FILTROS
            // ===================================================
            window.limpiarFiltros = function () {
                $('#filtro-nombre').val('');
                $('#filtro-curso').val('');
                $('#filtro-periodo').val('');
                $('#filtro-fecha-desde').val('');
                $('#filtro-fecha-hasta').val('');
                $('#filtros-activos-row').hide();
                $('#filtros-activos-badges').html('');
                cargarTabla();
            };

            // ===================================================
            // BADGES DE FILTROS ACTIVOS
            // ===================================================
            function mostrarBadgesFiltros(params) {
                let badges = '';
                let hayFiltro = false;

                if (params.nombre) {
                    badges += `<span class="badge badge-primary mr-1"><i class="fas fa-user mr-1"></i>${params.nombre}</span>`;
                    hayFiltro = true;
                }
                if (params.curso) {
                    badges += `<span class="badge badge-success mr-1"><i class="fas fa-book mr-1"></i>${params.curso}</span>`;
                    hayFiltro = true;
                }
                if (params.periodo) {
                    badges += `<span class="badge badge-warning mr-1"><i class="fas fa-calendar mr-1"></i>${params.periodo}</span>`;
                    hayFiltro = true;
                }
                if (params.fecha_desde) {
                    badges += `<span class="badge badge-info mr-1"><i class="fas fa-calendar-alt mr-1"></i>Desde: ${formatearFecha(params.fecha_desde)}</span>`;
                    hayFiltro = true;
                }
                if (params.fecha_hasta) {
                    badges += `<span class="badge badge-info mr-1"><i class="fas fa-calendar-check mr-1"></i>Hasta: ${formatearFecha(params.fecha_hasta)}</span>`;
                    hayFiltro = true;
                }

                if (hayFiltro) {
                    $('#filtros-activos-badges').html(badges);
                    $('#filtros-activos-row').show();
                } else {
                    $('#filtros-activos-row').hide();
                    $('#filtros-activos-badges').html('');
                }
            }

            // ===================================================
            // CARGA INICIAL
            // ===================================================
            cargarTabla();

        }); // end document ready


        // ===================================================
        // MODAL VER DETALLE
        // ===================================================
        function verDetalle(id) {
            openLoading();

            axios.post('/admin/diplomado/listadoalumnos/informacion', { id: id })
                .then((response) => {
                    closeLoading();

                    if (response.data.success === 1) {
                        const info = response.data.info;

                        // 🔥 SET INPUTS
                        $('#edit-id').val(info.id);
                        $('#edit-nombre').val(info.nombre || '');
                        $('#edit-fecha').val(info.fecha || '');
                        $('#edit-curso').val(info.curso || '');
                        $('#edit-periodo').val(info.periodo || '');
                        $('#edit-certificado').val(info.certificado || '');

                        // 🔥 QR
                        if (info.codigo_verificacion) {
                            const urlQR = `/qr/${info.codigo_verificacion}`;

                            $('#edit-qr').html(`
                        <a href="/verificar/${info.codigo_verificacion}" target="_blank">
                            <img src="${urlQR}" style="width:150px;">
                        </a>
                    `);
                        } else {
                            $('#edit-qr').html('<span class="badge badge-secondary">Sin QR</span>');
                        }

                        $('#modalEditar').modal('show');

                    } else {
                        toastr.error('Información no encontrada');
                    }
                })
                .catch(() => {
                    closeLoading();
                    toastr.error('Error al obtener información');
                });
        }





        // ===================================================
        // GUARDAR EDICIÓN
        // ===================================================
        function guardarEdicion() {
            const id          = $('#edit-id').val();
            const nombre      = $('#edit-nombre').val().trim();
            const fecha       = $('#edit-fecha').val();
            const curso       = $('#edit-curso').val().trim();
            const periodo     = $('#edit-periodo').val().trim();
            const certificado = $('#edit-certificado').val().trim();

            if (!nombre)  { toastr.error('El nombre es requerido');  return; }
            if (!fecha)   { toastr.error('La fecha es requerida');   return; }
            if (!curso)   { toastr.error('El curso es requerido');   return; }

            const formData = new FormData();
            formData.append('id',          id);
            formData.append('nombre',      nombre);
            formData.append('fecha',       fecha);
            formData.append('curso',       curso);
            formData.append('periodo',     periodo);
            formData.append('certificado', certificado);

            openLoading();

            axios.post('/admin/diplomado/listadoalumnos/actualizar', formData)
                .then((response) => {
                    closeLoading();
                    if (response.data.success === 1) {
                        toastr.success('Actualizado correctamente');
                        $('#modalEditar').modal('hide');
                        recargar();
                    } else {
                        toastr.error(response.data.message ?? 'Error al actualizar');
                    }
                })
                .catch(() => {
                    closeLoading();
                    toastr.error('Error al actualizar');
                });
        }


        // ===================================================
        // ELIMINAR REGISTRO
        // ===================================================
        function informacionBorrar(id) {
            Swal.fire({
                title: 'Borrar Registro',
                text: '¿Está seguro que desea eliminar este registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                allowOutsideClick: false,
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    borrarRegistro(id);
                }
            });
        }

        function borrarRegistro(id) {
            openLoading();
            const formData = new FormData();
            formData.append('id', id);

            axios.post('/admin/diplomado/listadoalumnos/borrar', formData)
                .then((response) => {
                    closeLoading();
                    if (response.data.success === 1) {
                        toastr.success('Eliminado correctamente');
                        recargar();
                    } else {
                        toastr.error('Error al eliminar');
                    }
                })
                .catch(() => {
                    closeLoading();
                    toastr.error('Error al eliminar');
                });
        }


        // ===================================================
        // UTILIDADES
        // ===================================================
        function formatearFecha(fecha) {
            if (!fecha) return '';
            const [y, m, d] = fecha.split('-');
            return `${d}-${m}-${y}`;
        }

    </script>
@endsection
