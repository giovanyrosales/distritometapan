<?php

namespace App\Http\Controllers\Backend\Extras\Slider;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SliderController extends Controller
{


    public function __construct(){
        $this->middleware('auth');
    }

    public function indexSlider(){
        return view('backend.admin.slider.vistaslider');
    }


    public function tablaSlider(){
        $listado = Slider::orderBy('posicion', 'ASC')->get();

        return view('backend.admin.slider.tablaslider',compact('listado'));
    }


    public function nuevoSlider(Request $request){

        // descripcion, link, imagen

        if ($request->hasFile('imagen')) {

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena . $tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.' . $request->imagen->getClientOriginalExtension();
            $nombreFoto = $nombre . strtolower($extension);
            $avatar = $request->file('imagen');
            $upload = Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));

            if ($upload) {

                if ($info = Slider::orderBy('posicion', 'DESC')->first()) {
                    $nuevaPosicion = $info->posicion + 1;
                } else {
                    $nuevaPosicion = 1;
                }

                $registro = new Slider();
                $registro->nombreslider = $request->descripcion;
                $registro->estado = 1;
                $registro->posicion = $nuevaPosicion;
                $registro->fotografia = $nombreFoto;
                $registro->link = $request->link;
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

    public function informacionSlider(Request $request){
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = Slider::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }


    public function actualizarPosicionSlider(Request $request){

        $tasks = Slider::all();

        foreach ($tasks as $task) {
            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->update(['posicion' => $order['posicion']]);
                }
            }
        }
        return ['success' => 1];
    }


    public function editarSlider(Request $request){

        // id, descripcion, link, imagen, toggle

        $rules = array(
            'id' => 'required',
            'toggle' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return ['success' => 0];
        }

        if ($request->hasFile('imagen')) {

            $infoDato = Slider::where('id', $request->id)->first();

            $imagenOld = $infoDato->fotografia;

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena . $tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.' . $request->imagen->getClientOriginalExtension();
            $nombreFoto = $nombre . strtolower($extension);
            $avatar = $request->file('imagen');
            $upload = Storage::disk('archivos')->put($nombreFoto, \File::get($avatar));

            if ($upload) {

                Slider::where('id', $request->id)
                    ->update([
                        'nombreslider' => $request->descripcion,
                        'estado' => $request->toggle,
                        'fotografia' => $nombreFoto,
                        'link' => $request->link
                    ]);

                if(Storage::disk('archivos')->exists($imagenOld)){
                    Storage::disk('archivos')->delete($imagenOld);
                }

                return ['success' => 1];
            } else {
                // error al subir imagen
                return ['success' => 99];
            }
        } else {
            Slider::where('id', $request->id)
                ->update([
                    'nombreslider' => $request->descripcion,
                    'estado' => $request->toggle,
                    'link' => $request->link
                ]);

            return ['success' => 1];
        }
    }




    // eliminar un slider
    public function borrarSlider(Request $request){

        $rules = array(
            'id' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return ['success' => 0];
        }

        if($infoSlider = Slider::where('id', $request->id)->first()){

            if($infoSlider->fotografia != null){
                if(Storage::disk('archivos')->exists($infoSlider->fotografia)){
                    Storage::disk('archivos')->delete($infoSlider->fotografia);
                }
            }

            Slider::where('id', $request->id)->delete();

            return ['success' => 1];
        }else{
            return ['success' => 99];
        }
    }


}
