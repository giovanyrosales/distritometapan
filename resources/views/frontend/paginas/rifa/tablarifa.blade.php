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
                                    <th style="width: 8%">Fecha</th>
                                    <th style="width: 12%">Nombre</th>
                                    <th style="width: 8%">DUI</th>
                                    <th style="width: 8%">Teléfono</th>
                                    <th style="width: 12%">Dirección</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($arrayRifa as $dato)
                                        <tr>
                                            <td style="width: 8%; font-size: 12px">{{ $dato->conteo }}</td>
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
    function cargarTablaParticipantes() {

        if ($.fn.DataTable.isDataTable('#tabla')) {
            $('#tabla').DataTable().destroy();
        }

        // Tipo fecha dd-mm-yyyy
        $.fn.dataTable.ext.type.order['date-dd-mm-yyyy-pre'] = function (date) {
            if (!date) return 0;
            let parts = date.split('-');
            return new Date(parts[2], parts[1] - 1, parts[0]).getTime();
        };

        $('#tabla-rifa').load('/rifa/tabla', function () {

            $('#tabla').DataTable({
                responsive: true,
                destroy: true,

                // 👉 mostrar TODOS por defecto
                pageLength: -1,

                // 👉 menú con opción TODO
                lengthMenu: [
                    [10, 100, 500, -1],
                    [10, 100, 500, "Todo"]
                ],

                // 👉 ordenar por FECHA (columna 1)
                order: [[1, 'desc']],

                columnDefs: [
                    { targets: 1, type: 'date-dd-mm-yyyy' }
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


