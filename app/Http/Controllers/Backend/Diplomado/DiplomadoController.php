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

        $arrayCurso = DiplomadoCursos::orderBy('nombre', 'ASC')->get();
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

            $nombreCurso = DiplomadoCursos::where('id', $request->curso)->first()->nombre;
            $nombreCertificado = DiplomadoCertificado::where('id', $request->certificado)->first()->nombre;

            $codigo = Str::uuid();

            DiplomadoAlumnos::create([
                'curso_id' => $request->curso,
                'certificado_id' => $request->certificado,
                'fecha' => Carbon::now('America/El_Salvador'),
                'codigo_verificacion' => $codigo,
                'nombre' => $request->nombre,
                'curso' => $nombreCurso,
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



}
