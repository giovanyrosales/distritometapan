<!-- ========================================= -->
<!-- CÓDIGO COMPLETO PARA TU VISTA BLADE     -->
<!-- ========================================= -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="tabla-rifa">
                            <table id="tabla" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 4%">#</th>
                                    <th style="width: 12%">Nombre</th>
                                    <th style="width: 8%">DUI</th>
                                    <th style="width: 8%">Teléfono</th>
                                    <th style="width: 12%">Dirección</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($arrayRifa as $dato)
                                    <tr>
                                        <td style="width: 4%; font-size: 12px">{{ $dato->conteo }}</td>
                                        <td style="width: 12%; font-size: 12px">{{ $dato->nombre }}</td>
                                        <td style="width: 8%; font-size: 12px">{{ $dato->dui }}</td>
                                        <td style="width: 8%; font-size: 12px">{{ $dato->telefono }}</td>
                                        <td style="width: 12%; font-size: 12px">{{ $dato->direccion }}</td>
                                    </tr>
                                @endforeach

                                <script>
                                    setTimeout(function () {
                                        closeLoading();
                                    }, 1000);
                                </script>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ========================================= -->
<!-- CSS PARA DATATABLE - SIN ::before        -->
<!-- ========================================= -->
<style>
    /* ===== PERSONALIZACIÓN BUSCADOR DATATABLE ===== */

    /* Contenedor del buscador */
    .dataTables_wrapper .dataTables_filter {
        text-align: right;
        margin-bottom: 15px;
    }

    /* Label "Buscar:" */
    .dataTables_wrapper .dataTables_filter label {
        font-size: 1rem !important;
        font-weight: 600 !important;
        color: #0f172a;
        margin-bottom: 0;
    }

    /* Input del buscador */
    .dataTables_wrapper .dataTables_filter input[type="search"] {
        border-radius: 10px !important;
        height: 38px !important;
        font-size: .95rem !important;
        padding: 8px 14px !important;
        background: #f9fafb !important;
        border: 1px solid #d1d5db !important;
        transition: .15s !important;
        width: 250px !important;
        margin-left: 8px !important;
    }

    .dataTables_wrapper .dataTables_filter input[type="search"]:focus {
        border-color: var(--brand) !important;
        box-shadow: 0 0 0 1px rgba(30, 52, 156, .2) !important;
        background: #fff !important;
        outline: none !important;
    }

    /* Selector de entradas */
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px !important;
        height: 38px !important;
        padding: 6px 12px !important;
        background: #f9fafb !important;
        border: 1px solid #d1d5db !important;
        margin: 0 8px !important;
    }

    .dataTables_wrapper .dataTables_length label {
        font-size: .95rem !important;
        font-weight: 600 !important;
        color: #0f172a;
    }

    /* Responsive para móviles */
    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_filter {
            text-align: left;
            margin-bottom: 12px;
        }

        .dataTables_wrapper .dataTables_filter input[type="search"] {
            width: 100% !important;
            margin-left: 0 !important;
            margin-top: 8px !important;
        }

        .dataTables_wrapper .dataTables_filter label {
            display: block;
            width: 100%;
        }
    }
</style>


<!-- ========================================= -->
<!-- JAVASCRIPT CON CONFIGURACIÓN EN ESPAÑOL  -->
<!-- ========================================= -->
<script>
    function cargarTablaParticipantes() {
        if ($.fn.DataTable.isDataTable('#tabla')) {
            $('#tabla').DataTable().destroy();
        }

        $('#tablaDatatable').load('/rifa/tabla', function () {
            $('#tabla').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, 100, 150, -1], [10, 25, 50, 100, 150, "Todo"]],
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
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false
            });
        });
    }


</script>

