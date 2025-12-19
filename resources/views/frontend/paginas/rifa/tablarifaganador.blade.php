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
                                    <th style="width: 12%">Premio</th>
                                    <th style="width: 12%">Nombre</th>
                                    <th style="width: 8%">DUI</th>
                                    <th style="width: 8%">Teléfono</th>
                                    <th style="width: 12%">Dirección</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($arrayRifaGanador as $dato)
                                    <tr>
                                        <td style="width: 12%; font-size: 12px">{{ $dato->nombrepremio }}</td>
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
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, 100, 150, -1], [10, 25, 50, 100, 150, "Todo"]],
                "language": {
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
