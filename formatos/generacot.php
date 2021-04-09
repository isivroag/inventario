<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';


	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;
	

	
			
			
			ob_start();
		    include(dirname('__FILE__').'/pcot.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			

			$dompdf->loadHtml($html,'UTF-8');
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('Presupuesto'.$folio.'.pdf',array('Attachment'=>0));
			exit;


?>