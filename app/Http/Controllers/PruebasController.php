<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PruebasController extends Controller
{
    public function Impresora() {
        // Lógica para generar el contenido a imprimir

        // return view('pruebas.impresoras.index');
        // Por ejemplo, un simple texto de prueba
        $contenido = "¡Hola, esto es un ejemplo de impresión desde Laravel!";

        // Imprimir
        $this->imprimirEnImpresoraTermica($contenido);

        // Puedes redirigir o devolver una respuesta según tus necesidades
        // return redirect()->back()->with('success', 'Impresión enviada a la impresora térmica.');
    }

    private function imprimirEnImpresoraTermica($contenido)
    {
        // Aquí debes agregar la lógica para enviar el contenido a la impresora térmica
        // Esto puede variar según el modelo de la impresora y la conexión (USB, red, etc.)
        // Puedes usar bibliotecas como Mike42/escpos-php

        // Ejemplo usando Mike42/escpos-php
        
        $nombreImpresora = "GIANT100";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(2, 2);
        $impresora->text("Imprimiendo\n");
        $impresora->text("ticket\n");
        $impresora->text("desde\n");
        $impresora->text("Laravel\n");
        $impresora->setTextSize(1, 1);
        $impresora->text("https://parzibyte.me");
        $impresora->feed(5);
        $impresora -> cut();
        $impresora -> pulse();
        $impresora->close();
    }
    
    // public function Impresora() {
    //     $nombreImpresora = "SAM4S GIANT-100";
    //     $connector = new WindowsPrintConnector($nombreImpresora);
    //     $impresora = new Printer($connector);
    //     $impresora->setJustification(Printer::JUSTIFY_CENTER);
    //     $impresora->setTextSize(2, 2);
    //     $impresora->text("Imprimiendo\n");
    //     $impresora->text("ticket\n");
    //     $impresora->text("desde\n");
    //     $impresora->text("Laravel\n");
    //     $impresora->setTextSize(1, 1);
    //     $impresora->text("https://parzibyte.me");
    //     $impresora->feed(5);
    //     $impresora->close();
    // }
}
