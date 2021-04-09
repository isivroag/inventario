<?php
$pagina = "formatopres";

include_once '../bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

if ($folio != "") {
    $objeto = new conn();
    $conexion = $objeto->connect();


    $consulta = "SELECT * FROM presupuesto WHERE folio_pres='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio = $dt['folio_pres'];

        $fecha = $dt['fecha_pres'];
        $idpros = $dt['id_pros'];
        $concepto = $dt['concepto_pres'];
        $ubicacion = $dt['ubicacion'];
        $total = $dt['total'];
    }

    if ($idpros != 0) {
        $consultapros = "SELECT nombre,correo FROM prospecto WHERE id_pros='$idpros'";

        $resultadopros = $conexion->prepare($consultapros);
        $resultadopros->execute();
        if ($resultado->rowCount() >= 1) {
            $datapros = $resultadopros->fetchAll(PDO::FETCH_ASSOC);
            foreach ($datapros as $dtp) {
                $prospecto = $dtp['nombre'];
                $correo = $dtp['correo'];
            }
        } else {
            $prospecto = "";
            $correo = "";
        }
    } else {
        $prospecto = "";
        $correo = "";
    }

    $consultac = "SELECT * FROM prospecto ORDER BY id_pros";
    $resultadoc = $conexion->prepare($consultac);
    $resultadoc->execute();
    $datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

    $consultadet = "SELECT * FROM vdetalle_pres WHERE folio_pres='$folio' ORDER BY id_reg";
    $resultadodet = $conexion->prepare($consultadet);
    $resultadodet->execute();
    $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);
} else {

    $folio = "1";

    $fecha = "";
    $idpros = "";
    $concepto = "";
    $ubicacion = "";
    $total = "";
    $prospecto = "ISRAEL IVAN ROMERO AGUILAR";
    $correo = "";

    //echo '<script type="text/javascript">';
    //echo 'window.location.href="../cntapresupuesto.php";';
    //echo '</script>';
}


?>

<style>
    .round {
        border-radius: 8px;
        border: 1px solid #0a4661;
        overflow: hidden;
        padding-bottom: 15px;
    }

    .round p {
        padding: 0 15px;
    }

    .page_pdf {
        width: 95%;
        margin: 15px;
        padding: 5;
    }

    .encabezado {
        /* font-family: 'BrixSansBlack';*/
        font-size: 12pt;
        display: block;
        background: #ec6c2b;
        color: #FFF;
        text-align: center;
        padding: 3px;
        margin-bottom: 5px;
    }

    .info_cliente {
        width: 100%;
        margin: 15px;
        padding: 5px;
        line-height: 15px;
    }

    .nota {
        font-size: 8pt;
    }

    .label_gracias {
        
        font-weight: bold;
        font-style: italic;

        margin-top: 20px;
    }
</style>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gallery Stone | ERP </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../css/adminlte.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="shortcut icon" href="../img/favicon.ico">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <div class="content page-pdf">
        
            <div class="row" style=" margin:10px 5px 10px 5px;">

                <div class="col-3" style="text-align: center;">
                    <img src="../img/logof.png" alt="">
                </div>

                <div class="col-6" style="text-align: center">
                    <p><strong style="font-size: 14pt;">GALLERY STONE</strong><br>
                        Araucarias No 116, Col. Indeco Animas Xalapa, Veracruz<br>
                        Teléfonos: 228-1524147 228-1179998<br>
                        Email: info@gallerystone.com.mx</p>
                </div>

                <div class="col-3 " style="text-align: center;line-height: 15px;">
                    <div class="round">
                        <span class="encabezado">Prespuesto</span>
                        <p>No. <strong><?php echo $folio; ?></strong></p>
                        <p>Fecha: <strong><?php echo $fecha; ?></strong></p>

                    </div>
                </div>

            </div>

            <div class="row info_cliente" style=" margin:10px 5px 10px 5px;">
                <div class="col-12 ">
                    <div class="round">
                        <span class="encabezado" style="margin-bottom: 5px">Cliente</span>
                        <p style="margin-bottom: 5px"><b><?php echo $prospecto ?></b> </p>
                        <p style="margin-bottom: 10px"> <b> PRESENTE</b></p>

                        <p style="text-align:justify;margin-bottom: 5px;line-height:18px">De acuerdo a su amable solicitud para el proyecto ubicado en <?php echo $ubicacion ?>; referente a <?php echo $concepto ?>; establecemos a su consideración la siguiente cotización
                        </p>

                    </div>
                </div>
            </div>

            <div class="row" style=" margin:10px 5px 10px 5px;">
                <div class="col-12 ">
                    <div class="table-responsive" style="padding:5px;">
                        <table class=" table round table-sm table-bordered table-striped factura_detalle">
                            <thead class="text-center " style="width:100%;background:#ec6c2b;color:#FFF">
                                <tr>
                                    <th class="textcenter">Concepto</th>
                                    <th class="textcenter">Descripcion</th>
                                    <th class="textcenter">Formato</th>
                                    <th class="textcenter">Cantidad</th>
                                    <th class="textcenter">U. Medida</th>
                                    <th class="textcenter">P.U.</th>
                                    <th class="textcenter">Monto</th>

                                </tr>
                            </thead>

                            <tbody class="detalle_productos">
                                <?php
                                foreach ($datadet as $row) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['nom_concepto'] ?></td>
                                        <td><?php echo $row['nom_item'] ?></td>
                                        <td class="text-center"><?php echo $row['formato'] ?></td>
                                        <td class="text-center"><?php echo $row['cantidad'] ?></td>
                                        <td class="text-center"><?php echo $row['nom_umedida'] ?></td>
                                        <td class="text-right">$ <?php echo number_format($row['precio'], 2) ?></td>
                                        <td class="text-right">$ <?php echo number_format($row['total'], 2) ?></td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                            <br>

                            <tfoot class="detalle_totales" style="line-height:10px">

                                <tr>
                                    <th colspan="6" class="text-right"><span>SUBTOTAL:</span></th>
                                    <th class="text-right"><span>$ 0.00</span></th>
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-right"><span>IVA (16%):</span></th>
                                    <th class="text-right"><span>$ 0.00</span></th>
                                </tr>
                                <tr>
                                    <th colspan="6" class="text-right"><span>TOTAL:</span></th>
                                    <th class="text-right"><span>$ <?php echo number_format($total, 2) ?></span></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <p class="nota">INCLUYE: <br>
                        - Los precios son en pesos mexicanos. <br>
                        - Colocación únicamente mano de obra. <br>
                        - No incluye adhesivos. <br>
                        - No incluye sellador ni servicio de aplicación de sellador. <br>
                        - No incluye andamios, tablones, etc. <br>
                        - No incluye entrecalles, boleos, cantos pulidos. Biseles, perforaciones, cortes 45°, etc. <br>
                        - Los precios son más IVA en caso de requerir Factura. <br>
                        - Los pagos con cheque fiscal, transferencia electrónica a cuenta fiscal generan cobro de IVA. <br>
                        - Se requiere un 70% de anticipo al confirmar el pedido y el 30% restante contra estimaciones semanales.<br>
                        - La presente cotización tiene una vigencia de 15 días a partir de su emisión. <br>
                        <b>Mármol, cantera y granito por ser de origen natural aceptan variación tanto en color como en veta, es norma universal el uso de estuco para corregir estos defectos. Así mismo puede sufrir diferentes comportamientos a la fricción y al medio ambiente.</b>
                    </p>
                </div>
                <div class="col-12">
                    <h4 class="label_gracias text-center">¡Gracias por su preferencia!</h4>
                </div>
            </div>

        
    </div>
</body>