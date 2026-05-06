@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">
@stop

<style>
    table { table-layout: fixed; }
</style>

<div id="divcontenedor" style="display:none">

    <section class="content" style="margin-top: 35px; margin-bottom: 60px">
        <div class="container-fluid">

            <div class="card card-gray-dark">
                <div class="card-header">
                    <h3 class="card-title">REPORTES DIPLOMADO</h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- SELECT CURSO + PERIODO --}}
                        <div class="col-md-4">
                            <label><i class="fas fa-book mr-1"></i> Curso</label>
                            <select id="select-curso" class="form-control select2">
                                <option value="">Seleccionar...</option>
                                @foreach($cursos as $item)
                                    <option value="{{ $item->curso }}|{{ $item->periodo }}">
                                        {{ $item->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FECHA DESDE --}}
                        <div class="col-md-3">
                            <label><i class="fas fa-calendar-alt mr-1"></i> Desde</label>
                            <input type="date" id="filtro-desde" class="form-control">
                        </div>

                        {{-- FECHA HASTA --}}
                        <div class="col-md-3">
                            <label><i class="fas fa-calendar-check mr-1"></i> Hasta</label>
                            <input type="date" id="filtro-hasta" class="form-control">
                        </div>

                    </div>

                    <br>

                    <button onclick="generarPDF()" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Generar PDF
                    </button>

                </div>
            </div>

        </div>
    </section>

</div>

@extends('backend.menus.footerjs')

@section('archivos-js')

    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            $("#divcontenedor").show();

        });
    </script>

    <script>

        function generarPDF() {

            let valor = $('#select-curso').val();

            if (valor === '') {
                toastr.error('Debe seleccionar un curso');
                return;
            }

            let [curso, periodo] = valor.split('|');

            let desde = $('#filtro-desde').val();
            let hasta = $('#filtro-hasta').val();

            let url = `/admin/diplomado/reportes/generar?curso=${curso}&periodo=${periodo}&desde=${desde}&hasta=${hasta}`;

            window.open(url, '_blank');
        }

    </script>

@endsection
