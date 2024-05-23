<?php

namespace App\Http\Controllers\Frontend\Front;

use App\Http\Controllers\Controller;
use App\Models\Compras;
use App\Models\Documento;
use App\Models\Finanzas;
use App\Models\Fotografia;
use App\Models\Noticia;
use App\Models\Programa;
use App\Models\Servicio;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                ->orderBy('id', 'ASC')
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
                ->orderBy('nombreservicio', 'ASC')
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

            $fotoInicial = Fotografia::where('noticia_id', $noticia->id)->first();

            // Forget se utiliza para eliminar el primer elemento de una coleccion
            $fotografias = Fotografia::where('noticia_id', $noticia->id)->get()->forget(0);
            $noticia->nombrefotografia = $fotoInicial;
            $noticiaReciente = $this->getRecentNew(3);
            $serviciosMenu = $this->getServiciosMenu();

            return view('frontend.paginas.noticias.vistanoticiaslug',compact(['noticia','serviciosMenu','noticiaReciente','fotografias']));
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

        $arrayCompras = Compras::orderBy('fecha', 'ASC')->get();

        foreach ($arrayCompras as $dato){

            $dato->fechaFormat = date("d-m-Y", strtotime($dato->fecha));
            $dato->fechaAnio = date("Y", strtotime($dato->fecha));
        }

        return view('frontend.paginas.compras.vistacompras', compact('arrayCompras', 'serviciosMenu'));
    }

}
