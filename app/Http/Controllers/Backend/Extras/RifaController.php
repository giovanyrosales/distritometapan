<?php

namespace App\Http\Controllers\Backend\Extras;

use App\Http\Controllers\Controller;
use App\Models\Distrito;
use App\Models\Rifa;
use App\Models\RifaGanadores;
use App\Models\RifaPremios;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RifaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    // VISTA PROTEGIDA
    public function vistaRifaPremios()
    {

        $serviciosMenu = Servicio::orderBy('id', 'DESC')->take(4)->get();
        $arrayDistrito = Distrito::orderBy('id', 'DESC')->get();

        $arrayPremios = RifaPremios::orderBy('nombre', 'ASC')->get();

        return view('frontend.paginas.rifa.vistarifasorteo', [
            'serviciosMenu' => $serviciosMenu,
            'arrayDistrito' => $arrayDistrito,
            'arrayPremios' => $arrayPremios
        ]);
    }

    public function generarGanadores(Request $request)
    {
        $cantidad = (int) $request->cantidad;
        $premio = (int) $request->premio;

        if ($cantidad <= 0) {
            return response()->json([
                'success' => 0,
                'message' => 'Cantidad inválida'
            ]);
        }

        // Solo participantes que aún no han ganado
        $query = Rifa::where('ganador', 0);

        /* $disponibles = $query->count();

         if ($cantidad > $disponibles) {
             return response()->json([
                 'success' => 0,
                 'message' => 'No hay suficientes participantes disponibles'
             ]);
         }*/

        DB::beginTransaction();

        try {
            // Selección aleatoria sin repetir
            $ganadores = $query
                ->inRandomOrder()
                ->limit($cantidad)
                ->lockForUpdate()
                ->get();

            foreach ($ganadores as $item) {

                $item->fechaFormat = date("d-m-Y h:i A", strtotime($item->fecha));
            }

            return response()->json([
                'success' => 1,
                'ganadores' => $ganadores
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => 0,
                'message' => 'Error al generar ganadores'
            ]);
        }
    }


    public function registrarGanadores(Request $request)
    {
        foreach ($request->ganadores as $g) {
            $rifa = Rifa::find($g['id']); // id del participante

            if ($rifa && !$rifa->ganador) {
                // 1️⃣ Actualizar la tabla rifa
                $rifa->ganador = 1;
                $rifa->fecha_ganador = Carbon::now('America/El_Salvador');
                $rifa->save();

                // 2️⃣ Verificar si ya existe en RifaGanadores
                $existe = RifaGanadores::where('id_rifapremios', $request->premio)
                    ->where('id_rifa', $rifa->id)
                    ->first();

                if (!$existe) {
                    // Insertar en tabla de ganadores
                    $nuevo = new RifaGanadores();
                    $nuevo->id_rifapremios = $request->premio;
                    $nuevo->id_rifa = $rifa->id;
                    $nuevo->save();
                }
            }
        }

        return response()->json(['success' => 1]);
    }

    public function generarReporte($idpremio)
    {
        //$mpdf = new \Mpdf\Mpdf(['format' => 'LETTER']);
        $mpdf = new \Mpdf\Mpdf([
            'tempDir' => sys_get_temp_dir(),
            'format' => 'LETTER-L'
        ]);
        $mpdf->SetTitle('Reporte');
        $mpdf->showImageErrors = false;

        $logoalcaldia = 'images/gobiernologo.jpg';
        $logosantaana = 'images/logo.png';

        // Obtener el nombre del premio
        $premio = \DB::table('rifa_premios')->where('id', $idpremio)->value('nombre');

        $tabla = "
    <table style='width: 100%; border-collapse: collapse;'>
        <tr>
            <td style='width: 15%; text-align: left;'>
                <img src='$logosantaana' alt='Santa Ana Norte' style='max-width: 100px; height: auto;'>
            </td>
            <td style='width: 60%; text-align: center;'>
                <h1 style='font-size: 16px; margin: 0; color: #003366; text-transform: uppercase;'>ALCALDÍA MUNICIPAL DE SANTA ANA NORTE</h1>
                <h2 style='font-size: 14px; margin: 0; color: #003366; text-transform: uppercase;'>Listado de Ganadores</h2>
            </td>
            <td style='width: 10%; text-align: right;'>

            </td>
        </tr>
    </table>
    <hr style='border: none; border-top: 2px solid #003366; margin: 10px 0;'>

    <!-- Título del Premio -->
    <h2 style='font-size: 14px; margin: 10px 0; color: #003366; text-transform: uppercase;'>PREMIO: $premio</h2>
    ";

        $ganadores = \DB::table('rifa_ganadores as rg')
            ->join('rifa as r', 'rg.id_rifa', '=', 'r.id')
            ->join('rifa_premios as rp', 'rg.id_rifapremios', '=', 'rp.id')
            ->select('r.nombre', 'r.dui', 'r.telefono', 'r.direccion')
            ->where('rg.id_rifapremios', $idpremio)
            ->get();

        $tabla .= "
   <table style='width: 100%; border-collapse: collapse; font-size: 12px;' border='1'>
    <thead>
        <tr style='background-color: #cccccc; color: black; text-align: center;'>
            <th style='padding: 5px; width: 3%'>#</th>
            <th style='padding: 5px;'>Nombre</th>
            <th style='padding: 5px; width: 10%'>DUI</th>
            <th style='padding: 5px; width: 10%'>Teléfono</th>
            <th style='padding: 5px;'>Dirección</th>
            <th style='padding: 5px; width: 120px;'>Firma</th>
        </tr>
    </thead>
    <tbody>
";

        $contador = 1;
        foreach ($ganadores as $g) {
            $tabla .= "
    <tr>
        <td style='padding: 5px; text-align: center; width: 3%'>$contador</td>
        <td style='padding: 5px;'>$g->nombre</td>
        <td style='padding: 5px; text-align: center; width: 10%'>$g->dui</td>
        <td style='padding: 5px; text-align: center; width: 10%'>$g->telefono</td>
        <td style='padding: 5px;'>$g->direccion</td>
        <td style='padding: 5px; height: 60px;'></td>
    </tr>
    ";
            $contador++;
        }

        $tabla .= "
    </tbody>
</table>
    ";

        $mpdf->WriteHTML($tabla,2);
        $mpdf->Output();
    }






    public function tablaRifa(){

        $conteo = 0;

        $arrayRifa = Rifa::orderBy('fecha', 'ASC')->get()->map(function ($item) use (&$conteo) {

            $conteo++;
            $item->conteo = $conteo;

            $item->fechaFormat = date('d-m-Y', strtotime($item->fecha));

            return $item;
        });

        return view('frontend.paginas.rifa.tablarifa', compact('arrayRifa'));
    }

    public function tablaRifaGanador(){

        $arrayRifaGanador = RifaGanadores::all();

        foreach ($arrayRifaGanador as $item) {

            $infoRifa = Rifa::where('id', $item->id_rifa)->first();
            $item->nombre = $infoRifa->nombre;
            $item->dui = $infoRifa->dui;
            $item->telefono = $infoRifa->telefono;
            $item->direccion = $infoRifa->direccion;

            $infoPremio = RifaPremios::where('id', $item->id_rifapremios)->first();
            $item->nombrepremio = $infoPremio->nombre;
        }

        return view('frontend.paginas.rifa.tablarifaganador', compact('arrayRifaGanador'));
    }


}
