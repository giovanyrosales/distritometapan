<?php

namespace App\Http\Controllers\Backend\Extras\Servicio;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\Sugerencias;
use App\Models\Votacion;
use App\Models\VotacionRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServicioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    public function indexServicio(){

        return view('backend.admin.servicio.vistaservicio');
    }

    public function tablaServicio(){

        $listado = Servicio::orderBy('id', 'ASC')->get();

        return view('backend.admin.servicio.tablaservicio', compact('listado'));
    }


    public function nuevoServicio(Request $request){

        $regla = array(
            'nombre' => 'required',
            'slug' => 'required',
        );

        // logo, imagen, editorc, editorl

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            // Evitar Slug repetido
            $slug = Str::slug($request->slug, '-');

            if(Servicio::where('slug', $slug)->first()){
                return ['success' => 1];
            }


            // GUARDAR LOGO

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena . $tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.' . $request->logo->getClientOriginalExtension();
            $nombreFoto = $nombre . strtolower($extension);
            $avatar = $request->file('logo');
            Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));


            // GUARDAR IMAGEN

            $cadena2 = Str::random(15);
            $tiempo2 = microtime();
            $union2 = $cadena2 . $tiempo2;
            $nombre2 = str_replace(' ', '_', $union2);

            $extension2 = '.' . $request->imagen->getClientOriginalExtension();
            $nombreFoto2 = $nombre2 . strtolower($extension2);
            $avatar2 = $request->file('imagen');
            Storage::disk('archivos')->put($nombreFoto2, \File::get($avatar2));


            $registro = new Servicio();
            $registro->nombreservicio = $request->nombre;
            $registro->estado = 1;
            $registro->logo = $nombreFoto;
            $registro->descorta = $request->editorc;
            $registro->deslarga = $request->editorl;
            $registro->slug = $slug;
            $registro->imagen = $nombreFoto2;
            $registro->save();


            DB::commit();
            return ['success' => 2];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }


    public function informacionServicio(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = Servicio::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }


    public function editarServicio(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'slug' => 'required',
            'toggle' => 'required'
        );

        // logo, imagen, editorc,  editorl

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            $slug = Str::slug($request->slug, '-');

            if(Servicio::where('slug', $slug)
                ->where('id', '!=', $request->id)
                ->first()){
                return ['success' => 1];
            }


            $infoFila = Servicio::where('id', $request->id)->first();

            $logoOld = $infoFila->logo;
            $imagenOld = $infoFila->imagen;


            if ($request->hasFile('logo')) {

                $cadena = Str::random(15);
                $tiempo = microtime();
                $union = $cadena . $tiempo;
                $nombre = str_replace(' ', '_', $union);

                $extension = '.' . $request->logo->getClientOriginalExtension();
                $nombreFoto = $nombre . strtolower($extension);
                $avatar = $request->file('logo');
                Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));

                if($logoOld != null){
                    if(Storage::disk('archivos')->exists($logoOld)){
                        Storage::disk('archivos')->delete($logoOld);
                    }
                }

                Servicio::where('id', $request->id)
                    ->update([
                        'logo' => $nombreFoto,
                    ]);
            }


            if ($request->hasFile('imagen')) {

                $cadena2 = Str::random(15);
                $tiempo2 = microtime();
                $union2 = $cadena2 . $tiempo2;
                $nombre2 = str_replace(' ', '_', $union2);

                $extension2 = '.' . $request->imagen->getClientOriginalExtension();
                $nombreFoto2 = $nombre2 . strtolower($extension2);
                $avatar2 = $request->file('imagen');
                Storage::disk('archivos')->put($nombreFoto2, \File::get($avatar2));

                if($imagenOld != null){
                    if(Storage::disk('archivos')->exists($imagenOld)){
                        Storage::disk('archivos')->delete($imagenOld);
                    }
                }

                Servicio::where('id', $request->id)
                    ->update([
                        'imagen' => $nombreFoto2,
                    ]);
            }


            Servicio::where('id', $request->id)
                ->update([
                    'nombreservicio' => $request->nombre,
                    'estado' => $request->toggle,
                    'slug' => $slug,
                    'descorta' => $request->editorc,
                    'deslarga' => $request->editorl
                ]);


            DB::commit();
            return ['success' => 2];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }


    public function borrarServicio(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $infoFila = Servicio::where('id', $request->id)->first();

        if($infoFila->logo != null){
            if(Storage::disk('archivos')->exists($infoFila->logo)){
                Storage::disk('archivos')->delete($infoFila->logo);
            }
        }

        if($infoFila->imagen != null){
            if(Storage::disk('archivos')->exists($infoFila->imagen)){
                Storage::disk('archivos')->delete($infoFila->imagen);
            }
        }

        // borrar
        Servicio::where('id', $request->id)->delete();

        return ['success' => 1];
    }

    public function descargarDocServicio()
    {
        $doc = "Escaneo.pdf";
        $pathToFile = public_path("images/" . $doc);
        $extension = pathinfo($pathToFile, PATHINFO_EXTENSION);

        $nombre = "Solicitud_de_Solvencia";

        $nombreFinal = $nombre . "." . $extension;
        return response()->download($pathToFile, $nombreFinal);
    }



    //************************************************************************************


    public function indexVotacion(){
        return view('backend.admin.votacion.vistavotacion');
    }


    public function tablaVotacion()
    {
        $arrayVotacion = Votacion::get();

        return view('backend.admin.votacion.tablavotacion', compact('arrayVotacion'));
    }

    public function nuevoVotacion(Request $request)
    {
        DB::beginTransaction();
        try {
            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena . $tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.' . $request->imagen->getClientOriginalExtension();
            $nombreFoto = $nombre . strtolower($extension);
            $avatar = $request->file('imagen');
            Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));


            $registro = new Votacion();
            $registro->nombre = $request->nombre;
            $registro->descripcion = $request->descripcion;
            $registro->imagen = $nombreFoto;
            $registro->activo = 1;
            $registro->save();

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }


    public function informacionVotacion(Request $request)
    {
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = Votacion::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }


    public function editarVotacion(Request $request)
    {
        $regla = array(
            'id' => 'required',
        );


        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();

        try {
            if ($request->hasFile('imagen')) {

                $cadena = Str::random(15);
                $tiempo = microtime();
                $union = $cadena . $tiempo;
                $nombre = str_replace(' ', '_', $union);

                $extension = '.' . $request->imagen->getClientOriginalExtension();
                $nombreFoto = $nombre . strtolower($extension);
                $avatar = $request->file('imagen');
                Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));

                $infoFila = Votacion::where('id', $request->id)->first();
                $imagenOld = $infoFila->imagen;

                if($imagenOld != null){
                    if(Storage::disk('archivos')->exists($imagenOld)){
                        Storage::disk('archivos')->delete($imagenOld);
                    }
                }

                Votacion::where('id', $request->id)
                    ->update([
                        'nombre' => $request->nombre,
                        'descripcion' => $request->descripcion,
                        'imagen' => $nombreFoto,
                        'activo' => $request->toggle,
                    ]);
            }else{
                Votacion::where('id', $request->id)
                    ->update([
                        'nombre' => $request->nombre,
                        'descripcion' => $request->descripcion,
                        'activo' => $request->toggle,
                    ]);
            }

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }


    public function indexSugerencias()
    {
        return view('backend.admin.sugerencias.vistasugerencias');
    }

    public function tablaSugerencias()
    {
        $arraySugerencias = Sugerencias::orderBy('fecha', 'ASC')->get();

        return view('backend.admin.sugerencias.tablasugerencias', compact('arraySugerencias'));
    }


    public function borrarSugerencias(Request $request)
    {
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        Sugerencias::where('id', $request->id)->delete();
        return ['success' => 1];
    }




}
