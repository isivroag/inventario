<!-- CODIGO PHP-->
<?php
$pagina = "requisicion";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);
$usuario = $_SESSION['s_nombre'];


if (isset($_GET['folio'])) {
    $folio = $_GET['folio'];
    $consulta = "SELECT * FROM requisicion WHERE folio_tmp='$folio'";
    $resultadobpres = $conexion->prepare($consulta);
    $resultadobpres->execute();


    if ($resultadobpres->rowCount() >= 1) {
        $databpres = $resultadobpres->fetchAll(PDO::FETCH_ASSOC);
        foreach ($databpres as $dtbpres) {
            $requisicion = $dtbpres['folio_req'];
        }
        $consulta = "SELECT * FROM tmp_req WHERE folio_req='$folio'";
    }
} else {
    $consulta = "SELECT * FROM tmp_req WHERE estado_req=1 and tokenid='$tokenid'";
    $requisicion = 0;
}



$resultado = $conexion->prepare($consulta);
$resultado->execute();

if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio = $dt['folio_req'];
        $fecha = $dt['fecha_req'];
        $solicitante = $dt['solicitante'];
        $fraccionamiento = $dt['fraccionamiento'];
        $obs_req = $dt['obs_req'];
    }
} else {
    $fecha = date('Y-m-d');
    $consultatmp = "INSERT INTO tmp_req (tokenid,estado_req,fecha_req,usuario) VALUES('$tokenid','1','$fecha','$usuario')";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();

    $consultatmp = "SELECT folio_req FROM tmp_req WHERE tokenid='$tokenid' and estado_req=1 ORDER BY folio_req DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    foreach ($datatmp as $dt) {
        $folio = $dt['folio_req'];
        $solicitante = "";
        $fraccionamiento = "";
        $obs_req = "";
    }
}

$message = "";




$consultacon = "SELECT * FROM producto WHERE estado_prod=1 ORDER BY id_prod";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);



$consultadet = "SELECT * FROM detalle_tmp WHERE folio_req='$folio' ORDER BY id_reg";
$resultadodet = $conexion->prepare($consultadet);
$resultadodet->execute();
$datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);




