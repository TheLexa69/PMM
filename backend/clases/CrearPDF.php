<?php
namespace clases;

// Importa la biblioteca TCPDF
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

class CrearPDF {
    function __construct($texto) {
        // Crea una nueva instancia de la clase TCPDF
        $pdf = new \TCPDF();
        $mail =  $_SESSION['mail']; 
        echo $mail;
        chmod("facturas", 0777);
        if (!file_exists("facturas" . DIRECTORY_SEPARATOR . $mail) && !is_dir("facturas" . DIRECTORY_SEPARATOR . $mail)) {
            mkdir("facturas" . DIRECTORY_SEPARATOR . $mail, 0777, true);
        }
        
        $fechaHoraActual = date('Y-m-d H:i:s');
        $ruta = "facturas" . DIRECTORY_SEPARATOR . $mail . DIRECTORY_SEPARATOR . $fechaHoraActual . ".pdf"; 
        echo $ruta;
        // Personaliza el PDF
        $pdf->SetTitle('Factura Lua Chea');
        // ...

        // Genera el contenido del PDF
        $pdf->AddPage();
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, $texto, 0, 1);

        // Salida del PDF al navegador
        $pdf->Output("1.pdf", "F");
        echo (dirname(__FILE__));
    }
}