<?php
/*if (isset($_GET['folio'])) {
   echo getPlantilla($_GET['folio']);
}*/


function getPlantilla($folio)
{
    include_once '../bd/conexion.php';



    if ($folio != "") {
        $objeto = new conn();
        $conexion = $objeto->connect();

        $consulta = "SELECT * FROM vventa WHERE folio_vta='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $dt) {
            $fecha = $dt['fecha_vta'];
            $cliente = $dt['nombre'];
            $concepto = $dt['concepto_vta'];
            $gtotal = $dt['gtotal'];
            $saldo = $dt['saldo'];
        }
        $consultadet = "SELECT * FROM pagocxc WHERE folio_vta='$folio' ORDER BY folio_pagocxc,fecha";
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../cntaventa.php";';
        echo '</script>';
    }

    $plantilla .= '
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
        <h1>Estado de Cuenta</h1>
        <div class="">Venta: <strong>' . $folio . '</strong></div>
        <div class="date">Fecha:' . $fecha . '</div>
      </div>

      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <h2 class="name">' . $cliente . '</h2>
          
          <p style="text-align:justify">PROYECTO: <strong>' . $concepto . '<strong></p>
          <p style="text-align:justify">TOTAL VENTA: <strong>$ ' . number_format($gtotal,2) . '<strong></p>
          <p style="text-align:justify">SALDO ACTUAL: <strong>$ ' . number_format($saldo,2) . '<strong></p>
          
        </div>
        
    </div>
    <table class="sborde" border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            
            <th class="total">Fecha</th>
            <th class="total">Concepto</th>
            <th class="total">Metodo de Pago</th>
            <th class="total">Monto</th>
            
          </tr>
        </thead>
        <tbody>';
    $x = 1;
    $pagos = 0;
    foreach ($datadet as $row) {
        $pagos += $row['monto'];
        $plantilla .= '
          <tr>
          
            <td class="desc">' . $row['fecha'] . '</td>
            <td class="desc">' . $row['concepto'] . '</td>
            <td class="desc">' . $row['metodo'] . '</td>
            <td class="qty">$' . number_format($row['monto'], 2) . '</td>
          </tr>
        ';
        $x++;
    }
    $plantilla .=
        '</tbody>
        <tfoot class="sborde">
         <tr>
         <td ></td>
          <td ></td>
          <td  >Total de Venta</td>
          <td >$ ' . number_format($gtotal, 2) . '</td>
        </tr>
        <tr>
          <td ></td>
          <td ></td>
          <td  >Pagos Recibidos</td>
          <td >$ ' . number_format($pagos, 2) . '</td>
        </tr>
         <tr>
            <td ></td>
            <td ></td>
            <td  >Saldo Actual</td>
            <td >$ ' . number_format($saldo, 2) . '</td>
            </tr>
             </tfoot>
      </table>

      <div id="thanks">¡Gracias por su preferencia!</div>
      
    </main>
    <footer>
     
    </footer>
  </body>';

    return $plantilla;
}
