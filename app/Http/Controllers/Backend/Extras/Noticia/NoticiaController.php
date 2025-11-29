<?php

namespace App\Http\Controllers\Backend\Extras\Noticia;

use App\Http\Controllers\Controller;
use App\Models\Fotografia;
use App\Models\Noticia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class NoticiaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexNoticia(){

        $fechaActual = Carbon::now('America/El_Salvador');

        return view('backend.admin.noticia.vistanoticia', compact('fechaActual'));
    }


    public function tablaNoticia(){
        $listado = Noticia::orderBy('fecha', 'DESC')->get();

        return view('backend.admin.noticia.tablanoticia',compact('listado'));
    }


    public function nuevoNoticia(Request $request)
    {
        $regla = array(
            'nombre' => 'required',
            'fecha'  => 'required',
            'slug'   => 'required',
            // opcional pero recomendado:
            // 'imagen.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        );

        // nombre, fecha, slug, editorc, editorl, imagen[]

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()) {
            return ['success' => 0];
        }

        DB::beginTransaction();
        try {

            $registro = new Noticia();
            $registro->nombrenoticia = $request->nombre;
            $registro->estado        = 0;
            $registro->fecha         = $request->fecha;
            $registro->descorta      = $request->editorc;
            $registro->deslarga      = $request->editorl;
            $registro->slug          = $request->slug;
            $registro->save();

            if ($request->hasFile('imagen')) {
                foreach ($request->file('imagen') as $img) {

                    $cadena = Str::random(15);
                    $tiempo = microtime();
                    $union  = $cadena . $tiempo;
                    $nombre = str_replace(' ', '_', $union);

                    $extension  = '.' . $img->getClientOriginalExtension();
                    $nombreFoto = $nombre . strtolower($extension);

                    // 👉 Sin Intervention: guardar el archivo tal cual en el disk 'archivos'
                    // storage/app/archivos (dependiendo de cómo tengas configurado el disk)
                    $img->storeAs('/', $nombreFoto, 'archivos');
                    // Alternativa equivalente:
                    // Storage::disk('archivos')->putFileAs('', $img, $nombreFoto);

                    $detalle = new Fotografia();
                    $detalle->noticia_id      = $registro->id;
                    $detalle->nombrefotografia = $nombreFoto;
                    $detalle->save();
                }
            }

            DB::commit();
            return ['success' => 1];

        } catch (\Throwable $e) {
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }

    public function informacionNoticia(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = Noticia::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }


    public function editarNoticia(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
            'fecha' => 'required',
            'slug' => 'required',
            'toggle' => 'required'
        );

        // editorc,  editorl

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if(Noticia::where('id', $request->id)->first()){

            Noticia::where('id', $request->id)
                ->update([
                    'nombrenoticia' => $request->nombre,
                    'estado' => $request->toggle,
                    'fecha' => $request->fecha,
                    'slug' => $request->slug,
                    'descorta' => $request->editorc,
                    'deslarga' => $request->editorl,
                ]);

            return ['success' => 1];
        }else{
            return ['success' => 99];
        }
    }

    public function borrarNoticia(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        // borrar todas las imagenes primero
        $listadoImagen = Fotografia::where('noticia_id', $request->id)->get();

        foreach ($listadoImagen as $dato){

            if($dato->nombrefotografia != null){
                if(Storage::disk('archivos')->exists($dato->nombrefotografia)){
                    Storage::disk('archivos')->delete($dato->nombrefotografia);
                }
            }
        }

        // borrar fotografia
        Fotografia::where('noticia_id', $request->id)->delete();

        // borrar noticia
        Noticia::where('id', $request->id)->delete();

        return ['success' => 1];
    }



    // ********************************************************************************************


    public function indexNoticiaImagen($id){



        return view('backend.admin.noticia.imagenes.vistaimagenes', compact('id'));
    }


    public function tablaNoticiaImagen($id){

        $listado = Fotografia::where('noticia_id', $id)
            ->orderBy('id', 'ASC')
            ->get();

        return view('backend.admin.noticia.imagenes.tablaimagenes', compact('listado'));
    }


    public function nuevoNoticiaImagen(Request $request)
    {
        $regla = array(
            'id' => 'required',
            // opcional recomendado:
            // 'imagen.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()) {
            return ['success' => 0];
        }

        DB::beginTransaction();
        try {

            if ($request->hasFile('imagen')) {
                foreach ($request->file('imagen') as $img) {

                    $cadena = Str::random(15);
                    $tiempo = microtime();
                    $union  = $cadena . $tiempo;
                    $nombre = str_replace(' ', '_', $union);

                    $extension  = '.' . $img->getClientOriginalExtension();
                    $nombreFoto = $nombre . strtolower($extension);

                    // 👉 Guardar directamente SIN Intervention
                    $img->storeAs('/', $nombreFoto, 'archivos');

                    $detalle = new Fotografia();
                    $detalle->noticia_id = $request->id;
                    $detalle->nombrefotografia = $nombreFoto;
                    $detalle->save();
                }
            }

            DB::commit();
            return ['success' => 1];

        } catch (\Throwable $e) {
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }



    public function borrarNoticiaImagen(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $infoImagen = Fotografia::where('id', $request->id)->first();

        if($infoImagen->nombrefotografia != null){
            if(Storage::disk('archivos')->exists($infoImagen->nombrefotografia)){
                Storage::disk('archivos')->delete($infoImagen->nombrefotografia);
            }
        }

        // borrar fotografia
        Fotografia::where('id', $request->id)->delete();

        return ['success' => 1];
    }


}
