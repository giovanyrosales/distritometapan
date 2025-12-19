<?php

namespace App\Http\Controllers\Frontend\Front;

use App\Http\Controllers\Controller;
use App\Models\Compras;
use App\Models\Distrito;
use App\Models\DistritoServicios;
use App\Models\Documento;
use App\Models\Finanzas;
use App\Models\Fotografia;
use App\Models\Noticia;
use App\Models\Programa;
use App\Models\Rifa;
use App\Models\Servicio;
use App\Models\Slider;
use App\Models\Sugerencias;
use App\Models\Votacion;
use App\Models\VotacionRegistro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{

    // Metodo para cargar informacion en pagina Index Publica
    public function index(){

        $slider = Slider::orderBy('posicion', 'ASC')->get();

        $programas = Programa::orderBy('id','ASC')->take(4)->get();

        $servicios = Servicio::where('estado', 1)
                                ->orderBy('id', 'DESC')
                                ->take(6)
                                ->get();

        $fotografia = Fotografia::orderBy('id', 'DESC')->take(8)->get();

        $serviciosMenu = $this->getServiciosMenu();

        foreach($fotografia  as $secciones){
            $noticia = Noticia::where('id', $secciones->noticia_id)->first();
            $secciones->nombre = $noticia->nombrenoticia;
            $secciones->fecha = $noticia->fecha;
        }

        $noticia = $this->getRecentNew(5);

        return view('frontend.principal.vistaprincipal',compact(['slider','programas','servicios','noticia','fotografia','serviciosMenu']));
    }


    public function getServiciosMenu(){
        return Servicio::where('estado', 1)
                ->orderBy('posicion', 'ASC')
                ->take(4)
                ->get();
    }

    public function getRecentNew($filtro){
        $noticiaReciente = Noticia::orderBy('fecha', 'DESC')->take($filtro)->get();

        foreach ($noticiaReciente  as $secciones) {
            $foto = Fotografia::where('noticia_id', $secciones->id)->first();
            $secciones->nombrefotografia = $foto->nombrefotografia;
        }
        return $noticiaReciente;
    }


    public function obtenerTodosServicios(){
        $servicios = Servicio::where('estado', 1)
                ->whereNotIn('id', [8])
                ->orderBy('posicion', 'ASC')
                ->get();

        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.servicio.vistaservicios', compact('servicios','serviciosMenu'));
    }

    public function serviciosPorNombre($slug){

        if($servicio =  Servicio::where('slug', $slug)
                               ->where('estado', 1)
                               ->first()){

            $serviciosMenu = $this->getServiciosMenu();
            $documentos = Documento::where('servicio_id', $servicio->idservicio)->get();

            return view('frontend.paginas.servicio.vistaservicio',compact(['servicio','serviciosMenu','documentos']));
        }
        else{
            return view('errors.404');
        }
    }


    public function paginaContravencional(){
        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.contravencional.vistacontravencional',compact('serviciosMenu'));
    }


    public function descargaContravencional($nameFile){
        $file="storage/archivos/".$nameFile;
        $headers = array('Content-Type: application/pdf',);
        return response()->download($file, $nameFile, $headers);
    }

    public function todasFotografias(Request $request){

        $fotografias = Fotografia::orderBy('noticia_id', 'DESC')->paginate(6);
        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.galeria.vistagaleria', compact(['fotografias','serviciosMenu']));
    }


    public function todasNoticias(){

        $paginator = Noticia::orderBy('fecha', 'DESC')
            ->where('estado', 1)
            ->paginate(20);

        foreach($paginator  as $dato){
            $foto = Fotografia::where('noticia_id', $dato->id)->first();
            $dato->nombrefotografia = $foto->nombrefotografia;
        }

        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.noticias.vistanoticias', compact(['serviciosMenu','paginator']));
    }


    public function noticiaPorNombre($slug){

        if($noticia =  Noticia::where('slug', $slug)->where('estado', 1)->first()){


            // Forget se utiliza para eliminar el primer elemento de una coleccion
            $fotografias = Fotografia::where('noticia_id', $noticia->id)->get();

            $primeraFoto = Fotografia::where('noticia_id', $noticia->id)
                ->orderBy('id', 'ASC')
                ->first();

            $noticiaReciente = $this->getRecentNew(3);
            $serviciosMenu = $this->getServiciosMenu();


            return view('frontend.paginas.noticias.vistanoticiaslug',compact(['noticia','serviciosMenu','noticiaReciente','fotografias', 'primeraFoto']));
        }else{
            return view('errors.404');
        }
    }


    public function descargarArchivo($nameFile){

        $file="storage/archivos/".$nameFile;
        $headers = array('Content-Type: application/pdf',);
        return response()->download($file, $nameFile, $headers);
    }


    public function todosLosProgramas(){
        $programas = Programa::where('estado', 1)->orderBy('nombreprograma', 'ASC')->get();
        $serviciosMenu = $this->getServiciosMenu();

        return view('frontend.paginas.programas.vistaprogramas',compact('programas','serviciosMenu'));
    }


    public function programaPorNombre($slug){

        if($programa = Programa::where('slug', $slug)->where('estado', 1)->first()){
            $serviciosMenu = $this->getServiciosMenu();

            return view('frontend.paginas.programas.vistaprogramaslug',compact(['programa','serviciosMenu']));
        }else{
            return view('errors.404');
        }
    }


    public function paginaHistoria(){

        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.historia.vistahistoria',compact('serviciosMenu'));
    }


    public function paginaGobierno(){
        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.gobierno.vistagobierno',compact('serviciosMenu'));
    }


    public function indexFinanzas(){

        $serviciosMenu = Servicio::orderBy('id', 'DESC')->take(4)->get();

        $finanzas = Finanzas::orderBy('fecha', 'DESC')->get();

        foreach($finanzas as $dato){
            $dato->fechaformato = date("d-m-Y", strtotime($dato->fecha));

            $dato->fechaanio = date("Y", strtotime($dato->fecha));
        }

        return view('frontend.paginas.finanzas.vistafinanzas', compact('serviciosMenu', 'finanzas'));
    }


    public function descargarDocumentoFinanzas($id){

        $infoFinanza = Finanzas::where('id', $id)->first();

        $nombre = str_replace(' ', '_', $infoFinanza->titulo);

        $pathToFile = "storage/archivos/" . $infoFinanza->documento;
        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);
        $nombre = $nombre . "." . $extension;
        return response()->download($pathToFile, $nombre);
    }


    public function indexCompras(){

        $serviciosMenu = Servicio::orderBy('id', 'DESC')->take(4)->get();

        $arrayCompras = Compras::orderBy('fecha', 'DESC')->take(20)->get();

        foreach ($arrayCompras as $dato){

            $dato->fechaFormat = date("d-m-Y", strtotime($dato->fecha));
            $dato->fechaAnio = date("Y", strtotime($dato->fecha));
        }

        return view('frontend.paginas.compras.vistacompras', compact('arrayCompras', 'serviciosMenu'));
    }

    public function descargarPoliticaAntiSoborno(){
        $pathToFile = "storage/documentos/pdf_antisoborno";
        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);
        $nombre = "Documento" . "." . $extension;
        return response()->download($pathToFile, $nombre);
    }

    public function politicaAntiSoborno(){
        $serviciosMenu = $this->getServiciosMenu();

        return view('frontend.paginas.antisoborno.vistaantisoborno', compact(['serviciosMenu']));
    }



    public function vistaVotacion(Request $request)
    {
        $serviciosMenu = Servicio::orderBy('id', 'DESC')->take(4)->get();

        // IP del usuario
        $ip = $request->ip();

        // Verificar si ya votó esta IP
        /*$yaVoto = VotacionRegistro::where('ip', $ip)->exists();

        // Si ya votó, solo enviamos una bandera a la vista
        if ($yaVoto) {
            return view('frontend.paginas.votacion.vistavotacion', [
                'yaVoto' => true,
                'serviciosMenu' => $serviciosMenu
            ]);
        }*/

        // Si NO ha votado, mostrar las opciones
        $opciones = Votacion::where('activo', 1)
            ->inRandomOrder()
            ->get();

        return view('frontend.paginas.votacion.vistavotacion', [
            'yaVoto' => false,
            'opciones' => $opciones,
            'serviciosMenu' => $serviciosMenu
        ]);
    }



    public function registrarVotacion(Request $request)
    {
        // Validar que venga una opción válida
        $request->validate([
            'id_votacion' => 'required|exists:votacion,id',
        ]);

        $ip = $request->ip();

        // Verificar si esta IP ya votó
        /*$yaVoto = DB::table('votacion_registro')
            ->where('ip', $ip)
            ->exists();

        if ($yaVoto) {
            return response()->json([
                'success' => 0,
                'msg' => 'Ya has realizado tu voto anteriormente.',
            ]);
        }*/

        // Registrar voto
        DB::table('votacion_registro')->insert([
            'id_votacion' => $request->id_votacion,
            'ip'          => $ip,
            'user_agent'  => $request->userAgent(),
            'fecha'       => now('America/El_Salvador'),
        ]);

        return response()->json([
            'success' => 1,
            'redirect' => route('index'),
            'msg' => '¡Gracias! Su voto ha sido registrado correctamente.',
        ]);
    }


    public function vistaSugerencias()
    {
        $serviciosMenu = Servicio::orderBy('id', 'DESC')->take(4)->get();

        $arrayDistrito = Distrito::orderBy('id', 'DESC')->get();

        return view('frontend.paginas.sugerencias.vistasugerencias', [
            'serviciosMenu' => $serviciosMenu,
            'arrayDistrito' => $arrayDistrito
        ]);
    }


    public function registrarSugerencia(Request $request)
    {
        $regla = array(
            'nombre' => 'required',
            'telefono' => 'required',
        );

        // correo, comentarios

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            $registro = new Sugerencias();
            $registro->id_distritoservicios = $request->id_distritoservicios;
            $registro->fecha = Carbon::now('America/El_Salvador');
            $registro->nombre = $request->nombre;
            $registro->telefono = $request->telefono;
            $registro->correo = $request->correo;
            $registro->comentarios = $request->comentarios;
            $registro->revisado = 0;
            $registro->save();

            DB::commit();
            return ['success' => 1];
        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }


    public function informacionDistritoServicios(Request $request)
    {
        $regla = [
            'id_distrito' => 'required|integer',
        ];

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()) {
            return ['success' => 0];
        }

        $lista = DistritoServicios::where('id_distrito', $request->id_distrito)
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        return [
            'success' => 1,
            'lista'   => $lista,
        ];
    }


    public function vistaRifa(Request $request)
    {
        $serviciosMenu = Servicio::orderBy('id', 'DESC')->take(4)->get();
        $arrayDistrito = Distrito::orderBy('id', 'DESC')->get();

        return view('frontend.paginas.rifa.vistarifa', [
            'serviciosMenu' => $serviciosMenu,
            'arrayDistrito' => $arrayDistrito
        ]);
    }



    public function registrarRifa(Request $request)
    {
        $regla = array(
            'nombre' => 'required',
            'dui' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        DB::beginTransaction();
        try {

            if(Rifa::where('dui', $request->dui)->first()){
                return ['success' => 1];
            }

            $registro = new Rifa();
            $registro->nombre = $request->nombre;
            $registro->dui = $request->dui;
            $registro->telefono = $request->telefono;
            $registro->direccion = $request->direccion;
            $registro->fecha = Carbon::now('America/El_Salvador');
            $registro->ganador = 0;
            $registro->save();

            DB::commit();
            return ['success' => 2
            ];
        }catch(\Throwable $e){
            Log::info('error: ' . $e);
            DB::rollback();
            return ['success' => 99];
        }
    }









}
