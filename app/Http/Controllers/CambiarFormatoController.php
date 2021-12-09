<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class CambiarFormatoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    protected function index()
    {
        return view('formato');
    }

    protected function create()
    {
        $readerIngresa = IOFactory::createReaderForFile($_FILES['documento1']['tmp_name']);
        $readerCiisa = IOFactory::createReaderForFile($_FILES['documento2']['tmp_name']);
        $readerIngresa->setReadDataOnly(true);
        $readerCiisa->setReadDataOnly(true);

        $spreadsheetIngresa = $readerIngresa->load($_FILES['documento1']['tmp_name']);
        $spreadsheetCiisa = $readerCiisa->load($_FILES['documento2']['tmp_name']);

        $hojaIngresa = $spreadsheetIngresa->getSheet(0);
        $hojaCiisa = $spreadsheetCiisa->getSheet(0);

        $cabecerasIngresa = $this->cabeceras($hojaIngresa);
        $cabecerasCiisa = $this->cabeceras($hojaCiisa);

        $this->crearTabla($cabecerasIngresa, 'ingresa');
        $this->crearTabla($cabecerasCiisa, 'ciisa');

        $cabecerasIngresa = json_encode($cabecerasIngresa);
        $cabecerasCiisa = json_encode($cabecerasCiisa);

        DB::table('config')->insert([
            'cabecerasIngresa' => $cabecerasIngresa,
            'cabecerasCiisa' => $cabecerasCiisa,
            'coincidencias' => NULL
        ]);
    }

    protected function ingresarCoincidencias()
    {
        $cabeceras = DB::table('config')->select('id', 'cabecerasIngresa', 'cabecerasCiisa')->get()->last();

        $id = json_decode($cabeceras->id);
        $cabecerasIngresa = json_decode($cabeceras->cabecerasIngresa);
        $cabecerasCiisa = json_decode($cabeceras->cabecerasCiisa);

        return view('coincidencias', compact('id', 'cabecerasIngresa', 'cabecerasCiisa'));
    }

    protected function coincidencias(Request $request)
    {

        $coincidencias = [];
        foreach ($request->all() as $key => $valor) {
            if ($key != 'id' && $key != '_token' && $valor != 'ninguna') {
                $coincidencias[] = [$key => $valor];
            }
        }

        $coincidencias = json_encode($coincidencias);

        DB::statement("UPDATE config SET coincidencias = '" . $coincidencias . "' WHERE config.id = '" . $request->id . "'");
    }

    protected function cabeceras($hoja)
    {
        $columnas = [];
        $cont = 0;
        foreach ($hoja->getRowIterator() as $row) {
            if ($cont < 1) {
                foreach ($row->getCellIterator() as $cell) {
                    if ($cell->getValue()) {
                        $columnas[] = $cell->getValue();
                    }
                }
                $cont++;
            }
        }
        return $columnas;
    }

    protected function crearTabla($cabeceras, $nombreTabla)
    {

        DB::statement('DROP TABLE IF EXISTS ' . $nombreTabla);

        DB::statement('CREATE TABLE ' . $nombreTabla . ' (`id` bigint(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`))');

        foreach ($cabeceras as $cabecera) {

            if ($cabecera) {
                DB::statement("ALTER TABLE " . $nombreTabla . " ADD `" . $cabecera . "` varchar(225)  NULL");
            }
        }
    }
}
