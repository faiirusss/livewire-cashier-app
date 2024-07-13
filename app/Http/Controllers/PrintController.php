<?php

namespace App\Http\Controllers;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PrintController extends Controller
{
    public function print()
    {
        $text = "Contoh teks yang akan dicetak\n";

        try {
            $connector = new WindowsPrintConnector("RP58-Printer");
            $printer = new Printer($connector);
            $printer->text($text);
            $printer->cut();
            $printer->close();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        return response()->json(['status' => 'success']);
    }
}
