<?php
    $folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

    require_once '../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;

    ob_start();
	include(dirname('__FILE__').'/pcotizacion.php');
    $html = ob_get_clean();
    
    $html2pdf =new HTML2PDF('P','A4','es','true','UTF-8');
    $html2pdf->writehtml($html);
    $html2pdf->output('Presupuesto'.$folio.'.pdf');
		
?>