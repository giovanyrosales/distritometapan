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
                                        <label>Nombre</label>
                                        <input style="color:#191818" type="text" id="nombre-nuevo" class="form-control" maxlength="450" />
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input style="color:#191818; width: 18%" value="{{ $fechaActual->format('Y-m-d') }}" type="date" id="fecha-nuevo" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input style="color:#191818" type="text" id="slug-nuevo" class="form-control" maxlength="150" />
                                    </div>


                                    <div class="form-group">
                                        <label>Imagenes</label>
                                        <input type="file" class="form-control" id="imagenes" name="imagenes[]" multiple accept="image/jpeg, image/jpg, image/png" />
                                    </div>


                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="box box-info">
                                                <div class="box-header with-border"  style="margin-top:10px">
                                                    <h3 class="box-title">Descripción Corta</h3>
                                                </div>
                                                <!-- editor 1 -->
                                                <textarea id="editor1" name="editor1"></textarea>
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="box box-info">
                                                <div class="box-header with-border" style="margin-top:10px">
                                                    <h3 class="box-title">Descripción Larga</h3>
                                                </div>
                                                <!-- editor 2-->
                                                <textarea id="editor2" name="editor2"></textarea>
                                            </div>

                                        </div>
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
                                        <label>Nombre</label>
                                        <input style="color:#191818" type="text" id="nombre-editar" class="form-control" maxlength="450" />
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input style="color:#191818; width: 18%" type="date" id="fecha-editar" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input style="color:#191818" type="text" id="slug-editar" class="form-control" maxlength="150" />
                                    </div>


                                    <div class="form-group">
                                        <label>Estado</label>
                                        <br>
                                        <label class="switch" style="margin-top:10px">
                                            <input type="checkbox" id="toggle">
                                            <div class="slider round">
                                                <span class="on">Activo</span>
                                                <span class="off">Inactivo</span>
                                            </div>
                                        </label>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="box box-info">
                                                <div class="box-header with-border"  style="margin-top:10px">
                                                    <h3 class="box-title">Descripción Corta</h3>
                                                </div>
                                                <!-- editor 1 -->
                                                <textarea id="editor3" name="editor3"></textarea>
                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="box box-info">
                                                <div class="box-header with-border" style="margin-top:10px">
                                                    <h3 class="box-title">Descripción Larga</h3>
                                                </div>
                                                <!-- editor 2-->
                                                <textarea id="editor4" name="editor4"></textarea>
                                            </div>

                                        </div>
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
    <script src="{{ asset('plugins/ckeditor5v1/build/ckeditor.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            var ruta = "{{ URL::to('/admin/noticia/tabla') }}";
            $('#tablaDatatable').load(ruta);


            window.varGlobalEditor1_Nuevo; // descripcion corta
            window.varGlobalEditor2_Nuevo; // descripcion larga
            window.varGlobalEditor3_Nuevo; // Editar descripcion corta
            window.varGlobalEditor4_Nuevo; // Editar descripcion larga

            ClassicEditor
                .create(document.querySelector('#editor1'), {
                    language: 'es',
                })
                .then(editor1 => {

                    varGlobalEditor1_Nuevo = editor1;
                })
                .catch(error => {

                });

            ClassicEditor
                .create(document.querySelector('#editor2'), {
                    language: 'es',
                })
                .then(editor2 => {

                    varGlobalEditor2_Nuevo = editor2;
                })
                .catch(error => {

                });


            //************

            ClassicEditor
                .create(document.querySelector('#editor3'), {
                    language: 'es',
                })
                .then(editor3 => {

                    varGlobalEditor3_Nuevo = editor3;
                })
                .catch(error => {

                });

            ClassicEditor
                .create(document.querySelector('#editor4'), {
                    language: 'es',
                })
                .then(editor4 => {

                    varGlobalEditor4_Nuevo = editor4;
                })
                .catch(error => {

                });

            document.getElementById("divcontenedor").style.display = "block";
        });
    </script>

    <script>

        function recargar(){
            var ruta = "{{ URL::to('/admin/noticia/tabla') }}";
            $('#tablaDatatable').load(ruta);
        }

        function modalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            varGlobalEditor1_Nuevo.setData("");
            varGlobalEditor2_Nuevo.setData("");

            $('#modalAgregar').modal('show');
        }

        function nuevoRegistro(){

            var nombre = document.getElementById('nombre-nuevo').value;
            var slug = document.getElementById('slug-nuevo').value;
            var fecha = document.getElementById('fecha-nuevo').value;
            var imagen = document.getElementById('imagenes');

            if(nombre === ''){
                toastr.error('Nombre es requerido')
                return
            }

            if(fecha === ''){
                toastr.error('Fecha es requerido')
                return
            }

            if(slug === ''){
                toastr.error('Slug es requerido')
                return
            }

            if(imagen.files && imagen.files[0]){
                // nada
            }else{
                toastr.error('Imagenes son requeridas');
                return
            }

            const editorCorta = varGlobalEditor1_Nuevo.getData();
            const editorLarga = varGlobalEditor2_Nuevo.getData();

            if(editorCorta === ''){
                toastr.error('Editor Corta es requerido')
                return
            }

            if(editorLarga === ''){
                toastr.error('Editor Larga es requerido')
                return
            }


            var files = imagen.files;
            for (var i = 0; i < files.length; i++){
                var file = files[i];

                if (!file.type.match('image/jpeg|image/jpeg|image/png')){
                    toastr.error('Formatos de imagen validos unicamente .jpg .jpeg .png');
                    return false;
                    break;
                }
            }

            openLoading();
            var formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('fecha', fecha);
            formData.append('slug', slug);
            formData.append('editorc', editorCorta);
            formData.append('editorl', editorLarga);

            var filesAdd = imagen.files;
            for (var i = 0; i < filesAdd.length; i++){
                var fileq = filesAdd[i];

                // Add the file to the request.
                formData.append('imagen[]', fileq, fileq.name);
            }

            axios.post('/admin/noticia/nuevo', formData, {
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

            axios.post('/admin/noticia/informacion',{
                'id': id
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(id);

                        $('#nombre-editar').val(response.data.info.nombrenoticia);
                        $('#fecha-editar').val(response.data.info.fecha);
                        $('#slug-editar').val(response.data.info.slug);

                        if(response.data.info.estado === 1){
                            $("#toggle").prop("checked", true);
                        }else{
                            $("#toggle").prop("checked", false);
                        }

                        varGlobalEditor3_Nuevo.setData(response.data.info.descorta);
                        varGlobalEditor4_Nuevo.setData(response.data.info.deslarga);

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
            var nombre = document.getElementById('nombre-editar').value;
            var slug = document.getElementById('slug-editar').value;
            var fecha = document.getElementById('fecha-editar').value;
            let t = document.getElementById('toggle').checked;
            let toggle = t ? 1 : 0;

            if(nombre === ''){
                toastr.error('Nombre es requerido')
                return
            }

            if(fecha === ''){
                toastr.error('Fecha es requerido')
                return
            }

            if(slug === ''){
                toastr.error('Slug es requerido')
                return
            }

            const editorCorta = varGlobalEditor3_Nuevo.getData();
            const editorLarga = varGlobalEditor4_Nuevo.getData();

            if(editorCorta === ''){
                toastr.error('Editor Corta es requerido')
                return
            }

            if(editorLarga === ''){
                toastr.error('Editor Larga es requerido')
                return
            }


            openLoading();
            var formData = new FormData();
            formData.append('id', id);
            formData.append('nombre', nombre);
            formData.append('fecha', fecha);
            formData.append('slug', slug);
            formData.append('editorc', editorCorta);
            formData.append('editorl', editorLarga);
            formData.append('toggle', toggle);

            axios.post('/admin/noticia/editar', formData, {
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

            axios.post('/admin/noticia/borrar',{
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

        function vistaImagenes(id){
            window.location.href="{{ url('/admin/noticiaimagen/index') }}/" + id;
        }


    </script>


@endsection
