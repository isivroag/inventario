



<?php



function getPlantilla($folio){



include_once '../bd/conexion.php';



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

$plantilla.='
<body>

	
		<header class="">
           <table>
           <tr>
           <td>
            <div class="logo_factura">
                <img style="width:180px;" src="../img/logof.png">
            </div>
        </td>
        <td class="textcenter">
            <div class="info_empresa" >
                <p><span class="empresa">GALLERY STONE</span><br>
                    Araucarias No 116, Col. Indeco Animas Xalapa, Veracruz<br>
                    Teléfonos: 228-1524147 228-1179998<br>
                    Email: info@gallerystone.com.mx</p>
            </div>
        </td>
        <td class="round">
            <div class=" info_factura">
                <span class="encabezado">Prespuesto</span>
                <p>No. Presupuesto: <strong>'. $folio .'</strong></p>
                <p>Fecha:'. $fecha .'</p>

            </div>
            </td>
    			<tr>				
			</table>
        </header>
        <main>
		<div>
			<table class="factura_cliente">
				<tr>
					<td class="info_cliente">
						<div class="round">
							<span class="encabezado">Cliente</span>
							<p><b>'. $prospecto .'</b> </p>
							<p><b> PRESENTE</b></p>
							<br>
							<p style="text-align:justify">De acuerdo a su amable solicitud para el proyecto ubicado en '. $ubicacion.'; referente a '. $concepto .'; establecemos a su consideración la siguiente cotización
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

                <tbody class="detalle_productos">';
					foreach ($datadet as $row) {
				$plantilla .='<tr>
							<td>'. $row['nom_concepto'].'</td>
							<td>'. $row['nom_item'].'</td>
							<td class="textcenter">'.$row['formato'].'</td>
							<td class="textcenter">'. $row['cantidad'] .'</td>
							<td class="textcenter">'. $row['nom_umedida'] .'</td>
							<td class="textright">$ '. number_format($row['precio'], 2).'</td>
							<td class="textright">$ '. number_format($row['total'], 2) .'</td>
						</tr>';
                    }
				$plantilla.='</tbody>
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
						<th class="textright"><span>$ '. number_format($total, 2) .'</span></th>
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
	</main>


</body>
';
return $plantilla;
}