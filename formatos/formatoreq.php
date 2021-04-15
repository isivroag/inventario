<?php
/*if (isset($_GET['folio'])) {
   echo getPlantilla($_GET['folio']);
}*/




function getPlantilla($folio, $pago)
{
    include_once '../bd/conexion.php';





    if ($folio != "") {
        $objeto = new conn();
        $conexion = $objeto->connect();



        $consulta = "SELECT * FROM requisicion WHERE folio_req='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $dt) {

            $fecha = $dt['fecha_req'];
            $solicitante = $dt['solicitante'];
            $fraccionamiento = $dt['fraccionamiento'];
            $obs = $dt['obs_req'];
        }

        $consultadet = "SELECT * FROM detalle_req WHERE folio_req='$folio' ORDER BY id_reg";
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
        
            <img src="img/logocompleto.png" style="max-width:120px">
        </div>
        <div id="company">
        <h2 class="name">FORMATO DE REQUISICIÓN DE MATERIALES</h2>
        
      </div>

        <div id="folio" >
            <h1>Requisición</h1>
            <div class="">Folio: <strong>' . $folio . '</strong></div>
            <div class="date">Fecha:' . $fecha . '</div>
        </div>

      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <h3 class="name">SOLICITANTE: ' . $solicitante . '</h3>
          <h3 style="text-align:justify">PROYECTO: <strong>' . $fraccionamiento . '<strong></h3>
          
          
        </div>
        
    </div>
    <table class="sborde" border="0" cellspacing="0" cellpadding="0" >
        <thead>
        <tr>
            
            <th class="iden" >ID MAT</th>
            <th class="desc">MATERIAL</th>
            <th class="desc">CANTIDAD</th>
            <th class="desc">U. MEDIDA</th>
            
          </tr>
        </thead>
        <tbody>';
    $x = 1;


    foreach ($datadet as $row) {

        $plantilla .= '
          <tr>
          
            <td class="iden" >' . $row['id_prod'] . '</td>
            <td class="desc">' . $row['nom_prod'] . '</td>
            <td class="desc">' . number_format($row['cantidad'], 2) . '</td>
            <td class="desc">' . $row['umedida'] . '</td>
          </tr>
        ';
        $x++;
    }

    //.$formatter->toInvoice($pagocom, 2, ') M.N' ).
    $plantilla .=
        '</tbody>
        <tfoot class="sborde">
        
             </tfoot>
      </table>
      <div class="clearfix">
        <h2 class="name"><strong>OBSERVACIONES:</strong></h2>
        <p class="name"> ' . $obs . '</p>
      </div>
     
      <div class="clearfix" style="text-align:center;margin-top:50px" >
        <hr style="width:200px"></hr>
        <h3>FIRMA DE AUTORIZACIÓN</h3>
      <div>
        
     
    </main>
   
  </body>';

    return $plantilla;
}