?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">
<style>
    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    #div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    #cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    #textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">


        <!-- Default box -->
        <div class="card">


            <div id="div_carga">

                <img id="cargador" src="img/loader.gif" />
                <span class=" " id="textoc"><strong>Cargando...</strong></span>

            </div>

            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">Requisición</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">


                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>-->
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        <!--<button id="btnNuevo" type="button" class="btn bg-gradient-primary btn-ms" data-toggle="modal"><i class="fas fa-envelope-square"></i> Enviar</button>-->
                    </div>
                </div>

                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">


                    <div class="content" disab>

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">
                                <div class="card-tools" style="margin:0px;padding:0px;">

                                    <button id="btnGuardarHead" name="btnGuardarHead" type="button" class="btn bg-success btn-sm">
                                        <i class="far fa-save"></i>
                                    </button>
                                </div>
                                <h1 class=" card-title punto bg-blue"> 1</h1>
                                <h1 class="card-title "> Datos de la Requisición</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">

                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="requisicion" id="requisicion" value="<?php echo $requisicion; ?>">
                                            <input type="hidden" class="form-control" name="tokenid" id="tokenid" value="<?php echo $tokenid; ?>">
                                            <label for="solicitante" class="col-form-label">Solicitante:</label>
                                            <input type="text" class="form-control" name="solicitante" id="solicitante" value="<?php echo $solicitante; ?>">
                                        </div>
                                    </div>



                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>


                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folior" class="col-form-label">Folio:</label>
                                            <input type="hidden" class="form-control" name="folio" id="folio" value="<?php echo $folio; ?>">
                                            <input type="text" class="form-control" name="folior" id="folior" value="<?php echo  "TMP-" . $folio; ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class=" row justify-content-sm-center">
                                    <div class="col-sm-8">

                                        <div class="form-group">
                                            <label for="fraccionamiento" class="col-form-label"> Fraccionamiento:</label>
                                            <input type="text" class="form-control" name="fraccionamiento" id="fraccionamiento" value="<?php echo $fraccionamiento; ?>">
                                        </div>

                                    </div>
                                </div>
                                <!-- modificacion Agregar notas a presupuesto-->
                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="obs" class="col-form-label">Observaciones:</label>
                                            <textarea rows="2" class="form-control" name="obs" id="obs"><?php echo $obs_req; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--fin modificacion agregar vendedor a presupuesto -->

                        </div>
                        <!-- Formulario Agrear Item -->
                        <div class="content" style="padding-top:0px;">
                            <div class="card card-widget " style="margin:2px;padding:5px;">

                                <div class="card-header bg-gradient-green" style="margin:0px;padding:8px;">
                                    <h1 class=" card-title punto bg-blue">2</h1>
                                    <h1 class="card-title" style="text-align:center;">Agregar Material</h1>
                                    <div class="card-tools" style="margin:0px;padding:0px;">

                                        <button type="button" class="btn bg-gradient-green btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body " style="margin:0px;padding:2px 5px;">
                                    <div class="row justify-content-sm-center">

                                        <div class="col-lg-4">
                                            <div class="input-group input-group-sm">

                                                <input type="hidden" class="form-control" name="claveconcepto" id="claveconcepto">


                                                <label for="concepto" class="col-form-label">Material:</label>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" name="concepto" id="concepto" disabled>
                                                    <span class="input-group-append">
                                                        <button id="bconcepto" type="button" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-lg-2">
                                            <input type="hidden" class="form-control" name="id_umedida" id="id_umedida">
                                            <label for="nom_umedida" class="col-form-label">U Medida:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control " name="nom_umedida" id="nom_umedida" disabled>
                                            </div>
                                        </div>


                                        <div class="col-lg-1">
                                            <label for="cantidad" class="col-form-label">Cantidad:</label>
                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="cantidad" id="cantidad" disabled>
                                            </div>
                                        </div>



                                        <div class="col-lg-1 justify-content-center">
                                            <label for="" class="col-form-label">Acción:</label>
                                            <div class="input-group-append input-group-sm justify-content-center d-flex">
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Agregar Item">
                                                    <button type="button" id="btnagregar" name="btnagregar" class="btn btn-sm bg-gradient-green" value="btnGuardar"><i class="fas fa-plus-square"></i></button>
                                                </span>
                                                <span class="d-inline-block" tabindex="1" data-toggle="tooltip" title="Limpiar">
                                                    <button type="button" id="btlimpiar" name="btlimpiar" class="btn btn-sm bg-gradient-purple" value="btnlimpiar"><i class="fas fa-brush"></i></button>
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- Tabla Y TOTALES-->
                        <div class="content" style="padding:5px 0px;">

                            <div class="card card-widget" style="margin-bottom:0px;">
                                <div class="card-header bg-gradient-green " style="margin:0px;padding:8px">
                                    <h1 class=" card-title punto bg-blue">3</h1>
                                    <h1 class="card-title "> Listado de Material</h1>
                                </div>
                                <div class="card-body" style="margin:0px;padding:3px;">

                                    <div class="row">

                                        <div class="col-lg-8 mx-auto">

                                            <div class="table-responsive" style="padding:5px;">

                                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed  mx-auto" style="width:100%;">
                                                    <thead class="text-center bg-gradient-green">
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Id Mat</th>
                                                            <th>Material</th>
                                                            <th>Cantidad</th>
                                                            <th>Unidad</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($datadet as $datdet) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $datdet['id_reg'] ?></td>
                                                                <td><?php echo $datdet['id_prod'] ?></td>
                                                                <td><?php echo $datdet['nom_prod'] ?></td>
                                                                <td><?php echo $datdet['cantidad'] ?></td>
                                                                <td><?php echo $datdet['umedida'] ?></td>
                                                                <td></td>
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
                        </div>
                    </div>
                </form>


                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>
        </div>



            <!-- /.card -->

    </section>






    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-green">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR MATERIAL</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaCon" id="tablaCon" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Material</th>
                                        <th>U. Medida</th>
                                        <th>Seleccionar</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datacon as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_prod'] ?></td>
                                            <td><?php echo $datc['nom_prod'] ?></td>
                                            <td><?php echo $datc['umedida'] ?></td>
                                            <td></td>
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
    </section>

    <section>


    </section>


</div>

<script>
    //window.addEventListener('beforeunload', function(event)  {

    // event.preventDefault();


    //event.returnValue ="";
    //});
</script>

<?php include_once 'templates/footer.php'; ?>
<script src="fjs/requisicion.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>