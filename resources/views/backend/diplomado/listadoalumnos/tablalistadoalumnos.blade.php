<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabla" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Fecha Creado</th>
                                <th>Alumno</th>
                                <th>Curso</th>
                                <th>Periodo</th>
                                <th>Certificado</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($arrayAlumnos as $dato)
                                <tr>

                                    {{-- Fecha creado --}}
                                    <td data-order="{{ $dato->fecha }}">
                                        {{ $dato->fecha_formateada }}
                                    </td>

                                    {{-- Datos del alumno --}}
                                    <td>{{ $dato->nombre }}</td>
                                    <td>{{ $dato->curso ?? '—' }}</td>
                                    <td>{{ $dato->periodo ?? '—' }}</td>
                                    <td>{{ $dato->certificado ?? '—' }}</td>

                                    {{-- Opciones --}}
                                    <td>
                                        <button type="button"
                                                class="btn btn-info btn-xs"
                                                onclick="verDetalle({{ $dato->id }})">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>

                                        <button type="button"
                                                style="margin: 5px"
                                                class="btn btn-danger btn-xs"
                                                onclick="informacionBorrar({{ $dato->id }})">
                                            <i class="fas fa-trash"></i> Borrar
                                        </button>
                                    </td>

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
</section>
