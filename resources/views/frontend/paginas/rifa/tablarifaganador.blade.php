<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="tabla-rifa">
                            <table id="tabla2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 8%">Fecha Ganador</th>
                                    <th style="width: 12%">Nombre</th>
                                    <th style="width: 8%">DUI</th>
                                    <th style="width: 8%">Teléfono</th>
                                    <th style="width: 12%">Dirección</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($arrayRifaGanador as $dato)
                                    <tr>
                                        <td style="width: 8%; font-size: 12px">{{ $dato->fechaFormat }}</td>
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


<script>
    function cargarTablaGanadores() {

        if ($.fn.DataTable.isDataTable('#tabla2')) {
            $('#tabla2').DataTable().destroy();
        }

        $('#tablaDatatable2').load('/rifa/tablaganador', function () {

            $('#tabla2').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']],
                lengthMenu: [[10, 100, 500, -1], [10, 100, 500, "Todo"]],
                columnDefs: [
                    { targets: 0, type: "date-dd-mm-yyyy" }
                ],
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla",
                    sSearch: "Buscar:",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Último",
                        sNext: "Siguiente",
                        sPrevious: "Anterior"
                    }
                }
            });

        });
    }

</script>
