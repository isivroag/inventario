<?php
$pagina = "rptpresupuesto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$mesactual = (isset($_GET['mes'])) ? $_GET['mes'] : date("m");
$yearactual = (isset($_GET['ejercicio'])) ? $_GET['ejercicio'] : date("Y");
$inicio = $yearactual . "-" . $mesactual . "-01";
$fin = $yearactual . "-" . $mesactual . "-30";

$consulta = "SELECT * FROM vproducto where estado_prod=1 order by id_prod";


$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);



$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card ">
            <div class="card-header bg-gradient-green text-light">
                <h4 class="card-title text-center">INVENTARIO</h4>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <div class="card-header bg-gradient-green">
                            Selector de Período
                        </div>
                        <div class="card-body p-0">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="mes" class="col-form-label">MES:</label>
                                        <select class="form-control" name="mes" id="mes" value="<?php echo $mesactual ?>">
                                            <option id="01" value="01" <?php echo ($mesactual == '01') ? "selected" : "" ?>>ENERO</option>
                                            <option id="02" value="02" <?php echo ($mesactual == '02') ? "selected" : "" ?>>FEBRERO</option>
                                            <option id="03" value="03" <?php echo ($mesactual == '03') ? "selected" : "" ?>>MARZO</option>
                                            <option id="04" value="04" <?php echo ($mesactual == '04') ? "selected" : "" ?>>ABRIL</option>
                                            <option id="05" value="05" <?php echo ($mesactual == '05') ? "selected" : "" ?>>MAYO</option>
                                            <option id="06" value="06" <?php echo ($mesactual == '06') ? "selected" : "" ?>>JUNIO</option>
                                            <option id="07" value="07" <?php echo ($mesactual == '07') ? "selected" : "" ?>>JULIO</option>
                                            <option id="08" value="08" <?php echo ($mesactual == '08') ? "selected" : "" ?>>AGOSTO</option>
                                            <option id="09" value="09" <?php echo ($mesactual == '09') ? "selected" : "" ?>>SEPTIEMBRE</option>
                                            <option id="10" value="10" <?php echo ($mesactual == '10') ? "selected" : "" ?>>OCTUBRE</option>
                                            <option id="11" value="11" <?php echo ($mesactual == '11') ? "selected" : "" ?>>NOVIEMBRE</option>
                                            <option id="12" value="12" <?php echo ($mesactual == '12') ? "selected" : "" ?>>DICIEMBRE</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group input-group-sm">
                                        <label for="ejercicio" class="col-form-label">EJERCICIO:</label>
                                        <input type="text" class="form-control" name="ejercicio" id="ejercicio" value="<?php echo $yearactual ?>">
                                    </div>
                                </div>

                                <div class="col-lg-2 align-self-end text-center">
                                    <div class="form-group input-group-sm">
                                        <button id="btnconsulta" name="btnconsulta" type="button" class="btn bg-gradient-success btn-ms form-control"><i class="fas fa-search"></i> Consultar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <br>
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-gradient-green">
                            Filtro por Categoría
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-2">
                                    <input type="hidden" id="titulo" name="titulo class=" form-control value="REPORTE DE INVENTARIOS PRESONALIZADO"></input>
                                </div>

                                <div class="col-lg-1 align-self-end text-center">
                                    <div class="form-group input-group-sm">
                                        <button id="btnBuscar" name="btnBuscar" type="button" class="btn bg-gradient-success btn-ms"><i class="fas fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-hover table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="font-size:15px">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>Id</th>
                                            <th>Clave</th>
                                            <th>Descripción</th>
                                            <th>U. Medida</th>
                                            <th>Inicial</th>
                                            <th>Entradas</th>
                                            <th>Salida</th>
                                            <th>Final</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                            $producto=$dat['id_prod'];

                                            //buscar inicial
                                            $consultaini = "SELECT mov_prod.id_prod,mov_prod.fecha_movp,mov_prod.saldofin FROM 
                                            mov_prod
                                            JOIN 
                                            (SELECT id_movp,id_prod,MAX(fecha_movp) as maxfecha_movp FROM mov_prod where fecha_movp<= '$inicio' GROUP BY id_prod ) AS cons
                                            ON mov_prod.id_prod = cons.id_prod AND mov_prod.fecha_movp= cons.maxfecha_movp WHERE mov_prod.id_prod='$producto'";


                                            $resultadoini = $conexion->prepare($consultaini);
                                            $resultadoini->execute();
                                            $dataini = $resultadoini->fetchAll(PDO::FETCH_ASSOC);

                                            $inicial = 0;
                                            $entrada=0;
                                            $salida=0;
                                            $final=0;
                                            foreach ($dataini as $rowini) {
                                                $inicial = $rowini['saldofin'];
                                            }

                                            //buscar entradas
                                            $consultaent="SELECT sum(cantidad) as cantidad from mov_prod where fecha_movp BETWEEN '$inicio' AND '$fin' AND id_prod='$producto' and tipo_movp<>'Salida'GROUP BY id_prod";
                                            $resultadoent = $conexion->prepare($consultaent);
                                            $resultadoent->execute();
                                            $dataent = $resultadoent->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($dataent as $rowent) {
                                                $entrada = $rowent['cantidad'];
                                            }


                                            //buscar salidas

                                            $consultasal="SELECT sum(cantidad) as cantidad from mov_prod where fecha_movp BETWEEN '$inicio' AND '$fin' AND id_prod='$producto' and tipo_movp='Salida'GROUP BY id_prod";
                                            $resultadosal = $conexion->prepare($consultasal);
                                            $resultadosal->execute();
                                            $datasal = $resultadosal->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($datasal as $rowsal) {
                                                $salida = $rowsal['cantidad'];
                                            }

                                            //buscar final

                                            $consultafin = "SELECT mov_prod.id_prod,mov_prod.fecha_movp,mov_prod.saldofin FROM 
                                            mov_prod
                                            JOIN 
                                            (SELECT id_movp,id_prod,MAX(fecha_movp) as maxfecha_movp FROM mov_prod where fecha_movp<= '$fin' GROUP BY id_prod ) AS cons
                                            ON mov_prod.id_prod = cons.id_prod AND mov_prod.fecha_movp= cons.maxfecha_movp WHERE mov_prod.id_prod='$producto'";


                                            $resultadofin = $conexion->prepare($consultafin);
                                            $resultadofin->execute();
                                            $datafin = $resultadofin->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($datafin as $rowfin) {
                                                $final = $rowfin['saldofin'];
                                            }


                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_prod'] ?></td>
                                                <td><?php echo $dat['clave_prod'] ?></td>
                                                <td><?php echo $dat['nom_prod'] ?></td>
                                                <td><?php echo $dat['umedida'] ?></td>
                                                <td><?php echo $inicial ?></td>
                                                <td><?php echo $entrada ?></td>
                                                <td><?php echo $salida ?></td>
                                                <td><?php echo $final ?></td>


                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>

    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>