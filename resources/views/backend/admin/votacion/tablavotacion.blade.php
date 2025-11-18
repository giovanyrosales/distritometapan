<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10%">Nombre</th>
                            <th style="width: 15%">Descripción</th>
                            <th style="width: 15%">Imagen</th>
                            <th style="width: 6%">Opciones</th>
                        </tr>
                        </thead>
                        <tbody id="tablecontents">
                            @foreach($arrayVotacion as $dato)
                                <tr>
                                    <td style="width: 10%">{{ $dato->nombre }}</td>
                                    <td style="width: 15%">{{ $dato->descripcion }}</td>

                                    <td>
                                        @if($dato->imagen != null)
                                            <img
                                                src="{{ url('storage/archivos/'.$dato->imagen) }}"
                                                width="190"
                                                height="176"
                                                style="border-radius:12px; object-fit:cover; display:block; margin:0 auto;"
                                            >
                                        @endif
                                    </td>

                                    <td style="width: 4%">

                                        <button type="button" class="btn btn-success btn-xs" onclick="informacion({{ $dato->id }})">
                                            <i class="fas fa-edit" title="Editar"></i>&nbsp; Editar
                                        </button>

                                        <button type="button" style="margin: 5px" class="btn btn-danger btn-xs" onclick="modalBorrar({{ $dato->id }})">
                                            <i class="fas fa-trash" title="Borrar"></i>&nbsp; Borrar
                                        </button>

                                        <button type="button" style="margin: 15px" class="btn btn-danger btn-xs" onclick="modalBorrarConteo({{ $dato->id }})">
                                            <i class="fas fa-trash" title="Borrar conteo"></i>&nbsp; Borrar Conteo
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
            "lengthMenu": [[10, 25, 50, 100, 150, -1], [10, 25, 50, 100, 150, "Todo"]],
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
