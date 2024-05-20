@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
@stop

<style>
    table{
        /*Ajustar tablas*/
        table-layout:fixed;
    }

    /* Extender el ancho del modal */
    .modal-dialog.modal-lg {
        max-width: 90%;
    }

    /* Asegúrate de que el contenido del modal sea desplazable si excede la altura */
    .modal-body {
        overflow-y: auto;
    }

</style>


<div id="divcontenedor" style="display: none">

    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <button type="button" onclick="modalAgregar()" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-square"></i>
                    Nuevo registro
                </button>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Noticias</li>
                    <li class="breadcrumb-item active">Listado</li>
                </ol>
            </div>

        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-gray-dark">
                <div class="card-header">
                    <h3 class="card-title">Listado</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="tablaDatatable">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalAgregar">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registro</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-nuevo">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input style="color:#191818; width: 18%" value="{{ $fechaActual->format('Y-m-d') }}" type="date" id="fecha-nuevo" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Título</label>
                                        <input style="color:#191818" type="text" id="titulo-nuevo" class="form-control" maxlength="100" />
                                    </div>


                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input style="color:#191818" type="text" id="descripcion-nuevo" class="form-control" maxlength="800" />
                                    </div>

                                    <div class="form-group">
                                        <label>Documento</label>
                                        <input type="file" class="form-control" id="documento" accept="application/pdf" />
                                    </div>


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="nuevoRegistro()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal editar -->
    <div class="modal fade" id="modalEditar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-editar">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <input type="hidden" id="id-editar"/>
                                    </div>


                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input style="color:#191818; width: 18%" value="{{ $fechaActual->format('Y-m-d') }}" type="date" id="fecha-editar" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Título</label>
                                        <input style="color:#191818" type="text" id="titulo-editar" class="form-control" maxlength="100" />
                                    </div>


                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input style="color:#191818" type="text" id="descripcion-editar" class="form-control" maxlength="800" />
                                    </div>

                                    <div class="form-group">
                                        <label>Documento</label>
                                        <input type="file" class="form-control" id="documento-editar" accept="application/pdf" />
                                    </div>



                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="editarRegistro()">Actualizar</button>
                </div>
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
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            var ruta = "{{ URL::to('/admin/finanzas/tabla') }}";
            $('#tablaDatatable').load(ruta);

            document.getElementById("divcontenedor").style.display = "block";
        });
    </script>

    <script>

        function recargar(){
            var ruta = "{{ URL::to('/admin/finanzas/tabla') }}";
            $('#tablaDatatable').load(ruta);
        }

        function modalAgregar(){
            document.getElementById("formulario-nuevo").reset();

            $('#modalAgregar').modal('show');
        }

        function nuevoRegistro(){

            var fecha = document.getElementById('fecha-nuevo').value;
            var titulo = document.getElementById('titulo-nuevo').value;
            var descripcion = document.getElementById('descripcion-nuevo').value;
            var documento = document.getElementById('documento');

            if(fecha === ''){
                toastr.error('Fecha es requerido')
                return
            }

            if(titulo === ''){
                toastr.error('Título es requerido')
                return
            }

            if(documento.files && documento.files[0]){ // si trae imagen
                if (!documento.files[0].type.match('application/pdf')){
                    toastr.error('Formato permitido: .pdf');
                    return;
                }
            }else{
                toastr.error('Documento es requerido')
                return;
            }

            openLoading();
            var formData = new FormData();
            formData.append('fecha', fecha);
            formData.append('titulo', titulo);
            formData.append('descripcion', descripcion);
            formData.append('documento', documento.files[0]);

            axios.post('/admin/finanzas/nuevo', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastr.success('Registrado');
                        $('#modalAgregar').modal('hide');
                        recargar();
                    }
                    else {
                        toastr.error('Error al registrar');
                    }
                })
                .catch((error) => {
                    toastr.error('Error al registrar');
                    closeLoading();
                });
        }



        function informacion(id){
            openLoading();
            document.getElementById("formulario-editar").reset();

            axios.post('/admin/finanzas/informacion',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(id);

                        $('#fecha-editar').val(response.data.info.fecha);
                        $('#titulo-editar').val(response.data.info.titulo);
                        $('#descripcion-editar').val(response.data.info.descripcion);

                    }else{
                        toastr.error('Información no encontrada');
                    }

                })
                .catch((error) => {
                    closeLoading();
                    toastr.error('Información no encontrada');
                });
        }


        function editarRegistro(){
            var id = document.getElementById('id-editar').value;

            var titulo = document.getElementById('titulo-editar').value;
            var descripcion = document.getElementById('descripcion-editar').value;
            var documento = document.getElementById('documento-editar');
            var fecha = document.getElementById('fecha-editar').value;

            if(fecha === ''){
                toastr.error('Fecha es requerido')
                return
            }

            if(titulo === ''){
                toastr.error('Título es requerido')
                return
            }

            if(documento.files && documento.files[0]){ // si trae imagen
                if (!documento.files[0].type.match('application/pdf')){
                    toastr.error('Formato permitido: .pdf');
                    return;
                }
            }

            openLoading();
            var formData = new FormData();
            formData.append('id', id);
            formData.append('fecha', fecha);
            formData.append('titulo', titulo);
            formData.append('descripcion', descripcion);
            formData.append('imagen', documento.files[0]);

            axios.post('/admin/finanzas/editar', formData, {
            })
                .then((response) => {
                    closeLoading();

                    if(response.data.success === 1){
                        toastr.success('Actualizado');
                        $('#modalEditar').modal('hide');
                        recargar();
                    }
                    else {
                        toastr.error('Error al actualizar');
                    }
                })
                .catch((error) => {
                    toastr.error('Error al actualizar');
                    closeLoading();
                });
        }


        function modalBorrar(id){
            Swal.fire({
                title: 'Borrar?',
                text: "",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si'
            }).then((result) => {
                if (result.isConfirmed) {
                    solicitarBorrar(id);
                }
            })
        }


        function solicitarBorrar(idfila){

            openLoading();

            axios.post('/admin/finanzas/borrar',{
                'id': idfila
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){

                        toastr.success('Borrado');
                        recargar();
                    }else{
                        toastr.error('Error al borrar');
                    }
                })
                .catch((error) => {
                    toastr.error('Error al borrar');
                    closeLoading();
                });
        }




    </script>


@endsection
