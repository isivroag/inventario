<?php
$pagina = "rptpresupuesto";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vproducto where estado_prod=1 order by id_prod";


$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$message = "";
$consultat = "SELECT * FROM tipop where estado_tipop=1 order by id_tipop";
$resultadot = $conexion->prepare($consultat);
$resultadot->execute();
$datat = $resultadot->fetchAll(PDO::FETCH_ASSOC);

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
                                    <input type="hidden" id="titulo" name="titulo class="form-control value="REPORTE DE INVENTARIOS PRESONALIZADO"></input>
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
                                            
                                            <th>Existencias</th>
                                            <th>U. Medida</th>
                                            
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_prod'] ?></td>
                                                <td><?php echo $dat['clave_prod'] ?></td>
                                                <td><?php echo $dat['nom_prod'] ?></td>
                                              
                                                <td><?php echo $dat['cant_prod'] ?></td>
                                                <td><?php echo $dat['umedida'] ?></td>
                                            
                                                <td><?php echo $dat['nom_tipop'] ?></td>

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
<script src="fjs/inventario.js"></script>
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