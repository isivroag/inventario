<!DOCTYPE html>


<head>
	<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Formato de Presupuesto</title>
	<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->

	<!-- overlayScrollbars -->


	<link rel="shortcut icon" href="../img/favicon.ico">
	<!-- Google Font: Source Sans Pro -->

	<link rel="stylesheet" href="../css/estilocot.css">

</head>



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
	echo '<script type="text/javascript">';
	echo 'window.location.href="../cntapresupuesto.php";';
	echo '</script>';
}


?>


<body>

	<div class="page_pdf">
		<div>
			<table class="factura_head">
				
					
						<td class="logo_factura">
							<div>
								<img style="width:180px;" src="../img/logof.png">
							</div>
						</td>

						<td class="info_empresa" style="width:380px;text-align:center">
							<div>
								<p><span class="empresa">GALLERY STONE</span><br>
									Araucarias No 116, Col. Indeco Animas Xalapa, Veracruz<br>
									Teléfonos: 228-1524147 228-1179998<br>
									Email: info@gallerystone.com.mx</p>
							</div>
						</td>

						<td class="info_factura" style="width:205px">
							<div class="round">
								<span class="encabezado">Prespuesto</span>
								<p>No. Presupuesto: <strong><?php echo $folio; ?></strong></p>
								<p>Fecha: <?php echo $fecha; ?></p>

							</div>
						</td>

					
				
			</table>
		</div>
		<div>
			<table class="factura_cliente">
				<tr>
					<td class="info_cliente">
						<div class="round">
							<span class="encabezado">Cliente</span>
							<p><b><?php echo $prospecto ?></b> </p>
							<p><b> PRESENTE</b></p>
							<br>
							<p style="text-align:justify">De acuerdo a su amable solicitud para el proyecto ubicado en <?php echo $ubicacion ?>; referente a <?php echo $concepto ?>; establecemos a su consideración la siguiente cotización
							</p>


						</div>
					</td>

				</tr>
			</table>
		</div>
		<div>
			<table class="factura_detalle">
				<thead class="" style="width:100%">
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
							<td class="textcenter"><?php echo $row['formato'] ?></td>
							<td class="textcenter"><?php echo $row['cantidad'] ?></td>
							<td class="textcenter"><?php echo $row['nom_umedida'] ?></td>
							<td class="textright">$ <?php echo number_format($row['precio'], 2) ?></td>
							<td class="textright">$ <?php echo number_format($row['total'], 2) ?></td>
						</tr>
					<?php
					}
					?>

				</tbody>
				<br>

				<tfoot class="detalle_totales">

					<tr>
						<th colspan="6" class="textright"><span>SUBTOTAL:</span></th>
						<th class="textright"><span>$ 0.00</span></th>
					</tr>
					<tr>
						<th colspan="6" class="textright"><span>IVA (16%):</span></th>
						<th class="textright"><span>$ 0.00</span></th>
					</tr>
					<tr>
						<th colspan="6" class="textright"><span>TOTAL:</span></th>
						<th class="textright"><span>$ <?php echo number_format($total, 2) ?></span></th>
					</tr>
				</tfoot>

			</table>
		</div>
		<div>
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
			<h4 class="label_gracias">¡Gracias por su preferencia!</h4>
		</div>
	</div>


</body>

</html>