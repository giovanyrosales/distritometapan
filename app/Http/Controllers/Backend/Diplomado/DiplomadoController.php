<?php

namespace App\Http\Controllers\Backend\Diplomado;

use App\Http\Controllers\Controller;
use App\Models\DiplomadoAlumnos;
use App\Models\DiplomadoCertificado;
use App\Models\DiplomadoCursos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\GdImageBackEnd;

class DiplomadoController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }


    // *************** CURSOS ***************

    public function indexCursos()
    {
        return view('backend.diplomado.cursos.vistacursos');
    }


    public function tablaCursos()
    {
        $arrayCursos = DiplomadoCursos::orderBy('nombre', 'ASC')->get();

        return view('backend.diplomado.cursos.tablacursos', compact('arrayCursos'));
    }


    public function registrarCursos(Request $request)
    {
        $regla = array(
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $registro = new DiplomadoCursos();
        $registro->nombre = $request->nombre;
        $registro->periodo = $request->periodo;
        $registro->save();

        return ['success' => 1];
    }


    public function informacionCursos(Request $request)
    {
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = DiplomadoCursos::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }

    public function editarCursos(Request $request)
    {
        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            DiplomadoCursos::where('id', $request->id)
                ->update([
                    'nombre' => $request->nombre,
                    'periodo' => $request->periodo,
                ]);

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }





    // *************** CERTIFICADO ***************

    public function indexCertificado()
    {
        return view('backend.diplomado.certificado.vistacertificado');
    }


    public function tablaCertificado()
    {
        $arrayCursos = DiplomadoCertificado::orderBy('nombre', 'ASC')->get();

        return view('backend.diplomado.certificado.tablacertificado', compact('arrayCursos'));
    }


    public function registrarCertificado(Request $request)
    {
        $regla = array(
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $registro = new DiplomadoCertificado();
        $registro->nombre = $request->nombre;
        $registro->save();

        return ['success' => 1];
    }


    public function informacionCertificado(Request $request)
    {
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = DiplomadoCertificado::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }

    public function editarCertificado(Request $request)
    {
        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            DiplomadoCertificado::where('id', $request->id)
                ->update([
                    'nombre' => $request->nombre,
                ]);


            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }



    // *************** GENERAR CERTIFICADO ***************

    public function indexGenerarCertificado()
    {

        $arrayCurso = DiplomadoCursos::orderBy('nombre', 'ASC')->get()
            ->map(function ($item) {
                $item->nombre_periodo = $item->nombre . ' - ' . $item->periodo;
                return $item;
            });

        $arrayCertificado = DiplomadoCertificado::orderBy('nombre', 'ASC')->get();

        return view('backend.diplomado.alumnos.vistagenerarcertificado', compact('arrayCurso', 'arrayCertificado'));
    }

    public function crearCertificacion(Request $request)
    {
        $regla = array(
            'nombre' => 'required',
            'curso' => 'required',
            'certificado' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            $infoCurso = DiplomadoCursos::where('id', $request->curso)->first();
            $nombreCertificado = DiplomadoCertificado::where('id', $request->certificado)->first()->nombre;

            $codigo = Str::uuid();

            DiplomadoAlumnos::create([
                'curso_id' => $request->curso,
                'certificado_id' => $request->certificado,
                'fecha' => Carbon::now('America/El_Salvador'),
                'codigo_verificacion' => $codigo,
                'nombre' => $request->nombre,
                'curso' => $infoCurso->nombre,
                'periodo' => $request->periodo,
                'certificado' => $nombreCertificado,
            ]);

            DB::commit();
            return [
                'success' => 1,
                'codigo' => $codigo
            ];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }


    public function qr($codigo)
    {
        $url = url("/verificar/$codigo");

        return response(
            \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(300)
                ->margin(1)
                ->generate($url),
            200
        )->header('Content-Type', 'image/svg+xml');
    }




    //************************** LISTADO DE ALUMNOS ************************************

    public function indexListadoAlumnos()
    {
        return view('backend.diplomado.listadoalumnos.vistalistadoalumnos');
    }



    public function tablaListadoAlumnos(Request $request)
    {
        $query = DiplomadoAlumnos::orderBy('fecha', 'asc');

        // Filtro por nombre del alumno
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtro por curso
        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        // Filtro por certificado
        if ($request->filled('certificado_id')) {
            $query->where('certificado_id', $request->certificado_id);
        }

        // Filtro por periodo
        if ($request->filled('periodo')) {
            $query->where('periodo', $request->periodo);
        }

        // Filtro por rango de fechas (campo 'fecha' de la tabla)
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        // Filtro por código de verificación
        if ($request->filled('codigo_verificacion')) {
            $query->where('codigo_verificacion', $request->codigo_verificacion);
        }

        $arrayAlumnos = $query->get()->map(function ($item) {

            // Formatear fecha
            $item->fecha_fmt = $item->fecha
                ? date('d/m/Y', strtotime($item->fecha))
                : null;

            return $item;
        });

        return view('backend.diplomado.listadoalumnos.tablalistadoalumnos', compact('arrayAlumnos'));
    }



    public function borrarListadoAlumnos(Request $request)
    {
        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()) {
            return ['success' => 0];
        }

        DiplomadoAlumnos::where('id', $request->id)->delete();

        return ['success' => 1];
    }


    public function informacionListadoAlumnos(Request $request)
    {
        $regla = array(
            'id' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()) {
            return ['success' => 0];
        }

        $info = DiplomadoAlumnos::where('id', $request->id)->first();

        return ['success' => 1, 'info' => $info];
    }


    public function actualizarListadoAlumnos(Request $request)
    {
        $regla = array(
            'id' => 'required',
            'fecha' => 'required',
            'nombre' => 'required',
            'curso' => 'required',
            'certificado' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            DiplomadoAlumnos::where('id', $request->id)
                ->update([
                    'fecha' => $request->fecha,
                    'nombre' => $request->nombre,
                    'curso' => $request->curso,
                    'periodo' => $request->periodo,
                    'certificado' => $request->certificado,
                ]);

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }


    public function indexReportes()
    {
        $cursos = DB::table('diplomado_alumnos')
            ->selectRaw("curso, periodo, CONCAT(curso, ' - ', COALESCE(periodo, 'Sin periodo')) as nombre")
            ->groupBy('curso', 'periodo')
            ->orderBy('curso')
            ->get();

        return view('backend.diplomado.reporte.vistareportediplomado', compact('cursos'));
    }


    public function generarReporte(Request $request)
    {
        $query = DiplomadoAlumnos::query();

        // 🔎 FILTROS
        if ($request->curso) {
            $query->where('curso', $request->curso);
        }

        if ($request->desde) {
            $query->whereDate('fecha', '>=', $request->desde);
        }

        if ($request->hasta) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        $alumnos = $query->orderBy('fecha', 'desc')->get();

        // 🧾 PDF
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'LETTER',
            'orientation' => 'P',
            'margin_top' => 10,
            'tempDir' => storage_path('app/mpdf')
        ]);

        $fecha = now()->format('d-m-Y');
        $logoalcaldia = public_path('images/logo.png');

        // 🧠 Tomar curso y periodo del request
        $curso   = $request->curso ?? '—';
        $periodo = $request->periodo ?? '—';

        $html = "
    <table width='100%' style='border-collapse:collapse; font-family:Arial, sans-serif; margin-bottom:6px;'>
        <tr>
            <td style='width:30%; border:0.8px solid #000; padding:6px 8px;'>
                <table width='100%'>
                    <tr>
                        <td style='width:35%; text-align:left;'>
                            <img src='{$logoalcaldia}' style='height:40px'>
                        </td>
                        <td style='width:65%; text-align:left; color:#104e8c;
                                    font-size:12px; font-weight:bold; line-height:1.4;'>
                            SANTA ANA NORTE<br>EL SALVADOR
                        </td>
                    </tr>
                </table>
            </td>

            <td style='width:70%; border:0.8px solid #000;
                        padding:8px; text-align:center; vertical-align:middle;'>

                <h2 style='margin:0;'>REPORTE DE CURSOS</h2>
                <p style='margin:0; font-size:12px;'>Fecha de generación: {$fecha}</p>

            </td>
        </tr>
    </table>
    ";

        // ✅ INFO CURSO / PERIODO
        $html .= "
    <table width='100%' style='margin-top:10px; font-size:14px; font-family:Arial;'>
        <tr>
            <td><strong>Curso:</strong> {$curso}</td>
            <td><strong>Periodo:</strong> {$periodo}</td>
        </tr>
    </table>
    ";

        if ($alumnos->isEmpty()) {

            $html .= "
        <p style='text-align:center; margin-top:40px; color:#888;'>
            No hay datos disponibles
        </p>";

        } else {

            $html .= "
        <br>
        <table width='100%' style='border-collapse:collapse; font-size:11px;' border='1' cellpadding='8'>
            <thead>
                <tr style='background:#e9ecef; color:#000;'>
                    <th style='width:5%; font-size: 13px'>#</th>
                    <th style='width:90%; font-size: 13px'>Nombre</th>
                </tr>
            </thead>
            <tbody>
        ";

            $i = 1;

            foreach ($alumnos as $a) {

                $html .= "
            <tr style='height:45px;'>
                <td style='text-align:center;'>{$i}</td>
                <td style='font-size: 12px'>{$a->nombre}</td>
            </tr>
            ";

                $i++;
            }

            $html .= "</tbody></table>";

            // ✍️ FIRMAS
            $html .= "
        <br><br><br><br>

        <table width='100%' style='margin-top:70px; font-family:Arial, sans-serif;'>
            <tr>

                <td style='width:50%; text-align:center;'>
                    <table width='50%' align='center' style='border-top:1px solid #000;'>
                        <tr><td></td></tr>
                    </table>
                    <p style='margin-top:6px; font-size:12px; font-weight:bold;'>
                        Lic. Sandra Velásquez García
                    </p>
                    <p style='margin:0; font-size:12px;'>
                        Jefa Unidad Técnico de Formación Técnica y Vocacional
                    </p>
                </td>

                <td style='width:50%; text-align:center;'>
                    <table width='50%' align='center' style='border-top:1px solid #000;'>
                        <tr><td></td></tr>
                    </table>
                    <p style='margin-top:6px; font-size:12px; font-weight:bold;'>
                        Ing. Vanessa del Socorro Carranza
                    </p>
                    <p style='margin:0; font-size:12px;'>
                        Gerencia Administrativa y Desarrollo Social
                    </p>
                </td>

            </tr>
        </table>
        ";
        }

        $mpdf->WriteHTML($html);

        return $mpdf->Output('reporte_cursos.pdf', 'I');
    }





}
