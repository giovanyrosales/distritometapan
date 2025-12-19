<?php

namespace App\Http\Controllers\Backend\Extras\Servicio;

use App\Http\Controllers\Controller;
use App\Models\Distrito;
use App\Models\DistritoServicios;
use App\Models\Rifa;
use App\Models\RifaPremios;
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



    public function indexDistrito()
    {
        return view('backend.admin.distrito.vistadistrito');
    }


    public function tablaDistrito()
    {
        $arrayDistrito = Distrito::orderBy('id', 'ASC')->get();

        return view('backend.admin.distrito.tabladistrito', compact('arrayDistrito'));
    }


    public function indexDistritoServicios($id)
    {
        $infoDistrito = Distrito::where('id', $id)->first();


        return view('backend.admin.distrito.servicios.vistadistritoservicios', compact('id', 'infoDistrito'));
    }


    public function tablaDistritoServicios($id)
    {
        $arrayServicios = DistritoServicios::where('id_distrito', $id)->orderBy('nombre', 'ASC')->get();

        return view('backend.admin.distrito.servicios.tabladistritoservicios', compact('arrayServicios'));
    }


    public function registrarDistritoServicios(Request $request)
    {
        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $registro = new DistritoServicios();
        $registro->id_distrito = $request->id;
        $registro->nombre = $request->nombre;
        $registro->save();

        return ['success' => 1];
    }


    public function informacionDistritoServicios(Request $request)
    {
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = DistritoServicios::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }

    public function editarDistritoServicios(Request $request)
    {
        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            DistritoServicios::where('id', $request->id)
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



    public function indexBuzonNuevo()
    {
        $user = auth()->user();
        $infoDistrito = Distrito::where('id', $user->id_distrito)->first();

        return view('backend.admin.distrito.buzonusuario.nuevo.vistanuevobuzon', compact('infoDistrito'));
    }


    public function tablaBuzonNuevo()
    {
        $user = auth()->user();

        $arrayDistritoServicios = DistritoServicios::where('id_distrito', $user->id_distrito)
            ->select('id')
            ->get();

        $arraySugerencias = Sugerencias::where('revisado', 0)
            ->whereIn('id_distritoservicios', $arrayDistritoServicios)
            ->orderBy('fecha', 'ASC')
            ->get()
            ->map(function($item){

                $item->fechaFormat = date("d-m-Y h:i A", strtotime($item->fecha));

                $infoServicio = DistritoServicios::where('id', $item->id_distritoservicios)->first();
                $item->nombreServicio = $infoServicio->nombre;

                return $item;
            });

        return view('backend.admin.distrito.buzonusuario.nuevo.tablanuevobuzon', compact('arraySugerencias'));
    }


    public function registrarRevisado(Request $request)
    {
        $regla = [
            'id' => 'required|integer',
        ];

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()) {
            return ['success' => 0]; // datos inválidos
        }

        $user = auth()->user();

        DB::beginTransaction();
        try {

            // 1) Obtener los id de distrito_servicios que pertenecen al distrito del usuario
            $idsDistritoServicios = DistritoServicios::where('id_distrito', $user->id_distrito)
                ->pluck('id'); // importante: pluck para quedarnos solo con los IDs

            // 2) Actualizar solo si la sugerencia pertenece a alguno de esos servicios
            Sugerencias::where('id', $request->id)
                ->whereIn('id_distritoservicios', $idsDistritoServicios)
                ->update([
                    'revisado' => 1,
                ]);

            DB::commit();
            return ['success' => 1];

        } catch (\Throwable $e) {
            Log::info('error: ' . $e);
            DB::rollBack();
            return ['success' => 99];
        }
    }

    public function indexBuzonTodos()
    {
        $user = auth()->user();
        $infoDistrito = Distrito::where('id', $user->id_distrito)->first();

        // FILTRO POR SERVICIOS DEL MISMO DISTRITO
        $arrayServicios = DistritoServicios::where('id_distrito', $infoDistrito->id)->orderBy('nombre', 'ASC')->get();

        return view('backend.admin.distrito.buzonusuario.todos.vistabuzontodos', compact('infoDistrito', 'arrayServicios'));
    }


    public function tablaBuzonTodos()
    {
        $user = auth()->user();

        $arrayDistritoServicios = DistritoServicios::where('id_distrito', $user->id_distrito)
            ->select('id')
            ->get();

        $arraySugerencias = Sugerencias::where('revisado', 0)
            ->whereIn('id_distritoservicios', $arrayDistritoServicios)
            ->orderBy('fecha', 'ASC')
            ->get()
            ->map(function($item){

                $item->fechaFormat = date("d-m-Y h:i A", strtotime($item->fecha));

                $infoServicio = DistritoServicios::where('id', $item->id_distritoservicios)->first();
                $item->nombreServicio = $infoServicio->nombre;

                return $item;
            });


        return view('backend.admin.distrito.buzonusuario.todos.tablabuzontodos', compact('arraySugerencias'));
    }


    public function tablaBuzonTodosBuscar($id) // id servicio y cada servicio tiene su distrito
    {
        $user = auth()->user();

        if($id === '0'){
            $arrayDistritoServicios = DistritoServicios::where('id_distrito', $user->id_distrito)
                ->select('id')
                ->get();
        }else{
            $arrayDistritoServicios = DistritoServicios::where('id_distrito', $user->id_distrito)
                ->where('id', $id)
                ->select('id')
                ->get();
        }

        $arraySugerencias = Sugerencias::where('revisado', 1)
            ->whereIn('id_distritoservicios', $arrayDistritoServicios)
            ->orderBy('fecha', 'ASC')
            ->get()
            ->map(function($item){

                $item->fechaFormat = date("d-m-Y h:i A", strtotime($item->fecha));

                $infoServicio = DistritoServicios::where('id', $item->id_distritoservicios)->first();
                $item->nombreServicio = $infoServicio->nombre;

                return $item;
            });

        return view('backend.admin.distrito.buzonusuario.todos.tablabuzontodos', compact('arraySugerencias'));
    }



    public function indexRifaPremios(Request $request)
    {
        return view('backend.admin.rifa.vistarifapremios');
    }

    public function tablaRifaPremios(Request $request)
    {

        $arrayPremios = RifaPremios::orderBy('nombre', 'ASC')->get();

        return view('backend.admin.rifa.tablarifapremios', compact('arrayPremios'));
    }


    public function registrarRifaPremios(Request $request)
    {
        $regla = array(
            'nombre' => 'required',
        );


        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            $registro = new RifaPremios();
            $registro->nombre = $request->nombre;
            $registro->save();

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }


    public function informacionRifaPremios(Request $request)
    {
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($info = RifaPremios::where('id', $request->id)->first()){

            return ['success' => 1, 'info' => $info];
        }else{
            return ['success' => 2];
        }
    }

    public function editarRifaPremios(Request $request){

        $regla = array(
            'id' => 'required',
            'nombre' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            RifaPremios::where('id', $request->id)
                ->update([
                    'nombre' => $request->nombre
                ]);

            DB::commit();
            return ['success' => 1];

        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }



}
