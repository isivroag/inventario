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
    $iva = $dt['iva'];
    $subtotal = $dt['subtotal'];
    $descuento = $dt['descuento'];
    $gtotal = $dt['gtotal'];
    
    $folio_tmp=$dt['folio_tmp'];
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
    <header class="clearfix">
      <div id="logo">
        <img src="../img/logof.png">
      </div>
      <div id="company">
        <h2 class="name">GALLERY STONE</h2>
        <div>Araucarias No 116, Col. Indeco Animas Xalapa, Veracruz</div>
        <div>Teléfonos: 228-1524147 228-1179998</div>
        <div><a href="mailto:ventas@gallerystone.com.mx">Email: ventas@gallerystone.com.mx</a></div>
      </div>
      
      <div id="folio">
        <h1>Presupuesto</h1>
        <div class="">Folio: <strong>'. $folio .'</strong></div>
        <div class="date">Fecha:'. $fecha .'</div>
      </div>

      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          
          <h2 class="name">'. $prospecto .'</h2>
          <div class="to">Presente</div>
          <p style="text-align:justify">De acuerdo a su amable solicitud para el proyecto ubicado en '. $ubicacion.'; referente a '. $concepto .'; establecemos a su consideración la siguiente cotización
							</p>
          
        </div>
        
      </div>
      <table class="sborde" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            
            <th class="total">Concepto</th>
            <th class="total">Descripción</th>
            <th class="total">Formato</th>
            <th class="total">Cantidad</th>
            <th class="total">U.M.</th>
            <th class="total">P.U.</th>
            <th class="total">Monto.</th>
          </tr>
        </thead>
        <tbody>';
        $x=1;
        foreach ($datadet as $row) {
         $plantilla.='
          <tr>
            <td class="desc">'. $row['nom_concepto'].'</td>
							<td class="desc">'. $row['nom_item'].'</td>
							<td class="desc">'.$row['formato'].'</td>
							<td class="qty">'. $row['cantidad'] .'</td>
							<td class="desc">'. $row['nom_umedida'] .'</td>
							<td class="qty">$'. number_format($row['precio'], 2).'</td>
							<td class="qty">$'. number_format($row['total'], 2) .'</td>
          </tr>
        ';
        $x++;
        }
$plantilla.=
        '</tbody>
        <tfoot class="sborde">
        ';
        if ($subtotal<>0 && $iva<>0) {
          $plantilla.=' <tr>
          <td colspan="3" ></td>
          <td colspan="3" >SUBTOTAL</td>
          <td >$ '. number_format($subtotal, 2) .'</td>
        </tr>';
        }
         if ($iva <> 0 ){
          $plantilla.='<tr>
          <td colspan="3"></td>
          <td  colspan="3">IVA 16%</td>
          <td >$ '. number_format($iva, 2) .'</td>
        </tr>';
         }
          if ($total<>0) {
            $plantilla.=' <tr>
            <td colspan="3"></td>
            <td  colspan="3">TOTAL</td>
            <td >$ '. number_format($total, 2) .'</td>
            </tr>';
          }
         if ($descuento<>0){
          $plantilla.='<tr>
          <td colspan="3"></td>
          <td   colspan="3">DESCUENTO</td>
          <td >$ '. number_format($descuento, 2) .'</td>
          </tr>';
         }
        
         if ($gtotal<>0 && $descuento<>0){
          $plantilla.='<tr>
          <td colspan="3"></td>
          <td  colspan="3">GRAN TOTAL</td>
          <td >$ '. number_format($gtotal, 2) .'</td>
        </tr>';
         }
       $plantilla.=' </tfoot>
      </table>

      <div id="thanks">¡Gracias por su preferencia!</div>
      <div id="notices">
        <div>NOTA:</div>
        <div class="notice">
        ';
        $consultacond = "SELECT * from contmp where folio_pres='$folio_tmp' order by id_reg";
        $resultadocond = $conexion->prepare($consultacond);
        $resultadocond->execute();
        if ($resultadocond->rowCount() >= 1) {
          $datacond = $resultadocond->fetchAll(PDO::FETCH_ASSOC);
          foreach ($datacond as $dtcond) {
            $plantilla.=$dtcond['nom_cond'].'<br>';
          }
        }
          $plantilla.=' </div>
      </div>
    </main>
    <footer>
     
    </footer>
  </body>';

return $plantilla;
}
