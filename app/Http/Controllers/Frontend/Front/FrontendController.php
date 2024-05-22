<?php

namespace App\Http\Controllers\Frontend\Front;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Fotografia;
use App\Models\Noticia;
use App\Models\Programa;
use App\Models\Servicio;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    // Metodo para cargar informacion en pagina Index Publica
    public function index(){


        $slider = Slider::all()->sortBy('posicion');
        $programas = Programa::all()->sortByDesc('id')->take(4);
        $servicios = Servicio::all()->sortByDesc('id')->take(6);
        $fotografia = Fotografia::all()->sortByDesc('id')->take(8);
        $serviciosMenu = $this->getServiciosMenu();

        foreach($fotografia  as $secciones){
            $noticia = Noticia::where('id', $secciones->noticia_id)->select('nombrenoticia', 'fecha')->first();
            $secciones->nombre = $noticia->nombrenoticia;
            $secciones->fecha = $noticia->fecha;
        }

        $noticia = $this->getRecentNew(5);

        return view('frontend.principal.vistaprincipal',compact(['slider','programas','servicios','noticia','fotografia','serviciosMenu']));
    }


    public function getServiciosMenu(){
        return Servicio::all()->sortByDesc('id')->take(4);
    }

    public function getRecentNew($filtro){
        $noticiaReciente = Noticia::orderBy('fecha', 'DESC')->take($filtro);

        foreach ($noticiaReciente  as $secciones) {
            $foto = Fotografia::where('noticia_id', $secciones->idnoticia)->pluck('nombrefotografia')->first();
            $secciones->nombrefotografia = $foto;
        }
        return $noticiaReciente;
    }


    public function obtenerTodosServicios(){
        $servicios = Servicio::all();
        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.servicio.vistaservicios', compact('servicios','serviciosMenu'));
    }

    public function serviciosPorNombre($slug){
        $servicio =  Servicio::where('slug', $slug)->first();
        $serviciosMenu = $this->getServiciosMenu();
        $documentos = Documento::where('servicio_id', $servicio->idservicio)->get();
        return view('frontend.paginas.servicio.vistaservicio',compact(['servicio','serviciosMenu','documentos']));
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

        $noticias = Noticia::orderBy('fecha', 'DESC')->paginate(3);

        foreach($noticias  as $dato){
            $foto = Fotografia::where('noticia_id', $dato->id)->pluck('nombrefotografia')->first();
            $dato->nombrefotografia = $foto;
        }

        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.noticias.vistanoticias', compact(['serviciosMenu','noticias']));
    }


    public function noticiaPorNombre($slug){

        $noticia =  Noticia::where('slug', $slug)->first();
        $fotoInicial = Fotografia::where('noticia_id', $noticia->id)->pluck('nombrefotografia')->first();

        // Forget se utiliza para eliminar el primer elemento de una coleccion
        $fotografias = Fotografia::where('noticia_id', $noticia->id)->get()->forget(0);
        $noticia->nombrefotografia = $fotoInicial;
        $noticiaReciente = $this->getRecentNew(3);
        $serviciosMenu = $this->getServiciosMenu();

        return view('frontend.paginas.noticias.vistanoticiaslug',compact(['noticia','serviciosMenu','noticiaReciente','fotografias']));
    }


    public function descargarArchivo($nameFile){

        $file="storage/archivos/".$nameFile;
        $headers = array('Content-Type: application/pdf',);
        return response()->download($file, $nameFile, $headers);
    }


    public function todosLosProgramas(){
        $programas = Programa::all();
        $serviciosMenu = $this->getServiciosMenu();

        return view('frontend.paginas.programas.vistaprogramas',compact('programas','serviciosMenu'));
    }


    public function programaPorNombre($slug){

        $programa = Programa::where('slug', $slug)->first();
        $serviciosMenu = $this->getServiciosMenu();

        return view('frontend.paginas.programas.vistaprogramaslug',compact(['programa','serviciosMenu']));
    }


    public function paginaHistoria(){

        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.historia.vistahistoria',compact('serviciosMenu'));
    }


    public function paginaGobierno(){

        $serviciosMenu = $this->getServiciosMenu();
        return view('frontend.paginas.gobierno.vistagobierno',compact('serviciosMenu'));
    }





}
