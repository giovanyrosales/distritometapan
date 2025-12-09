<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10%">Fecha</th>
                                <th style="width: 15%">Servicio</th>
                                <th style="width: 15%">Nombre</th>
                                <th style="width: 15%">Teléfono</th>
                                <th style="width: 15%">Correo</th>
                                <th style="width: 15%">Comentarios</th>
                                <th style="width: 6%">Opciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($arraySugerencias as $dato)
                                <tr>
                                    <td style="width: 10%">{{ $dato->fechaFormat }}</td>
                                    <td style="width: 10%">{{ $dato->nombreServicio }}</td>
                                    <td style="width: 15%">{{ $dato->nombre }}</td>
                                    <td style="width: 15%">{{ $dato->telefono }}</td>
                                    <td style="width: 15%">{{ $dato->correo }}</td>
                                    <td style="width: 15%">{{ $dato->comentarios }}</td>

                                    <td style="width: 4%">

                                        <button type="button" style="margin: 5px" class="btn btn-success btn-xs" onclick="infoRevisado({{ $dato->id }})">
                                            <i class="fas fa-edit" title="Revisado"></i>&nbsp; Revisado
                                        </button>
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(function () {
        $("#tabla").DataTable({
            columnDefs: [
                { type: 'date-euro', targets: 0 } // Suponiendo que la columna de fecha es la primera (índice 0)
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pagingType": "full_numbers",
            "lengthMenu": [[500, -1], [500, "Todo"]],
            "language": {

                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
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
            "responsive": true, "lengthChange": true, "autoWidth": false,
        });
    });


</script>
