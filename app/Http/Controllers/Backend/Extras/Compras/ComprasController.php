<?php

namespace App\Http\Controllers\Backend\Extras\Compras;

use App\Http\Controllers\Controller;
use App\Models\Compras;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class ComprasController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexCompras(){
        $fechaActual = Carbon::now('America/El_Salvador');

        return view('backend.admin.compras.vistacompras', compact('fechaActual'));
    }

    public function tablaCompras(){

        $listado = Compras::orderBy('fecha', 'ASC')->get();

        foreach ($listado as $dato){
            $dato->fechaFormat = date("d-m-Y", strtotime($dato->fecha));
        }

        return view('backend.admin.compras.tablacompras', compact('listado'));
    }


    public function nuevoCompras(Request $request){

        $regla = array(
            'fecha' => 'required',
            'titulo' => 'required',
        );

        // descripcion, documento

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}


        if ($request->hasFile('documento')) {

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena . $tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.' . $request->documento->getClientOriginalExtension();
            $nombreFoto = $nombre . strtolower($extension);
            $avatar = $request->file('documento');
            $upload = Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));

            if ($upload) {

                $registro = new Compras();
                $registro->titulo = $request->titulo;
                $registro->descripcion = $request->descripcion;
                $registro->fecha = $request->fecha;
                $registro->documento = $nombreFoto;
                $registro->save();

                return ['success' => 1];
            }
            else {
                return ['success' => 99];
            }

        }else{
            return ['success' => 99];
        }
    }


    public function informacionCompras(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = Compras::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }


    public function editarCompras(Request $request){

        $rules = array(
            'id' => 'required',
            'fecha' => 'required',
            'titulo' => 'required'
        );

        // descripcion, documento

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return ['success' => 0];
        }

        if ($request->hasFile('documento')) {

            $infoDato = Compras::where('id', $request->id)->first();

            $imagenOld = $infoDato->documento;

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena . $tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.' . $request->documento->getClientOriginalExtension();
            $nombreFoto = $nombre . strtolower($extension);
            $avatar = $request->file('documento');
            $upload = Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));

            if ($upload) {

                Compras::where('id', $request->id)
                    ->update([
                        'titulo' => $request->titulo,
                        'descripcion' => $request->descripcion,
                        'fecha' => $request->fecha,
                        'documento' => $nombreFoto
                    ]);

                if($imagenOld != null){
                    if(Storage::disk('archivos')->exists($imagenOld)){
                        Storage::disk('archivos')->delete($imagenOld);
                    }
                }

                return ['success' => 1];
            } else {
                // error al subir imagen
                return ['success' => 99];
            }
        } else {
            Compras::where('id', $request->id)
                ->update([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    'fecha' => $request->fecha,
                ]);

            return ['success' => 1];
        }
    }



    public function borrarCompras(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $infoFila = Compras::where('id', $request->id)->first();

        if($infoFila->documento != null){
            if(Storage::disk('archivos')->exists($infoFila->documento)){
                Storage::disk('archivos')->delete($infoFila->documento);
            }
        }

        // borrar
        Compras::where('id', $request->id)->delete();

        return ['success' => 1];
    }

}
