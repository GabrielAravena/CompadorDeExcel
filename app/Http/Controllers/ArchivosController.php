<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ArchivosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->truncar('ciisa');
        $this->truncar('ingresa');

        $readerIngresa = IOFactory::createReaderForFile($_FILES['documento1']['tmp_name']);
        $readerCiisa = IOFactory::createReaderForFile($_FILES['documento2']['tmp_name']);
        $readerIngresa->setReadDataOnly(true);
        $readerCiisa->setReadDataOnly(true);

        $spreadsheetIngresa = $readerIngresa->load($_FILES['documento1']['tmp_name']);
        $spreadsheetCiisa = $readerCiisa->load($_FILES['documento2']['tmp_name']);

        $hojaIngresa = $spreadsheetIngresa->getSheet(0);
        $hojaCiisa = $spreadsheetCiisa->getSheet(0);

        $this->insertar($hojaIngresa, 'ingresa');
        $this->insertar($hojaCiisa, 'ciisa');
    }

    protected function insertar($hoja, $nombreTabla)
    {
        try {
            $cont = 0;
            foreach ($hoja->getRowIterator() as $row) {

                $fila = [];
                $id = 0;
                foreach ($row->getCellIterator() as $cell) {

                    $fila[] = $cell->getValue();
                }
                $filas[] = $fila;
                if ($cont > 0) {
                    $cont1 = 0;
                    foreach ($fila as $item) {
                        if ($filas[0][$cont1] != null) {
                            if ($cont1 == 0) {
                                $id = DB::table($nombreTabla)->insertGetId(
                                    [$filas[0][$cont1] => $fila[$cont1]]
                                );
                            } else {
                                DB::statement("UPDATE " . $nombreTabla . " SET " . $filas[0][$cont1] . " = '" . $fila[$cont1] . "' WHERE " . $nombreTabla . ".id = '" . $id . "'");
                            }
                        }
                        $cont1++;
                    }
                }
                $cont++;
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    protected function comparar()
    {

        $ciisa = DB::table('ciisa')->get();
        $ingresa = DB::table('ingresa')->get();
        $coincidencias = DB::table('config')->select('cabecerasCiisa', 'coincidencias')->get()->last();

        $spreadsheetResultado = new Spreadsheet();
        $hoja = $spreadsheetResultado->getActiveSheet();

        $cabecerasCiisa = json_decode($coincidencias->cabecerasCiisa);
        $coincidencias = json_decode($coincidencias->coincidencias);

        $columna = 1;
        foreach ($cabecerasCiisa as $cell) {

            $hoja->setCellValueByColumnAndRow($columna, 1, $cell);
            $columna++;
        }

        $fila = 2;
        foreach ($ciisa as $ciisaItem) {
            foreach ($ingresa as $ingresaItem) {

                if ($ciisaItem->RUT == $ingresaItem->RUT) {

                    $columna = 0;
                    foreach ($ciisaItem as $cell) {
                        foreach ($coincidencias as $item) {
                            foreach ($item as $ciisaCoin => $ingresaCoin) {
                                if ($columna > 0 && $cabecerasCiisa[$columna-1] == $ciisaCoin && $ciisaItem->$ciisaCoin != $ingresaItem->$ingresaCoin) {
                                

                                    $hoja->getStyleByColumnAndRow($columna, $fila)
                                        ->getFill()
                                        ->setFillType(Fill::FILL_SOLID)
                                        ->getStartColor()->setARGB('FFFF0000');
                                }
                            }
                        }
                        
                        $hoja->setCellValueByColumnAndRow($columna, $fila, $cell);
                        $columna++;
                    }
                } else {
                    $fila--;
                }
                $fila++;
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="resultado.xlsx"');
        header('Cache-Control: max-age=0');


        $writer = IOFactory::createWriter($spreadsheetResultado, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    protected function truncar($nombreTabla)
    {
        DB::statement("TRUNCATE TABLE " . $nombreTabla);
    }
}
