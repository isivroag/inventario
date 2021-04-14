<?php
    $folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
 
    

    require_once ('../vendor/autoload.php');
    
    $css=file_get_contents('../css/estiloreq.css');

    require_once ('formatoreq.php');
    $plantilla= getPlantilla($folio,$pago);
   
    $mpdf = new \Mpdf\Mpdf(['format' => [139, 215],'orientation' => 'L','margin_top' =>10,'margin_bottom' =>10,	'margin_left' => 10,	'margin_right' => 10,	'mirrorMargins' =>true ],);

    
    
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("Estado de Cuenta Venta: ".$folio.".pdf","I");

   
