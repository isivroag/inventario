
<?php

//print_r($_REQUEST);
//exit;
//echo base64_encode('2');
//exit;
$correo="";
$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

$correo = (isset($_GET['correo'])) ? $_GET['correo'] : '';
//$name = (isset($_GET['name'])) ? $_GET['name'] : '';
echo $correo;

require_once '../pdf/vendor/autoload.php';

use Dompdf\Dompdf;


ob_start();
include(dirname('__FILE__') . '/pcot.php');
$html = ob_get_clean();
$file_name = 'Presupuesto.pdf';
// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter', 'portrait');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser

$dompdf->stream('Presupuesto'.$folio.'.pdf',array('Attachment'=>0));
$file = $dompdf->output();
file_put_contents($file_name, $file);
ob_end_clean();

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