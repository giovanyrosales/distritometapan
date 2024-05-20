<?php

namespace App\Http\Controllers\Backend\Extras\Finanzas;

use App\Http\Controllers\Controller;
use App\Models\Finanzas;
use App\Models\Linkucp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FinanzasController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function indexFinanzas(){

        $fechaActual = Carbon::now('America/El_Salvador');

        return view('backend.admin.finanzas.vistafinanzas', compact('fechaActual'));
    }


    public function tablaFinanzsas(){

        $listado = Finanzas::orderBy('id', 'ASC')->get();

        foreach ($listado as $dato){
            $dato->fechaFormat = date("d-m-Y", strtotime($dato->fecha));
        }

        return view('backend.admin.finanzas.tablafinanzas', compact('listado'));
    }


    public function nuevoFinanzas(Request $request){

        $regla = array(
            'titulo' => 'required',
            'fecha' => 'required',
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

                $registro = new Finanzas();
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


    public function informacionFinanzas(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = Finanzas::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }


    public function editarFinanzas(Request $request){

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

            $infoDato = Finanzas::where('id', $request->id)->first();

            $imagenOld = $infoDato->documento;

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena . $tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.' . $request->imagen->getClientOriginalExtension();
            $nombreFoto = $nombre . strtolower($extension);
            $avatar = $request->file('imagen');
            $upload = Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));

            if ($upload) {

                Finanzas::where('id', $request->id)
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
            Finanzas::where('id', $request->id)
                ->update([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    'fecha' => $request->fecha,
                ]);

            return ['success' => 1];
        }
    }

    public function borrarFinanzas(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $infoFila = Finanzas::where('id', $request->id)->first();

        if($infoFila->documento != null){
            if(Storage::disk('archivos')->exists($infoFila->documento)){
                Storage::disk('archivos')->delete($infoFila->documento);
            }
        }

        // borrar
        Finanzas::where('id', $request->id)->delete();

        return ['success' => 1];
    }





    //****************************** UCP *******************************************************************



    public function indexUcp(){

        return view('backend.admin.ucp.vistaucp');
    }


    public function tablaUcp(){

        $listado = Linkucp::where('id', 1)->get();

        return view('backend.admin.ucp.tablaucp', compact('listado'));
    }

    public function informacionUcp(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = Linkucp::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }


    public function editarUcp(Request $request){

        $regla = array(
            'id' => 'required',
            'link' => 'required',
            'toggle' => 'required'
        );

        // titulo, descripcion

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        Linkucp::where('id', $request->id)
            ->update([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'linkucp' => $request->link,
                'activo' => $request->toggle
            ]);

        return ['success' => 1];
    }


}
