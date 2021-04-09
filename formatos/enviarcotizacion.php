
<?php

//print_r($_REQUEST);
//exit;
//echo base64_encode('2');
//exit;
$correo="";
$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

$correo = (isset($_GET['correo'])) ? $_GET['correo'] : '';



$file_name = 'Presupuesto.pdf';

require_once ('../vendor/autoload.php');
    
    $css=file_get_contents('../css/estilocotizacion.css');

    require_once ('fcot.php');
    $plantilla= getPlantilla($folio);
   
    $mpdf = new \Mpdf\Mpdf([]);

    
    
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("Presupuesto ".$folio.".pdf","I");



// (Optional) Setup the paper size and orientation

// Render the HTML as PDF

// Output the generated PDF to Browser



$file = $mpdf->Output("Presupuesto ".$folio.".pdf","S");
file_put_contents($file_name, $file);


require '../plugins/phpmailer/class.phpmailer.php';
require '../plugins/phpmailer/class.smtp.php';
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = '587';
$mail->SMTPAuth = true;
$mail->Username = 'israel_romero@tecniem.com';
$mail->Password = '66obispo.colima';
$mail->SMTPSecure = 'tls';
$mail->From = 'israel_romero@tecniem.com';
$mail->FromName = 'Israel Romero';
$mail->clearAddresses();
$mail->ClearAllRecipients();
$mail->addAddress($correo);
$mail->addCC($correo);
$mail->WordWrap = 50;
$mail->isHTML(true);

$mail->addAttachment($file_name);

$mail->AddEmbeddedImage('../img/LOGOF.png','imagen','LOGOF.png');

$mail->Subject = 'Presupuesto';
$mail->Body = file_get_contents('formatocorreo.html');

if ($mail->send()) {
    $mensaje = 1;
} else {
    $mensaje = 0;
}

if ($mensaje == 1) {
    echo '<script type="text/javascript">
    alert("Enviado");
           </script>';
} else {
    echo '<script type="text/javascript">
    alert("No enviado!");
           </script>';
}
$mail->clearAddresses();
$mail->clearAttachments();
$mail->SmtpClose();
unset($mail);
unlink($file_name);

exit;

?>

<script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>