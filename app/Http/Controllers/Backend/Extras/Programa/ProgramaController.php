<?php

namespace App\Http\Controllers\Backend\Extras\Programa;

use App\Http\Controllers\Controller;
use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProgramaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    public function indexPrograma(){

        return view('backend.admin.programa.vistaprograma');
    }

    public function tablaPrograma(){

        $listado = Programa::orderBy('id', 'ASC')->get();

        return view('backend.admin.programa.tablaprograma', compact('listado'));
    }

    public function nuevoPrograma(Request $request){

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

            if(Programa::where('slug', $slug)->first()){
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


            $registro = new Programa();
            $registro->nombreprograma = $request->nombre;
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


    public function informacionPrograma(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = Programa::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }


    public function editarPrograma(Request $request){

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

            if(Programa::where('slug', $slug)
                ->where('id', '!=', $request->id)
                ->first()){
                return ['success' => 1];
            }


            $infoFila = Programa::where('id', $request->id)->first();

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

                Programa::where('id', $request->id)
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

                Programa::where('id', $request->id)
                    ->update([
                        'imagen' => $nombreFoto2,
                    ]);
            }


            Programa::where('id', $request->id)
                ->update([
                    'nombreprograma' => $request->nombre,
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


    public function borrarPrograma(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $infoFila = Programa::where('id', $request->id)->first();

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
        Programa::where('id', $request->id)->delete();

        return ['success' => 1];
    }

}
